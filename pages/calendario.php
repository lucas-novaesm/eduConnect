<?php
// Iniciando a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificando se o usuário está logado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['tipo'])) {
    header("Location: ../index.php?tela=login");
    exit;
}

// Incluindo o arquivo de conexão
require_once(__DIR__ . '/../includes/conexao.php');

// Configuração de localização para português
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$usuario_id = $_SESSION['usuario_id'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;

if (!$usuario_id || !$tipo) {
  header("Location: index.php?tela=login");
  exit;
}

// Processar cancelamento de aula se solicitado
if (isset($_POST['cancelar_aula']) && isset($_POST['agendamento_id'])) {
  $agendamento_id = intval($_POST['agendamento_id']);
  
  // Verificar se o usuário tem permissão para cancelar esta aula
  $check_sql = "SELECT * FROM agendamentos WHERE id = $agendamento_id AND "
             . ($tipo === 'aluno' ? "aluno_id = $usuario_id" : "educador_id = $usuario_id");
  $check_result = $conn->query($check_sql);
  
  if ($check_result && $check_result->num_rows > 0) {
    // Excluir o agendamento
    $delete_sql = "DELETE FROM agendamentos WHERE id = $agendamento_id";
    if ($conn->query($delete_sql)) {
      $mensagem = "Aula cancelada com sucesso!";
    } else {
      $erro = "Erro ao cancelar aula: " . $conn->error;
    }
  } else {
    $erro = "Você não tem permissão para cancelar esta aula.";
  }
}

if ($tipo === 'aluno') {
  $sql = "
    SELECT a.id, a.data, u.nome AS educador_nome, e.materia, e.bairro, e.cidade
    FROM agendamentos a
    JOIN usuarios u ON a.educador_id = u.id
    JOIN educadores e ON u.id = e.usuario_id
    WHERE a.aluno_id = $usuario_id
    ORDER BY a.data ASC
  ";
} elseif ($tipo === 'educador') {
  $sql = "
    SELECT a.id, a.data, u.nome AS aluno_nome, u.email
    FROM agendamentos a
    JOIN usuarios u ON a.aluno_id = u.id
    WHERE a.educador_id = $usuario_id
    ORDER BY a.data ASC
  ";
}

$result = $conn->query($sql);

$eventos = [];
$aulas = [];
$total_aulas = 0;

if ($result && $result->num_rows > 0) {
  $total_aulas = $result->num_rows;
  while ($row = $result->fetch_assoc()) {
    $titulo = ($tipo === 'aluno')
      ? $row['educador_nome'] . ' - ' . $row['materia']
      : $row['aluno_nome'];
    
    $eventos[] = [
      'id' => $row['id'],
      'title' => $titulo,
      'start' => $row['data']
    ];
    
    $aulas[] = [
      'id' => $row['id'],
      'titulo' => $titulo,
      'data' => $row['data']
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendário de Aulas</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="../css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="../css/critical-fixes.css?v=<?= time() ?>">
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
</head>
<body>

<?php require_once(__DIR__ . '/../includes/header.php'); ?>

<main class="container">
  <div class="page-header">
    <h2>
      <?= ($tipo === 'aluno') ? "Minhas Aulas Agendadas" : "Aulas Marcadas com Alunos" ?>
      <span class="contador-aulas"><?= $total_aulas ?> aula<?= $total_aulas != 1 ? 's' : '' ?></span>
    </h2>
    <p class="page-description">Visualize e gerencie suas aulas agendadas no calendário abaixo.</p>
  </div>
  
  <?php if (isset($mensagem)): ?>
    <div class="mensagem-sucesso"><?= $mensagem ?></div>
  <?php endif; ?>
  
  <?php if (isset($erro)): ?>
    <div class="mensagem-erro"><?= $erro ?></div>
  <?php endif; ?>

  <div class="calendar-wrapper">
    <div id='calendar'></div>

    <div class="cards-laterais">
      <?php if (count($aulas) > 0): ?>
        <?php foreach ($aulas as $aula): ?>
          <div class="aula-card">
            <div class="aula-header">
              <strong><?= htmlspecialchars($aula['titulo']) ?></strong>
              <span class="aula-badge"><?= date('d/m', strtotime($aula['data'])) ?></span>
            </div>
            <div class="aula-info">
              <div class="aula-info-item">
                <i class="fas fa-calendar-day"></i>
                <span><?= ucfirst(strftime('%A', strtotime($aula['data']))) ?>, <?= date('d', strtotime($aula['data'])) ?> de <?= ucfirst(strftime('%B', strtotime($aula['data']))) ?></span>
              </div>
              <div class="aula-info-item">
                <i class="fas fa-clock"></i>
                <span><?= date('H:i', strtotime($aula['data'])) ?> horas</span>
              </div>
            </div>
            <form method="post" onsubmit="return confirm('Tem certeza que deseja cancelar esta aula?');">
              <input type="hidden" name="agendamento_id" value="<?= $aula['id'] ?>">
              <button type="submit" name="cancelar_aula" class="btn-cancelar"><i class="fas fa-times-circle"></i> Cancelar Aula</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-aulas">
          <i class="fas fa-calendar-times"></i>
          <p>Você não possui aulas agendadas.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'pt-br',
      events: <?= json_encode($eventos) ?>,
      eventClick: function(info) {
        if (confirm('Deseja cancelar a aula com ' + info.event.title + '?')) {
          var form = document.createElement('form');
          form.method = 'post';
          form.style.display = 'none';
          
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'agendamento_id';
          input.value = info.event.id;
          
          var button = document.createElement('input');
          button.type = 'hidden';
          button.name = 'cancelar_aula';
          button.value = '1';
          
          form.appendChild(input);
          form.appendChild(button);
          document.body.appendChild(form);
          form.submit();
        }
      }
    });
    calendar.render();
  });
</script>
<?php include dirname(__DIR__) . "/includes/footer.php"; ?>
</body>
</html>
