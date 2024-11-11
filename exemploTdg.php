<?php
require_once 'ProdutoGateway.php';

try{
    $conn = new PDO("mysql:host=localhost;dbname=estoque", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ProdutoGateway::setConnection($conn);
    // $data = new stdClass;
    // $data-> descricao = 'vinho';
    // $data->estoque = '8';
    // $data->preco_custo = 12;
    // $data->preco_venda = 18;
    // $data->codigo_barras = '12312423';
    // $data->cadata_cadastro = date('Y-m-d');
    // $data->origem = 'N';

    $gw = new ProdutoGateway;
    // $gw->save($data);
    // $produto = $gw->find(4);
    // $produto->estoque +=2;
    // $gw->save($produto);

    $gw = new ProdutoGateway;
    foreach ($gw->all('estoque <= 10') as $produto)
    {
        print $produto->descricao . "<br>";
    }
}
catch(Exception $e){
    print $e->getMessage();
}