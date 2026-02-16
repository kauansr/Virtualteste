<?php
require("../../database.php");

if (isset($_GET['id'])) {
    $produto_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM produtos WHERE id = '$produto_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $produto = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $produto]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Produto não encontrado']);
    }

    mysqli_close($conn);
}
?>
