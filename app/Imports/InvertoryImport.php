<?php

namespace App\Imports;

use App\Models\in_product_lists;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvertoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        Log::info("Начало импорта инвентаря, количество строк: " . $rows->count());

        foreach ($rows as $index => $row) {
            Log::info("Обработка строки: {$index}");

            // Получаем значение из столбца 'inv_number'
            $inv_number = $row['inv_number'] ?? null;
            Log::info("Инвентарный номер: " . ($inv_number ?: 'отсутствует'));

            if (is_null($inv_number)) {
                Log::warning("Пропуск строки {$index}: inv_number отсутствует");
                continue;
            }

            // Проверка на дубликат
            $existingRecord = in_product_lists::where('inv_number', $inv_number)->first();
            if ($existingRecord) {
                Log::warning("Дубликат inv_number: {$inv_number}");
                continue;
            }

            // Получение ID для аудиторий
            $auditoryID = DB::table('auditories')->where('auditoryName', $row['auditoryname'])->value('auditoryID');
            if (is_null($auditoryID)) {
                Log::warning("Не найдена аудитория для строки {$index}");
                continue;
            }

            // Получение ID для зданий
            $buildingID = DB::table('buildings')->where('buildingName', $row['buildingname'])->value('buildingID');
            if (is_null($buildingID)) {
                Log::warning("Не найдено здание для строки {$index}");
                continue;
            }

            // Получение ID для названия продукта
            $id_name = DB::table('in_product_name')->where('name_product', $row['name_product'])->value('id_name');
            if (is_null($id_name)) {
                Log::warning("Не найдено название продукта для строки {$index}");
                continue;
            }

            // Определение типа (1 - Личный, 2 - Аудиторный)
            $type = $row['type'] == 'Личный' ? 1 : ($row['type'] == 'Аудиторный' ? 2 : null);
            if (is_null($type)) {
                Log::warning("Некорректный тип для строки {$index}");
                continue;
            }

            in_product_lists::create([
                'inv_number' => $inv_number,
                'status' => 1,
                'current_status' => 1,
                'actual_inventory' => 1,
                'auditoryID' => !empty($auditoryID) ? $auditoryID : null,
                'buildingID' => !empty($buildingID) ? $buildingID : null,
                'id_name' => !empty($id_name) ? $id_name : null,
                'type' => !empty($type) ? $type : null,
            ]);

            Log::info("Успешно добавлена запись с inv_number: {$inv_number}");
        }

        Log::info("Импорт завершен");
    }
}
