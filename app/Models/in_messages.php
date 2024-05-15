<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_messages extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'in_messages';
    protected $primaryKey = 'id_message';
}
