<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class BankCashPayment extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "bank_cash_payment";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
}
