<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cases extends Model
{
    protected $table = 'cases';
	
	protected $fillable = ['title', 'img', 'price', 'type', 'is_active'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
