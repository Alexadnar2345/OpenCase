@extends('layout')

@section('content')
<div class="site-title">FAQ <b>Гарантии</b></div>
    <div class="faq-3">
        <div class="faq-3-i">
            <div class="faq-3-images"><img src="{{ asset('assets/images/faq-1.png') }}" alt="" /></div>
            <div class="hidden">
                <div class="faq-3-name">БЕЗОПАСНО</div>
                <div class="faq-3-mess">Мы используем 256 битный сертификат, который защищает ваши транзакции и авторизации на сайте.</div>
            </div>
        </div>
        <div class="faq-3-i">
            <div class="faq-3-images"><img src="{{ asset('assets/images/faq-2.png') }}" alt="" /></div>
            <div class="hidden">
                <div class="faq-3-name">Честно</div>
                <div class="faq-3-mess">Система основана на билетном алгоритме, выбор выигрыша просходит за счет сайта random.org</div>
            </div>
        </div>
        <div class="faq-3-i">
            <div class="faq-3-images"><img src="{{ asset('assets/images/faq-3.png') }}" alt="" /></div>
            <div class="hidden">
                <div class="faq-3-name">Моментально</div>
                <div class="faq-3-mess">Вы получите свой выигрыш моментально на баланс системы. С нами очень выгодно выигрывать.</div>
            </div>
        </div>
    </div>
    <div class="site-title site-title-2">Почему нам можно <b>Доверять?</b></div>
    <div class="faq-full">
        <div class="faq-info">
            <div class="faq-info-num">1</div>
            <div class="hidden">
                <div class="faq-info-name">ПЕРСОНАЛЬНЫЙ <b>АТТЕСТАТ</b> WEBMONEY</div>
                <div class="faq-info-mess">Персональный аттестат выдается участнику системы WebMoney Transfer после проверки его персональных (паспортных) данных одним из Регистраторов - участников партнерской программы Центра аттестации.</div>
            </div>
        </div>
        <div class="faq-info">
            <div class="faq-info-num">2</div>
            <div class="hidden">
                <div class="faq-info-name"><b>ИНДЕНТИФИКАЦИЯ</b> ЯНДЕКС КОШЕЛЬКА</div>
                <div class="faq-info-mess">Нами была проведена процедура идентификации в Яндексе. Наши персональные данные, включая паспорт, адрес прописки были нотариально завершены и переданы сотрудникам Яндекса.</div>
            </div>
        </div>
        <div class="faq-info">
            <div class="faq-info-num">3</div>
            <div class="hidden">
                <div class="faq-info-name"><b>ДОГОВОР</b> С FREKASSA</div>
                <div class="faq-info-mess">Были подписаны и доставлены договоры, по проведению интернет транзакций на персонализированные счета {{ $sitename }}. Данная процедура предусматривается многими процессинговыми сервисами и были пройдены нами.</div>
            </div>
        </div>
    </div>
    <div class="site-title site-title-2">Часто задаваемые <b>вопросы?</b></div>
    <div class="faq-loop">
        <div class="faq-i opened">
            <div class="faq-name">Как можно пополнить баланс?</div>
            <div class="faq-mess">Баланс на нашем сайте вы можете пополнить абсолютно разными способами: WebMoney, Яндекс.Деньги, Приват24, ЕвроСеть и т.п
Чтобы пополнить баланс, перейдите в свой личный кабинет и нажмите "Пополнить баланс"</div>
        </div>
        <div class="faq-i opened">
            <div class="faq-name">Как вывести средства?</div>
            <div class="faq-mess">Средства вы сможете вывести зайдя в свой профиль, нажав "Вывод средств"</div>
        </div>
        <div class="faq-i opened">
            <div class="faq-name">Как определяется приз?</div>
            <div class="faq-mess">Программа для вычисления победителя основана на генерации случайного числа исходя из процентного шанса приза. Чем дороже приз - тем меньше шанс выпадения.</div>
        </div>
        <div class="faq-i opened">
            <div class="faq-name">Я сделал запрос на вывод средств, но деньги не пришли?</div>
            <div class="faq-mess">Вывод средств производится в течении 24-х часов. Если, вдруг, средства не пришли в течении указанного времени - обратитесь в тех.поддержку.</div>
        </div>
		<div class="faq-i opened">
            <div class="faq-name">Как мне получить купон/клавиатуру/мышь и т.д.?</div>
            <div class="faq-mess">Если вам выпал данный вид приза, то обратитесь в поддержку, вам лично выдадут приз.</div>
        </div>
		<div class="faq-i opened">
            <div class="faq-name">Где мне найти агента поддержки?</div>
            <div class="faq-mess">В нашей группе Вконтакте - https://vk.com/Case4cash Вы можете найти ответы на многочисленные вопросы или просто написать в Личные Сообщения группы. Вам оперативно ответит наш менеджер.</div>
        </div>
    </div>
@endsection