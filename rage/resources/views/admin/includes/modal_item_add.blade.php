<script>
	$("#range_1").ionRangeSlider({
		type: "single",
		min: 0.1,
		max: 100,
		step: 0.1
	});
</script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Создание нового предмета</h4>
</div>
<form method="post" action="/admin/item/add" class="horizontal-form" id="save">
<div class="modal-body">
	<input name="id" value="{{ $case->id }}" type="hidden">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Имя предмета</label>
					<input type="text" class="form-control" name="name" value="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Цена</label>
					<input type="text" class="form-control" name="price" value="">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label">Тип</label>
					<select class="form-control" tabindex="1" name="type" value="">
						<option value="0">Валюта</option>
						<option value="1">Предмет</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-12 control-label text-center">Шанс выпадения</label>
					<div class="col-md-12">
						<input id="range_1" type="text" name="percent"/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-center">
					<label class="control-label">Валюта</label>
					<div class="col-md-12">
						<div class="mt-radio-inline">
							<label class="mt-radio">
								<input type="radio" name="rarity" value="0"> Нет
								<span></span>
							</label>
							<label class="mt-radio">
								<input type="radio" name="rarity" value="1"><img src="/assets/images/coin/1.png" width="40px">
								<span></span>
							</label>
							<label class="mt-radio">
								<input type="radio" name="rarity" value="2"><img src="/assets/images/coin/2.png" width="40px">
								<span></span>
							</label>
							<label class="mt-radio">
								<input type="radio" name="rarity" value="3"><img src="/assets/images/coin/3.png" width="40px">
								<span></span>
							</label>
							<label class="mt-radio">
								<input type="radio" name="rarity" value="4"><img src="/assets/images/coin/4.png" width="40px">
								<span></span>
							</label>
							<label class="mt-radio">
								<input type="radio" name="rarity" value="5"><img src="/assets/images/coin/5.png" width="40px">
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
					<label class="control-label">Предмет</label>
					<div class="col-md-12">
						<input type="text" class="form-control" name="img" placeholder="Путь к картинке: /assets/images/iphone5s.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="modal-footer">
	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Закрыть</button>
	<button type="submit" class="btn green"><i class="fa fa-check"></i> Сохранить</button>
</div>
</form>