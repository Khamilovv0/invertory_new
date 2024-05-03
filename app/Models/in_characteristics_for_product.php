<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_characteristics_for_product extends Model
{
    protected $fillable = ['characteristic_value'];
    // другие свойства и методы

    protected $table = 'in_characteristics_for_products';
    protected $primaryKey = 'id_characteristics_for_product';

    public function characteristic()
    {
        return $this->belongsTo(in_list_characteristics::class, 'id_characteristic', 'id_characteristic');
    }
}
