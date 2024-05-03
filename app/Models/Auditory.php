<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\in_product_lists;

class Auditory extends Model
{
    protected $connection = 'mysql_platonus';

    // Указываем имя таблицы, если оно не соответствует стандартному названию
    protected $table = 'auditories';

    // Указываем поля, которые можно массово назначать
    protected $fillable = ['auditoryNameKz', 'buildingID'];

    // Устанавливаем обратную связь к корпусам
    public function building()
    {
        return $this->belongsTo(Building::class, 'buildingID');
    }

}
