<?php
class Produto
{
    private $data;

    public function __get($name)
    {
        return $this->data[$name]
    }

    public function __set($name, $value)
    {
        return $this->data[$name] = $value;
    }
    public static function find($id)
    {
        $gw = ProdutoGateway;
        return $gw->find($id, 'Produto');
    }
    public static function all($filter = ''){
        $gw = ProdutoGateway;
        return $gw->all($filter, 'Produto');
    }
    
    public function delete(){
        $gw = ProdutoGateway;
        return $gw->delete($this->id);
        
    }
    public function save(){
        $gw = ProdutoGateway;
        return $gw->save((object) $this->data);

    }

    public function getMargemLucro(){

    }
    public function registraCompra(){

    }
}
