<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
  <div class="container mt-5">
    <h2 class="mb-4">Dashboard de Gerenciamento</h2>
    <div class="list-group">
      <a href="categorias.php" class="list-group-item list-group-item-action">
        <i class="fas fa-tags"></i> Gerenciar Categorias
      </a>
      <a href="produtos.php" class="list-group-item list-group-item-action">
        <i class="fas fa-boxes"></i> Gerenciar Produtos
      </a>
      <a href="outros.php" class="list-group-item list-group-item-action">
        <i class="fas fa-cogs"></i> Outras Funcionalidades
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
