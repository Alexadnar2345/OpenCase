@extends('layout')

@section('content')
    <div class="c-title">Топовые <b>комнаты</b></div>
    <div class="viewn-loop">
            @foreach($cases_item as $case)
                @if($case['place'] == 0)
                <div class="viewn {{ $case['img'] }} {{ $case['item'] }}" onclick="return location.href = '/case/{{ $case['id'] }}'">
    				<!--<div class="klemo klemo-2"></div>-->
                    <div class="viewn-row">
                        <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                        <div class="viewn-rub">{{ $case['max_price'] }}</div>
                        <div class="viewn-text">{{ $case['title'] }}</div>
                    </div>
                    <div class="viewn-info">Содержит от <span>{{ $case['min_price'] }}р</span> до <span>{{ $case['max_price'] }}р</span></div>
                    <div class="viewn-price">Стоимость игры: <b>{{ $case['price'] }}Р</b></div>
                    <a href="/case/{{ $case['id'] }}" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
                </div>
                @endif
            @endforeach
    </div>
    <div class="c-title c-title-2">Обычные <b>комнаты</b></div>
    <div class="viewn-loop">
            @foreach($cases as $case)
                @if($case['place'] == 0)
                <div class="viewn {{ $case['img'] }}" onclick="return location.href = '/case/{{ $case['id'] }}'">
    				<!--<div class="klemo klemo-2"></div>-->
                    <div class="viewn-row">
                        <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                        <div class="viewn-rub">{{ $case['max_price'] }}</div>
                        <div class="viewn-text">{{ $case['title'] }}</div>
                    </div>
                    <div class="viewn-info">Содержит от <span>{{ $case['min_price'] }}р</span> до <span>{{ $case['max_price'] }}р</span></div>
                    <div class="viewn-price">Стоимость игры: <b>{{ $case['price'] }}Р</b></div>
                    <a href="/case/{{ $case['id'] }}" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
                </div>
                @endif
            @endforeach
<!--
            <div class="viewn viewn-5" onclick="return location.href = '/case/17'">
                                    <div class="klemo klemo-2"></div>
                <div class="viewn-row">
                    <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                    <div class="viewn-rub">1600</div>
                    <div class="viewn-text">Тестовый</div>
                </div>
                <div class="viewn-info">Содержит от <span>100р</span> до <span>1600р</span></div>
                <div class="viewn-price">Стоимость игры: <b>0Р</b></div>
                <a href="/case/17" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
            </div>
            <div class="viewn viewn-5" onclick="return location.href = '/case/5'">
                <div class="viewn-row">
                    <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                    <div class="viewn-rub">50</div>
                    <div class="viewn-text">Кейс №1</div>
                </div>
                <div class="viewn-info">Содержит от <span>1р</span> до <span>50р</span></div>
                <div class="viewn-price">Стоимость игры: <b>19Р</b></div>
                <a href="/case/5" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
            </div>
-->
    </div>
@endsection