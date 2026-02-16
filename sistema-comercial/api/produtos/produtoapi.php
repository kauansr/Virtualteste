<?php
session_start();
require '../../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $status = trim($_POST['status']);

   
    $sql = "INSERT INTO produtos (nome, descricao, status) 
            VALUES (?, ?, ?)";


    if ($stmt = mysqli_prepare($conn, $sql)) {
       
        mysqli_stmt_bind_param($stmt, "sss", $nome, $descricao, $status);

      
        if (mysqli_stmt_execute($stmt)) {
            
            echo "Produto cadastrado com sucesso!";
        } else {
          
            echo "Erro ao cadastrar produto: " . mysqli_stmt_error($stmt);
        }

       
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($conn);
    }

  
    mysqli_close($conn);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['produto_id'], $data['nome'], $data['descricao'],  $data['status'])) {
        
        $produto_id = $data['produto_id']; 
        $nome = trim($data['nome']);
        $descricao = trim($data['descricao']);
        $status = trim($data['status']);
        
       
        $sql = "UPDATE produtos
                SET nome = ?, descricao = ?, status = ? 
                WHERE id = ?";
        
       
        if ($stmt = mysqli_prepare($conn, $sql)) {
           
            mysqli_stmt_bind_param($stmt, 'sssi', $nome, $descricao, $status, $produto_id);

           
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto atualizado com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar produto: ' . mysqli_error($conn)]);
            }

            
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados insuficientes para atualizar o produto.']);
    }

    mysqli_close($conn);
}



if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['delete_produto'])) {
        $produto_id = $data['delete_produto'];  

        
        $sql = "DELETE FROM produtos WHERE id = ?";
        
       
        if ($stmt = mysqli_prepare($conn, $sql)) {
            
            mysqli_stmt_bind_param($stmt, 'i', $produto_id);

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Produto removido com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao remover produto: ' . mysqli_error($conn)]);
            }

        
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID do produto não encontrado']);
    }

    mysqli_close($conn);
}



?>