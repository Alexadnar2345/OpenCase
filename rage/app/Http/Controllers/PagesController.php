<?php

namespace App\Http\Controllers;
use File;
use Auth;
use App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SteamController;
use Invisnik\LaravelSteamAuth\SteamAuth;
use Carbon\Carbon;
use DB;
use Socialite;
use App\User;
use App\Cases;
use App\Config;
use App\Droped;
use App\Withdraw;

class PagesController extends Controller
{
	public function __construct() {
		parent::__construct();
        $this->config = new ConfigController();
        $this->config = $this->config->config;
		$title = $this->config->title;
    }
    
    /*Попонение*/
    public function pay(Request $r)
	{
        $sum = $r->get('num');
		
		if(!$sum) return \Redirect::back();
        /*CREATE PAY*/
        $pay = [
            'secret' => md5($this->config->mrh_ID . ":" . $sum . ":" . $this->config->mrh_secret1 . ":" . $this->config->order_id),
            'merchant_id' => $this->config->mrh_ID,
            'order_id' => $this->config->order_id,
            'sum' => $r->get('num'),
            'user_id' => $this->user->vk_id
        ];
        DB::table('payments')->insert($pay);
        /*REDIRECT*/
        
        DB::table('config')->where('id', 1)->update([
            'order_id' => $this->config->order_id+1 
        ]);
        
        return Redirect('https://www.free-kassa.ru/merchant/cash.php?m='.$this->config->mrh_ID.'&oa='.$r->get('num').'&o='.$pay['order_id'].'&s='.md5($this->config->mrh_ID.':'.$sum.':'.$this->config->mrh_secret1.':'.$pay['order_id']));
        
	}
	
	public function result(Request $r)
	{
        $ip = false;
        if(isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $this->getIp($_SERVER['HTTP_X_REAL_IP']);
        } else {
            $ip = $this->getIp($_SERVER['REMOTE_ADDR']);
        }
        if(!$ip) return 'Ошибка при проверке IP free-kassa';
        /* SEARCH MERCH */
        $merch = DB::table('payments')->where('order_id', $r->get('MERCHANT_ORDER_ID'))->first();
		$merch_order_id = $r->get('MERCHANT_ORDER_ID');
        if(!$merch) return 'Не удалось найти заказ #'.$r->get('MERCHANT_ORDER_ID');
        /* ADD BALANCE TO USER */
        #check amount
        if($r->get('AMOUNT') != $merch->sum) return 'Вы оплатили не тот заказ!';
        
        $user = User::where('vk_id', $merch->user_id)->first();
        if(!$user) return 'Не удалось найти юзера!';
        
		/* ADD Balance from user and partner */
        $sum = floor($merch->sum);
		$money = count($sum);
		if($sum < 5000) $money = 5;
		if($sum > 5000) $money = 10;
		if($sum > 10000) $money = 15;
        User::where('vk_id', $user->vk_id)->update([
            'money' => $user->money+$sum 
        ]);
		if($user->partner != 0) {
			$partner = User::where('id', $user->partner)->first();
			$partner->money += $sum / 100 * $money;
			$partner->save();
		}
        
        /*UPDATE MERCH STATUS*/
        DB::table('payments')->where('order_id', $merch_order_id)->update([
            'status' => 1 
        ]);
		
		DB::table('success_pay')->insert([
        	'user' => $user->vk_id,
            'price' => $sum,
            'status' => 1,
       	]);
        
        /* SUCCESS REDIRECT */
        return redirect()->route('home');
	}
    
    /* CHECK FREE KASSA IP */
    function getIp($ip) {
        $list = ['136.243.38.147','136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189'];
        for($i = 0; $i < count($list); $i++) {
            if($list[$i] == $ip) return true;
        }
        return false;
    }
	
	function success() {
		return view('pages.pay.success');
	}
	
	function fail() {
		return view('pages.pay.fail');
	}
    /*Попонение*/
    
    public function index(Request $r) {
		if (($r->get('ref') || $r->get('REF')) and Auth::Guest()) {
            \Cookie::queue(\Cookie::make('ref', str_replace("ref", "", $r->get('ref')), 60));
        } elseif (($r->get('ref') || $r->get('REF')) and Auth::user()->partner == 0 and Auth::user()->id != str_replace("ref", "", $r->get('ref'))) {
            \Cookie::queue(\Cookie::make('ref', str_replace("ref", "", $r->get('ref')), 60));
        }
		
        $cases = $this->getDefaultCases();
        $cases_item = $this->getItemCases();
		
        return view('pages.index', compact('cases', 'cases_item'));
    }
    
    public function profile($id) {
        $user = User::where('id', $id)->first();
        if(!$user) return view('errors.404');
        $title = 'Профиль - '.$user->name;
        
        $data = [
            'username' => $user->name,
            'avatar' => $user->avatar,
            'id' => $user->vk_id,
            'cases' => DB::table('opened')->where('user_id', $id)->count(),
            'price' => number_format(DB::table('opened')->where('user_id', $id)->sum('price'), 0, ',', ' ')
        ];
        
        $last_drops = DB::table('opened')->where('user_id', $id)->orderBy('id', 'desc')->limit(35)->get();
        
        // Нужно будет подвести статистику юзера
        return view('pages.profile', compact('title', 'data', 'last_drops'));
    }
    
    public function my_profile() {
        if(Auth::guest()) return view('errors.404');
        $title = 'Профиль';
        $user = $this->user;
		
		$data = [
            'username' => $user->name,
            'avatar' => $user->avatar,
            'money' => $user->money,
            'id' => $user->vk_id,
            'cases' => DB::table('opened')->where('user_id', $user->id)->count(),
            'price' => number_format(DB::table('opened')->where('user_id', $user->id)->sum('price'), 0, ',', ' ')
        ];
        
        $last_drops = DB::table('opened')->where('user_id', $user->id)->orderBy('id', 'desc')->limit(35)->get();
		
        $item_drops = Droped::where('user_id', $user->id)->where('status', 0)->orderBy('drop_id', 'desc')->get();
        
        return view('pages.my_profile', compact('title', 'data', 'last_drops', 'item_drops'));
    }
    
    public function ref() {
        $title = 'Реф. Система';
        
        return view('pages.ref', compact('title'));
    }
    
    public function faq() {
        $title = 'FAQ';
        
        return view('pages.faq', compact('title'));
    }
    
    public function license() {
        $title = 'Пользовательское соглашение';
        return view('pages.license', compact('title'));
    }
    
    public function getDefaultCases() {
        $list = Cases::where('is_active', 1)->where('type', 0)->orderBy('price', 'asc')->get();
        $cases = [];
        for($i = 0; $i < count($list); $i++) {
            $items = DB::table('cases_items')->where('case_id', $list[$i]->id)->get();
            if($items) {
                # Сортировка предметов в кейсе по убыванию цены
                usort($items, function($a,$b) {
                    return ($b->price-$a->price);
                });
                
                $max_price = $items[0]->price; // Максимальный выигрыш
                
                #Переворачиваем массив, дабы получить минимальный выигрыш
                
                $items = array_reverse($items);
                
                $min_price = $items[0]->price; // Минимальный выигрыш
                
                # Поиск минимального и максимального выигрыша из кейса
                
                # Сбор массива
                $cases[] = [
                    'id' => $list[$i]->id,
                    'title' => $list[$i]->title,
                    'img' => $list[$i]->img,
                    'price' => $list[$i]->price,
                    'type' => $list[$i]->type,
                    'place' => $list[$i]->place,
                    'min_price' => $min_price,
                    'max_price' => $max_price
                ];
            }
        }
        return $cases;
    } 
	
	public function getItemCases() {
        $list = Cases::where('is_active', 1)->where('type', 1)->orderBy('price', 'asc')->get();
        $cases = [];
        for($i = 0; $i < count($list); $i++) {
            $items = DB::table('cases_items')->where('case_id', $list[$i]->id)->get();
            if($items) {
                # Сортировка предметов в кейсе по убыванию цены
                usort($items, function($a,$b) {
                    return ($b->price-$a->price);
                });
                
                $max_price = $items[0]->price; // Максимальный выигрыш
                
                #Переворачиваем массив, дабы получить минимальный выигрыш
                
                $items = array_reverse($items);
                
                $min_price = $items[0]->price; // Минимальный выигрыш
                
                # Поиск минимального и максимального выигрыша из кейса
                
                # Сбор массива
                $cases[] = [
                    'id' => $list[$i]->id,
                    'title' => $list[$i]->title,
                    'img' => $list[$i]->img,
                    'item' => $list[$i]->item,
                    'price' => $list[$i]->price,
                    'type' => $list[$i]->type,
                    'place' => $list[$i]->place,
                    'min_price' => $min_price,
                    'max_price' => $max_price
                ];
            }
        }
        return $cases;
    }
    
    public function case($id) {
        $title = 'Открытие кейса';
        
        $case = $this->getCase($id);
        $withdraw = DB::table('opened')->where('case_id', $id)->sum('price');
        $line = [];
        for($i = 0; $i < 7; $i++) foreach($case->items as $item) $line[] = $item;
        return view('pages.case', compact('case', 'withdraw', 'line', 'title'));
    }
    
    public function getCase($id) {
        $case = Cases::where('id', $id)->first();
        if(!$case) return;
        $items = DB::table('cases_items')->where('case_id', $id)->orderBy('price', 'asc')->get();
        $case->items = $items;
        $case->min = DB::table('cases_items')->where('case_id', $id)->orderBy('price', 'asc')->first();
        $case->max = DB::table('cases_items')->where('case_id', $id)->orderBy('price', 'desc')->first();
        return $case;
    }
    
    public function test() {
        /*$sum = floor('6000');
		$money = count($sum);
		if($sum < 5000) $money = 5;
		if($sum > 5000) $money = 10;
		if($sum > 10000) $money = 15;
        return $money;*/
		$user = User::where('vk_id', '9798985')->where('partner', '1')->first();
		return $user->partner;
    }
    /*Вывод баланса*/
    
    /*Проверка баланса FKW (Работает уже почти XD)*/
    public function getBalans_frw() {
		$data = array(
			'wallet_id' => $this->config->fk_wallet,
			'sign' => md5($this->config->fk_wallet.$this->config->fk_api),
			'action' => 'get_balance',
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://wallet.free-kassa.ru/api_v1.php');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($result, true);

		if(!$json['status']) return;

		return $json['data']['RUR'];
    } 
    /*Проверка баланса FKW*/
    
    /*Вывод баланса*/
	public function withdraw(Request $r) {
		$sum = $r->get('value');
		$wallet = $r->get('wallet');
		$type = $r->get('system');
		
		if(!$sum) return [
			'msg' => 'Вы не ввели сумму вывода.',
			'icon' => 'error'
		];
		if(!$wallet) return [
			'msg' => 'Вы не ввели номер кошелька.',
			'icon' => 'error'
		];
		if($sum < 100) return [
			'msg' => 'Минимальная сумма вывода 100 рублей.',
			'icon' => 'error'
		];
		if($this->user->money < $sum) return [
			'msg' => 'На вашем счету не достаточно средств для вывода.',
			'icon' => 'error'
		];
		
		if($type == 'qiwi') $system = 63;
		if($type == 'webmoney') $system = 1;
		if($type == 'yandex') $system = 45;
		
		$data = array(
			'wallet_id' => $this->config->fk_wallet,
			'purse' => $wallet,
			'amount' => $sum,
			'desc' => 'Vivod usera id'.$this->user->vk_id,
			'currency' => $system,
			'sign' => md5($this->config->fk_wallet.$system.$sum.$wallet.$this->config->fk_api),
			'action' => 'cashout',
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://wallet.free-kassa.ru/api_v1.php');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = trim(curl_exec($ch));
		$c_errors = curl_error($ch);
		curl_close($ch);
		
		$json = json_decode($result, true);
		if($json['status'] == 'error') {
			if($json['desc'] == 'Balance too low') {
				$desc = 'Попробуйте пожалуйста позже.';
				return [
					'msg' => $desc,
					'icon' => 'error'
				];
			}
			return [
				'msg' => 'Ошибка выплаты, возможно вы ввели неверные данные.',
				'icon' => 'error'
			];
		}
		
		if($json['status'] == 'info') {
			User::where('vk_id', $this->user->vk_id)->update([
				'money' => $this->user->money-$sum
			]);
			
			Withdraw::create([
				'user_id' => $this->user->vk_id,
				'sum' => $sum,
				'wallet' => $wallet,
				'system' => $type
			]);
			
			$this->redis->publish('update_balance', json_encode([
				'user' => $this->user->id,
				'money' => $this->user->money
			]));
			
			return [
				'msg' => 'Ваша заявка поставлена в очередь. Вывод происходит в течении 24 часов.',
				'icon' => 'success'
			];
		}
	}
}