<?php
session_start();
include '../includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$educador_id = $_POST['educador_id'] ?? null;
$data = $_POST['horario'] ?? null;

if (!$usuario_id || !$educador_id || !$data) {
  echo "Dados incompletos para agendamento.";
  exit;
}

// Verifica se o aluno já tem uma aula nesse horário
$verificar = "
SELECT * FROM agendamentos
WHERE aluno_id = $usuario_id
AND data = '$data'
";
$res = $conn->query($verificar);
if ($res->num_rows > 0) {
  echo "<script>alert('Você já tem uma aula marcada nesse horário!'); window.location='../index.php?tela=calendario';</script>";
  exit;
}

// Buscar valor_hora do educador
$sql_valor = "SELECT valor_hora FROM educadores WHERE usuario_id = $educador_id";
$res_valor = $conn->query($sql_valor);
if (!$res_valor || $res_valor->num_rows == 0) {
  echo "<script>alert('Educador inválido.'); window.location='../index.php?tela=educadores';</script>";
  exit;
}
$valor = (int) $res_valor->fetch_assoc()['valor_hora'];

// Buscar saldo atual do aluno
$sql_saldo = "SELECT educoins FROM usuarios WHERE id = $usuario_id";
$res_saldo = $conn->query($sql_saldo);
$saldo = (int) $res_saldo->fetch_assoc()['educoins'];

if ($saldo < $valor) {
  echo "<script>alert('Você não tem moedas suficientes para agendar esta aula.'); window.location='../index.php?tela=educadores';</script>";
  exit;
}

// Executar transação: descontar + agendar
$conn->begin_transaction();

try {
  $sql_update = "UPDATE usuarios SET educoins = educoins - $valor WHERE id = $usuario_id";
  $conn->query($sql_update);

  $sql_insert = "
    INSERT INTO agendamentos (aluno_id, educador_id, data)
    VALUES ($usuario_id, $educador_id, '$data')
  ";
  $conn->query($sql_insert);

  $conn->commit();

  $_SESSION['educoins'] -= $valor; // atualiza sessão
  echo "<script>alert('Aula agendada com sucesso!'); window.location='../index.php?tela=calendario';</script>";
} catch (Exception $e) {
  $conn->rollback();
  echo "<script>alert('Erro ao agendar aula. Tente novamente.'); window.location='../index.php?tela=educadores';</script>";
}
?>
