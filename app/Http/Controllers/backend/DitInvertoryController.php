<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\in_product_list_characteristics;
use App\Models\in_list_characteristics;
use App\Models\in_product_lists;
use App\Models\in_characteristics_for_product;
use App\Models\Write_off;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Auditory;
use Illuminate\Support\Str;

class DitInvertoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateDit()
    {
        $building = DB::table('buildings')->get();

        $auditories = DB::table('auditories')->get();

        $sortedAuditories = $auditories->sortBy('auditoryName');

        return view('backend.invertory.create_invertory.dit_create', ['building' => $building, 'auditories' =>$sortedAuditories]);
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

    public function addAll(Request $request) {
        $quantity = $request->input('quantity'); // Получаем количество из инпута

        for ($i = 0; $i < $quantity; $i++) {
            // Вставка записи в таблицу in_product_lists и получение id
            $id = DB::table('in_product_lists')->insertGetId([
                'id_name' => $request->input('id_name'),
                'buildingID' => $request->input('buildingID'),
                'auditoryID' => $request->input('auditoryID'),
                'TutorID' => $request->input('TutorID'),
                'type' => $request->input('type'),
                'inv_number' => $request->input('inv_number'),
                'redactor_id' => Auth::user()->TutorID,
            ]);

            // Вставка значений в таблицу in_characteristics_for_product
            $values = $request->names;
            $id_characteristics = $request->id_characteristic;

            foreach ($values as $index => $value) {
                $id_characteristic = $id_characteristics[$index];

                in_characteristics_for_product::insert([
                    'current_status' => 0,
                    'id_product' => $id,
                    'id_characteristic' => $id_characteristic,
                    'characteristic_value' => $value,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Данные успешно добавлены!');
    }


    public function forBuilding($buildingId)
    {
        $auditories = Auditory::where('buildingID', $buildingId)->get();
        return response()->json($auditories);
    }
}
