<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesInvoiceLine extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "sales_invoice_line";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
}
