@extends('admin')

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/admin">Главная</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Настройки</span>
		</li>
	</ul>
</div>

<h1 class="page-title"> Настройки сайта </h1>

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
				<form method="post" action="/admin/settings/save" class="horizontal-form">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-body">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet-title">
									<div class="form-group">
										<div class="caption font-red-sunglo">
											<span class="caption-subject bold uppercase">Основные настройки</span>
										</div>
									</div>
								</div>
							</div> 
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Домен</label>
									<input type="text" class="form-control" placeholder="Домен" name="domain" value="{{ $config->domain }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Имя сайта</label>
									<input type="text" class="form-control" placeholder="Имя сайта" name="sitename" value="{{ $config->sitename }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Титул</label>
									<input type="text" class="form-control" placeholder="Титул" name="title" value="{{ $config->title }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Описание для поисковых систем</label>
									<input type="text" class="form-control" placeholder="Описание" name="description" value="{{ $config->description }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Ключи для поисковых систем</label>
									<input type="text" class="form-control" placeholder="Ключи" name="keywords" value="{{ $config->keywords }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Минимальная сумма пополнения</label>
									<input type="text" class="form-control" placeholder="Сумма" name="min_with_sum" value="{{ $config->min_with_sum }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="portlet-title">
									<div class="form-group">
										<div class="caption font-red-sunglo">
											<span class="caption-subject bold uppercase">Настройка оплаты</span>
										</div>
									</div>
								</div>
							</div> 
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">FK API</label>
									<input type="text" class="form-control" placeholder="FK API" name="fk_api" value="{{ $config->fk_api }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">ID Магазина</label>
									<input type="text" class="form-control" placeholder="ID Магазина" name="mrh_ID" value="{{ $config->mrh_ID }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Секретный ключ #1</label>
									<input type="text" class="form-control" placeholder="Секретный ключ #1" name="mrh_secret1" value="{{ $config->mrh_secret1 }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Секретный ключ #2</label>
									<input type="text" class="form-control" placeholder="Секретный ключ #2" name="mrh_secret2" value="{{ $config->mrh_secret2 }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Номер кошелька FK</label>
									<input type="text" class="form-control" placeholder="Номер кошелька FK" name="fk_wallet" value="{{ $config->fk_wallet }}">
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