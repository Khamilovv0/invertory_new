<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_list_characteristics extends Model
{
    use HasFactory;

    protected $table = 'in_list_characteristics';
    protected $primaryKey = 'id_characteristic';

    public function in_product_list_characteristics()
    {
        return $this->hasMany(in_product_list_characteristics::class, 'id_characteristic', 'id_characteristic');
    }

}
