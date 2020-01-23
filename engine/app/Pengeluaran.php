<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable; use SoftDeletes;
    public $table = "pengeluaran";

    protected $guarded = [];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
    const DELETED_AT = 'deletedOn';
    //
    public function kategori()
	{
		return $this->belongsTo('App\KategoriPengeluaran', 'kategori_pengeluaran_id', 'id');
    }
    
    public function inventaris()
	{
		return $this->belongsTo('App\Inventoris', 'inventaris_id', 'id');
    }

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
