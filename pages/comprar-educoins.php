<?php
if (!isset($_SESSION)) session_start();
require_once dirname(__DIR__) . "/includes/conexao.php";
require_once dirname(__DIR__) . "/includes/config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Comprar eduCoins | EduConnect</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $base_url ?>/css/comprar.css?v=<?= time() ?>">
  <link rel="stylesheet" href="<?= $base_url ?>/css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

  <?php include dirname(__DIR__) . "/includes/header.php"; ?>

  <main class="comprar-container">
    <h1><i class="fas fa-coins" style="color: #FFD700;"></i> Comprar eduCoins</h1>
    <p>Escolha um pacote de moedas para adicionar ao seu saldo:</p>

    <div class="pacotes">
      <?php
      $pacotes = [
        ['moedas' => 100, 'valor' => 10.00],
        ['moedas' => 250, 'valor' => 20.00],
        ['moedas' => 500, 'valor' => 35.00],
        ['moedas' => 1000, 'valor' => 60.00],
        ['moedas' => 2000, 'valor' => 100.00],
        ['moedas' => 5000, 'valor' => 200.00],
      ];

      foreach ($pacotes as $pacote): ?>
        <form method="POST" action="<?= $base_url ?>/actions/processar-compra.php" class="pacote-card">
          <input type="hidden" name="moedas" value="<?= $pacote['moedas'] ?>">
          <input type="hidden" name="valor" value="<?= $pacote['valor'] ?>">
          <h2><?= $pacote['moedas'] ?> <i class="fas fa-coins" style="color: #FFD700;"></i> </h2>
          <p>R$ <?= number_format($pacote['valor'], 2, ',', '.') ?></p>
          <button type="submit">Comprar</button>
        </form>
      <?php endforeach; ?>
    </div>
  </main>

  <?php include dirname(__DIR__) . "/includes/footer.php"; ?>
</body>
</html>
