
<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kpopland";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Se o formulário for enviado, processar o comentário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comentario'])) {
    // Obter o comentário e o nome do usuário (se fornecido)
    $comentario = $_POST['comentario'];
    $nome_usuario = isset($_POST['nome_usuario']) ? $_POST['nome_usuario'] : 'Anônimo'; // Nome padrão se não fornecido

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO comentarios (nome_usuario, comentario) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome_usuario, $comentario);

    if ($stmt->execute()) {
        echo "<script>alert('Comentário enviado com sucesso!');</script>";
    } else {
        echo "Erro ao enviar o comentário: " . $stmt->error;
    }

    // Fechar a preparação da query
    $stmt->close();
}

// Consultar os comentários mais recentes
$sql = "SELECT nome_usuario, comentario, data_envio FROM comentarios ORDER BY data_envio DESC LIMIT 10";
$result = $conn->query($sql);

$comentarios = [];
if ($result->num_rows > 0) {
    // Buscar os comentários
    while ($row = $result->fetch_assoc()) {
        $comentarios[] = $row;
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/kpopland.png">
    <title>KpopLand</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .comentarios {
            margin-top: 30px;
        }
        .comentario {
            background-color: #f1f1f1;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .comentario p {
            margin: 0;
            font-size: 14px;
        }
        .comentario .usuario {
            font-weight: bold;
            color: #007bff;
        }
        .comentario .data {
            font-size: 12px;
            color: #888;
        }
        textarea {
            width: 90%;
            height: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            resize: none;
            margin-bottom: 10px;
        }
        input{
            width: 50%;
            height: 40px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            resize: none;
            margin-bottom: 10px;
        }
        .form-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-button:hover {
            background-color: #0056b3;
        }
        
        .rodape {
            background-color: #611DF2;
            color: white;
            height: auto;
            width: 100%;
            font-size: 14px;
        }

        .rodape a {
            text-decoration: none;
            color: white;
        }

        .rodape p {
            margin-bottom: 5px;
        }

        .rodape-div {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin: auto;
            align-items: stretch;
            padding: 60px 10px 40px 10px;
        }

        .rodape-div-1, .rodape-div-2, .rodape-div-3, .rodape-div-4 {
            display: flex;
            width: calc(100% / 4 - 20px);
            padding: 10px;
        }

        .rodape span {
            font-size: 20px;
            color: white;
        }

        .rodape-direitos {
            width: calc(100% - 20px);
            background-color: black;
            padding: 10px;
            margin: 0px;
            text-align: center;
        }

        /*mobile*/
        @media (max-width: 768px) {
            .rodape-div-1, .rodape-div-2, .rodape-div-3, .rodape-div-4 {
                width: calc(50% - 20px);
                padding: 10px;
            }

            .rodape-div {
                padding: 60px 0px 40px 0px;
            }
        }
                    #navbar {
        background-color: #6E1AE8;
        height: 4%;
        width: 100%;
        margin: auto;
        }
        body {
    background: rgb(97, 29, 242);
    background: linear-gradient(90deg, rgba(97, 29, 242, 1) 0%, rgba(110, 26, 232, 1) 35%, rgba(131, 82, 235, 1) 100%);
}
    </style>
</head>
<body>
<div id="navbar">
<a href="..\index.html"><img src="../img/kpopland.png" width="120"></a>
      </div>

    <div class="container">
        <h2>Comunidade K-pop</h2>

        <!-- Formulário para enviar comentário -->
        <form method="POST" action="comunidade.php">
            <textarea name="comentario" placeholder="Compartilhe sua opinião sobre o K-pop..." required></textarea><br>
            <input type="text" name="nome_usuario" placeholder="Seu nome (opcional)" /><br>
            <button type="submit" class="form-button">Enviar Opinião</button>
        </form>

        <!-- Lista de comentários -->
        <div class="comentarios">
            <h3>Comentários Recentes:</h3>
            <?php if (count($comentarios) > 0): ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comentario">
                        <p class="usuario"><?php echo htmlspecialchars($comentario['nome_usuario']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
                        <p class="data"><?php echo $comentario['data_envio']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há comentários ainda.</p>
            <?php endif; ?>
        </div>
    </div>
 <br> <br>
    <footer class="rodape" id="contato">
    <div class="rodape-div">

        <div class="rodape-div-1">
            <div class="rodape-div-1-coluna">
                <!-- elemento -->
                <img alt="" src="../img/kpopland.png" width="130">
                <p>Feito: Luiz Fernando</p>
            </div>
        </div>
  
        <div class="rodape-div-2">
            <div class="rodape-div-2-coluna">
                <!-- elemento -->
                <span><b>Contatos</b></span>
                <p>luiztld@gmail.com</p>
                <p>+55 12 996394245</p>
            </div>
        </div>
  
        <div class="rodape-div-3">
            <div class="rodape-div-3-coluna">
                <!-- elemento -->
                <span><b>Links</b></span>
                <p><a href="../rodapetelas/redes.html">Redes</a></p>
                <p><a href="../rodapetelas/duvidas.html">Dúvidas</a></p>
                <p><a href="..\sobre.html">Sobre</a></p>
                <p><a href="comunidade.php">Comunidade</a></p>
            </div>
        </div>

        <div class="rodape-div-4">
            <div class="rodape-div-4-coluna">
                <!-- elemento -->
                <span><b>Outros</b></span>
                <p>Políticas de Privacidade</p>
            </div>
        </div>

    </div>
</footer>


<!--******************************************-->


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="js/bootstrap.min.js"></script>

</body>

</html>


