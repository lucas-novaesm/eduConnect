<?php 
if (!isset($_SESSION)) session_start();
include 'includes/conexao.php';

// Contador de aulas agendadas
$usuario_id = $_SESSION['usuario_id'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;
$total_aulas = 0;

if ($usuario_id && $tipo) {
  if ($tipo === 'aluno') {
    $sql = "SELECT COUNT(*) as total FROM agendamentos WHERE aluno_id = $usuario_id";
  } else {
    $sql = "SELECT COUNT(*) as total FROM agendamentos WHERE educador_id = $usuario_id";
  }
  
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $total_aulas = $row['total'];
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | EduConnect</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/critical-fixes.css?v=<?= time() ?>">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container">
  <div class="welcome-section">
    <!-- Estrutura totalmente modificada para resolver o problema de corte do nome -->
    <div style="width:100%; overflow:visible; margin-bottom:20px;">
      <div style="display:inline-block; width:auto;">
        <h1 style="font-size:1.5rem; margin-bottom:5px; display:inline-block;">Olá,</h1>
        <h1 style="font-size:1.5rem; margin-bottom:5px; display:block; word-break:break-all; overflow-wrap:break-word; color:#084F55;"><?= htmlspecialchars($_SESSION['usuario']) ?>!</h1>
      </div>
      <p style="margin-top:5px;">Bem-vindo à sua área pessoal no EduConnect</p>
    </div>
    <div class="welcome-card">
      <div class="welcome-icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="welcome-content">
        <h2>Painel de Controle</h2>
        <p>Acesse as principais funcionalidades do sistema abaixo:</p>
      </div>
    </div>
    
    <div class="dashboard-cards">
      <?php if ($_SESSION['tipo'] === 'aluno'): ?>
        <a href="index.php?tela=educadores" class="dashboard-card">
          <div class="card-icon">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <div class="card-content">
            <h3 class="card-title">Encontrar Educadores</h3>
            <p>Procure educadores disponíveis e agende suas aulas</p>
          </div>
          <div class="card-arrow">
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
        
        <a href="index.php?tela=calendario" class="dashboard-card">
          <div class="card-icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="card-content">
            <h3 class="card-title">Minhas Aulas</h3>
            <p>Visualize suas aulas agendadas</p>
            <span class="contador-aulas"><?= $total_aulas ?> aula<?= $total_aulas != 1 ? 's' : '' ?></span>
          </div>
          <div class="card-arrow">
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      <?php else: ?>
        <a href="index.php?tela=calendario" class="dashboard-card">
          <div class="card-icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="card-content">
            <h3 class="card-title">Agenda de Aulas</h3>
            <p>Visualize suas aulas marcadas com alunos</p>
            <span class="contador-aulas"><?= $total_aulas ?> aula<?= $total_aulas != 1 ? 's' : '' ?></span>
          </div>
          <div class="card-arrow">
            <i class="fas fa-arrow-right"></i>
          </div>
        </a>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Font Awesome para ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
