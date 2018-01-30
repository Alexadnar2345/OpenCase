<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
	
	protected $fillable = ['vk_id', 'name', 'avatar', 'token', 'partner'];
    
    protected $hidden = ['token', 'remember_token'];
    
    public static function find($id) {
        $user = \DB::table('users')->where('vk_id', $id)->first();
        if(!$user) return false;
        return true;
    }
    
}
