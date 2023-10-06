<?php

namespace App\Http\Controllers;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Print_;

class ProductosController extends Controller{



    // index

    public function index(){
        return response()->json([
            'data'=> Productos::all()    
        ], 200);
    }


    // store

    public function store(Request $request){

       
        $validate = Validator::make(
              $request->all(),
              [
                'nombre_producto' => 'required|max:100|min:3',
                'categoria' => 'required|max:10|min:3',
                'precio' => 'required|numeric'
              ]
         );

        if($validate->fails()){
            return response()->json([
                'message' => 'Error de validacion',
                'error' => $validate->errors()
            ], 400);
        }

        $productoExistente = Productos::where('nombre_producto', $request->nombre_producto)->first();

        if($productoExistente){
            return response()->json([
                'message' => 'El producto ya existe'
            ], 400);
        }

        $producto = new Productos();

        $producto->nombre_producto = $request->nombre_producto;
        $producto->categoria = $request->categoria;
        $producto->precio = $request->precio;
        $producto ->save();

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data' => $producto
        ], 201);
    }

    // update

    public function update(Request $request, $id){
        $validator = Validator::make([
            $request->all(),
            [
                'nombre_producto' => 'required|max:100|min:3',
                'categoria' => 'required|max:10|min:3',
                'precio' => 'required|numeric'
            ]
        
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error de validacion',
                'error' => $validator->errors()
            ], 400);
        }

        $productoExistente = Productos::where('nombre_producto', $request->nombre_producto)->first();

        if($productoExistente && $productoExistente->id != $id){
            return response()->json([
                'message' => 'El producto ya existe'
            ], 400);
        }

        $producto = new Productos();

        $producto->nombre_producto = $request->nombre_producto;
        $producto->categoria = $request->categoria;
        $producto->precio = $request->precio;
        $producto ->save();

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'data' => $producto
        ], 201);

    }

    // destroy

    public function destroy(int $id){
        $producto = Productos::find($id);

        if(!$producto){
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ], 200);
    }
}
