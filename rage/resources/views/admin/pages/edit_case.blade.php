@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Редактировать кейс</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Редактирование кейса </h1>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div> <!-- end .flash-message -->

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<form method="post" action="/admin/case/update" class="horizontal-form" id="save">
					<input name="id" value="{{$case->id}}" type="hidden">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Название</label>
									<input type="text" class="form-control" placeholder="Название кейса" name="title" value="{{ $case->title }}">
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Цена</label>
									<input type="text" class="form-control" placeholder="0" name="price" value="{{ $case->price }}">
								</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Категория</label>
									<select class="form-control" tabindex="1" name="type">
										<option value="1" @if($case->type == 1) selected @endif>Топовые комнаты</option>
										<option value="0" @if($case->type == 0) selected @endif>Обычные комнаты</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Отключение кейса</label>
									<select class="form-control" tabindex="1" name="is_active">
										<option value="1" @if($case->is_active == 1) selected @endif>Включен</option>
										<option value="0" @if($case->is_active == 0) selected @endif>Отключен</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group text-center">
									<label class="control-label">Картинка</label>
									<div class="col-md-12">
										<div class="mt-radio-inline">
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-1" @if($case->img == 'viewn-1') checked @endif> <img src="/assets/images/viewn/1.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-2" @if($case->img == 'viewn-2') checked @endif> <img src="/assets/images/viewn/2.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-3" @if($case->img == 'viewn-3') checked @endif> <img src="/assets/images/viewn/3.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-4" @if($case->img == 'viewn-4') checked @endif> <img src="/assets/images/viewn/4.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-5" @if($case->img == 'viewn-5') checked @endif> <img src="/assets/images/viewn/5.png" width="100px">
												<span></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group text-center">
									<label class="control-label">Предмет в кейсе</label>
									<div class="col-md-12">
										<div class="mt-radio-inline">
											<label class="mt-radio">
												<input type="radio" name="item" value="" @if($case->item == '') checked @endif> Нет
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w1" @if($case->item == 'w1') checked @endif> <img src="/assets/images/w1.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w2" @if($case->item == 'w2') checked @endif> <img src="/assets/images/w2.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w3" @if($case->item == 'w3') checked @endif> <img src="/assets/images/w3.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w4" @if($case->item == 'w4') checked @endif> <img src="/assets/images/w4.png" width="60px">
												<span></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-actions right">
						<button type="submit" class="btn blue"><i class="fa fa-check"></i> Сохранить </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<h1 class="page-title"> Список предметов <span style="margin-left: 20px;"><a class="btn btn-lg green" data-toggle="modal" data-target="#add_item" href="/admin/item/{{ $case->id }}/add"> Добавить предмет <i class="fa fa-plus"></i></a></span></h1>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Картинка</th>
							<th>Имя</th>
							<th>Цена</th>
							<th>Тип</th>
							<th>Шанс</th>
							<th>Управление</th>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $item)
						<tr>
							<td style="vertical-align: middle;">{{$item->id}}</td>
							<td align="center"><img width="50px" @if($item->type == 0) @if($item->rarity != 0) src="/assets/images/coin/{{ $item->rarity }}.png" @else src="{{ $item->img }}" @endif @else src="{{ $item->img }}" @endif/></td>
							<td style="vertical-align: middle;">{{$item->name}}</td>
							<td style="vertical-align: middle;">{{$item->price}}</td>
							<td style="vertical-align: middle;">@if($item->type == 0) Валюта @else Предмет @endif</td>
							<td style="vertical-align: middle;">{{$item->percent}}%</td>
							<td align="center" style="vertical-align: middle;">
								<a class="btn blue btn-sm" data-toggle="modal" data-target="#add_item" href="/admin/item/{{ $item->id }}/edit">Редактировать</a>
								<a class="btn red btn-sm" href="/admin/item/{{ $item->id }}/delete">Удалить</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_item" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			@include('admin.includes.modal_item_add', ['case' => $case])
		</div>
	</div>
</div>

@if(!$item)
<div class="modal fade" id="edit_item" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			@include('admin.includes.modal_item_edit', ['item' => $item])
		</div>
	</div>
</div>
@else
@endif
@endsection