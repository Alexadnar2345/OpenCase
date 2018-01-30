@extends('layout')

@section('content')
    <div class="site-title">ЛИЧНЫЙ <b>КАБИНЕТ</b></div>
    <div class="profile">
        <div class="profile-ava"><a href="http://vk.com/id{{ $data['id'] }}"><img src="{{ $data['avatar'] }}" alt="" /></a></div>
        <div class="hidden">
            <div class="profile-panel">
                <div class="profile-login ell">{{ $data['username'] }}</div>
				<a href="/logout" class="profile-logout">Выход с сайта</a>
            </div>
			<div class="profile-button">
                <a href="#" onclick="$('#modal-1').arcticmodal(); return false;">ПОПОЛНИТЬ БАЛАНС</a>
                <a href="#" onclick="$('#modal-2').arcticmodal(); return false;">ВЫВЕСТИ СРЕДСТВА</a>
            </div>
            <div class="clear"></div>
            <div class="profile-info">
				Кейсы: <span>{{ $data['cases'] }}</span>
			</div>
            <div class="profile-info" style="position:relative;">
				Выигрыш: <span>{{ $data['price'] }}р</span>
			</div>
			<div class="profile-info" style="position:relative;">
				<div class="profile-button" style="top:4px; right:0; width:auto;">
                    <a href="/ref" style="height:26px; line-height:26px; width:auto; float:left; padding:0 10px;" class="btn-green">Реферальная система</a>
                </div>
			Баланс: <span>{{ $data['money'] }}р</span>
			</div>
        </div>
    </div>
	@if($item_drops != '[]')
    <div class="coin-title coin-title-2">ОЖИДАЮТ ВАШИХ <b>ДЕЙСТВИЙ:</b></div>
    <div class="coin-loop">
        @foreach($item_drops as $drop)
			<div class="coin-i" data-element="{{ $drop->drop_id }}">
				<div class="item-status">
					<div class="takeItem" id="takeItem" data-userid="{{ $drop->user_id }}" data-id="{{ $drop->drop_id }}">Забрать</div>
					<div class="sellItem" id="sellItem" data-userid="{{ $drop->user_id }}" data-id="{{ $drop->drop_id }}">Продать</div>
				</div>
				<a href="/case/{{ $drop->case_id }}"><span><img src="{{ $drop->img }}" alt="" /></span></a>
			</div>
        @endforeach
    </div>
	@endif
    <div class="coin-title coin-title-2">ИСТОРИЯ ВАШИХ <b>ПРИЗОВ:</b></div>
    <div class="coin-loop">
        @foreach($last_drops as $drop)
            @if($drop->type == 0)
				@if($drop->rarity != 0)
					<div class="coin-i"><a href="/case/{{ $drop->case_id }}"><span><img src="../assets/images/coin/{{ $drop->rarity }}.png" alt="" /><b>{{ $drop->price }}</b></span></a></div>
				@else
					<div class="coin-i"><a href="/case/{{ $drop->case_id }}"><span><img src="{{ $drop->img }}" alt="" /><b>{{ $drop->price }}</b></span></a></div>
				@endif	
            @else
                <div class="coin-i">
					<div class="item-status" style="display: none;">
						<div class="takeItem">Забрать</div>
						<div class="sellItem">Продать</div>
					</div>
					<a href="/case/{{ $drop->case_id }}"><span><img src="{{ $drop->img }}" alt="" /></span></a>
				</div>
            @endif
        @endforeach
    </div>
@endsection