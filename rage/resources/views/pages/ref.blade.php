@extends('layout')

@section('content')
    <div class="site-title">Реферальная <b>Система</b></div>
    <div class="ref-loop">
        <b>ЧТО ТАКОЕ РЕФЕРАЛЬНАЯ СИСТЕМА?</b>
        <p>Реферальная система это возможность приглашать других людей через специальную реферальную ссылку, которая указана у Вас в личном кабинете.</p>
        <br />
        <p>За каждого зарегестрированного по Вашей реферальной ссылке человека вы будете получать процент! Каждый раз когда Ваш друг пополняет баланс, Вам будет зачислятся процент!</p>
        <br />
        <p>Можно вообще не играть на сайте, а только приглашать друзей и иметь хороший пассивных доход!</p>
        <br />
        <p>Делитесь ссылкой с друзьями, знакомыми и получайте легкие деньги!</p>
    </div>
    <div class="site-title site-title-2">Почему нам можно <b>Доверять?</b></div>
    <div class="faq-full">
        <div class="faq-info">
            <div class="faq-info-num">1</div>
            <div class="hidden">
                <div class="faq-info-name"><b>ДЕНЬГИ</b> ЗА РЕГЕСТРАЦИЮ РЕФЕРАЛА</div>
                <div class="faq-info-mess">За каждого приглашённого человека вы получаете 1р. Чем больше вы приглашаете людей, тем больше ваш пассивный заработок.</div>
            </div>
        </div>
        <div class="faq-info">
            <div class="faq-info-num">2</div>
            <div class="hidden">
                <div class="faq-info-name">ПРОЦЕНТЫ ОТ ПОПОЛНЕНИЯ <b>РЕФЕРАЛОВ</b></div>
                <div class="faq-info-mess">После того как вы пригласите человека по вашей уникальной ссылке, он становится вашим рефералом. Если данный человек будет пополнять баланс на сайте, вы будете получать по 5% от потраченных им денег на сайте.</div>
            </div>
        </div>
        <div class="faq-info">
            <div class="faq-info-num">3</div>
            <div class="hidden">
                <div class="faq-info-name">БОЛЬШОЙ <b>ДОХОД</b></div>
                <div class="faq-info-mess">Пригласив много друзей, которые зарегестрируются по вашей реферальной ссылке, вы сможете получать больше чем открывая паки!</div>
            </div>
        </div>
    </div>
    <div class="site-title site-title-2">Ваша реферальная <b>ссылка</b></div>
    <div class="ref-loop myreflink">
        <p>Ваша рефериальная ссылка: <em>http://{{ $sitename }}/?ref=@if(!Auth::guest()){{$u->id}}@endif</em></p>
        <br />
        <p>По вашей ссылке зарегистрировались: <em>@if(!Auth::guest()){{App\User::where('partner',$u->id)->count()}}@else 0 @endif</em></p>
    </div>
@endsection