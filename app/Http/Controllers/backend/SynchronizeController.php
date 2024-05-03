<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\in_product_list_characteristics;

class SynchronizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function synchronize(){

        $characteristics = in_product_list_characteristics::with('in_product_name', 'in_list_characteristics')->get();

        return view('backend.invertory.category.synchronize', ['list' => $characteristics]);
    }

    public function synchronize_complete(Request $request){


        $categoryId = $request->id_name;
        $parameters = $request->properties;

        foreach ($parameters as $param) {
            in_product_list_characteristics::create([
                'id_name' => $categoryId,
                'id_characteristic' => $param,
            ]);
        }



        return redirect()->back()->with('success', 'Данные успешно синхронизированы!');

    }


}
