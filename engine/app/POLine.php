<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class POLine extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;use SoftDeletes;
    public $table = "po_line";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //

    public function purchaseline()
    {
        return $this->belongsTo('App\PurchaseInvoiceLine', 'id', 'po_line_id');
    }

    public function inventoryproperty()
    {
        return $this->belongsTo('App\InventoryProperty', 'inventory_property_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo('App\ItemStock', 'item_stock_id', 'id');
    }

    public function satuan()
    {
        return $this->belongsTo('App\Satuan', 'satuan_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_id', 'id');
    }
}
