<?php

class Fornecedor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
    $sql = "SELECT * FROM fornecedores";
    $result = mysqli_query($this->conn, $sql);

    $dados = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dados[] = $row;
        }
    }
    return $dados;
}

 
    public function cadastrar($nome, $cnpj, $email, $telefone, $status) {
        $sql = "INSERT INTO fornecedores (nome, cnpj, email, telefone, status) 
                VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $nome, $cnpj, $email, $telefone, $status);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

   
    public function atualizar($id, $nome, $cnpj, $email, $telefone, $status) {
        $sql = "UPDATE fornecedores 
                SET nome = ?, cnpj = ?, email = ?, telefone = ?, status = ? 
                WHERE id = ?";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $cnpj, $email, $telefone, $status, $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

   
    public function excluir($id) {
        $sql = "DELETE FROM fornecedores WHERE id = ?";
        
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
