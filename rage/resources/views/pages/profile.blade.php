@extends('layout')

@section('content')
    <div class="site-title">Профиль</div>
    <div class="profile">
        <div class="profile-ava"><a href="http://vk.com/id{{ $data['id'] }}"><img src="{{ $data['avatar'] }}" alt="" /></a></div>
        <div class="hidden">
            <div class="profile-panel">
                <div class="profile-login ell">{{ $data['username'] }}</div>
            </div>
            <div class="clear"></div>
            <div class="profile-info">Кейсы: <span>{{ $data['cases'] }}</span></div>
            <div class="profile-info">Выигрыш: <span>{{ $data['price'] }}р</span></div>
        </div>
    </div>
    <div class="coin-title coin-title-2">ПОСЛЕДНИЕ <b>{{ count($last_drops) }} ПРИЗОВ:</b></div>
    <div class="coin-loop">
        @foreach($last_drops as $drop)
			@if($drop->type == 0)
			@if($drop->rarity != 0)
						<div class="coin-i"><a href="/case/{{ $drop->case_id }}"><span><img src="../assets/images/coin/{{ $drop->rarity }}.png" alt="" /><b>{{ $drop->price }}</b></span></a></div>
                        @else
						<div class="coin-i"><a href="/case/{{ $drop->case_id }}"><span><img src="{{ $drop->img }}" alt="" /><b>{{ $drop->price }}</b></span></a></div>
                        @endif	
            @else
			<div class="coin-i"><a href="/case/{{ $drop->case_id }}"><span><img src="{{ $drop->img }}" alt="" /><b></b></span></a></div>
		@endif
			
        @endforeach
    </div>
@endsection