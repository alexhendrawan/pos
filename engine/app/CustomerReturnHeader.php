<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerReturnHeader extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "customer_return_header";

	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';
    //

	public function sales()
	{
		return $this->belongsTo('App\CustomerShipmentHeader', 'sales_id','sales_order_header_id');
	}

	public function detail()
	{
		return $this->hasMany('App\CustomerReturnLine', 'customer_return_header_id', 'id');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer', 'customer_id', 'id');
	}
}


