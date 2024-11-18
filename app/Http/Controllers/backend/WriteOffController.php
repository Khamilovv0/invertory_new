<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\in_product_lists;
use App\Models\Write_off;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WriteOffController extends Controller
{
    public function write_off(){

        return view('backend.invertory.create_invertory.write_off');

    }

    public function write_off_save(Request $request)
    {
        $invNumbers = $request->input('inv_numbers');
        $document_number = $request->input('document_number');
        $theme = $request->input('theme');
        $date = $request->input('date');

        // Проверка на наличие загруженного файла
        if ($request->hasFile('file')) {
            // Генерация уникального имени для файла
            $uniqueFileName = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();

            // Сохранение файла в папку public с уникальным именем
            $filePath = $request->file('file')->storeAs('public/act', $uniqueFileName);

            // Перебор каждого инвентарного номера и добавление записи
            foreach ($invNumbers as $inv_number) {
                $id_product = DB::table('in_product_lists')->where('inv_number', $inv_number)->value('id_product');

                // Вставка записи с использованием Eloquent
                Write_off::create([
                    'inv_number' => $inv_number,
                    'document_number' => $document_number,
                    'theme' => $theme,
                    'file' => $uniqueFileName,
                    'date' => $date,
                    'id_product' => $id_product,
                ]);

                // Обновление write_off на 0 для текущего id_product
                DB::table('in_product_lists')
                    ->where('id_product', $id_product)
                    ->update(['write_off' => 0]);
            }

        }

        return redirect()->back()->with('success', 'Записи успешно добавлены в список списанных инвентарей.');
    }

    public function write_off_list(){

        $results=DB::table('write_off')
            ->leftJoin('in_product_lists', 'write_off.id_product', '=', 'in_product_lists.id_product')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->get();

        return view('backend.invertory.create_invertory.write_off_list', compact('results'));

    }

    public function doc_view(Request $request, $id){
        $view = DB::table('write_off')->where('id', $id)->first();

        return view('backend.invertory.create_invertory.document_view', compact('view'));
    }
}
