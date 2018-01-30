<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Cases;
use App\Opened;
use App\Droped;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function open(Request $r) {
        if(Auth::guest()) return [
            'msg' => 'Вам необходимо авторизироваться!',
            'icon' => 'error'
        ];
        
        $case = Cases::where('id', $r->get('case_id'))->first();
        if(is_null($case)) return [
            'msg' => 'Не удалось найти кейс #'.$r->get('case_id'),
            'icon' => 'error'
        ];
        
        if($case->is_active == 0) return [
            'msg' => 'Это кейс в данный момент недосутпен',
            'icon' => 'error'
        ];
        
        if($this->user->money < $case->price) return [
            'msg' => 'Недостаточно баланса на вашем счету!',
            'icon' => 'error'
        ];
        
        # Получение ленты дропа
        $items = DB::table('cases_items')->where('case_id', $case->id)->get();
        
        if(is_null($items)) return [
            'msg' => 'Не удалось найти содержимое кейса #'.$case->id,
            'icon' => 'error'
        ];
        
        $list = [];
		foreach($items as $item) for($i = 0; $i < ($item->percent); $i++) $list[] = $item;
        // Перемешиваем массив
        shuffle($list);
        // Находим 80 (победный) итем из 100
        $drop = $list[79];
        
        // Забираем цену кейса из баланса юзера
        $this->user->money -= $case->price;
        // Обновляем баланс
        $this->redis->publish('update_balance', json_encode([
            'user' => $this->user->id,
            'money' => $this->user->money
        ]));
        // Добавляем баланс юзеру
		if($drop->type == 0) $this->user->money += $drop->price;
        $this->redis->publish('update_balance_after', json_encode([
            'user' => $this->user->id,
            'money' => $this->user->money
        ]));
        // Сохраняем данные юзера
        $this->user->save();
		
        # Добавляем дроп в лайв-ленту
        DB::table('opened')->insert([
            'user_id' => $this->user->id,
            'case_id' => $case->id,
            'name' => $drop->name,
            'img' => $drop->img,
            'type' => $drop->type,
            'rarity' => $drop->rarity,
            'price' => $drop->price,
            'time' => Carbon::now()
        ]);
        
        # Передача данных в лайв-ленту
        $values = [
            'user_id' => $this->user->id,
            'user_avatar' => $this->user->avatar,
            'item_name' => $drop->name,
            'item_type' => $drop->type,
            'item_img' => $drop->img,
            'item_rarity' => $drop->rarity,
            'item_price' => $drop->price
        ];
        
        $this->redis->publish('live_drops', json_encode($values));
        
		$item_droped = Opened::where('user_id', $this->user->id)->where('type', 1)->orderBy('id', 'desc')->value('id');
		
		if($drop->type == 1) {
			DB::table('item_droped')->insert([
				'drop_id' => $item_droped,
				'user_id' => $this->user->id,
				'case_id' => $case->id,
				'img' => $drop->img,
				'name' => $drop->name,
				'status' => 0,
				'price' => $drop->price
			]);
		}
		
        return [
            'success' => true,
            'user_id' => $this->user->id,
            'drop_id' => $item_droped,
            'list' => $list,
            'drop' => $drop
        ]; 
    }
	
	public function takeItem(Request $r) {
		$user = User::where('id', $r->get('user_id'))->first();
		$drop = Droped::where('drop_id', $r->get('drop_id'))->orderBy('id', 'desc')->first();
		
		if($r->get('user_id') != $drop->user_id) {
			return [
				'msg' => 'У вас нет предметов для отправки!',
				'icon' => 'success'
			];
		}
		if($r->get('drop_id') != $drop->drop_id) {
			return [
				'msg' => 'У вас нет предметов для отправки!',
				'icon' => 'success'
			];
		}
		if($drop->status == 1) {
			return [
				'msg' => 'Предмет продан!',
				'icon' => 'error'
			];
		}
		if($drop->status == 2) {
			return [
				'msg' => 'Предмет уже отправлен!',
				'icon' => 'error'
			];
		}
		
		Droped::where('drop_id', $r->get('drop_id'))->update([
            'status' => 2
        ]);
		
		return [
            'msg' => 'Вы оставили заявку на отправку!',
            'icon' => 'success'
        ];
	}
	
	public function sellItem(Request $r) {
		$user = User::where('id', $r->get('user_id'))->first();
		$drop = Droped::where('drop_id', $r->get('drop_id'))->orderBy('id', 'desc')->first();

		if($r->get('user_id') != $drop->user_id) {
			return [
				'msg' => 'У вас нет предметов для продажи!',
				'icon' => 'success'
			];
		}
		if($r->get('drop_id') != $drop->drop_id) {
			return [
				'msg' => 'У вас нет предметов для продажи!',
				'icon' => 'success'
			];
		}
		if($drop->status == 1) {
			return [
				'msg' => 'Предмет уже продан!',
				'icon' => 'error'
			];
		}
		if($drop->status == 2) {
			return [
				'msg' => 'Предмет уже отправлен!',
				'icon' => 'error'
			];
		}
		
		Droped::where('drop_id', $r->get('drop_id'))->update([
            'status' => 1
        ]);
		
		User::where('vk_id', $user->vk_id)->update([
            'money' => $user->money+$drop->price
        ]);
		
		return [
            'msg' => 'Вы продали предмет!',
            'icon' => 'success',
            'item_price' => $drop->price
        ];
	}
    
    public function test() {
        $item_droped = Opened::where('user_id', $this->user->id)->where('type', 1)->orderBy('id', 'desc')->value('id');
		return $item_droped;
    }
}