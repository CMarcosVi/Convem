<?php
require_once 'actions/connection.php';

$categoria_id = isset($_GET['categoria_id']) ? (int) $_GET['categoria_id'] : 1;

try {
    $stmt = $pdo->prepare("SELECT id, nome, preco FROM produtos WHERE id_categoria = :categoria_id");
    $stmt->execute(['categoria_id' => $categoria_id]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>One Minute Conveniência</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <h4>One Minute</h4>
        <a href="?categoria_id=1"><i class="fas fa-coffee"></i> Cafés</a>
        <a href="?categoria_id=2"><i class="fas fa-glass-martini-alt"></i> Refrigerantes</a>
        <a href="?categoria_id=3"><i class="fas fa-bolt"></i> Energéticos</a>
        <a href="?categoria_id=4"><i class="fas fa-pizza-slice"></i> Salgados</a>
        <a href="?categoria_id=5"><i class="fas fa-candy-cane"></i> Doces</a>
        <a href="?categoria_id=6"><i class="fas fa-box"></i> Mercadoria</a>
        <a href="?categoria_id=7"><i class="fas fa-smoking"></i> Tabacaria</a>
      </div>

      <!-- Main content -->
      <div class="col-md-10">
        <h2 class="mt-3">
          Produtos da Categoria:
          <?php
          $categorias = [
              1 => 'Cafés',
              2 => 'Refrigerantes',
              3 => 'Energéticos',
              4 => 'Salgados',
              5 => 'Doces',
              6 => 'Mercadoria',
              7 => 'Tabacaria'
          ];
          echo $categorias[$categoria_id] ?? 'Desconhecida';
          ?>
        </h2>
        <div class="row">
          <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
              <div class="col-md-4 mb-4">
                <div class="product-card">
                  <h5><?= htmlspecialchars($produto['nome']) ?></h5>
                  <div class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
                  <div class="quantity-controls mt-3">
                    <button onclick="changeQuantity(<?= $produto['id'] ?>, '<?= $produto['nome'] ?>', <?= $produto['preco'] ?>, -1)">-</button>
                    <span>1</span>
                    <button onclick="changeQuantity(<?= $produto['id'] ?>, '<?= $produto['nome'] ?>', <?= $produto['preco'] ?>, 1)">+</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-center">Nenhum produto encontrado para esta categoria.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Cart -->
    <div class="cart">
      <div class="cart-header">Carrinho</div>
      <div class="cart-items"></div>
      <div class="cart-total">Total: R$ 0,00</div>
      <button class="btn btn-success w-100 mt-3" onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
  </div>

  <script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function changeQuantity(id, name, price, change) {
      const index = cart.findIndex(item => item.id === id);
      if (index > -1) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) cart.splice(index, 1);
      } else if (change > 0) {
        cart.push({ id, name, price, quantity: 1 });
      }
      saveCart();
    }

    function saveCart() {
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCart();
    }

    function renderCart() {
      const cartItems = document.querySelector('.cart-items');
      const cartTotal = document.querySelector('.cart-total');
      cartItems.innerHTML = '';
      let total = 0;

      cart.forEach(item => {
        total += item.price * item.quantity;
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
          <span>${item.name} (x${item.quantity})</span>
          <span>R$ ${(item.price * item.quantity).toFixed(2).replace('.', ',')}</span>
          <i class="fas fa-trash-alt remove-item" onclick="removeItem(${item.id})"></i>
        `;
        cartItems.appendChild(div);
      });

      cartTotal.textContent = `Total: R$ ${total.toFixed(2).replace('.', ',')}`;
    }

    function removeItem(id) {
      cart = cart.filter(item => item.id !== id);
      saveCart();
    }

    function finalizarCompra() {
      alert('Compra finalizada!');
      cart = [];
      saveCart();
    }

    renderCart();
  </script>
</body>
</html>

