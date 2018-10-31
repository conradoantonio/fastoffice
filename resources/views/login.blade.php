<html>
	<head>
		<title>{{Route::current()->getName()}} | {{config('app.name')}}</title>
		<link href="{{asset('/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen"/>
		<!-- BEGIN CORE CSS FRAMEWORK -->
		<link href="{{asset('/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/plugins/boostrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/animate.min.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css"/>
		<!-- END CORE CSS FRAMEWORK -->

		<!-- BEGIN CSS TEMPLATE -->
		<link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
		<link href="{{asset('/css/themes/coporate/style.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/themes/coporate/responsive.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/plugins/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css"/>
		 <style type="text/css">
            /* Change the white to any color ;) */
            input:-webkit-autofill {
                -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            }
            body{
                background: url({{asset('img/background_login.jpg')}});
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center bottom;
            }
            .opacity {
                opacity: 0.9;
            }
            .login-panel h6 {
                padding: 0 15px 10px;
            }
        </style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default panel-login">
						<div class="panel-heading">Inicio de sesión</div>
						<div class="panel-body">
							<form class="form" method="POST" action="{{ url('login') }}" autocomplete="off">
								{{ csrf_field() }}

								<div class="row form-group {{ $errors->has('email') || $errors->has('status') || $errors->has('role') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<label for="email" class="control-label">Correo electrónico</label>
										<input id="email" type="email" class="form-control not-empty" name="email" value="{{ @session('account')?session('account'):'' }}" autofocus data-name="Correo electrónico">

										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
										@if ($errors->has('status'))
											<span class="help-block">
												<strong>{{ $errors->first('status') }}</strong>
											</span>
										@endif
										@if ($errors->has('role'))
											<span class="help-block">
												<strong>{{ $errors->first('role') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="row form-group {{ $errors->has('password') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<label for="password" class="control-label">Contraseña</label>
										<input id="password" type="password" class="form-control not-empty" name="password" data-name="Contraseña">

										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<div class="text-center">
										<button class="btn btn-primary btn-login">
											Login
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="{{asset('/plugins/jquery-1.8.3.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/sweetalert2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/validForm.js')}}" type="text/javascript"></script>