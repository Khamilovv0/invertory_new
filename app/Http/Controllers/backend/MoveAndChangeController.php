<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function change()
    {
        return view('backend.invertory.redactor.change');
    }
}
