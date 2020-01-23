<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderHeader extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "sales_order_header";

	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';
    //
	public function customer()
	{
		return $this->belongsTo('App\Customer', 'customer_id', 'id');
	}
	public function detail()
	{
		return $this->hasMany('App\SalesOrderLine', 'sales_order_header_id', 'id');
	}
}
