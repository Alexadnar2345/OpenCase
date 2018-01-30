<?php namespace App\Http\Controllers;

use App\User;
use App\Cases;
use App\Items;
use App\Config;
use App\Droped;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function index()
    {
		$user_money = \DB::table('users')->where('money', '!=', 0)->sum('money');
		$user_today = \DB::table('users')->where('created_at', '>=', Carbon::today())->count();
		$opened_today = \DB::table('opened')->where('time', '>=', Carbon::today())->count();
		$pay_today = \DB::table('success_pay')->where('created_at', '>=', Carbon::today())->sum('price');
		$pay_week = \DB::table('success_pay')->where('created_at', '>=', Carbon::now()->subDays(7))->sum('price');
		$pay_month = \DB::table('success_pay')->where('created_at', '>=', Carbon::now()->subDays(30))->sum('price');
		$pay_all = \DB::table('success_pay')->sum('price');
		$fk_money = explode('.', $this->getBalans_frw());
		$fk_money = $fk_money[0];
		
		if(!$user_money) $user_money = 0;
		if(!$user_today) $user_today = 0;
		if(!$opened_today) $opened_today = 0;
		if(!$pay_today) $pay_today = 0;
		if(!$pay_week) $pay_week = 0;
		if(!$pay_month) $pay_month = 0;
		if(!$pay_all) $pay_all = 0;
		if(!$fk_money) $fk_money = 0;

		return view('admin.index', compact('user_money', 'user_today', 'fk_money', 'opened_today', 'pay_today', 'pay_week', 'pay_month', 'pay_all')); 
    }
	
	public function users()
    {
		$users = User::get();
		return view('admin.pages.users', compact('users')); 
    }
	
	public function edit_user($id)
    {
		return view('admin.includes.modal_users', ['user' => User::findOrFail($id)]);
    }
	
	public function item_add($id)
    {
		return view('admin.includes.modal_item_add', ['case' => Cases::findOrFail($id)]);
    }
	
	public function item_edit($id)
    {
		return view('admin.includes.modal_item_edit', ['item' => Items::findOrFail($id)]);
    }
	
	public function item_create(Request $r) {     
        Items::create([
            'case_id' => $r->get('id'),
            'name' => $r->get('name'),
            'price' => $r->get('price'),
            'img' => $r->get('img'),
            'rarity' => $r->get('rarity'),
            'type' => $r->get('type'),
            'percent' => $r->get('percent')
        ]);
		
		$r->session()->flash('alert-success', 'Предмет добавлен!');
        return redirect()->back();
    }
	
	public function item_update(Request $r) {     
        Items::where('id', $r->get('id'))->update([
            'name' => $r->get('name'),
            'price' => $r->get('price'),
            'img' => $r->get('img'),
            'rarity' => $r->get('rarity'),
            'type' => $r->get('type'),
            'percent' => $r->get('percent')
        ]);
		
		$r->session()->flash('alert-success', 'Предмет обновлен!');
        return redirect()->back();
    }
	
	public function user_save(Request $r) {     
        User::where('id', $r->get('id'))->update([
            'name' => $r->get('name'),
            'money' => $r->get('money'),
            'is_admin' => $r->get('is_admin'),
            'profit' => $r->get('profit')
        ]);
		
		$r->session()->flash('alert-success', 'Настройки пользователя сохранены!');
        return redirect()->route('users');
    }
	
	public function user_ban($id, Request $r) {     
        User::where('id', $id)->update(['is_banned' => 1]);
		
		$r->session()->flash('alert-success', 'Пользователь забанен!');
        return redirect()->route('users');
    }
	
	public function user_unban($id, Request $r) {     
        User::where('id', $id)->update(['is_banned' => 0]);
		
		$r->session()->flash('alert-success', 'Пользователь разбанен!');
        return redirect()->route('users');
    }
	
	public function new_case()
    {
		return view('admin.pages.new_case'); 
    }
	
	public function case_edit($id)
    {
		$case = Cases::where('id', $id)->first();
		$items = Items::where('case_id', $id)->get();
		
		$item = Items::where('case_id', $id)->get();
		
		return view('admin.pages.edit_case', compact('case', 'items', 'item'));
    }
	
	public function add_case(Request $r) {     
        Cases::create([
            'title' => $r->get('title'),
            'price' => $r->get('price'),
            'type' => $r->get('type'),
            'is_active' => $r->get('is_active'),
            'img' => $r->get('img'),
            'item' => $r->get('item')
        ]);
		
		$r->session()->flash('alert-success', 'Вы создали новый кейс!');
        return redirect()->route('cases');
    }
	
	public function case_update(Request $r) {     
        Cases::where('id', $r->get('id'))->update([
            'title' => $r->get('title'),
            'price' => $r->get('price'),
            'type' => $r->get('type'),
            'is_active' => $r->get('is_active'),
            'img' => $r->get('img'),
            'item' => $r->get('item')
        ]);
		
		$r->session()->flash('alert-success', 'Вы обновили кейс!');
        return redirect()->route('cases');
    }
	
	public function case_delete($id, Request $r) {
		Cases::where('id', $id)->delete();
		
		$r->session()->flash('alert-success', 'Кейс удален!');
        return redirect()->route('cases');
	}
	
	public function item_delete($id, Request $r) {
		Items::where('id', $id)->delete();
		
		$r->session()->flash('alert-success', 'Предмет удален!');
        return redirect()->back();
	}
	
	public function cases() {
		$cases = Cases::get();
		return view('admin.pages.cases', compact('cases')); 
    }
	
	public function case_enable($id, Request $r) {     
        Cases::where('id', $id)->update(['is_active' => 1]);
		
		$r->session()->flash('alert-success', 'Кейс вновь доступен для игроков!');
        return redirect()->route('cases');
    }
	
	public function case_disable($id, Request $r) {     
        Cases::where('id', $id)->update(['is_active' => 0]);
		
		$r->session()->flash('alert-success', 'Кейс не доступен для игроков!');
        return redirect()->route('cases');
    }
	
	public function settings()
    {
		$config = Config::first();
		return view('admin.pages.settings', compact('config')); 
    }
	
	public function settings_save(Request $r) {     
        Config::where('id', 1)->update([
            'domain' => $r->get('domain'),
            'sitename' => $r->get('sitename'),
            'title' => $r->get('title'),
            'description' => $r->get('description'),
            'keywords' => $r->get('keywords'),
            'min_with_sum' => $r->get('min_with_sum'),
            'fk_api' => $r->get('fk_api'),
            'mrh_ID' => $r->get('mrh_ID'),
            'mrh_secret1' => $r->get('mrh_secret1'),
            'mrh_secret2' => $r->get('mrh_secret2'),
            'fk_wallet' => $r->get('fk_wallet')
        ]);
		
		$r->session()->flash('alert-success', 'Настройки обновлены!');
        return redirect()->route('settings');
    }
	
	public function withdraw()
    {
		$withdrows = Withdraw::get();
		return view('admin.pages.withdraw', compact('withdrows')); 
    }
	
	public function won()
    {
		$wons = Droped::where('status', 2)->get();
		return view('admin.pages.won', compact('wons')); 
    }
	
	public function drop_done($id, Request $r) {
		Droped::where('id', $id)->update([
            'status' => 3
        ]);
		
		$r->session()->flash('alert-success', 'Предмет обработан, свяжись с победителем для отправки!');
        return redirect()->route('admin.won');
	}
	
	public function drop_moneyback($id, Request $r) {
		$drop = Droped::where('id', $id)->first();
		$user = User::where('id', $drop->user_id)->first();
		
		Droped::where('id', $id)->update([
            'status' => 4
        ]);
		
		User::where('vk_id', $user->vk_id)->update([
            'money' => $user->money+$drop->price
        ]);
		
		$r->session()->flash('alert-success', 'Вы вернули всю сумму товара на счет пользователя!');
        return redirect()->route('admin.won');
	}
	
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
}