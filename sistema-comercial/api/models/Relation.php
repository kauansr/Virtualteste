<?php

class ProdutoFornecedor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar($fornecedorid, $produtoid) {
        $sql = "INSERT INTO produto_fornecedor (fornecedor_id, produto_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $fornecedorid, $produtoid);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    
    public function listarPorProduto($produto_id) {
        $sql = "SELECT pf.id, f.nome AS fornecedor_nome, p.nome AS produto_nome
                FROM produto_fornecedor pf
                INNER JOIN fornecedores f ON f.id = pf.fornecedor_id
                INNER JOIN produtos p ON p.id = pf.produto_id
                WHERE pf.produto_id = ?";

        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $produto_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $dados = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $dados[] = $row;
            }
            return $dados;
        }
        return [];
    }

    
    public function excluir($id) {
        $sql = "DELETE FROM produto_fornecedor WHERE id = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

   
    public function excluirPorProduto($produto_id) {
        $sql = "DELETE FROM produto_fornecedor WHERE produto_id = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $produto_id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }


    public function excluirVarios($ids = []) {
        if (empty($ids)) return false;

        
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $tipos = str_repeat('i', count($ids));

        $sql = "DELETE FROM produto_fornecedor WHERE id IN ($placeholders)";

        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, $tipos, ...$ids);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function verificarRelacionamento($fornecedorid, $produtoid) {
    
    $sql = "SELECT id FROM fornecedores WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fornecedorid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 0) return "Fornecedor não encontrado.";

    
    $sql = "SELECT id FROM produtos WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $produtoid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 0) return "Produto não encontrado.";

    
    $sql = "SELECT id FROM produto_fornecedor WHERE fornecedor_id = ? AND produto_id = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $fornecedorid, $produtoid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) return "Essa relação já existe!";

    return true; 
}

}

?>
