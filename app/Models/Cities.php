<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $table ='tbl_cities';
    public function customers()
    {
        return $this->hasMany(Customer::class, 'city_id');
    }
}
