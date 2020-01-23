<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemStock extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "item_stock";

	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';
    //

	public function inventoryproperty()
	{
		return $this->belongsTo('App\InventoryProperty', 'item_id', 'id');
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
