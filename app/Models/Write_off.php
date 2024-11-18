<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Write_off extends Model
{
    protected $table = 'write_off'; // если имя таблицы не совпадает с именем модели (по умолчанию Laravel ожидает таблицу во множественном числе)

    // Убедитесь, что эти поля могут быть массово назначены
    protected $fillable = ['inv_number', 'document_number', 'theme', 'file', 'date', 'id_product'];
}
