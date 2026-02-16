<?php

require("../../database.php");

$sql = 'SELECT * FROM fornecedores';
$fornecedores = mysqli_query($conn, $sql);

$dados = array();

if (mysqli_num_rows($fornecedores) > 0) {
    while ($row = mysqli_fetch_assoc($fornecedores)) {
        $dados[] = $row;
    }
    echo json_encode($dados); 
} else {
    echo json_encode([]); 
}

// Fechar a conexão
mysqli_close($conn);
?>
