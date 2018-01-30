<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConfigController extends Controller
{
    public function __construct() {
        $this->config = $this->getConfig();
    }
    
    public function getConfig() {
        $config = DB::table('config')->first();
        return $config;
    }
}
