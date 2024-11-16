<?php
require_once '../actions/connection.php';

try {
    // Consulta para buscar as categorias
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
  <title>Gerenciar Categorias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

  <div class="container mt-5">
    <h2 class="mb-4">Categorias Cadastradas</h2>

    <!-- Tabela de Categorias -->
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($categorias)): ?>
          <?php foreach ($categorias as $categoria): ?>
            <tr>
              <td><?= htmlspecialchars($categoria->id) ?></td>
              <td><?= htmlspecialchars($categoria->nome_item) ?></td>
              <td>
                <!-- Dropdown de Ações -->
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ações
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="editar_categoria.php?id=<?= htmlspecialchars($categoria->id) ?>">Editar</a></li>
                    <li><a class="dropdown-item text-danger" href="desativar_categoria.php?id=<?= htmlspecialchars($categoria->id) ?>">Desativar</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="text-center">Nenhuma categoria cadastrada.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
