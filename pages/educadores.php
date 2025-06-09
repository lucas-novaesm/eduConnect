<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Educadores</title>
  <link rel="stylesheet" href="../css/estilo.css?v=<?= time() ?>">
  <link rel="stylesheet" href="../css/critical-fixes.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    .filtro-form {
      max-width: 800px;
      margin: 20px auto;
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .filtro-form input {
      padding: 10px 14px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      min-width: 200px;
    }

    .educadores-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      padding: 20px;
    }

    .educador-card {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 16px;
      width: 250px;
      background: white;
      text-align: center;
    }

    .educador-card img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .btn-agendar {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 12px;
      background-color: #007bff;
      color: white;
      border-radius: 6px;
      text-decoration: none;
    }

    .btn-agendar:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
  <h2 style="text-align:center; margin-top: 20px;">Educadores Disponíveis</h2>

  <div class="filtro-form">
    <input type="text" id="filtroMateria" placeholder="Filtrar por matéria">
    <input type="text" id="filtroCidade" placeholder="Filtrar por cidade">
  </div>

  <div id="educadores-container" class="educadores-container">
    <!-- Os resultados aparecerão aqui -->
  </div>
</main>

<script>
function buscarEducadores() {
  const materia = document.getElementById('filtroMateria').value;
  const cidade = document.getElementById('filtroCidade').value;

  const params = new URLSearchParams({ materia, cidade });

  fetch('includes/buscareducadores.php?' + params.toString())
    .then(response => response.text())
    .then(data => {
      document.getElementById('educadores-container').innerHTML = data;
    })
    .catch(error => {
      document.getElementById('educadores-container').innerHTML = '<p>Erro ao carregar educadores.</p>';
      console.error('Erro:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
  const materiaInput = document.getElementById('filtroMateria');
  const cidadeInput = document.getElementById('filtroCidade');

  materiaInput.addEventListener('input', buscarEducadores);
  cidadeInput.addEventListener('input', buscarEducadores);

  buscarEducadores(); // Carregar todos inicialmente
});
</script>

</body>
</html>
