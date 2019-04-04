<!DOCTYPE html>
<html>
<head>
	<title>Contrato de prestación de servicios</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/pdf_v2.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrapv4.min.css')}}">
</head>

{{-- <body> --}}
<div class="fixed-top">
	<img class="logo" src="{{asset('img/fa_of_logo.png')}}">
</div>
<div class="fixed-middle">
	<img class="water-mark" src="{{asset('img/fa_icon.png')}}">
</div>
<div class="start-page">
	@include('contracts.physical_virtual.cover')

	<div class="new-page"></div>
	<br>
	@include('contracts.physical_virtual.statements')
</div>

{{-- </body> --}}
{{-- @include('contracts.layouts.footer') --}}
</html>

