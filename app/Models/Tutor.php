<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\in_product_lists;

class Tutor extends Model
{
    protected $connection = 'mysql_platonus';

    // Указываем имя таблицы, если оно не соответствует стандартному названию
    protected $table = 'tutors';

    protected $primaryKey = 'TutorID';
}
