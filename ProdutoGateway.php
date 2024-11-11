<?php
class ProdutoGateway {
    // Conexão com o banco de dados
    private static $conn;
    
    public static function setConnection(PDO $conn) {
        self::$conn = $conn;
    }

    public function find($id, $class = 'stdClass') {
        $sql = "SELECT * FROM produto WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject($class);
    }

    public function all($filter = '', $class = 'stdClass') {
        $sql = "SELECT * FROM produto ";
        if ($filter) {
            $sql .= "WHERE $filter";
        }
        $stmt = self::$conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function delete($id) {
        $sql = "DELETE FROM produto WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save($data) {
        if (empty($data->id)) {
            // Não define `id`, pois é `AUTO_INCREMENT`
            $sql = "INSERT INTO produto (descricao, estoque, preco_custo, preco_venda, codigo_barras, data_cadastro, origem) 
                    VALUES (:descricao, :estoque, :preco_custo, :preco_venda, :codigo_barras, :data_cadastro, :origem)";
            $stmt = self::$conn->prepare($sql);
        } else {
            $sql = "UPDATE produto SET 
                    descricao = :descricao,
                    estoque = :estoque,
                    preco_custo = :preco_custo, 
                    preco_venda = :preco_venda,
                    codigo_barras = :codigo_barras,
                    data_cadastro = :data_cadastro,
                    origem = :origem
                    WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $data->id, PDO::PARAM_INT);
        }

        // Bind dos parâmetros comuns
        $stmt->bindValue(':descricao', $data->descricao);
        $stmt->bindValue(':estoque', $data->estoque, PDO::PARAM_INT);
        $stmt->bindValue(':preco_custo', $data->preco_custo);
        $stmt->bindValue(':preco_venda', $data->preco_venda);
        $stmt->bindValue(':codigo_barras', $data->codigo_barras);
        $stmt->bindValue(':data_cadastro', $data->data_cadastro);
        $stmt->bindValue(':origem', $data->origem);

        return $stmt->execute();
    }

    public function getLastId() {
        $sql = "SELECT MAX(id) as max FROM produto";
        $stmt = self::$conn->query($sql);
        $data = $stmt->fetchObject();
        return $data->max;
    }
}
