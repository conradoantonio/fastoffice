<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>@yield('pageTitle') | {{config('app.name')}}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="base-url" content="{{ url('') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="" name="description" />
	<meta content="Luis Castañeda" name="author" />

	<link href="{{asset('/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<!-- BEGIN CORE CSS FRAMEWORK -->
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/animate.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('/plugins/jquery-datatable/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('/plugins/bootstrap-select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('/plugins/ios-switch/ios7-switch.css')}}" rel="stylesheet" type="text/css" media="screen">
	<link href="{{asset('/plugins/boostrap-slider/css/slider.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/dropzone/css/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
	<!-- END CORE CSS FRAMEWORK -->

	<!-- BEGIN CSS TEMPLATE -->
	<link href="{{asset('/css/themes/coporate/style.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/themes/coporate/responsive.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-tag/bootstrap-tagsinput.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>

	<!-- CSS PROPIOS -->
	<link href="{{asset('/css/plugins/sweetalert.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/croppie.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
	<script src="{{asset('/plugins/jquery-1.8.3.min.js')}}" type="text/javascript"></script>

	<!-- IMPORT LINKS USED IN VIEWS-->
	@stack('links')
	<!-- END CSS TEMPLATE -->
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="">
<!-- BEGIN HEADER -->
<!-- ESPACIO PARA MODALS -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titleModal" id="pictureModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="titleModal">Actualizar foto de perfil</h4>
			</div>
			<div class="modal-body">
				{{ Form::model(auth()->user(), ['url' => route('User.updatePictue', auth()->user()->id), 'id' => 'pictureForm' ,'autocomplete' => 'off', 'files' => true]) }}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="form-group col-md-5 text-center">
							<img src="{{asset(auth()->user()->photo)}}" alt="..." class="img-circle" width="35%" id="foto_perfil">
						</div>
						<div class="form-group col-md-7">
							{{Form::label('photo', 'Foto de perfil', ['class' => !auth()->user()->photo?'label-control required':'label-control'])}}
							{{Form::hidden('base64', null, ['class' => 'form-control'])}}
							{{Form::file('photo', ['class' =>!auth()->user()->photo?'form-control not-empty file image':'form-control', 'data-name' => 'Foto'])}}
						</div>
					</div>
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="destroyCroppie()">Cancelar</button>
				<button type="submit" class="btn btn-success guardar" data-target="pictureForm">Guardar</button>
			</div>
		</div>
	</div>
</div>
@yield('modals')
<!-- FIN ESPACIO PARA MODALS -->
<div class="header navbar navbar-inverse ">
		<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<div class="header-seperation">
			<ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
				<li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" > <div class="iconset top-menu-toggle-white"></div> </a> </li>
			</ul>
			<!-- BEGIN LOGO -->
			<a href="{{url('/home')}}"><img src="{{asset('/img/logo.png')}}" class="logo" alt=""  data-src="{{asset('/img/logo.png')}}" data-src-retina="{{asset('/img/logo.png')}}" width="27%" height="21"/></a>
			<!-- END LOGO -->
			<div class="pull-right">
				<ul class="nav pull-right notifcation-center">
					<!-- <li class="dropdown" id="header_task_bar">
						<a href="{{url('home')}}" class="dropdown-toggle active" data-toggle="">
							<i class="fa fa-home"></i>
						</a>
					</li> -->
					<li class="dropdown" id="header_task_bar_2">
						<a href="#!" class="logout"><i class="glyphicon glyphicon-log-out"></i>
							<form class="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
						</a>
					</li>
					<!-- <li class="dropdown" id="header_inbox_bar" > <a href="email.html" class="dropdown-toggle" >
						<div class="iconset top-messages"></div>
						<span class="badge" id="msgs-badge">2</span> </a></li> -->
					<!-- <li class="dropdown" id="portrait-chat-toggler" style="display:none"> <a href="#sidr" class="chat-menu-toggle">
						<div class="iconset top-chat-white "></div>
						</a> </li> -->
				</ul>
			</div>
			<ul class="nav pull-right notifcation-center">
<!--				<li class="dropdown" id="header_task_bar"> <a href="{{url('/home')}}" class="dropdown-toggle active" data-toggle=""> <div class="iconset top-home"></div> </a> </li>
-->
			</ul>
		</div>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<div class="header-quick-nav" >
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="pull-left">
				<ul class="nav quick-section">
					<li class="quicklinks">
						<a href="#" class="" id="layout-condensed-toggle" >
							<i class="top-menu-toggle-dark fa fa-bars"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
			<!-- BEGIN CHAT TOGGLER -->
			<div class="pull-right">
				@if( auth()->user()->role_id == 3 )
					<div class="chat-toggler" id="notifications">
						<a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom"  data-content='' data-toggle="dropdown" data-original-title="Recordatorios">
							<div class="user-details">
								<div class="username">
									<span class="badge badge-important">{{session('reminders')->count()}}</span> <i class="fa fa-bell"></i></span>
								</div>
				  			</div>
				  			<div class="iconset top-down-arrow"></div>
			  			</a>
			  			<div id="notification-list" style="display:none">
							<div style="width:300px">
								@foreach( session('reminders') as $reminder )
								@php
									$class = "";
									if ( $reminder->proccess == 1 ){
										$class = 'success';
									} elseif ( $reminder->proccess == 0 ){
										$class = 'warning';
									} else {
										$class = 'danger';
									}
								@endphp
								<div class="notification-messages {{$class}}">
									<div class="message-wrapper">
										<div class="heading"> {{$reminder->office->name}} - {{ucwords(strftime('%d %B %Y %H:%M', strtotime($reminder->datetime_start)))}}</div>
										<div class="description"> {{$reminder->title}} </div>
										<div class="date pull-left"> Usuario: {{$reminder->user? $reminder->user->fullname : 'No registrado'}} </div>
									</div>
									<div class="clearfix"></div>
								</div>
								@endforeach
							</div>
			  			</div>
					</div>
				@endif
				{{-- <div class="chat-toggler">
					<a href="#" class="dropdown-toggle">
						<div class="user-details">
							<div class="username">{{auth()->user()->fullname}}</div>
						</div>
					</a>
					<div class="profile-pic"> <img src="{{!auth()->user()->photo?asset('/img/profiles/avatar_small.jpg'):asset('/img/profiles/'.auth()->user()->id.'/'.auth()->user()->photo)}}" alt="" data-src="{{!auth()->user()->photo?asset('/img/profiles/avatar_small.jpg'):asset('/img/profiles/'.auth()->user()->id.'/'.auth()->user()->photo)}}" data-src-retina="{{!auth()->user()->photo?asset('/img/profiles/avatar_small2x.jpg'):asset('/img/profiles/'.auth()->user()->id.'/'.auth()->user()->photo)}}" width="35" height="35"> </div>
				</div> --}}
				<ul class="nav quick-section">
					<li class="quicklinks"> <span class="h-seperate"></span></li>
					<li class="quicklinks">
						<a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
							<div class="top-settings-dark fa fa-cog"></div>
						</a>
						<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
							<li><a data-toggle="modal" data-target="#pictureModal" href="#"><i class="fa fa-picture-o" aria-hidden="true" style="font-size: 15px !important;"></i> Cambiar foto perfil</a></li>
							<li>
								<a href="#!" class="logout"><i class="fa fa-power-off" style="font-size: 15px !important;"></i> Cerrar sesión
									<form class="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
								</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>
			<!-- END CHAT TOGGLER -->
		</div>
	<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar" id="main-menu">
		<!-- BEGIN MINI-PROFILE -->
		<div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
			<div class="user-info-wrapper">
				<div class="profile-wrapper">
					<img src="{{asset(auth()->user()->photo)}}"  alt="" data-src="{{asset(auth()->user()->photo)}}" data-src-retina="{{asset(auth()->user()->photo)}}" width="69" height="69" />
				</div>
				<div class="user-info">
					<div class="greeting">Bienvenido</div>
					<div class="username">{{auth()->user()->fullname}} <span class="semi-bold"></span></div>
					<div class="status">Status<a href="#"><div class="status-icon green"></div>Online</a></div>
				</div>
			</div>
			<!-- END MINI-PROFILE -->

			<!-- BEGIN SIDEBAR MENU -->
			<ul>
				<li class="start {{ ( Route::currentRouteName()== 'Dashboard' ) ? 'active open' : '' }}">
					<a href="{{route('Dashboard')}}"> <i class="fa fa-line-chart"></i> <span class="title">Dashboard</span> <span class="selected"></span></a>
				</li>
				<li class="{{ in_array(Route::currentRouteName(), ['User.index1', 'User.index2', 'User.form'] ) ? 'active' : '' }}">
					<a href="#!">
						<i class="fa fa-users"></i> <span class="title">Usuarios</span> <span class="selected"></span> <span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="{{ ( in_array(Route::currentRouteName(), ['User.index1', 'User.form']) ) ? 'active' : '' }}"> <a href="{{route('User.index1')}}"> Sistema </a> </li>
						<li class="{{ ( Route::currentRouteName() == 'User.index2' ) ? 'active' : '' }}"> <a href="{{route('User.index2')}}"> Aplicación</a> </li>
					</ul>
				</li>
				<?php /*
					<li class="start {{ ( Route::currentRouteName()== 'Company' ) ? 'active' : '' }}">
						<a href="{{route('Company')}}"> <i class="fa fa-info-circle"></i> <span class="title">Empresa</span> <span class="selected"></span></a>
					</li>
					<li class="start {{ ( in_array(Route::currentRouteName(),['News', 'News.form']) ) ? 'active open' : '' }}">
						<a href="{{route('News')}}"> <i class="fa fa-newspaper-o"></i> <span class="title">Noticias</span> <span class="selected"></span></a>
					</li>
					<li class="start {{ ( in_array(Route::currentRouteName(),['Banner', 'Banner.form']) ) ? 'active open' : '' }}">
						<a href="{{route('Banner')}}"> <i class="fa fa-image"></i> <span class="title">Banners</span> <span class="selected"></span></a>
					</li>
					<li class="start {{ ( in_array(Route::currentRouteName(),['Faq', 'Faq.form']) ) ? 'active open' : '' }}">
						<a href="{{route('Faq')}}"> <i class="fa fa-question-circle"></i> <span class="title">Faqs</span> <span class="selected"></span></a>
					</li>
				*/?>
				<li class="{{ in_array(Route::currentRouteName(), ['Template', 'Template.form', 'Crm.prospects', 'Crm.prospects.form'] ) ? 'active' : '' }}">
					<a href="javascript:;">
						<i class="fa fa-list-ul"></i> <span class="title">CRM</span> <span class="selected"></span> <span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="{{ ( in_array(Route::currentRouteName(),['Crm.prospects', 'Crm.prospects.form']) ) ? 'active open' : '' }}">
							<a href="{{route('Crm.prospects')}}"> Prospectos </a>
						</li>
						<li class="{{ ( in_array(Route::currentRouteName(),['', '']) ) ? 'active open' : '' }}">
							<a href="{{route('Crm.prospects.history')}}"> Prospectos (Descartados) </a>
						</li>
						<li class="{{ ( in_array(Route::currentRouteName(),['', '']) ) ? 'active open' : '' }}">
							<a href=""> Clientes </a>
						</li>
						<li class="{{ ( in_array(Route::currentRouteName(),['Template', 'Template.form']) ) ? 'active open' : '' }}">
							<a href="{{route('Template')}}"> Plantillas </a>
						</li>
					</ul>
				</li>
				<li class="{{ in_array(Route::currentRouteName(), ['Erp', 'Erp.form', 'Office', 'Office.form', 'Branch', 'Branch.form', 'Category', 'Category.form'] ) ? 'active open' : '' }}">
					<a href="#!">
						<i class="fa fa-money"></i> <span class="title">ERP</span> <span class="selected"></span> <span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						@if(auth()->user()->role->name == 'Administrador')
						<li class="{{ ( in_array(Route::currentRouteName(),['Category', 'Category.form']) ) ? 'active' : '' }}">
							<a href="{{route('Category')}}"> Categorías </a>
						</li>
						@endif
						<li class="{{ ( in_array(Route::currentRouteName(),['Erp', 'Erp.form']) ) ? 'active' : '' }}">
							<a href="{{route('Erp')}}"> Ingresos y egresos </a>
						</li>
						@if(auth()->user()->role->name == 'Administrador')
							<li class="{{ in_array(Route::currentRouteName(), ['Branch', 'Branch.form'] ) ? 'active' : '' }}">
								<a href="{{route('Branch')}}"> Franquicias </a>
							</li>
						@endif
						@if( auth()->user()->role_id != 3 )
						<li class="{{ in_array(Route::currentRouteName(), ['Office', 'Office.form'] ) ? 'active' : '' }}">
							<a href="{{route('Office')}}"> Oficinas </a>
						</li>
						@endif
					</ul>
				</li>

				<li class="start {{ in_array(Route::currentRouteName(), ['Meeting', 'Meeting.form'] ) ? 'active open' : '' }}">
					<a href="{{route('Meeting')}}"> <i class="fa fa-calendar"></i> <span class="title">Calendario</span> <span class="selected"></span></a>
				</li>

			</ul>
			<div class="clearfix"></div>
		</div>
		<!-- END SIDEBAR MENU -->
	</div>
	<a href="#" class="scrollup">Scroll</a>
	<!-- <div class="footer-widget">
		<div class="progress transparent progress-small no-radius no-margin">
			<div data-percentage="100%" class="progress-bar progress-bar-info animate-progress-bar" ></div>
		</div>
		<div class="pull-right">
			<div class="details-status">
				<span data-animation-duration="560" data-value="100" class="animate-number"></span>%
			</div>
			<a href="#!" class="logout"><i class="fa fa-power-off"></i>
				<form class="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
			</a>
		</div>
	</div> -->
	<!-- END SIDEBAR -->
	<!-- BEGIN PAGE CONTAINER-->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<div id="portlet-config" class="modal hide">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button"></button>
				<h3>Widget Settings</h3>
			</div>
			<div class="modal-body"> Widget settings form goes here </div>
		</div>
		<div class="clearfix"></div>
		<div class="content">
			<!-- Aquí va el contenido del cms -->
			@yield('content')
		</div>
	</div>
 </div>
<!-- END CONTAINER -->
<!-- BEGIN CHAT -->

<!-- END CHAT -->
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->

<script src="{{asset('/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{asset('/plugins/breakpoints.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-block-ui/jqueryblockui.js')}}" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-numberAnimate/jquery.animateNumbers.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/dropzone/dropzone.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{asset('/js/core.js')}}" type="text/javascript"></script>

<!-- JQUERY DATATABLE -->
<script src="{{ asset('/plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/datatables.js') }}"></script>

<!-- JS PROPIOS -->
<script src="{{asset('/js/script.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/croppie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/validForm.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/bootstrap-tag/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/generalAjax.js')}}" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->

<!-- IMPORT SCRIPTS USED IN VIEWS-->
@stack('scripts')

</body>
</html>