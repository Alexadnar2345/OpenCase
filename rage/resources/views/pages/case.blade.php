@extends('layout')

@section('content')
    <div class="rulet-title">ОТКРЫТИЕ КОМНАТЫ:<b> {{ $case->price }}Р</b></div>
    <div class="rulets">
        <div class="rulet">
            <ul id="line">
                @foreach($line as $item)
                    @if($item->type == 0)
                        @if($item->rarity != 0)
                            <li><span><img src="../assets/images/coin/{{ $item->rarity }}.png" alt=""><b>{{ $item->price }}</b></span></li>
                        @else
                            <li><span><img src="{{ $item->img }}" alt=""><b>{{ $item->price }}</b></span></li>
                        @endif
                    @else
						<li><span><img src="{{ $item->img }}" alt=""><b></b></span></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="rulet-text">Вы можете выиграть: <span>от {{ $case->min->price }}р до {{ $case->max->price }}р</span></div>

            <div class="rulet-all">Выдано: {{ $withdraw }}р</div>
    
                        <a class="rulet-button open-link" data-case_id="{{ $case->id }}">НАЧАТЬ ИГРАТЬ ЗА {{ $case->price }}Р</a>
            
            <div style="font-weight:bold; padding:50px 0 0 0; text-align:center;"></div>
    
    <div class="coin-title">Предметы, которые могут вам выпасть из этого кейса</div>
        <div class="coin-loop">
            @foreach($case->items as $item)
				@if($item->type == 0)
                    @if($item->rarity != 0)
                        <div class="coin-i"><span><img src="../assets/images/coin/{{ $item->rarity }}.png" alt="" /><b> {{ $item->price }} </b></span></div>
                    @else
                        <div class="coin-i"><span><img src="{{ $item->img }}" alt="" /><b> {{ $item->price }} </b></span></div>
                    @endif
				@else
				<div class="coin-i"><span><img src="{{ $item->img }}" alt="" /><b></b></span></div>
				@endif
            @endforeach    
        </div>
    </div>
@endsection