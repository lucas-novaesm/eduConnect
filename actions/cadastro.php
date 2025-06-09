<?php
include '../includes/conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$tipo = $_POST['tipo'];

// Cadastrar no banco principal
$sql = "INSERT INTO usuarios (nome, email, senha, tipo)
        VALUES ('$nome', '$email', '$senha', '$tipo')";

if ($conn->query($sql)) {
  $usuario_id = $conn->insert_id;

  // Cadastro específico por tipo
  if ($tipo === 'educador') {
    $materia = $_POST['materia'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$valor_hora = 100;

$sql_educador = "INSERT INTO educadores (usuario_id, materia, bairro, cidade, avaliacao, valor_hora)
                 VALUES ($usuario_id, '$materia', '$bairro', '$cidade', 0, $valor_hora)";
    $conn->query($sql_educador);
  } elseif ($tipo === 'aluno') {
    $sql_aluno = "INSERT INTO alunos (usuario_id) VALUES ($usuario_id)";
    $conn->query($sql_aluno);
  }

  header("Location: ../index.php?tela=cadastro&sucesso=1");
} else {
  echo "Erro ao cadastrar: " . $conn->error;
}
?>
