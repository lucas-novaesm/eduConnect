<?php
if (!isset($_SESSION)) session_start();
include 'includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
if (!$usuario_id) {
  header("Location: index.php?tela=login");
  exit;
}

$educador_id = $_GET['id'] ?? null;
if (!$educador_id) {
  echo "<p>Educador não encontrado.</p>";
  exit;
}

// Buscar dados do educador
$sql = "SELECT u.nome, e.* 
        FROM educadores e
        JOIN usuarios u ON u.id = e.usuario_id
        WHERE e.usuario_id = $educador_id";
$result = $conn->query($sql);
$educador = $result->fetch_assoc();

if (!$educador) {
  echo "<p>Educador não encontrado.</p>";
  exit;
}

// Horários fixos (mock)
$horarios_disponiveis = [
  '2025-06-05 10:00',
  '2025-06-05 14:00',
  '2025-06-06 09:00',
  '2025-06-06 15:00',
  '2025-06-07 11:00'
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agendar Aula</title>
  <link rel="stylesheet" href="css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/background.css">
  <link rel="stylesheet" href="css/chat-fix.css">
  <link rel="stylesheet" href="css/critical-fixes.css">
  <style>
    .agendar-container {
      max-width: 500px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid var(--border-color, #ccc);
      border-radius: 10px;
      background-color: var(--bg-secondary, #f9f9f9);
      color: var(--text-primary, #333);
    }
    
    /* Estilos diretos para o select de horários */
    #horario {
      background-color: #333333 !important;
      border: 2px solid #5c5c5c !important;
      color: white !important;
      padding: 12px 15px !important;
      font-size: 16px !important;
      border-radius: 8px !important;
      width: 100% !important;
      margin-top: 10px !important;
      margin-bottom: 20px !important;
      appearance: none !important;
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
    }
    
    .modern-select {
      width: 100%;
      padding: 12px 15px;
      font-size: 16px;
      border: 2px solid var(--input-border, #ccc);
      border-radius: 8px;
      background-color: var(--input-bg, white);
      color: var(--input-text, black);
      appearance: none;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 20px;
    }
    .agendar-container img {
      width: 100%;
      max-height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .agendar-container h3 {
      margin-bottom: 10px;
    }
    .horario {
      margin: 8px 0;
    }
    .btn-agendar {
      background-color: #28a745;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-agendar:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="agendar-container">
  <?php
    $foto = $educador['foto'] ?? '';
    $foto_path = (!empty($foto)) ? $foto : 'images/educadorPadrao.png';
  ?>
    <img src="<?= $foto_path ?>" alt="Foto de <?= htmlspecialchars($educador['nome']) ?>">

  <h3><?= htmlspecialchars($educador['nome']) ?></h3>
  <p><strong>Matéria:</strong> <?= htmlspecialchars($educador['materia']) ?></p>
  <p><strong>Local:</strong> <?= htmlspecialchars($educador['bairro']) ?>, <?= htmlspecialchars($educador['cidade']) ?></p>

  <form action="actions/agendar.php" method="POST">

  
    <input type="hidden" name="educador_id" value="<?= $educador_id ?>">
    
    <!-- Estilos adicionados pelo JavaScript para garantir contraste adequado -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const horarioSelect = document.getElementById('horario');
      horarioSelect.style.backgroundColor = '#333333';
      horarioSelect.style.color = 'white';
      horarioSelect.style.border = '2px solid #5c5c5c';
      horarioSelect.style.padding = '12px 15px';
      horarioSelect.style.borderRadius = '8px';
      horarioSelect.style.width = '100%';
      
      // Adiciona ícone de seta personalizada
      const wrapper = document.createElement('div');
      wrapper.style.position = 'relative';
      wrapper.style.width = '100%';
      
      // Insere o wrapper antes do select
      horarioSelect.parentNode.insertBefore(wrapper, horarioSelect);
      // Move o select para dentro do wrapper
      wrapper.appendChild(horarioSelect);
      
      // Cria o indicador de seta
      const arrow = document.createElement('div');
      arrow.innerHTML = '▼';
      arrow.style.position = 'absolute';
      arrow.style.right = '15px';
      arrow.style.top = '50%';
      arrow.style.transform = 'translateY(-50%)';
      arrow.style.pointerEvents = 'none';
      arrow.style.color = '#00E6F0';
      
      wrapper.appendChild(arrow);
    });
    </script>


    <label for="horario" style="display: block; margin-bottom: 8px; margin-top: 15px; font-weight: bold; color: var(--text-primary, #333);">Escolha um horário:</label>
    <select name="horario" id="horario" required class="modern-select" style="background-color: #333333 !important; border: 2px solid #5c5c5c !important; color: white !important; padding: 12px 15px !important;">
      <?php foreach ($horarios_disponiveis as $horario): ?>
        <option value="<?= $horario ?>"><?= date('d/m/Y H:i', strtotime($horario)) ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>
    <button type="submit" class="btn-agendar">Confirmar Agendamento</button>
  </form>
</div>

</body>
</html>
