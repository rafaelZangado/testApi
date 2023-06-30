<?php 

namespace App\Contrcts;

interface RepoInterface{
    public function getAll();
    public function createItem($data);
    public function deletarItem($data);
    public function editItem($data);
}