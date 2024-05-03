<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
        protected $fillable = [
        "TutorID",
        "token"
    ];

    protected $table = 'token';
    protected $primaryKey = 'token_id';
}
