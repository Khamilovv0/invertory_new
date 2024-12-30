<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\in_messages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = DB::table('in_messages AS m')
            ->where('m.TutorID', Auth::user()->TutorID)
            ->leftJoin('tutors AS t', 'm.TutorID', '=', 't.TutorID')
            ->leftJoin('in_product_name AS p', 'm.id_name', '=', 'p.id_name')
            ->select(
                'm.*',
                DB::raw("CONCAT(t.lastname, ' ', t.firstname) AS tutor_fullname"),
                'p.name_product'
            )
            ->orderBy('id_message', 'desc')
            ->get();

        return view('home', compact('messages'));
    }
}
