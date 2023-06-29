<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Products;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request)
    {
        $input = $request->all();
        if (Auth::attempt($input)) {
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;
    
            return response()->json([
                'status' => 200,
                'token' => $token,
                'user' => [
                    'name' => $user->name
                ]
            ], 200);
        }
    
        return response()->json([
            'status' => 401,
            'message' => 'Credenciais inválidas'
        ], 401);
    }

    public function userLogout()
    {

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user->tokens()->delete();
            Auth::guard('api')->logout();
    
            return response()->json([
                'message' => 'Usuário deslogado com sucesso',
                'user' => $user
            ], 200);
        }
    
        return response()->json([
            'message' => 'Usuário não está autenticado'
        ], 401);
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
