<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\in_characteristics_for_product;
use App\Models\in_list_characteristics;
use App\Models\in_product_list_characteristics;
use Illuminate\Http\Request;
use App\Models\in_product_lists;
use Illuminate\Support\Facades\DB;
use App\Models\Auditory;
use App\Models\Building;
use Illuminate\Support\Facades\Auth;

class AllDatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        $items = in_product_lists::with(['characteristics' => function ($query) {
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
            ->get();




        return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
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
            ->find($id_product);
        return view('backend.invertory.redactor.move', compact('edit'));
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

    public function updateAll(Request $request,$id_product)
    {
        DB::table('in_product_lists')->where('id_product', $id_product)->first();
        $data = array();
        $data['buildingID'] = $request->buildingID;
        $data['auditoryID'] = $request->auditoryID;
        $data['TutorID'] = $request->TutorID;
        $data['status'] = 1;
        $update = DB::table('in_product_lists')->where('id_product', $id_product)->update($data);


        $values = $request->names;
        $id_characteristics = $request->id_characteristic;

        foreach ($values as $index => $value) {
            $id_characteristic = $id_characteristics[$index];

            // Пытаемся найти запись по заданным параметрам
            $characteristic = in_characteristics_for_product::where('id_product', $id_product)
                ->where('id_characteristic', $id_characteristic)
                ->first();

            // Если запись найдена, обновляем ее значение, если нет - создаем новую запись
            if ($characteristic) {
                $characteristic->update(['characteristic_value' => $value]);
            } else {
                in_characteristics_for_product::insert([
                    'id_product' => $id_product,
                    'id_characteristic' => $id_characteristic,
                    'characteristic_value' => $value,
                ]);
            }
            return redirect()->back()->with('success','Инвертаризация успешна обновлена!');
        }

        if ($update)
        {
            return redirect()->back()->with('success','Инвертаризация успешна обновлена!');
        }
        else
        {
            $notification=array
            (
                'messege'=>'error ',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
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
            $item->status = 2; // Замените 2 на нужное значение для подтвержденного статуса
            $item->save();
        }

        // Перенаправляем обратно на предыдущую страницу
        return back();
    }

    public function refuseStatus($id)
    {
        // Находим запись по ID
        $item = in_product_lists::where('id_product', $id)->firstOrFail();

        $adminTutorID = [646, 359];
        // Проверяем, является ли текущий пользователь администратором
        if (in_array(Auth::user()->TutorID, $adminTutorID)) {
            // Обновляем значение поля "status"
            $item->status = 3; // Замените 2 на нужное значение для подтвержденного статуса
            $item->save();
        }

        // Перенаправляем обратно на предыдущую страницу
        return back();
    }

}
