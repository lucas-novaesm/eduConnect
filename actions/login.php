<?php
session_start();
include '../includes/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
  $usuario = $res->fetch_assoc();

  if (password_verify($senha, $usuario['senha'])) {
    // 💡 Salvar nome, id e tipo na sessão
    $_SESSION['usuario'] = $usuario['nome'];
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['tipo'] = $usuario['tipo'];

    header("Location: ../index.php?tela=home");
    exit;
  } else {
    echo "Senha incorreta.";
  }
} else {
  echo "Usuário não encontrado.";
}
?>
