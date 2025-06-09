<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | EduConnect</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
  <link rel="stylesheet" href="css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="../css/critical-fixes.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/theme.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/background.css?v=<?= time() ?>">
 
</head>
<body class="body-form">

  <div class="login-page-container">
    <div class="login-info-panel">
      <div class="welcome-content">
        <h3>Bem-vindo de volta! <span class="wave-emoji">👋</span></h3>
        <div class="info-text">
          <p>Conecte-se à nossa plataforma e tenha acesso a professores qualificados para aulas particulares sob medida para você.</p>
          <p>Encontre especialistas em diversas áreas, solicite aulas com facilidade e acompanhe tudo diretamente pela sua conta.</p>
          <div class="feature-highlight">
            <i class="ri-graduation-cap-line"></i>
            <p>Aprenda no seu ritmo, com quem entende do assunto.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="login-form-panel">
      <div class="form-header">
        <img src="images/logo.png" alt="EduConnect Logo" class="header-logo">
        <h2>Login</h2>
      </div>
      <form action="actions/login.php" method="POST" class="modern-form">
        <div class="form-group">
          <div class="input-icon-wrapper">
            <i class="ri-mail-line"></i>
            <input type="email" name="email" placeholder="E-mail" required>
          </div>
        </div>
        <div class="form-group">
          <div class="input-icon-wrapper">
            <i class="ri-lock-line"></i>
            <input type="password" name="senha" placeholder="Senha" required>
          </div>
        </div>
        <button type="submit" class="btn-primary">
          <span>Entrar</span>
          <i class="ri-arrow-right-line"></i>
        </button>
      </form>
      <div class="form-footer">
        <a href="index.php?tela=cadastro" class="register-link">
          <i class="ri-user-add-line"></i>
          <span>Não tem conta? Cadastre-se</span>
        </a>
      </div>
    </div>
  </div>
  <script>
    // Update theme toggle icon
    const updateThemeIcon = () => {
      const icon = document.getElementById('themeIcon');
      const currentTheme = document.documentElement.getAttribute('data-theme');
      icon.className = currentTheme === 'dark' ? 'ri-moon-line' : 'ri-sun-line';
    };

    // Toggle theme
    const toggleTheme = () => {
      const currentTheme = document.documentElement.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      setTheme(newTheme);
      updateThemeIcon();
    };

    // Initial icon setup
    updateThemeIcon();
  </script>
</body>
</html>
