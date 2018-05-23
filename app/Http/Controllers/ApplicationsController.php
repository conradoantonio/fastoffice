<?php

namespace App\Http\Controllers;

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
            return view('applications.table', ['prospects' => $prospects]);
        }
        return view('applications.index', ['prospects' => $prospects, 'menu' => $menu , 'title' => $title]);
    }

    /**
     * Show the form for creating/editing a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($id = 0)
    {
        $title = "Formulario";
        $menu = "Productos";
        $product = null;
        $categories = Category::all();
        if ($id) {
            $product = Product::find($id);
        }
        return view('products.form', ['product' => $product, 'categories' => $categories, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $product = New Product;

        $img = $this->upload_file($req->file('img'), 'img/products', true);

        $product->name = $req->name;
        $product->price = $req->price;
        $product->category_id = $req->category_id;
        $product->description = $req->description;
        $product->img = $img;

        $product->save();

        return response(['msg' => 'Producto registrado correctamente', 'status' => 'success', 'url' => url('admin/productos')], 200);
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
     * Use Excel instance to import many products at once.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $req)
    {
        $file = $req->excel_file;
        if ($file) {
            $path = $file->getRealPath();
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx' || $extension == 'xls') {
                $data = Excel::load($path, function($reader) {
                    $reader->setDateFormat('Y-m-d');
                })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $category = Category::where('name', $value->categoria)->first();

                        #If the given category wasn't found, then skip this product
                        if (!$category)
                            continue;

                        $insert = [
                            'name' => $value->nombre,
                            'price' => $value->precio,
                            'category_id' => $category->id,
                            'description' => $value->descripcion,
                            'img' => $value->img ? 'img/products/'.$value->img : 'img/default.jpg',
                        ];

                        Product::updateOrCreate([
                            'name' => $insert['name']
                        ], $insert);
                    }
                }//End data count if
                $data = ['url' => url('admin/productos'), 'refresh' => 'table', 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'Registros validados correctamente'];
                event(new PusherEvent($data));
                return response($data, 200);
            }//End of extension if
        } else {
            return response(['msg' => 'There is not file to upload'], 404);
        }
    }

    /**
     * Use Excel instance to export all products at once.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $req)
    {
    	$rows = array();
        $products = Product::all();

        foreach ($products as $product) {
            $img = explode('/', $product->img);
            $rows [] = ['nombre' => $product->name, 'precio' => $product->price, 'categoria' => $product->category->name, 'descripcion' => $product->description, 'img' => $img[2]];
        }

        Excel::create('Productos', function($excel) use($rows) {
            $excel->sheet('Hoja 1', function($sheet) use($rows) {
                $sheet->cells('A:E', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:E1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($rows);
            });
        })->export('xlsx');
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $req)
    {
        $msg = count($req->ids) > 1 ? 'los productos' : 'el producto';
        $products = Product::whereIn('id', $req->ids)
        ->get();
        //->delete();
        //->update(['status' => $req->status]);

        if ($products) {
            $data = ['url' => url('admin/productos'), 'refresh' => 'table', 'user_id' => $this->current_user->id, 'status' => 'success' ,'msg' => 'Éxito cambiando el status de '.$msg];
            event(new PusherEvent($data));
            return response($data, 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('admin/productos')], 404);
        }
    }
}
