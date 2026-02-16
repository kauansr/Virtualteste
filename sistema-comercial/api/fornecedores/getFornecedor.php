<?php
require("../../database.php");

if (isset($_GET['id'])) {
    $fornecedor_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM fornecedores WHERE id = '$fornecedor_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $fornecedor = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $fornecedor]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Fornecedor não encontrado']);
    }

    mysqli_close($conn);
}
?>
