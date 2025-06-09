<?php
function includeHeader() {
    include 'includes/header.php';
}

function includeFooter() {
    include 'includes/footer.php';
}

function getPageTitle($tela) {
    $titles = [
        'home' => 'Início',
        'login' => 'Login',
        'registro' => 'Registro',
        'educadores' => 'Educadores',
        'calendario' => 'Calendário',
        'perfil' => 'Meu Perfil',
        'sobre' => 'Sobre Nós',
        'ajuda' => 'Ajuda',
        'termos' => 'Termos de Uso'
    ];
    
    return isset($titles[$tela]) ? $titles[$tela] . ' | EduConnect' : 'EduConnect';
}
?>
