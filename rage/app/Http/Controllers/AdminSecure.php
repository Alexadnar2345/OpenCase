<?php

namespace App\Http\Controllers;

use Auth;

class AdminSecure extends Controller
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public $user;
    public $redis;
    public $title;
    
    public function __construct()
    {
        if(Auth::guest()) return view('errors.404');
        if($this->user->state != 2) return view('errors.404');
        
        $this->setTitle('Title not started');
        
        $this->user = Auth::user();
        view()->share('u', $this->user);
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        view()->share('title', $this->title);
    }
}
