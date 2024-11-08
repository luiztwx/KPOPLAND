<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kpopland";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome_usuario, comentario, data_envio FROM comentarios ORDER BY data_envio DESC LIMIT 10";
$result = $conn->query($sql);

$comentarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comentarios[] = $row;
    }
}

echo json_encode($comentarios);

$conn->close();
?>
