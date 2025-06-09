<?php
if (!isset($_SESSION)) session_start();
require_once __DIR__ . "/config.php";

// Verifica se o usuário está logado
$usuario_logado = isset($_SESSION['usuario']);
?>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Estilos -->
<link rel="stylesheet" href="<?= $base_url ?>/css/estilo.css?v=<?= time() ?>">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Outros CSS -->
<link rel="stylesheet" href="<?= $base_url ?>/css/theme-toggle.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/background.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/theme.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/dark-theme.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/chat-fix-dark.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/nome-fix.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/layout-fix.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/contrast-fix.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= $base_url ?>/css/header-fix.css?v=<?= time() ?>">

<nav class="navbar">
  <div class="nav-container">
    <a href="<?= $base_url ?>/index.php" class="nav-logo">
      <img src="<?= $base_url ?>/images/logo.png" alt="EduConnect Logo" class="header-logo">
    </a>

    <button class="nav-toggle" aria-label="Abrir Menu">
      <span class="hamburger"></span>
    </button>

    <?php $tela_atual = $_GET['tela'] ?? 'home'; ?>
    <div class="nav-menu">
      <div class="nav-links">
        <a href="<?= $base_url ?>/index.php?tela=home" class="nav-link <?= $tela_atual === 'home' ? 'active' : '' ?>">
          <i class="fas fa-home"></i>
          <span>Início</span>
        </a>
        <a href="<?= $base_url ?>/index.php?tela=educadores" class="nav-link <?= $tela_atual === 'educadores' ? 'active' : '' ?>">
          <i class="fas fa-chalkboard-teacher"></i>
          <span>Educadores</span>
        </a>
        <a href="<?= $base_url ?>/index.php?tela=aulas" class="nav-link <?= $tela_atual === 'aulas' ? 'active' : '' ?>">
          <i class="fas fa-book-reader"></i>
          <span>Aulas Complementares</span>
        </a>
        <a href="<?= $base_url ?>/pages/chat.php" class="nav-link <?= $tela_atual === 'chat' ? 'active' : '' ?>">
          <i class="fas fa-comments"></i>
          <span>Chat de Dúvidas</span>
        </a>
        <a href="<?= $base_url ?>/pages/calendario.php" class="nav-link <?= $tela_atual === 'calendario' ? 'active' : '' ?>">
          <i class="fas fa-calendar-alt"></i>
          <span>Calendário</span>
        </a>
      </div>

      <?php if ($usuario_logado): ?>
        <div class="nav-user" style="display: flex; align-items: center; gap: 1.5rem;">

          <!-- Saldo de EduCoins -->
          <div class="nav-item-divider">
            <div class="educoins-saldo">
              <i class="fas fa-coins" style="color: #FFD700;"></i>
              <span>
                <?= $_SESSION['educoins'] ?? 0 ?>
                <a href="<?= $base_url ?>/pages/comprar-educoins.php" class="educoins-link">eduCoins</a>
              </span>
            </div>
          </div>

          <!-- Perfil -->
          <div class="nav-item-divider">
            <a href="<?= $base_url ?>/index.php?tela=perfil" class="nav-user-link" title="<?= htmlspecialchars($_SESSION['usuario']) ?>">
              <i class="fas fa-user-circle"></i>
              <span><?= htmlspecialchars($_SESSION['usuario']) ?></span>
            </a>
          </div>

          <!-- Alternar Tema -->
          <button id="theme-toggle" class="theme-toggle" aria-label="Alterar tema">
            <i class="fas fa-sun" id="theme-icon-sun"></i>
            <i class="fas fa-moon" id="theme-icon-moon"></i>
          </button>

          <!-- Sair -->
          <a href="<?= $base_url ?>/actions/logout.php" class="logout-link" title="Sair">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>
      <?php else: ?>
        <div class="nav-user">
          <a href="<?= $base_url ?>/index.php?tela=login" class="nav-user-link">
            <i class="fas fa-sign-in-alt"></i>
            <span>Entrar</span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<script>
  document.querySelector('.nav-toggle').addEventListener('click', function() {
    document.querySelector('.nav-menu').classList.toggle('active');
    this.classList.toggle('active');
  });

  document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const sunIcon = document.getElementById('theme-icon-sun');
    const moonIcon = document.getElementById('theme-icon-moon');

    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);

    if (currentTheme === 'dark') {
      sunIcon.style.display = 'none';
      moonIcon.style.display = 'inline-block';
    } else {
      sunIcon.style.display = 'inline-block';
      moonIcon.style.display = 'none';
    }

    themeToggle?.addEventListener('click', function () {
      const theme = document.documentElement.getAttribute('data-theme');
      const newTheme = theme === 'light' ? 'dark' : 'light';

      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);

      if (newTheme === 'dark') {
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'inline-block';
      } else {
        sunIcon.style.display = 'inline-block';
        moonIcon.style.display = 'none';
      }
    });
  });
</script>
