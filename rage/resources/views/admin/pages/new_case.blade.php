@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Добавить кейс</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Создание нового кейса </h1>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-body">
				<form method="post" action="/admin/case/save" class="horizontal-form" id="save">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Название</label>
									<input type="text" class="form-control" placeholder="Название кейса" name="title">
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Цена</label>
									<input type="text" class="form-control" placeholder="0" name="price">
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
										<option value="1">Топовые комнаты</option>
										<option value="0">Обычные комнаты</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Отключение кейса</label>
									<select class="form-control" tabindex="1" name="is_active">
										<option value="1">Включен</option>
										<option value="0">Отключен</option>
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
												<input type="radio" name="img" value="viewn-1" checked=""> <img src="/assets/images/viewn/1.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-2"> <img src="/assets/images/viewn/2.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-3"> <img src="/assets/images/viewn/3.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-4"> <img src="/assets/images/viewn/4.png" width="100px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="img" value="viewn-5"> <img src="/assets/images/viewn/5.png" width="100px">
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
												<input type="radio" name="item" value="" checked=""> Нет
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w1"> <img src="/assets/images/w1.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w2"> <img src="/assets/images/w2.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w3"> <img src="/assets/images/w3.png" width="60px">
												<span></span>
											</label>
											<label class="mt-radio">
												<input type="radio" name="item" value="w4"> <img src="/assets/images/w4.png" width="60px">
												<span></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-actions right">
						<button type="submit" class="btn blue"><i class="fa fa-check"></i> Создать </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection