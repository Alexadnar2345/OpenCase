<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Redis;
use DB;
use Auth;
use App\User;
use App\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function __construct()
    {
		$this->config = new ConfigController();
        $this->config = $this->config->config;
        $this->setTitle('Title not started');
        $this->setDesc('Desc not started');
        $this->setKeyw('Desc not started');
        $this->setSitename('SiteName not started');
        if(Auth::check())
        {
            $this->user = Auth::user();
            view()->share('u', $this->user);
        }
        $this->redis = Redis::connection();
        view()->share('drops', $this->getLive());
        view()->share('top', $this->getTop());
        view()->share('stats', $this->getStats());
    }
    
    public function setTitle($title)
    {
        $this->title = $this->config->title;
        view()->share('title', $this->title);
    }
    
    public function setDesc($description)
    {
        $this->description = $this->config->description;
        view()->share('description', $this->description);
    }
    
    public function setKeyw($description)
    {
        $this->keywords = $this->config->keywords;
        view()->share('keywords', $this->keywords);
    }
    
    public function setSitename($sitename)
    {
        $this->sitename = $this->config->sitename;
        view()->share('sitename', $this->sitename);
    }
    
    public function getLive()
    {
        $list = DB::table('opened')->orderBy('id', 'desc')->limit(20)->get();
        $drops = [];
        for($i = 0; $i < count($list); $i++) {
            $user = User::where('id', $list[$i]->user_id)->first();
            if(isset($user)) {
                $drops[] = [
                    'name' => $list[$i]->name,
                    'img' => $list[$i]->img,
                    'type' => $list[$i]->type,
                    'rarity' => $list[$i]->rarity,
                    'price' => $list[$i]->price,
                    'user' => $user
                ];
            }
        }
        return $drops;
    }
    
    public function getTop()
    {
        $users = User::join('opened', 'opened.user_id', '=', 'users.id')
            ->select('users.id', DB::raw('SUM(opened.price) as value'), DB::raw('COUNT(opened.id) as cases'), 'users.name', 'users.avatar')
            ->orderBy('value', 'desc')
            ->groupBy('users.id')
            ->limit(10)
            ->get();
        
        return $users;
    }
    
    public function getStats()
    {
        return [
            'users' => User::count(),
            'opened' => DB::table('opened')->count()
        ];
    }
}
