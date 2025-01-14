<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Auditory;
use App\Models\in_product_lists;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ForQrCodeController extends Controller
{
    public function for_qr_list_inv(){
        $list = in_product_lists::with(['characteristics' => function ($query) {
            $query->with('characteristic')->where('current_status', '0');
        }])
            ->leftJoin('auditories', 'in_product_lists.auditoryID', '=', 'auditories.auditoryID')
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->where('in_product_lists.verification_status', 2)
            ->orderBy('id_product', 'desc')->get();

        return view('backend.invertory.generator.for_qr_list_inv', ['for_qr' => $list]);
    }
    public function for_qr_list_auditory(){
        $list = DB::table('auditories')
            ->get();
        $sortedAuditories = $list->sortBy('auditoryName');

        return view('backend.invertory.generator.for_qr_list_auditory', ['for_qr' => $sortedAuditories]);
    }

    public function qr_generate_inv(Request $request)
    {
        // Получаем массив ID продуктов из формы
        $id_products = $request->input('id_products');

        // Проверяем, есть ли данные
        if (empty($id_products)) {
            return back()->with('error', 'Выберите хотя бы один инвентарный номер.');
        }

        // Получаем данные из базы для выбранных ID
        $products = in_product_lists::whereIn('id_product', $id_products)
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->where('in_product_lists.verification_status', 2)
            ->select('inv_number', 'id_product')
            ->get();

        // Генерируем QR-коды для каждого продукта и кодируем их в base64
        foreach ($products as $product) {
            $url = route('qr_scan_list', ['id_product' => $product->id_product]); // Генерация ссылки через маршрут
            $qrCode = QrCode::format('svg')
                ->size(432) // Размер в пикселях (54 мм)
                ->margin(0) // Без отступов
                ->generate($url); // Вставляем URL в QR-код

            $product->qr_code_base64 = base64_encode($qrCode);
        }

        // Передаём данные в PDF
        $pdf = Pdf::loadView('backend.invertory.generator.qr_generated', ['products' => $products]);

        // Возвращаем PDF
        return $pdf->stream('qr_pdf.pdf'); // Открыть PDF в браузере
    }

    public function qr_generate_auditory(Request $request)
    {
        // Получаем auditoryID из формы
        $auditoryID = $request->input('auditoryID');

        // Проверяем, есть ли данные
        if (empty($auditoryID)) {
            return back()->with('error', 'Выберите хотя бы один Auditory ID.');
        }

        // Получаем данные из базы для указанного auditoryID
        $products = in_product_lists::where('auditoryID', $auditoryID)
            ->where('in_product_lists.actual_inventory', 1)
            ->where('in_product_lists.write_off', 1)
            ->where('in_product_lists.verification_status', 2)
            ->select('inv_number', 'id_product', 'auditoryID')
            ->get();

        // Проверяем, есть ли записи для указанного auditoryID
        if ($products->isEmpty()) {
            return back()->with('error', 'Нет данных для указанного Auditory ID.');
        }

        // Генерируем QR-коды для каждого продукта
        foreach ($products as $product) {
            $url = route('qr_scan_list', ['id_product' => $product->id_product]); // Генерация ссылки через маршрут
            $qrCode = QrCode::format('svg')
                ->size(432) // Размер в пикселях (54 мм)
                ->margin(0) // Без отступов
                ->generate($url); // Вставляем URL в QR-код

            $product->qr_code_base64 = base64_encode($qrCode);
        }


        // Генерируем PDF с QR-кодами
        $pdf = Pdf::loadView('backend.invertory.generator.qr_generated', ['products' => $products]);

        // Возвращаем PDF
        return $pdf->stream('qr_pdf.pdf');
    }


    public function qr_scan_list($id_product)
    {

        // Базовый запрос
        $query = in_product_lists::with(['characteristics' => function ($query) {
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
            ->where('in_product_lists.verification_status', 2);

        // Добавление условия поиска, если передан id_product
        if (!empty($id_product)) {
            $query->where('in_product_lists.id_product', $id_product);
        }

        // Получение данных
        $items = $query->orderBy('id_product', 'desc')->get();

        // Возврат представления с данными
        return view('backend.invertory.generator.qr_scan_list', ['items' => $items]);
    }

}
