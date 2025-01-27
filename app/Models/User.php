<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'initial', 'first_name', 'last_name', 'father_name', 'phone_number', 'emergency_number', 'city', 'address', 'aadhar_number', 'driving_license_number', 'pan', 'salary', 'deduction', 'others', 'role', 'user_name', 'password', 'description', 'document', 'emp_id', 'location', 'joining_date', 'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
    /* public function attendance()
    {
        return $this->hasMany(Attendance::class);
    } */

    public function attendance(){
      return $this->hasMany(Attendance::class, 'employee_id');
      }

    public function branch() {
    return $this->belongsTo(Branch::class, 'location', 'id');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id');
    }

}
