<?php
if (!isset($_SESSION)) session_start();
require_once __DIR__ . "/../includes/conexao.php";

$usuario_id = $_SESSION['usuario_id'] ?? null;
$moedas = (int)($_POST['moedas'] ?? 0);

if ($usuario_id && $moedas > 0) {
  $sql = "UPDATE usuarios SET educoins = educoins + $moedas WHERE id = $usuario_id";
  $conn->query($sql);

  $_SESSION['educoins'] = ($_SESSION['educoins'] ?? 0) + $moedas;

  header("Location: ../pages/comprar-educoins.php?sucesso=1");
  exit;
}

header("Location: ../pages/comprar-educoins.php?erro=1");
exit;
