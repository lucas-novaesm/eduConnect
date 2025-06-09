<?php
if (!isset($_SESSION)) session_start();
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/conexao.php";
require_once __DIR__ . "/../includes/header.php";
?>

<main class="container">
  <div class="page-header">
    <h2><i class="fas fa-graduation-cap"></i> Aulas Complementares</h2>
    <p>Expanda seu conhecimento com nossas aulas gravadas de alta qualidade.</p>
  </div>

  <div class="video-grid">
    <?php
    $videos = [
      [
        'arquivo' => 'aula1.mp4',
        'titulo' => 'Introdução à Plataforma',
        'duracao' => '15:30',
        'professor' => 'Prof. Ana Silva',
        'icone' => 'fas fa-laptop'
      ],
      [
        'arquivo' => 'citacao-direta-indireta.mp4',
        'titulo' => 'Citação Direta e Indireta - Aula de Português',
        'duracao' => '25:45',
        'professor' => 'Prof. Carlos Santos',
        'icone' => 'fas fa-book'
      ],
      [
        'arquivo' => 'short-answers-ingles.mp4',
        'titulo' => 'Short Answers - Aula de Inglês',
        'duracao' => '20:15',
        'professor' => 'Prof. Maria Oliveira',
        'icone' => 'fas fa-language'
      ],
      [
        'arquivo' => 'guerra-fria-resumo.mp4',
        'titulo' => 'Guerra Fria - Aula de História',
        'duracao' => '35:20',
        'professor' => 'Prof. João Lima',
        'icone' => 'fas fa-landmark'
      ],
    ];

    foreach ($videos as $video) {
      echo '<div class="video-card">';
      echo "  <h3><i class=\"{$video['icone']}\"></i> {$video['titulo']}</h3>";
      echo '  <video controls>';
      echo "    <source src='/EduConnect/videos/{$video['arquivo']}' type='video/mp4'>";
      echo '    Seu navegador não suporta vídeos HTML5.';
      echo '  </video>';
      echo '  <div class="video-info">';
      echo '    <div class="video-duration">';
      echo "      <i class=\"far fa-clock\"></i> {$video['duracao']}";
      echo '    </div>';
      echo "    <div class=\"video-professor\">{$video['professor']}</div>";
      echo '  </div>';
      echo '</div>';
    }
    ?>
  </div>
</main>
