<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use DB;

class AuthController extends Controller
{    
    
    public function login(Request $r)
    {   
        if($r->get('code')) {
            $user = Socialite::driver('vkontakte')->user();
            $response = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='.$user->user['uid'].'&fields=photo_200,sex&access_token='.$user->token.'&v=5.60'));
            $avatar = false;
            if($response->response[0]->first_name != 'DELETED') $avatar= $response->response[0]->photo_200;
            $auth = $this->findOfCreateUser($user, $avatar);
            Auth::login($auth, true, 1);
            return redirect('/');
        }
        
        return Socialite::driver('vkontakte')->scopes(['friends', 'photo_200', 'sex'])->redirect();
    }
    
    private function findOfCreateUser($user, $avatar) {
        $ava = $user->avatar;
        if($avatar) $ava = $avatar;
        
        $u = User::where('vk_id', $user->id)->first();
		$partner = User::where('id', \Request::cookie('ref'))->first();
		
		$cookie = \Request::cookie('ref');
		if($cookie == null) $cookie = 0;
		
        if($u) {
            DB::table('users')->where('vk_id', $u->vk_id)->update([
                'name' => $user->name,
                'avatar' => $ava,
                'token' => $user->token
            ]);
			if($u->partner == 0)  {
				DB::table('users')->where('id', $u->id)->update(['partner' => \Request::cookie('ref')]);
				if(!$cookie == null) DB::table('users')->where('id', $partner->id)->update(['money' => $partner->money+1]);
            }
            $user = $u;
        } else {
            $user = User::create([
                'vk_id' => $user->id,
                'name' => $user->name,
                'avatar' => $ava,
                'token' => $user->token,
				'partner' => $cookie
            ]);
			if(!$cookie == null) DB::table('users')->where('id', $partner->id)->update(['money' => $partner->money+1]);
        }
        return $user;
    }
    
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}