<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Auditory;
use Illuminate\Support\Facades\DB;

class ToPdfController extends Controller
{
    public function open_pdf() {
        $auditories = DB::table('auditories')->get();

        $sortedAuditories = $auditories->sortBy('auditoryName');

        return view('backend.invertory.redactor.formation_inventory', ['auditories' => $sortedAuditories]);
    }

}
