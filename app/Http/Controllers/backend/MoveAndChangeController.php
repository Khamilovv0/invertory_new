<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\in_characteristics_for_product;
use App\Models\in_list_characteristics;
use App\Models\in_product_list_characteristics;
use App\Models\in_product_lists;
use App\Models\in_messages;
use App\Models\Move;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MoveAndChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function move()
    {

        $building = DB::table('buildings')->get();
        $auditories = DB::table('auditories')->get();

        $sortedAuditories = $auditories->sortBy('auditoryName');

        return view('backend.invertory.redactor.move', ['building' => $building, 'auditories' =>$sortedAuditories]);
    }

    public function editAll ($id_product)
    {
        $edit = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors', 'in_product_lists.TutorID', '=', 'tutors.TutorID')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                DB::raw("CONCAT(tutors.lastname, ' ', tutors.firstname) AS tutor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->find($id_product);

        $building = DB::table('buildings')->get();

        $auditories = DB::table('auditories')->get();

        $sortedAuditories = $auditories->sortBy('auditoryName');
        return view('backend.invertory.redactor.move', compact('edit', 'building', 'sortedAuditories'));
    }

    public function getForm($id_name)
    {
        $productListCharacteristics = in_product_list_characteristics::where('id_name', $id_name)->get();

        $forms = $productListCharacteristics->map(function ($item) {
            $listCharacteristic = in_list_characteristics::where('id_characteristic', $item->id_characteristic)->first();
            return [
                'id_characteristic' => $item->id_characteristic,
                'input_characteristic' => $listCharacteristic ? $listCharacteristic->input_characteristic : ''
            ];
        });

        return response()->json(['forms' => $forms]);
    }

    public function change()
    {
        return view('backend.invertory.redactor.change');
    }

    public function updateAll(Request $request, $id_product)
    {
        // Валидация входящих данных
        $request->validate([
            'buildingID' => 'required',
            'auditoryID' => 'required',
            'TutorID' => 'required',
            'names' => 'required|array',
            'id_characteristic' => 'required|array',
        ]);

        DB::beginTransaction(); // Начинаем транзакцию

        try {
            // Проверка на существование записи
            $productList = DB::table('in_product_lists')->where('id_product', $id_product)->first();
            if (!$productList) {
                return redirect()->back()->with('error', 'Запись не найдена!');
            }

            // Подготовка данных для обновления
            $data = [
                'buildingID' => $request->buildingID,
                'auditoryID' => $request->auditoryID,
                'type' => $request->type,
                'TutorID' => $request->TutorID,
                'verification_status' => 1,
                'redactor_id' => Auth::user()->TutorID,
            ];

            // Обновление записи в таблице `in_product_lists`
            DB::table('in_product_lists')->where('id_product', $id_product)->update($data);

                DB::transaction(function () use ($id_product, $request) {
                    // Сначала обновляем записи с тем же id_product, устанавливая current_status в 1
                    in_characteristics_for_product::where('id_product', $id_product)
                        ->update(['current_status' => 1]);

                    // Вставляем каждую запись по отдельности
                    foreach ($request->names as $index => $value) {
                        $id_characteristic = $request->id_characteristic[$index];

                        in_characteristics_for_product::insert([
                            'current_status' => 0,
                            'id_product' => $id_product,
                            'id_characteristic' => $id_characteristic,
                            'characteristic_value' => $value,
                        ]);
                    }
                });

            DB::commit(); // Завершаем транзакцию
            return redirect()->back()->with('success', 'Инвентаризация успешно обновлена!');

        } catch (\Exception $e) {
            DB::rollBack(); // Откатываем транзакцию в случае ошибки
            return redirect()->back()->with('success', 'Инвентаризация успешно обновлена!');
        }
    }


    public function confirmStatus($id)
    {
        // Находим запись по ID
        $item = in_product_lists::where('id_product', $id)->firstOrFail();

        $adminTutorID = [646, 359];
        // Проверяем, является ли текущий пользователь администратором
        if (in_array(Auth::user()->TutorID, $adminTutorID)) {
            // Обновляем значение поля "status"
            $item->verification_status = 2; // Замените 2 на нужное значение для подтвержденного статуса
            $item->save();

            in_messages::where('id_product', $id)->delete();

            Note::where('id_product', $id)->delete();

        }

        // Перенаправляем обратно на предыдущую страницу
        return back()->with('success', 'Статус подтвержден!');
    }

    public function refuseStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'inv_number' => 'required',
            'redactor_id' => 'required',
            'id_product' => 'required',
            'id_name' => 'required',
        ]);

        $item = in_product_lists::where('id_product', $id)->first();


        $adminTutorID = [646, 359];
        if (in_array(Auth::user()->TutorID, $adminTutorID)) {
            // Обновляем значение поля "status"
            $id = $request->input('id_product');
            $item = in_product_lists::findOrFail($id);
            $item->verification_status = 3;
            $item->save();

            $message = new in_messages();
            $message->message = $validated['message'];
            $message->TutorID = $validated['redactor_id'];
            $message->inv_number = $validated['inv_number'];
            $message->id_name = $validated['id_name'];
            $message->id_product = $validated['id_product'];
            $message->save();


        }

        return back()->with('warning', 'Отправлен на доработку');
    }

    public function change_tutor(){

        return view('backend.invertory.redactor.change');

    }

    public function search_item(Request $request)
    {
        // Получаем поисковой запрос из запроса GET
        $query = $request->input('query', '');

        // Выполняем поиск в таблице InProductList по полю inv_number
        $products = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors', 'in_product_lists.TutorID', '=', 'tutors.TutorID')
            ->where('in_product_lists.inv_number', 'like', "%$query%") // Фильтруем по inv_number
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                DB::raw("CONCAT(tutors.lastname, ' ', tutors.firstname) AS tutor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->get();

        // Возвращаем результат поиска на страницу search.blade.php
        return view('backend.invertory.redactor.search')->with('product', $products)->with('query', $query);
    }

    public function editChange ($id_product)
    {
        $edit = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors', 'in_product_lists.TutorID', '=', 'tutors.TutorID')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                DB::raw("CONCAT(tutors.lastname, ' ', tutors.firstname) AS tutor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->find($id_product);
        return view('backend.invertory.redactor.edit_change', compact('edit'));
    }


    public function insert(Request $request, $id_product)
    {
        $new_id = DB::table('in_product_lists')->insertGetId([
            'id_name' => $request->input('id_name'),
            'buildingID' => $request->input('buildingID'),
            'auditoryID' => $request->input('auditoryID'),
            'TutorID' => $request->input('TutorID'),
            'type' => $request->input('type'),
            'inv_number' => $request->input('inv_number'),
            'verification_status' => 1,
            'redactor_id'=> Auth::user()->TutorID,
        ]);

        $date = $request->input('date');

        // Проверка наличия загруженного файла
        if ($request->hasFile('file')) {
            try {
                $uniqueFileName = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('public/move_document', $uniqueFileName);

                Move::create([
                    'file' => 'move_document/' . $uniqueFileName,
                    'inv_number' => $request->input('inv_number'),
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Ошибка при загрузке файла: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Файл не был загружен.');
        }

        in_product_lists::where('id_product', $id_product)->update(['actual_inventory' => 0]);

        Note::where('id_product', $id_product)->delete();

        Note::create([
            'id_product' => $new_id,
            'note' => 'Перемещено'
        ]);



        return view('backend.invertory.redactor.change')->with('success','Перемещение успешно совершено!');
    }

    public function story($id_name)
    {
        $results = DB::table('in_product_lists')
            ->where('id_name', $id_name)
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
            ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
            ->leftJoin('move_inventory', 'in_product_lists.inv_number', '=', 'move_inventory.inv_number')
            ->whereNotNull('move_inventory.id') // Исключаем записи без связанных документов
            ->select(
                'auditories.auditoryName',
                'move_inventory.file',
                'move_inventory.inv_number',
                'move_inventory.id',
                DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname"),
                'in_product_lists.updated_at'
            )
            ->orderBy('updated_at')
            ->get();

        return view('backend.invertory.redactor.story', compact('results'));
    }

    public function move_view(Request $request, $id)
    {
        $view = DB::table('move_inventory')->where('id', $id)->first();

        if (!$view) {
            return redirect()->back()->with('error', 'Документ не найден.');
        }

        return view('backend.invertory.redactor.move_document_view', compact('view'));
    }


    /*public function writeOff($id_product)
    {
        in_product_lists::where('id_product', $id_product)->update(['write_off' => 0]);

        return back()->with('success', 'Инвертарь успешно списан');
    }*/

}
