<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_product_name extends Model
{
    use HasFactory;

    protected $table = 'in_product_name';
    protected $primaryKey = 'id_name';

    public function in_product_list_characteristics()
    {
        return $this->hasMany(in_product_list_characteristics::class, 'id_name', 'id_name');
    }

}

