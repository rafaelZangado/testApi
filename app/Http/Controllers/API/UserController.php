<?php

namespace App\Http\Controllers\API;

use App\Contrcts\RepoInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $postRepo;

    public function __construct(RepoInterface $repor)
    {
        $this->postRepo = $repor;
    }

    /**
     * @param Request $request
     * @return JsonResponse
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

    /**
    * Realiza o logout do usuário autenticado.
    *
    * @return JsonResponse
    */
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

    /**
    * Obtém os detalhes do usuário autenticado.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getUserDetail()
    {
        $user = Auth::guard('api')->user();
        return Response(['Data' => $user],200);
    }

    /**
    * Adiciona um novo item (produto).
    *
    * @param  ProductRequest  $request
    * @return JsonResponse
    */
    public function addItem(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = $this->postRepo->createItem($validatedData);
        return response()->json($product, 201);
    }

    /**
    * Lista todos os itens (produtos).
    *
    * @return JsonResponse
    */
    public function listarItens()
    {
        $products = $this->postRepo->getAll();
        return response()->json($products);       
    }

    /**
    * Edita um item (produto) existente.
    *
    * @param  Request  $request
    * @return JsonResponse
    */
    public function editarItem(Request $request)
    {
        $validatedData = $request->validated();
        $product = $this->postRepo->editItem($validatedData);
        
        if (!$product) {
            return response()->json([
                'error' => 'Produto não encontrado'
            ], 404);
        }
        
        return response()->json([
            'message' => 'Produto atualizado com sucesso',
            'data' => $product
        ], 200);
    }

    /**
    * Deleta um item (produto) existente.
    *
    * @param  Request  $request
    * @return JsonResponse
    */
    public function deletarItem(Request $request)
    {
        $product = $this->postRepo->deletarItem($request->all());

        return response()->json([
            'message' => 'Produto excluído com sucesso',
            'Produto' => $product
        ]);
    }
}
