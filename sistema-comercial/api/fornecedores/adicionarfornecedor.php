<?php
session_start();
require '../../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $cnpj = trim($_POST['cnpj']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $status = trim($_POST['status']);

   
    $sql = "INSERT INTO fornecedores (nome, cnpj, email, telefone, status) 
            VALUES (?, ?, ?, ?, ?)";


    if ($stmt = mysqli_prepare($conn, $sql)) {
       
        mysqli_stmt_bind_param($stmt, "sssss", $nome, $cnpj, $email, $telefone, $status);

      
        if (mysqli_stmt_execute($stmt)) {
            
            echo "Fornecedor cadastrado com sucesso!";
        } else {
          
            echo "Erro ao cadastrar fornecedor: " . mysqli_stmt_error($stmt);
        }

       
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($conn);
    }

  
    mysqli_close($conn);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['fornecedor_id'], $data['nome'], $data['cnpj'], $data['email'], $data['telefone'], $data['status'])) {
        
        $fornecedor_id = $data['fornecedor_id']; 
        $nome = trim($data['nome']);
        $cnpj = trim($data['cnpj']);
        $email = trim($data['email']);
        $telefone = trim($data['telefone']);
        $status = trim($data['status']);
        
       
        $sql = "UPDATE fornecedores 
                SET nome = ?, cnpj = ?, email = ?, telefone = ?, status = ? 
                WHERE id = ?";
        
       
        if ($stmt = mysqli_prepare($conn, $sql)) {
           
            mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $cnpj, $email, $telefone, $status, $fornecedor_id);

           
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Fornecedor atualizado com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar fornecedor: ' . mysqli_error($conn)]);
            }

            
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados insuficientes para atualizar o fornecedor.']);
    }

    mysqli_close($conn);
}



if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['delete_fornecedor'])) {
        $fornecedor_id = $data['delete_fornecedor'];  

        
        $sql = "DELETE FROM fornecedores WHERE id = ?";
        
       
        if ($stmt = mysqli_prepare($conn, $sql)) {
            
            mysqli_stmt_bind_param($stmt, 'i', $fornecedor_id);

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Fornecedor removido com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao remover fornecedor: ' . mysqli_error($conn)]);
            }

        
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID do fornecedor não encontrado']);
    }

    mysqli_close($conn);
}



?>