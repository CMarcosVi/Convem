<?php
require_once '../../actions/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? null;
    $preco = $_POST['preco'] ?? null;
    $id_categoria = $_POST['id_categoria'] ?? null;

    if (empty($nome) || empty($preco) || empty($id_categoria)) {
        die("Erro: Todos os campos são obrigatórios!");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, id_categoria) VALUES (:nome, :preco, :id_categoria)");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);

        $stmt->execute();

        echo "Item criado com sucesso!";
    } catch (PDOException $e) {
        die("Erro ao criar item: " . $e->getMessage());
    }
} else {
    die("Erro: Método inválido.");
}
