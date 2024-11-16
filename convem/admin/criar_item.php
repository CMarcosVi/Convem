<?php
require_once '../actions/connection.php';

try {
    $stmt = $pdo->query("SELECT id, nome_item FROM categorias");
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Itens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
  <div class="container mt-5">
    <h2 class="mb-4">Criar Novo Item</h2>
    <form action="actions/criar_item.php" method="POST">
      <!-- Nome do item -->
      <div class="mb-3">
        <label for="nomeItem" class="form-label">Nome do Item</label>
        <input type="text" id="nomeItem" name="nome" class="form-control" placeholder="Digite o nome do item" required>
      </div>
    
      <!-- Preço do item -->
      <div class="mb-3">
        <label for="precoItem" class="form-label">Preço do Item</label>
        <input type="number" id="precoItem" name="preco" class="form-control" placeholder="Digite o preço do item" step="0.01" required>
      </div>
    
      <!-- Categoria -->
      <div class="mb-3">
        <label for="categoriaItem" class="form-label">Categoria</label>
        <select id="categoriaItem" name="id_categoria" class="form-select" required>
          <option value="" disabled selected>Selecione uma categoria</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria->id) ?>">
              <?= htmlspecialchars($categoria->nome_item) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    
      <!-- Botão de envio -->
      <button type="submit" class="btn btn-primary">Salvar Item</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
