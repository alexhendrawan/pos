<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoicePayment extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "purchase_invoice_payment";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //

        public function purchaseinvoiceheader()
	{
		return $this->belongsTo('App\PurchaseInvoiceHeader', 'purchase_invoice_header_id', 'id');
	}
}
