<?php
if (!isset($_SESSION)) session_start();

require_once __DIR__ . '/config.php'; // caminho correto
require_once __DIR__ . '/conexao.php';    // conexão com banco (define $conn)

$materia = $_GET['materia'] ?? '';
$cidade = $_GET['cidade'] ?? '';

$sql = "
SELECT u.id, u.nome, u.email, e.materia, e.bairro, e.cidade, e.avaliacao, e.foto, e.valor_hora
FROM usuarios u
JOIN educadores e ON u.id = e.usuario_id
WHERE u.tipo = 'educador'
";

if (!empty($materia)) {
  $materia = $conn->real_escape_string($materia);
  $sql .= " AND e.materia LIKE '%$materia%'";
}

if (!empty($cidade)) {
  $cidade = $conn->real_escape_string($cidade);
  $sql .= " AND e.cidade LIKE '%$cidade%'";
}

$sql .= " ORDER BY u.nome ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $foto_path = !empty($row['foto']) ? $row['foto'] : $base_url . '/images/educadorPadrao.png';
    $valor = !empty($row['valor_hora']) ? number_format($row['valor_hora'], 2, ',', '.') : '100,00';

    echo "<div class='educador-card'>
            <img src='" . $foto_path . "' alt='Foto de " . htmlspecialchars($row['nome']) . "'>
            <h3>" . htmlspecialchars($row['nome']) . "</h3>
            <p><i class='fas fa-book'></i> <strong>Matéria:</strong> " . htmlspecialchars($row['materia']) . "</p>
            <p><i class='fas fa-map-marker-alt'></i> <strong>Cidade:</strong> " . htmlspecialchars($row['cidade']) . "</p>
            <p><i class='fas fa-dollar-sign'></i> <strong>Valor/Hora:</strong> R$ " . $valor . "</p>
            <a href='" . $base_url . "/index.php?tela=agendar&id=" . $row['id'] . "' class='btn-agendar'>
              <i class='fas fa-calendar-plus'></i> Agendar Aula
            </a>
          </div>";
  }
} else {
  echo "<p style='text-align:center;'>Nenhum educador encontrado.</p>";
}
?>
