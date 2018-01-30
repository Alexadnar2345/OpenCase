<!doctype html>
<html lang="ru">
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8" />
	<meta name="keywords" content="{{ $keywords }}" />
	<meta name="description" content="{{ $description }}" />
	<meta name="csrf-token" content="{!!	csrf_token()	 !!}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.toast.min.css') }}" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<meta content="/images/faq-1.png" property="og:image">
	<script src="https://vk.com/js/api/openapi.js?136" type="text/javascript"></script>
</head>
<body>

@if(Auth::guest())
<script>
    const USER_ID = null;
</script>
@else
<script>
    const USER_ID = '{{ $u->id }}';
</script>
@endif

<div style="display:none;">
	@if(!Auth::guest())
    <div class="modal" id="modal-1" style="width:520px;">
        <div class="modal-close arcticmodal-close"></div>
        <div class="modal-top">
            <div class="modal-title">ПОПОЛНЕНИЕ <b>БАЛАНСА</b></div>
        </div>
        <div class="modal-content">
            <form action="/pay" method="GET" class="balance">           
                <div class="balance-text">Вы можете пополнить баланс напрямую через удобный сервис freekassa, где <br /> можете выбрать удобный способ пополнения: Qiwi, Яндекс Деньги и т.д<br>
				<span style="color:#efd53a">Пополни счет на сумму свыше 300 руб и получи +10% в подарок.</span>
				</div>
                <div class="balance-text-2">ВВЕДИТЕ СУММУ:</div>
                <input type="number" name="num" min="1" placeholder="100">
                <div class="clear"></div>
                <input type="submit" value="ПОПОЛНИТЬ БАЛАНС" />
            </form>
        </div>
    </div>
    <div class="modal" id="modal-2" style="width:520px;">
        <div class="modal-close arcticmodal-close"></div>
        <div class="modal-top">
            <div class="modal-title">Вывод <b>средств</b></div>
        </div>
        <div class="modal-content">
            <div class="balance">
                <div class="balance-text">Обработка вывода обычно осуществляется в течении часа. <br /> В некоторых случаях платеж может быть обработан до 24 часов.</div>
                <div class="balance-text-2">ВВЕДИТЕ СУММУ:</div>
                <input id="f_value" name="value" type="text" placeholder="100" required />
                <div class="balance-text-3">Выберите платежную систему:</div>
                <div class="balance-nav">
                    <ul>
                        <li class="active" data-type="qiwi"></li>
                        <li class="" data-type="webmoney"></li>
                        <li class="" data-type="yandex"></li>
                    </ul>
                </div>
                <div class="balance-text-4">Введите номер кошелька:</div>
                <input id="f_wallet" name="wallet" type="text" placeholder="Номер кошелька" style="width:224px;" required/>
                <div class="clear"></div>
                <input id="withdraw" type="submit" value="Вывести средства" />
            </div>
        </div>
    </div>
    <div class="modal" id="modal-3" style="width:400px;">
        <div class="modal-close arcticmodal-close"></div>
        <div class="modal-top">
            <div class="modal-title">Ваш <b>выигрыш</b></div>
        </div>
        <div class="modal-content viewn-1">
            <div class="coin-i coin-new"><span><img src="" alt="" /><b></b></span></div>
            <a class="viewn-link coin-btn" onclick="$('#modal-3').arcticmodal('close'); return false;">Попробывать еще</a>
        </div>
    </div>
    <div class="modal" id="modal-4" style="width:400px;">
        <div class="modal-close arcticmodal-close"></div>
        <div class="modal-top">
            <div class="modal-title">Ваш <b>выигрыш</b></div>
        </div>
        <div class="modal-content viewn-1">
            <div class="coin-i coin-new"><span><img src="" alt="" /><b></b></span></div>
            <div class="clear"></div>
            <a id="take_item" class="viewn-link coin-btn coin-btn-l" data-id="" data-userid="">Забрать</a>
            <a id="sell_item" class="viewn-link coin-btn coin-btn-r" data-id="" data-userid="">Продать <span>(за <span class="sp_value">0</span> руб)</span></a>
        </div>
    </div>
	<div class="modal" id="modal-5" style="width:520px;">
        <div class="modal-close arcticmodal-close"></div>
        <div class="modal-top">
            <div class="modal-title">ПРОМОКОД</b></div>
        </div>
        <div class="modal-content">
            <form action="/promocode" method="POST" class="balance">
                <input type="hidden" name="_token" value="AQ4gESk5ZpcvAvpaL8LtDG5zgUTr1MM11kKnWfj6">
                <div class="balance-text-2">ВВЕДИТЕ ПРОМОКОД:</div>
                <input id="p_code" type="text" name="amount" value="" placeholder="" />
                <div class="clear"></div>
                <input id="promocode" type="submit" value="АКТИВИРОВАТЬ" />
            </form>
        </div>
    </div>
	@endif
</div>
<div class="wrapper">
    <div class="header full">
        <a href="/" class="logo"></a>
		@if(Auth::guest())
			<a href="/login" class="login"></a>
		@else
			<div class="mini-profile">
				<div class="mini-profile-ava"><a href="/profile"><img src="{{ $u->avatar }}" alt=""></a></div>
				<div class="hidden">
					<div class="mini-profile-login ell">{{ $u->name }}</div>
					<a href="/logout" class="mini-profile-logout"></a>
					<div class="clear"></div>
					<div class="mini-profile-balance left">
						<div class="mini-profile-button">
							<a onclick="$('#modal-1').arcticmodal(); return false;"></a>
							<a onclick="$('#modal-2').arcticmodal(); return false;"></a>
						</div>
						Баланс: <b id="balance">{{ $u->money }}</b><b>Р</b>
					</div>
				</div>
			</div>
		@endif
		<div class="nav">
            <ul>
                <li><a href="/faq"><b>FAQ</b> Гарантии</a></li>
                <li><a href="/ref"><b>Реферальная</b> система</a></li>
                <li><a href="https://vk.com/ragecash"><b>Вконтакте</b> Соц.сеть</a></li>
            </ul>
        </div>
    </div>
    <div class="live">
        <div class="live-title">
            <b>ПОСЛЕДНИИ ВЫИГРЫШИ:</b>
            <a href="#top">ТОП ИГРОКОВ</a>
        </div>
        <div class="live-content">
            <ul id="live_drops">
                @foreach($drops as $drop)
                    @if($drop['type'] == 0)
                        @if($drop['rarity'] != 0)
                            <li class="live-item" style="background: url('../assets/images/coin/{{ $drop['rarity'] }}.png') no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/{{ $drop['user']['id'] }}"><img src="{{ $drop['user']['avatar'] }}" alt="">{{ $drop['price'] }}</a></li>
                        @else
                            <li class="live-item" style="background: url('{{ $drop['img'] }}') no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/{{ $drop['user']['id'] }}"><img src="{{ $drop['user']['avatar'] }}" alt="">{{ $drop['price'] }}</a></li>
                        @endif
                    @else
                    <li class="live-item" style="background: url({{ $drop['img'] }}) no-repeat 0 0;background-size: 64px 64px;"><a href="/profile/{{ $drop['user']['id'] }}"><img src="{{ $drop['user']['avatar'] }}" alt=""></a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container full" id="pjax-container">
        @yield('content')
    </div>
   <div class="stats">
        <ul>
            <li>
                <span class="stats-l stats-onlineNow">0</span>
                <span class="stats-r"><b>Игроков</b> Online</span>
            </li>
            <li>
                <span class="stats-l" id="user-count">{{ $stats['users'] }}</span>
                <span class="stats-r"><b>Всего</b> Игроков</span>
            </li>
            <li>
                <span class="stats-l" id="game-count">{{ $stats['opened'] }}</span>
                <span class="stats-r"><b>Всего</b> Игр</span>
            </li>
        </ul>
    </div>
    <div class="topuser full" id="top">
        <div class="topuser-title"><span>ТОП </span>ИГРОКОВ</div>
        <div class="top-3">
            @for($i = 0; $i < 3; $i++)
                @if(isset($top[$i]))
                        <div class="top-3-i">
                            <div class="top-3-num"><span>{{ $i+1 }}</span></div>
                            <div class="top-3-ava"><a href="/profile/{{ $top[$i]->id }}"><img src="{{ $top[$i]->avatar }}" alt="" /></a></div>
                            <div class="top-3-rub">Общий выигрыш: <b>{{ $top[$i]->value }}Р</b></div>
                            <div class="top-3-game">Всего игр: <b>{{ $top[$i]->cases }}</b></div>
                        </div>
                @else
                        <div class="top-3-i">
                            <div class="top-3-num"><span>{{ $i+1 }}</span></div>
                            <div class="top-3-ava"><a><img src="http://vk.com/images/camera_200.png" alt="" /></a></div>
                            <div class="top-3-rub">Общий выигрыш: <b>0Р</b></div>
                            <div class="top-3-game">Всего игр: <b>0</b></div>
                        </div>
                @endif
            @endfor
        </div>
        <div class="top-all">
            @for($i = 3; $i < 10; $i++)
                @if(isset($top[$i]))
                    <div class="top-i">
                        <div class="top-ava"><a href="/profile/{{ $top[$i]->id }}"><img src="{{ $top[$i]->avatar }}" alt="" /></a></div>
                        <div class="top-game">Всего игр: <span>{{ $top[$i]->cases }}</span></div>
                        <div class="top-rub">{{ $top[$i]->value }}Р</div>
                    </div>
                @else
                    <div class="top-i">
                        <div class="top-ava"><a><img src="http://vk.com/images/camera_200.png" alt="" /></a></div>
                        <div class="top-game">Всего игр: <span>0</span></div>
                        <div class="top-rub">0Р</div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.smoothscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.arcticmodal-0.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/socket.io-1.3.7.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/csnow.js') }}"></script>
	<script>
	$(document).ready(function(){
		$(document).snowfall({
			flakeCount : 77, //количество снежинок
			flakeColor : '#FFFFFF', //цвет снежинок
			flakeIndex: 999999, //z-index снежинок
			minSize : 5, //минимальный размер снежинок
			maxSize : 7, //максимальный размер снежинок
			minSpeed : 3, //минимальная скорость падения снежинок
			maxSpeed : 5, //максимальная скорость падения снежинок
			round : true, //округлая форма снежинок: "да" - true, "нет" - false
		});
	});
	</script>
	<div id="vk_community_messages"></div>
    <div class="footer full">
        <div class="footer-text">Все права защищены. &copy; 2016 <br />
            Авторизуясь на сайте вы принимаете
            <a href="/license"><b>пользовательское соглашение</b></a><br>
            Copyright by <span>{{ $sitename }}</span> 
        </div>
        <a href="//www.free-kassa.com/"><img src="//www.free-kassa.ru/img/fk_btn/14.png" style="
    border-left-width: 355px;
    margin-left: 385px;
    margin-top: 60px;
    ">
		
        <div class="footer-blank">
			<a href="https://vk.com/s_info" target="_blank"><img src="{{ asset('assets/images/s-info.png')}}"></a>
			
        </div>
    </div>
</div>
</body>
</html>
