<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanInterest extends Model
{
  use HasFactory;

  /* protected $table ='loan_interest_payments';
  protected $fillable = ['loan_id', 'month', 'interest_amount', 'payment_method','user_id']; */



  public function loanType()
  {
      return $this->belongsTo(LoanType::class);
  }
}
