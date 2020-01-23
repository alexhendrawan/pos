<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReturnHeader extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    public $table = "supplier_return_header";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_code', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo('App\PurchaseInvoiceHeader', 'po_id', 'poheader_id');
    }

    public function detail()
    {
        return $this->hasMany('App\SupplierReturnLine', 'supplier_return_header_id', 'id');
    }
}
