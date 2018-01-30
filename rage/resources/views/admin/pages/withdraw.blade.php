@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Выводы</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Выводы пользователей </h1>

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
							<th>Пользователь</th>
							<th>Сумма</th>
							<th>Кошелек</th>
							<th>Систем</th>
							<th>Дата</th>
						</tr>
					</thead>
					<tbody>
						@foreach($withdrows as $withdrow)
						<tr>
							<td style="vertical-align: middle;">{{$withdrow->id}}</td>
							<td style="vertical-align: middle;"><a href="https://vk.com/{{$withdrow->user_id}}" target="_blank">Открыть VK</a></td>
							<td style="vertical-align: middle;">{{$withdrow->sum}}</td>
							<td style="vertical-align: middle;">{{$withdrow->wallet}}</td>
							<td style="vertical-align: middle;">{{$withdrow->system}}</td>
							<td style="vertical-align: middle;">{{$withdrow->created_at}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection