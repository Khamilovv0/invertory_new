<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\in_characteristics_for_product;

class in_product_lists extends Model
{

    public $timestamps = false;

    protected $table = 'in_product_lists';
    protected $primaryKey = 'id_product';

    public function characteristics()
    {
        return $this->hasMany(in_characteristics_for_product::class, 'id_product', 'id_product');
    }

    protected $fillable = [
        'inv_number',
        'status',
        'current_status',
        'actual_inventory',
        'auditoryID',
        'buildingID',
        'id_name',
        'type',
    ];

}
