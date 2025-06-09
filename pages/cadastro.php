<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro | EduConnect</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
  <link rel="stylesheet" href="css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/theme.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/background.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/register.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/critical-fixes.css?v=<?= time() ?>">

</head>
<body class="body-form">


  <div class="register-container">
    <div class="form-header">
      <img src="images/logo.png" alt="EduConnect Logo" class="header-logo">
      <h2>Cadastro</h2>
      <p class="form-subtitle">Junte-se à nossa comunidade de aprendizado</p>
    </div>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
      <div class="alert alert-success">
        <i class="ri-checkbox-circle-line"></i>
        <span>Cadastro realizado com sucesso! Redirecionando...</span>
      </div>
      <script>
        setTimeout(() => {
          window.location.href = "index.php?tela=login";
        }, 2000);
      </script>
    <?php endif; ?>

    <form action="actions/cadastro.php" method="POST" onsubmit="return validarEducador()" class="modern-form">
      <div class="user-type-selector">
        <label>Tipo de Usuário</label>
        <div class="toggle-buttons">
          <input type="radio" id="aluno" name="tipo" value="aluno" checked onchange="mostrarCamposEducador()">
          <label for="aluno" class="toggle-button">
            <i class="ri-user-line"></i>
            <span>Aluno</span>
          </label>
          
          <input type="radio" id="educador" name="tipo" value="educador" onchange="mostrarCamposEducador()">
          <label for="educador" class="toggle-button">
            <i class="ri-team-line"></i>
            <span>Educador</span>
          </label>
        </div>
      </div>

      <div class="form-group">
        <div class="input-icon-wrapper">
          <i class="ri-user-line"></i>
          <input type="text" name="nome" placeholder="Nome completo" required>
        </div>
      </div>

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
          <button type="button" class="toggle-password" onclick="togglePassword(this)">
            <i class="ri-eye-line"></i>
          </button>
        </div>
      </div>

      <div id="camposEducador" class="extra-campos">
        <div class="form-group">
          <div class="input-icon-wrapper">
            <i class="ri-book-open-line"></i>
            <input type="text" name="materia" id="materia" placeholder="Matéria que leciona">
          </div>
        </div>

        <div class="form-group">
          <div class="input-icon-wrapper">
            <i class="ri-map-pin-line"></i>
            <input type="text" name="bairro" id="bairro" placeholder="Bairro">
          </div>
        </div>

        <div class="form-group">
          <div class="input-icon-wrapper">
            <i class="ri-building-line"></i>
            <input type="text" name="cidade" id="cidade" placeholder="Cidade">
          </div>
        </div>
      </div>

      <button type="submit" class="btn-primary">
        <span>Criar conta</span>
        <i class="ri-arrow-right-line"></i>
      </button>
    </form>

    <div class="form-footer">
      <a href="index.php?tela=login" class="login-link">
        <i class="ri-login-circle-line"></i>
        <span>Já tem conta? Faça login</span>
      </a>
    </div>
  </div>

  <script>
    function mostrarCamposEducador() {
      const tipo = document.querySelector('input[name="tipo"]:checked').value;
      const campos = document.getElementById('camposEducador');
      campos.style.display = (tipo === 'educador') ? 'block' : 'none';
    }

    function validarEducador() {
      const tipo = document.querySelector('input[name="tipo"]:checked').value;
      if (tipo === 'educador') {
        const materia = document.getElementById('materia').value.trim();
        const bairro = document.getElementById('bairro').value.trim();
        const cidade = document.getElementById('cidade').value.trim();

        if (!materia || !bairro || !cidade) {
          showError("Por favor, preencha todos os campos do educador.");
          return false;
        }
      }
      return true;
    }

    function togglePassword(button) {
      const input = button.parentElement.querySelector('input');
      const icon = button.querySelector('i');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ri-eye-off-line';
      } else {
        input.type = 'password';
        icon.className = 'ri-eye-line';
      }
    }

    function showError(message) {
      const alert = document.createElement('div');
      alert.className = 'alert alert-error';
      alert.innerHTML = `
        <i class="ri-error-warning-line"></i>
        <span>${message}</span>
      `;
      
      const form = document.querySelector('.modern-form');
      form.insertBefore(alert, form.firstChild);
      
      setTimeout(() => {
        alert.remove();
      }, 5000);
    }
  </script>
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
