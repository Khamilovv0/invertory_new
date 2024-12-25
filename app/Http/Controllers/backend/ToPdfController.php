<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Auditory;
use App\Models\in_product_lists;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToPdfController extends Controller
{
    public function open_pdf() {
        $auditories = DB::table('auditories')->get();

        $sortedAuditories = $auditories->sortBy('auditoryName');

        return view('backend.invertory.redactor.formation_inventory', ['auditories' => $sortedAuditories]);
    }

    public function generatePdf(Request $request)
    {
        // Получение значения auditoryID из формы
        $auditoryID = $request->input('auditoryID');
        $head = $request->input('head');

        // Проверка, что аудитория была выбрана
        if (!$auditoryID) {
            return redirect()->back()->withErrors(['auditoryID' => 'Пожалуйста, выберите аудиторию']);
        }

        // Получение данных из таблицы in_product_lists, фильтрация по auditoryID
        $items = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->where('in_product_lists.auditoryID', $auditoryID)
            ->leftJoin('in_product_name', 'in_product_lists.id_name', '=', 'in_product_name.id_name')
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->leftJoin('tutors', 'in_product_lists.TutorID', '=', 'tutors.TutorID')
            ->select(
                'in_product_lists.*',
                'auditories.auditoryName',
                'in_product_name.name_product',
                'tutors.lastname',
                'tutors.firstname',
            )
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->where('in_product_lists.verification_status', 2)
            ->orderBy('id_product', 'desc')
            ->get();

        // Подготовка изображения
        $imagePath = public_path('backend/dist/img/metu.png');
        $imageData = base64_encode(file_get_contents($imagePath));

        // Передача данных в шаблон
        $data = [
            'head' => $head,
            'items' => $items,
            'auditoryID' => $auditoryID,
            'imageBase64' => 'data:image/jpeg;base64,' . $imageData,
        ];

        // Генерация PDF
        $pdf = Pdf::loadView('backend.invertory.redactor.inventory_pdf', $data);

        return $pdf->stream('document.pdf'); // Открыть PDF в браузере
    }

}
