<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_product_list_characteristics extends Model
{
    protected $fillable = ['id_name', 'id_characteristic'];

    protected $table = 'in_product_list_characteristics';
    protected $primaryKey = 'id_product_characteristic';

    public function in_product_name()
    {
        return $this->belongsTo(in_product_name::class, 'id_name', 'id_name');
    }

    public function in_list_characteristics()
    {
        return $this->belongsTo(in_list_characteristics::class, 'id_characteristic', 'id_characteristic');
    }
}
