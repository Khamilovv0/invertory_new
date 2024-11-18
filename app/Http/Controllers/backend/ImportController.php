<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\InvertoryImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        try {
            Excel::import(new InvertoryImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Импорт завершен');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ошибка импорта: ' . $e->getMessage());
        }
    }
}
