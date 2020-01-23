<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerShipmentHeader extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
	public $table = "customer_shipment_header";
	protected $guarded = [];
	const CREATED_AT = 'createdOn';
	const UPDATED_AT = 'updatedOn';
	const DELETED_AT = 'deletedOn';

	public function sales()
	{
		return $this->belongsTo('App\SalesOrderHeader', 'sales_order_header_id', 'id');
	}

	public function supir()
	{
		return $this->belongsTo('App\User', 'sales1_id', 'id');
	}
	
	public function kenek()
	{
		return $this->belongsTo('App\User', 'sales2_id', 'id');
	}
}
