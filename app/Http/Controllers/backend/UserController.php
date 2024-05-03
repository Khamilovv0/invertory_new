<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function UserList(Request $request)
    {
        $list = DB::connection('mysql_platonus')->table('tutors')->get();
        return view('backend.user.list_user',compact('list'));
    }

}
