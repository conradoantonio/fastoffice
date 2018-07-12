<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
	//return view('welcome');
	if(Auth::check()){return Redirect::to('dashboard');}
	return Redirect::to('login');
});

/*-- Login --*/
Route::get('login', function () {
	return view('login');
})->name('Login');
Route::post('login','LoginController@login');

Route::group(['middleware' => ['auth']], function() {
	#Login
	Route::post('logout','LoginController@logout');

	#Dashboard
	Route::get('dashboard', 'HomeController@index')->name('Dashboard');
	Route::put('actualizar-foto-perfil/{id}', 'UsersController@updatePhotoProfile')->name('User.updatePictue');

	Route::group(['middleware' => 'role:Administrador'], function() {
		#Compañia
		Route::get('empresa', 'CompaniesController@index')->name('Company');
		Route::put('actualizar-empresa/{id}', 'CompaniesController@update')->name('Company.update');

		#Ctegorías ingresos/egresos
		Route::get('categorias', 'CategoriesController@index')->name('Category');
		Route::get('formulario-categoria/{id?}', 'CategoriesController@form')->name('Category.form');
		Route::post('alta-categoria', 'CategoriesController@store')->name('Category.store');
		Route::put('actualizar-categoria/{id}', 'CategoriesController@update')->name('Category.update');
		Route::patch('status-categoria', 'CategoriesController@status')->name('Category.status');
		Route::delete('eliminar-categoria/{id}', 'CategoriesController@destroy')->name('Category.destroy');
		Route::delete('eliminar-categorias', 'CategoriesController@multipleDestroys')->name('Category.multipleDestroys');

		#Franquicias
		Route::get('franquicias', 'BranchesController@index')->name('Branch');
		Route::get('imagenes-franquicia/{id}', 'BranchesController@getPicturesByBranch')->name('Branch.Pictures');
		Route::get('formulario-franquicia/{id?}', 'BranchesController@form')->name('Branch.form');
		Route::post('alta-franquicia', 'BranchesController@store')->name('Branch.store');
		Route::post('subir-excel-franquicias', 'BranchesController@import')->name('Branch.excel');
		Route::put('actualizar-franquicia/{id}', 'BranchesController@update')->name('Branch.update');
		Route::patch('status-franquicia', 'BranchesController@status')->name('Branch.status');
		Route::delete('eliminar-franquicia/{id}', 'BranchesController@destroy')->name('Branch.destroy');
		Route::delete('eliminar-franquicias', 'BranchesController@multipleDestroys')->name('Branch.multipleDestroys');
		Route::delete('eliminar-franquicia-imagen', 'BranchesController@deleteBranchPicture')->name('Branch.destroyImage');

		#Templates
		Route::get('plantillas', 'TemplatesController@index')->name('Template');
		Route::get('formulario-plantilla/{id?}', 'TemplatesController@form')->name('Template.form');
		Route::post('alta-plantilla', 'TemplatesController@store')->name('Template.store');
		Route::put('actualizar-plantilla/{id}', 'TemplatesController@update')->name('Template.update');
		Route::patch('status-plantilla', 'TemplatesController@status')->name('Template.status');
		Route::delete('eliminar-plantilla/{id}', 'TemplatesController@destroy')->name('Template.destroy');
		Route::delete('eliminar-plantillas', 'TemplatesController@multipleDestroys')->name('Template.multipleDestroys');

		#Attachment
		Route::delete('eliminar-adjunto', 'AttachmentsController@delete')->name('Attachment.delete');
	});

	Route::group(['middleware' => 'role:Administrador,Franquisatario,Recepcionista'], function() {
		#Meetings
		Route::get('reuniones/{id?}/{start_date?}/{end_date?}', 'MeetingsController@index')->name('Meeting');
		Route::get('formulario-reunion/{id?}', 'MeetingsController@form')->name('Meeting.form');
		Route::post('alta-reunion', 'MeetingsController@store')->name('Meeting.store');
		Route::put('actualizar-reunion/{id}', 'MeetingsController@update')->name('Meeting.update');
		Route::patch('status-reunion', 'MeetingsController@status')->name('Meeting.status');
		Route::patch('progreso-reunion', 'MeetingsController@progress')->name('Meeting.progress');
		Route::delete('eliminar-reunion/{id}', 'MeetingsController@destroy')->name('Meeting.destroy');
		Route::delete('eliminar-reuniones', 'MeetingsController@multipleDestroys')->name('Meeting.multipleDestroys');
		Route::get('obtener-calendario/{id?}/{start_date?}/{end_date?}', 'MeetingsController@events')->name('Meeting.events');

		#Erp
		Route::get('erp/{id?}/{start_date?}/{end_date?}', 'ErpController@index')->name('Erp');
		Route::get('formulario-erp/{id?}', 'ErpController@form')->name('Erp.form');
		Route::post('alta-erp', 'ErpController@store')->name('Erp.store');
		Route::put('actualizar-erp/{id}', 'ErpController@update')->name('Erp.update');
		Route::patch('status-erp', 'ErpController@status')->name('Erp.status');
		Route::delete('eliminar-erp/{id}', 'ErpController@destroy')->name('Erp.destroy');
		Route::get('obtener-categories/{branch_id?}', 'ErpController@getCategoriesByType')->name('Erp.categories');

		#Prospects
		Route::prefix('crm/prospectos')->group(function () {
			Route::get('/', 'ApplicationsController@index')->name('Crm.prospects');
			Route::get('historial', 'ApplicationsController@show_applications_rejected')->name('Crm.prospects.history');
			Route::get('formulario-prospecto/{id?}', 'ApplicationsController@form_prospect')->name('Crm.prospects.form');
			Route::post('guardar-prospecto', 'ApplicationsController@save_prospect')->name('Crm.prospects.save');
			Route::post('actualizar-prospecto', 'ApplicationsController@update_prospect')->name('Crm.prospects.update');
			Route::post('change-status', 'ApplicationsController@change_status')->name('Crm.prospects.change_status');
			Route::post('filtrar-oficinas', 'ApplicationsController@filter_offices')->name('Crm.prospects.filter_offices');
			Route::post('guardar-commentario', 'ApplicationsController@save_application_comments')->name('Crm.prospects.save_comment');
			Route::post('ver-commentarios', 'ApplicationsController@view_applications_coments')->name('Crm.prospects.view_comments');
			Route::post('obtener-info-application', 'ApplicationsController@get_application_info')->name('Crm.prospects.get_application_info');
		});

		#Contracts
		Route::prefix('crm/contracts')->group(function () {
			Route::get('/', 'ContractsController@index')->name('Crm.contracts');
			Route::get('ver-contrato/{id?}', 'ContractsController@show_contract')->name('Crm.prospects.show_contract');//View contracts
			Route::get('recibo-de-dinero/{id?}', 'ContractsController@show_money_receipt')->name('Crm.contracts.show_money_receipt');
			Route::get('formulario/{app_id?}/{contract_id?}', 'ContractsController@form')->name('Crm.contracts.form');
			Route::post('guardar', 'ContractsController@save')->name('Crm.contracts.save');
			Route::post('actualizar', 'ContractsController@update')->name('Crm.contracts.update');
		});

		#Offices
		Route::get('oficinas/{id?}', 'OfficesController@index')->name('Office');
		Route::get('formulario-oficina/{id?}', 'OfficesController@form')->name('Office.form');
		Route::get('imagenes-oficina/{id}', 'OfficesController@getPicturesByOffice')->name('Office.Pictures');
		Route::post('alta-oficina', 'OfficesController@store')->name('Office.store');
		Route::post('subir-excel-oficinas', 'OfficesController@import')->name('Office.excel');
		Route::put('actualizar-oficina/{id}', 'OfficesController@update')->name('Office.update');
		Route::patch('status-oficina', 'OfficesController@status')->name('Office.status');
		Route::delete('eliminar-oficina/{id}', 'OfficesController@destroy')->name('Office.destroy');
		Route::delete('eliminar-oficinas', 'OfficesController@multipleDestroys')->name('Office.multipleDestroys');
		Route::get('obtener-usuarios/{branch_id?}', 'OfficesController@getUsersByBranch')->name('Office.users');
		Route::delete('eliminar-oficina-imagen', 'OfficesController@deleteOfficePicture')->name('Office.destroyImage');
		Route::get('obtener-municipio/{state_id}', 'OfficesController@getMunicipalities')->name('Office.state');

		#Auditorias
		Route::get('auditorias/{id?}', 'AuditsController@index')->name('Audit');
		Route::get('detalle-auditoria/{id}', 'AuditsController@show')->name('Audit.show');
	});

	#Usuarios
	Route::get('usuarios-sistema', 'UsersController@index')->name('User.index1');
	Route::get('usuarios-aplicacion', 'UsersController@index')->name('User.index2');
	Route::get('formulatio-usuario/{id?}', 'UsersController@form')->name('User.form');
	Route::post('alta-usuario', 'UsersController@store')->name('User.store');
	Route::put('actualizar-usuario/{id}', 'UsersController@update')->name('User.update');
	Route::patch('status-usuario', 'UsersController@status')->name('User.status');
	Route::delete('eliminar-usuario/{id}', 'UsersController@destroy')->name('User.destroy');

	#Noticias
	Route::get('noticias', 'NewsController@index')->name('News');
	Route::get('formNoticias/{id?}', 'NewsController@form')->name('News.form');
	Route::post('alta-Noticia', 'NewsController@store')->name('News.store');
	Route::put('actualizar-Noticia/{id}', 'NewsController@update')->name('News.update');
	Route::patch('status-Noticia/{id}', 'NewsController@status')->name('News.status');
	Route::delete('eliminar-Noticia/{id}', 'NewsController@destroy')->name('News.destroy');
	Route::delete('eliminar-Noticias', 'NewsController@multipleDestroys')->name('News.multipleDestroys');

	#Banners
	Route::get('banners', 'BannersController@index')->name('Banner');
	Route::get('formulario-banners/{id?}', 'BannersController@form')->name('Banner.form');
	Route::post('alta-banner', 'BannersController@store')->name('Banner.store');
	Route::put('actualizar-banner/{id}', 'BannersController@update')->name('Banner.update');
	Route::patch('status-banner', 'BannersController@status')->name('Banner.status');
	Route::delete('eliminar-banner/{id}', 'BannersController@destroy')->name('Banner.destroy');
	Route::delete('eliminar-banners', 'BannersController@multipleDestroys')->name('Banner.multipleDestroys');

	#Faqs
	Route::get('faqs', 'FaqsController@index')->name('Faq');
	Route::get('formulario-faqs/{id?}', 'FaqsController@form')->name('Faq.form');
	Route::post('alta-faq', 'FaqsController@store')->name('Faq.store');
	Route::put('actualizar-faq/{id}', 'FaqsController@update')->name('Faq.update');
	Route::patch('status-faq', 'FaqsController@status')->name('Faq.status');
	Route::delete('eliminar-faq/{id}', 'FaqsController@destroy')->name('Faq.destroy');
	Route::delete('eliminar-faqs', 'FaqsController@multipleDestroys')->name('Faq.multipleDestroys');
});

#Rutas API
Route::prefix('apiv1')->group(function () {
	/*
	* Webservices básicos
	*/
	Route::post('login', 'ApiController@login');
	Route::post('registro', 'ApiController@register');
	Route::post('actualizar-perfil', 'ApiController@updateProfile');
	Route::post('recuperar-password', 'ApiController@recovery');

	Route::post('filtrar-oficinas', 'ApiController@filter_offices');
	Route::post('guardar-prospecto', 'ApiController@save_prospect');
	Route::post('enviar-correo', 'ApiController@sendEmailCronJob');
});