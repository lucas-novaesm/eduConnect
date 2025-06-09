<?php
if (!isset($_SESSION)) session_start();
include 'includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;

if (!$usuario_id) {
  header("Location: index.php?tela=login");
  exit;
}

$sql = "SELECT * FROM usuarios WHERE id = $usuario_id";
$usuario = $conn->query($sql)->fetch_assoc();

$educador = null;
if ($tipo === 'educador') {
  $sql_educador = "SELECT * FROM educadores WHERE usuario_id = $usuario_id";
  $educador = $conn->query($sql_educador)->fetch_assoc();
}

// Verificar se há mensagem de sucesso na sessão
$mensagem_sucesso = '';
if (isset($_SESSION['mensagem_sucesso'])) {
  $mensagem_sucesso = $_SESSION['mensagem_sucesso'];
  unset($_SESSION['mensagem_sucesso']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Meu Perfil - EduConnect</title>
  <link rel="stylesheet" href="css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/critical-fixes.css?v=<?= time() ?>">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    .perfil-container {
      max-width: 800px;
      margin: 30px auto;
      padding: 30px;
      background: var(--card-color);
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .perfil-header {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px solid var(--border-color);
    }
    
    .perfil-header h2 {
      margin: 0;
      color: var(--text-color);
      font-size: 24px;
    }
    
    .perfil-header i {
      font-size: 28px;
      margin-right: 15px;
      color: var(--primary-color);
    }
    
    .perfil-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--text-color);
    }
    
    .form-group input, .form-group select {
      display: block;
      width: 100%;
      padding: 12px;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      background-color: var(--input-bg);
      color: var(--text-color);
      transition: all 0.3s ease;
    }
    
    .form-group input:focus, .form-group select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
      outline: none;
    }
    
    .readonly {
      background-color: var(--disabled-bg) !important;
      cursor: not-allowed;
      opacity: 0.8;
    }
    
    .foto-perfil {
      grid-column: 1 / -1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .foto-preview {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 3px solid var(--primary-color);
    }
    
    .foto-upload {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .foto-upload label {
      cursor: pointer;
      padding: 8px 15px;
      background-color: var(--primary-color);
      color: white;
      border-radius: 5px;
      margin-top: 10px;
      transition: all 0.3s ease;
    }
    
    .foto-upload label:hover {
      background-color: var(--primary-color-dark);
    }
    
    .foto-upload input[type="file"] {
      display: none;
    }
    
    .btn-atualizar {
      grid-column: 1 / -1;
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
    }
    
    .btn-atualizar:hover {
      background-color: var(--primary-color-dark);
      transform: translateY(-2px);
    }
    
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: 500;
    }
    
    .alert-success {
      background-color: rgba(76, 175, 80, 0.2);
      color: #2e7d32;
      border: 1px solid #2e7d32;
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
      .perfil-form {
        grid-template-columns: 1fr;
      }
      
      .perfil-container {
        margin: 20px 15px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="perfil-container">
  <?php if ($mensagem_sucesso): ?>
    <div class="alert alert-success">
      <i class='bx bx-check-circle'></i> <?= $mensagem_sucesso ?>
    </div>
  <?php endif; ?>
  
  <div class="perfil-header">
    <i class='bx bx-user-circle'></i>
    <h2>Meu Perfil</h2>
  </div>
  
  <form action="actions/atualizarPerfil.php" method="POST" enctype="multipart/form-data" class="perfil-form">
    <?php if ($tipo === 'educador' && !empty($educador['foto'])): ?>
    <div class="foto-perfil">
      <img src="<?= htmlspecialchars($educador['foto']) ?>" alt="Foto de perfil" class="foto-preview" id="foto-preview">
      <div class="foto-upload">
        <label for="foto-input"><i class='bx bx-camera'></i> Alterar foto</label>
        <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewFoto(this)">
      </div>
    </div>
    <?php elseif ($tipo === 'educador'): ?>
    <div class="foto-perfil">
      <img src="images/educadorPadrao.png" alt="Foto de perfil" class="foto-preview" id="foto-preview">
      <div class="foto-upload">
        <label for="foto-input"><i class='bx bx-camera'></i> Adicionar foto</label>
        <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewFoto(this)">
      </div>
    </div>
    <?php endif; ?>
    
    <div class="form-group">
      <label for="tipo-conta"><i class='bx bx-id-card'></i> Tipo de Conta:</label>
      <input type="text" id="tipo-conta" value="<?= ucfirst(htmlspecialchars($usuario['tipo'])) ?>" class="readonly" disabled>
    </div>

    <div class="form-group">
      <label for="email"><i class='bx bx-envelope'></i> E-mail:</label>
      <input type="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" class="readonly" disabled>
    </div>

    <div class="form-group">
      <label for="nome"><i class='bx bx-user'></i> Nome Completo:</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
    </div>

    <?php if ($tipo === 'educador'): ?>
      <div class="form-group">
        <label for="materia"><i class='bx bx-book'></i> Matéria:</label>
        <input type="text" id="materia" name="materia" value="<?= htmlspecialchars($educador['materia'] ?? '') ?>" placeholder="Ex: Matemática, Física, Química...">
      </div>

      <div class="form-group">
        <label for="bairro"><i class='bx bx-map-pin'></i> Bairro:</label>
        <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($educador['bairro'] ?? '') ?>" placeholder="Seu bairro">
      </div>

      <div class="form-group">
        <label for="cidade"><i class='bx bx-buildings'></i> Cidade:</label>
        <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($educador['cidade'] ?? '') ?>" placeholder="Sua cidade">
      </div>
      
      <div class="form-group">
        <label for="descricao"><i class='bx bx-text'></i> Descrição Profissional:</label>
        <textarea id="descricao" name="descricao" rows="4" placeholder="Conte um pouco sobre sua experiência e metodologia de ensino..."><?= htmlspecialchars($educador['descricao'] ?? '') ?></textarea>
      </div>
    <?php endif; ?>

    <button type="submit" class="btn-atualizar"><i class='bx bx-save'></i> Atualizar Perfil</button>
  </form>
</div>

<script>
function previewFoto(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      document.getElementById('foto-preview').src = e.target.result;
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>
