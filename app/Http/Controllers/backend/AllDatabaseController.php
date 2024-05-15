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
            ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
            ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->get();

        return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
    }


}
