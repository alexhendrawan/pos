<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMutation extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "stock_mutation";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
     public function stock()
    {
        return $this->belongsTo('App\ItemStock', 'item_stock_id', 'id');
    }
}
