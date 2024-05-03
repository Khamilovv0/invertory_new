<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function authenticate()
    {
        $validated = request()->validate([
            'Login' => 'required',
            'Password'=> 'required',
        ]);

        // Сброс всех сессии
        request()->session()->regenerate();

        $user = User::where('Login', $validated['Login'])
            ->where('Password',md5($validated['Password']))
            ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
        }

        return redirect()->route('login')->withErrors(['Password' => 'Логин или пароль не правильный']);
    }

    public function logout(Request $request)
    {
        //Проверка активная ли у пользователя сессия
        if (Auth::check()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('login'); //Редирект на страницу login если сессия уже закончена(если не редиректнуть выходило ошибка 404 при нажатии на кнопку logout)


    }


    /*use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/

    /*public function saveToken(Request $request)
    {
        $token = $request->input('token');
        $TutorID = $request->input('TutorID');

        // Сохранение токена и идентификатора пользователя в базе данных
        Token::create([
            'token' => $token,
            'TutorID' => $TutorID,
        ]);

        // Дополнительные действия по аутентификации пользователя с использованием токена, если необходимо

        return redirect()->route('home'); // Перенаправление на нужную страницу после обработки токена
    }*/

    public function authenticateViaToken(Request $request)
    {
        $token = $request->input('token'); // Получаем токен из параметра URL

        // Проверяем наличие токена в базе данных
        $tokenRecord = Token::where('token', $token)->first();

        if ($tokenRecord) {
            // Проверяем, равен ли статус 1
            if ($tokenRecord->status == 1) {
                // Проверяем, не истек ли срок действия токена (это пример, уточните по своей логике)
                /*if ($tokenRecord->created_at->addMinutes(60)->isPast()) {
                    return redirect()->route('login')->withErrors(['user_password' => 'Срок сессии истек, авторизуйтесь снова']);
                }*/

                // Авторизуем пользователя, как если бы он ввел логин и пароль
                Auth::loginUsingId($tokenRecord->TutorID);

                // Устанавливаем статус токена в 0 и сохраняем изменения
                $tokenRecord->status = 0;
                $tokenRecord->save();

                // Удаление записей из таблицы 'tokens', где 'status' равен 0
                DB::table('token')->where('status', 0)->delete();
                // Возвращаем успешный ответ, перенаправление на главную страницу
                return redirect()->route('home');
            } else {
                // Перенаправление на внешний сайт, если статус не равен 1
                return redirect()->away('https://ais.kazetu.kz');
            }
        }else {

            // Возвращаем ошибку, если токен не найден
            return redirect()->away('https://ais.kazetu.kz');
        }
    }

}
