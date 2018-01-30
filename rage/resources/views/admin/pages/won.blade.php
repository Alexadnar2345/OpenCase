@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Предметы</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Предметы для отправки </h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Картинка</th>
							<th>Победитель</th>
							<th>Кейс</th>
							<th>Имя</th>
							<th>Цена</th>
							<th>Статус</th>
							<th>Управление</th>
						</tr>
					</thead>
					<tbody>
						@foreach($wons as $won)
						<tr>
							<td style="vertical-align: middle;">{{$won->id}}</td>
							<td align="center"><img width="50px" src="{{$won->img}}"/></td>
							<td style="vertical-align: middle;"><a href="/profile/{{$won->user_id}}" target="_blank">Перейти в профиль</a></td>
							<td style="vertical-align: middle;">#{{$won->case_id}}</td>
							<td style="vertical-align: middle;">{{$won->name}}</td>
							<td style="vertical-align: middle;">{{$won->price}}</td>
							<td style="vertical-align: middle;">{{$won->status}}</td>
							<td align="center" style="vertical-align: middle;">
								@if($won->status == 3)
									<span class="btn red btn-sm">Отправлен победителю</span>
								@elseif($won->status == 4)
									<span class="btn red btn-sm">Зачисление на баланс</span>
								@else
									<a class="btn blue btn-sm" href="/admin/drop/{{ $won->id }}/done">Обработать</a>
									<a class="btn green btn-sm" href="/admin/drop/{{ $won->id }}/moneyback">Зачислить на баланс</a>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection