<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', 'senha');
define('DB', 'sistema_comercial');


$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die ('Não foi possivel conectar')

?>