<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Products;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request)
    {
       $input = $request->all();
       Auth::attempt($input);
       $user = Auth::user();
       $token = $user->createToken('token')->accessToken;

        return Response(['status' => 200, 'token' => $token], 200);
    }

   
    public function getUserDetail()
    {
        $user = Auth::guard('api')->user();
        return Response(['Data' => $user],200);
    }

   
    public function addItem(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = Products::create($validatedData);
        return response()->json($product, 201);
    }

   
    public function listarItens()
    {
        $products = Products::all();
        return response()->json($products);
    }

    public function editarItem(Request $request)
    {
        $product = Products::find($request->id);
       
        if (!$product) {
            return response()->json([
                'error' => 'Produto não encontrado'
            ], 404);
        }

      
        $product->name = $request->input('name');
        $product->phone = $request->input('phone');

        
        $product->save();

        
        return response()->json([
            'message' => 'Produto atualizado com sucesso', 
            'data' => $product
        ], 200);

    }

    public function deletarItem(Request $request)
    {
        $product = Products::findOrFail($request->id);
        $product->delete();

        return response()->json([
            'message' => 'Produto excluído com sucesso'
        ]);
    }
}
