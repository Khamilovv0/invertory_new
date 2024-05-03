<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\in_product_lists;

class Building extends Model
{

    protected $connection = 'mysql_platonus';
    // Указываем имя таблицы, если оно не соответствует стандартному названию
    protected $table = 'buildings';

    // Указываем поля, которые можно массово назначать
    protected $fillable = ['buildingName'];

    // Устанавливаем связь с аудиториями
    public function auditories()
    {
        return $this->hasMany(Auditory::class, 'buildingID');
    }

}
