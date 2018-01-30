<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Items extends Model
{
    protected $table = 'cases_items';
	
	protected $fillable = ['case_id', 'name', 'img', 'rarity', 'type', 'price', 'percent'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
