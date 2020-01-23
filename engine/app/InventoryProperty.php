<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryProperty extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "inventory_property";

	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';
    //
	public function item()
	{
		return $this->belongsTo('App\Item', 'item_id', 'id');
	}
	public function category()
	{
		return $this->belongsTo('App\Category', 'item_color_id', 'id');
	}
	public function brand()
	{
		return $this->belongsTo('App\Brand', 'brand_id', 'id');
	}


}
