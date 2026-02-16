<?php

class Produto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
    $sql = "SELECT * FROM produtos";
    $result = mysqli_query($this->conn, $sql);

    $dados = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dados[] = $row;
        }
    }
    return $dados;
}

 
    public function cadastrar($nome, $descricao, $status) {
        $sql = "INSERT INTO produtos (nome, descricao,  status) 
                VALUES (?, ?, ?)";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $nome, $descricao, $status);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

   
    public function atualizar($id, $nome, $descricao, $status) {
        $sql = "UPDATE produtos 
                SET nome = ?, descricao = ?, status = ? 
                WHERE id = ?";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssi', $nome, $descricao, $status, $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

   
    public function excluir($id) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
