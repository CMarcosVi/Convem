<?php
require_once '../../actions/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação e sanitização dos dados
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
    $id_categoria = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
    $estoque = filter_var($_POST['estoque'], FILTER_VALIDATE_INT);

    // Verificação dos dados recebidos
    if ($preco === false || $estoque === false || empty($nome) || $id_categoria === false) {
        die("Erro: Preço, estoque ou categoria inválido.");
    }

    try {
        // Inserção no banco de dados
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, id_categoria, estoque) VALUES (:nome, :preco, :id_categoria, :estoque)");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);

        $stmt->execute();

        // Redirecionar para a página com mensagem de sucesso
        header("Location: ../criar_item.php?status=success");
        exit;
    } catch (PDOException $e) {
        // Registrar erro em log e exibir mensagem genérica
        error_log($e->getMessage(), 3, '/path/to/your/log/file.log');
        die("Erro ao criar item. Tente novamente mais tarde.");
    }
} else {
    die("Erro: Método inválido.");
}

