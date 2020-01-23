<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class POHeader extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "po_header";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
    public function supplier()
	{
		return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
	}

    public function warehouse()
	{
		return $this->belongsTo('App\Warehouse', 'Warehouse_id', 'id');
	}
}
