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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST['comentario'];
    $nome_usuario = $_POST['usuario']; // Nome do usuário logado

    // Inserir comentário no banco de dados
    $stmt = $conn->prepare("INSERT INTO comentarios (nome_usuario, comentario) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome_usuario, $comentario);

    if ($stmt->execute()) {
        echo "Comentário enviado com sucesso!";
    } else {
        echo "Erro ao enviar o comentário: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
