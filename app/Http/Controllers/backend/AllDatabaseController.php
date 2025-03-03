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
use Mockery\Matcher\Not;
use Yajra\DataTables\DataTables;

class AllDatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        $items = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
            ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
            ->leftJoin('notes', 'in_product_lists.id_product', '=', 'notes.id_product')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                'notes.note',
                DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->orderBy('id_product', 'desc')
            ->get();

        return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
    }

    public function filter()
    {
        $items = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
            ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
            ->leftJoin('notes', 'in_product_lists.id_product', '=', 'notes.id_product')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                'notes.note',
                DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->whereNotNull('in_product_lists.TutorID')
            ->whereNotNull('in_product_lists.type')
            ->whereNotNull('in_product_lists.auditoryID')
            ->orderBy('id_product', 'desc')
            ->get();

        return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
    }

    public function noSorted()
        {
            $items = in_product_lists::with(['characteristics' => function ($query) {
                $query->with('characteristic')->where('current_status', '0');
            }])
                ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
                ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
                ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
                ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
                ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
                ->leftJoin('notes', 'in_product_lists.id_product', '=', 'notes.id_product')
                ->select(
                    'in_product_lists.*',
                    'buildings.buildingName',
                    'auditories.auditoryName',
                    'in_product_name.name_product',
                    'notes.note',
                    DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                    DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname")
                )
                ->where('in_product_lists.actual_inventory', 1)
                ->where('in_product_lists.write_off', 1)
                ->whereNull('in_product_lists.type')
                ->orWhereNull('in_product_lists.auditoryID')
                ->orWhereNull('in_product_lists.inv_number')
                ->orderBy('id_product', 'desc')
                ->get();

            return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
        }

    public function noNumber()
    {
        $items = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('buildings', 'in_product_lists.buildingID', '=', 'buildings.buildingID')
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('tutors AS tutor', 'in_product_lists.TutorID', '=', 'tutor.TutorID')
            ->leftJoin('tutors AS redactor', 'in_product_lists.redactor_id', '=', 'redactor.TutorID')
            ->leftJoin('notes', 'in_product_lists.id_product', '=', 'notes.id_product')
            ->select(
                'in_product_lists.*',
                'buildings.buildingName',
                'auditories.auditoryName',
                'in_product_name.name_product',
                'notes.note',
                DB::raw("CONCAT(tutor.lastname, ' ', tutor.firstname) AS tutor_fullname"),
                DB::raw("CONCAT(redactor.lastname, ' ', redactor.firstname) AS redactor_fullname")
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->whereNull('in_product_lists.inv_number')
            ->orderBy('id_product', 'desc')
            ->get();

        return view('backend.invertory.create_invertory.all_db', ['items' => $items]);
    }

    public function export()
    {
        $items = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
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
            ->where('in_product_lists.write_off', 1)
            ->orderBy('id_product', 'desc')
            ->get();

        return view('backend.invertory.create_invertory.export_db', ['items' => $items]);
    }
}
