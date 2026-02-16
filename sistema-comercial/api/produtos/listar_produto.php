<?php

require("../../database.php");

$sql = 'SELECT * FROM produtos';
$produtos = mysqli_query($conn, $sql);

$dados = array();

if (mysqli_num_rows($produtos) > 0) {
    while ($row = mysqli_fetch_assoc($produtos)) {
        $dados[] = $row;
    }
    echo json_encode($dados); 
} else {
    echo json_encode([]); 
}


mysqli_close($conn);
?>
