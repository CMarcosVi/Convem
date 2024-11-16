<?php
require_once '../actions/connection.php';

try {
    // Consulta para buscar os produtos e suas categorias
    $stmt = $pdo->query("
        SELECT 
            p.id AS produto_id, 
            p.nome AS produto_nome, 
            p.preco AS produto_preco, 
            c.nome_item AS categoria_nome 
        FROM produtos p
        LEFT JOIN categorias c ON p.id_categoria = c.id
    ");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Produtos Cadastrados</h2>
      <a href="criar_item.php" class="btn btn-success">
        <i class="fa fa-plus"></i> Criar Produto
      </a>
    </div>

    <!-- Tabela de Produtos -->
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Preço (R$)</th>
          <th>Categoria</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($produtos)): ?>
          <?php foreach ($produtos as $produto): ?>
            <tr>
              <td><?= htmlspecialchars($produto->produto_id) ?></td>
              <td><?= htmlspecialchars($produto->produto_nome) ?></td>
              <td><?= number_format($produto->produto_preco, 2, ',', '.') ?></td>
              <td><?= htmlspecialchars($produto->categoria_nome) ?: 'Sem categoria' ?></td>
              <td>
                <!-- Dropdown de Ações -->
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ações
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="editar_produto.php?id=<?= htmlspecialchars($produto->produto_id) ?>">Editar</a></li>
                    <li><a class="dropdown-item text-danger" href="excluir_produto.php?id=<?= htmlspecialchars($produto->produto_id) ?>">Excluir</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center">Nenhum produto cadastrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
