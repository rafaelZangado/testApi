<?php 

namespace App\Repositories;

use App\Contrcts\RepoInterface;
use App\Models\Products;

class ProductRepository implements RepoInterface{

    protected $products;

    public function __construct(Products $products)
    {
      $this->products = $products;  
    }

    public function getAll(){
        return $this->products->all();
    }

    public function createItem($data){
       
        $this->products->name = $data['name'];
        $this->products->phone = $data['phone'];       
        $this->products->save();
       
        return  $this->products;
    }

    public function editItem($data){

        $product = $this->products->find($data['id']);

        if (!$product) {
            return null; 
        }

        $product->name = $data['name'];
        $product->phone = $data['phone'];

        $product->save();

        return $product;
    }

    public function deletarItem($data){
        $product = $this->products->findOrFail($data['id']);
        $product->delete();

        return $product;
    }

   
}