<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Opened extends Model
{
    protected $table = 'opened';
	
	protected $fillable = ['user_id', 'case_id', 'name', 'img', 'rarity', 'type', 'price'];
    
    protected $hidden = ['time'];
    
}
