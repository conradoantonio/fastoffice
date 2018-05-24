<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
        $title = "Prospectos";
        $menu = "CRM";
        $prospects = Application::orderBy('id', 'desc')->where('status', 0)->get();

        if ($req->ajax()) {
            return view('applications.prospects.table', ['prospects' => $prospects]);
        }
        return view('applications.prospects.index', ['prospects' => $prospects, 'menu' => $menu , 'title' => $title]);
    }

    /**
     * Show the form for creating/editing a resource about a new prospect.
     *
     * @return \Illuminate\Http\Response
     */
    public function form_prospect($id = 0)
    {
        $title = "Formulario";
        $menu = "Prospectos";
        $prospect = null;
        $customers = User::where('role_id', 4)->get();
        $offices = Office::where('status', 1)->get();//Falta filtrar por disponibilidad y tipo de usuario
        if ($id) {
            $prospect = Application::where('status', 0)->first($id);
        }
        return view('applications.prospects.form', ['prospect' => $prospect, 'customers' => $customers, 'offices' => $offices, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save a new prospect.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_prospect(Request $req)
    {
        return app('App\Http\Controllers\ApiController')->save_prospect($req);
    }

    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $product = Product::find($req->id);
        if ($product) {
        	$img = $this->upload_file($req->file('img'), 'img/products', true);

            $product->name = $req->name;
            $product->price = $req->price;
            $product->category_id = $req->category_id;
            $product->description = $req->description;
	        $img ? $product->img = $img : '';

	        $product->save();

	        return response(['msg' => 'Producto actualizado correctamente', 'status' => 'success', 'url' => url('admin/productos')], 200);
        }

	    return response(['msg' => 'No se encontró el producto a editar', 'status' => 'error', 'url' => url('admin/productos')], 404);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $req)
    {
        $msg = count($req->ids) > 1 ? 'los prospectos' : 'el prospecto';
        $products = Product::whereIn('id', $req->ids)
        ->get();
        //->delete();
        //->update(['status' => $req->status]);

        if ($products) {
            $data = ['url' => url('crm/prospectos'), 'refresh' => 'table', 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'Éxito cambiando el status de '.$msg];
            return response($data, 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('crm/prospectos')], 404);
        }
    }
}
