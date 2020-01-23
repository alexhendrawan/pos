<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoiceHeader extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "purchase_invoice_header";

	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';
    //

	public function poheader()
	{
		return $this->belongsTo('App\POHeader', 'poheader_id', 'id');
    }
    public function detail()
    {
        return $this->hasMany('App\PurchaseInvoiceLine', 'purchase_invoice_header_id', 'id');
	}
	public function payment()
    {
        return $this->hasMany('App\PurchaseInvoicePayment', 'purchase_invoice_header_id', 'id');
    }
}
