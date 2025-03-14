<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    protected $table ='pincode';

    protected $fillable =['name', 'name_tamil', 'pin_code', 'status', 'added_by','updated_by'];


    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function customers()
{
    return $this->hasMany(Customer::class, 'pincode');
}



}
