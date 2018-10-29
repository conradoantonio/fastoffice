<div class="row">
	@if( auth()->user()->role_id == 1 )
		<div class="form-group col-md-{{$dates?4:12}} {{auth()->user()->role_id!=1?'hide':''}}">
			{{Form::label('branch_id', 'Franquicia', ['class' => 'control-label required'])}}
			{!!Form::select('branch_id', $branches, null, ['class' => ' form-control not-empty select2 col-md-12', 'id' => 'byField', 'name' => 'branch_id', 'data-name' => 'Franquicia'] )!!}
		</div>
	@endif
	@if( auth()->user()->role_id == 2 )
		@if( Route::currentRouteName() == "Erp" )
			<div class="form-group col-md-{{$dates?4:12}}">
				{{Form::label('branch_id', 'Franquicia', ['class' => 'control-label required'])}}
				{!!Form::select('branch_id', $branches, null, ['class' => ' form-control not-empty select2 col-md-12', 'id' => 'byField', 'name' => 'branch_id', 'data-name' => 'Franquicia'] )!!}
			</div>
		@else
			<div class="form-group col-md-{{$dates?4:12}} {{auth()->user()->role_id!=2?'hide':''}}">
				{{Form::label('office_id', 'Oficina', ['class' => 'control-label required'])}}
				{!!Form::select('office_id', $offices, null, ['class' => ' form-control not-empty select2 col-md-12', 'id' => 'byField', 'name' => 'office_id', 'data-name' => 'Oficina'] )!!}
			</div>
		@endif
	@endif
	@if( $dates )
	<div class="form-group col-md-{{auth()->user()->role_id==1||auth()->user()->role_id==2?4:6}}">
		<label for="start_date">Fecha inicio</label>
		<div class="input-append success date col-md-11 no-padding">
			{{Form::text('start_date', Route::input('start_date'), ['class' => 'form-control', "id" => "start_date"])}}
		    <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
		</div>
	</div>
	<div class="form-group col-md-{{auth()->user()->role_id==1||auth()->user()->role_id==2?4:6}}">
		<label for="end_date">Fecha término</label>
		<div class="input-append success date col-md-11 no-padding">
			{{Form::text('end_date', Route::input('end_date'), ['class' => 'form-control', "id" => "end_date"])}}
		    <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
		</div>
	</div>
	@endif
	<div class="col-md-12 text-center">
		<button class="btn btn-primary" id="filtrar" data-url="{{$index_url}}">
			Filtrar
		</button>
		@if ( $export_url )
		<button class="btn btn-info" id="exportar" data-url="{{$export_url}}">
			Exportar
		</button>
		@endif
	</div>
</div>