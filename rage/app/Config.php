<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Config extends Model
{
    protected $table = 'config';
	
	protected $fillable = ['domain', 'sitename', 'title', 'description', 'keywords', 'mrh_ID', 'order_id', 'mrh_secret1', 'mrh_secret2'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
