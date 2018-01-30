<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Withdraw extends Model
{
    protected $table = 'withdraw';
	
	protected $fillable = ['user_id', 'sum', 'wallet', 'system'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
