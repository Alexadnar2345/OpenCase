<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Droped extends Model
{
    protected $table = 'item_droped';
	
	protected $fillable = ['drop_id', 'user_id', 'case_id', 'img', 'name', 'status', 'price'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
