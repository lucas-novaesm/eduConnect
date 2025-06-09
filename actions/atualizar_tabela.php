<?php
session_start();
include '../includes/conexao.php';

// Verificar se a coluna 'descricao' já existe na tabela 'educadores'
$result = $conn->query("SHOW COLUMNS FROM educadores LIKE 'descricao'");
$exists = $result->num_rows > 0;

// Se a coluna não existir, adiciona ela
if (!$exists) {
    $sql = "ALTER TABLE educadores ADD COLUMN descricao TEXT AFTER cidade";
    if ($conn->query($sql) === TRUE) {
        echo "Coluna 'descricao' adicionada com sucesso à tabela 'educadores'";
    } else {
        echo "Erro ao adicionar coluna: " . $conn->error;
    }
} else {
    echo "A coluna 'descricao' já existe na tabela 'educadores'";
}
?>

<script>
    // Redirecionar de volta para a página de perfil após 3 segundos
    setTimeout(function() {
        window.location.href = '../index.php?tela=perfil';
    }, 3000);
</script>
