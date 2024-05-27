<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão

// Verifica se existe a variável de sessão com os horários agendados
if (isset($_SESSION["horarios_agendados"])) {
    // Remove todos os horários agendados
    unset($_SESSION["horarios_agendados"]);
    echo "Mensagens de agendamento apagadas com sucesso.";
} else {
    echo "Não há mensagens de agendamento para apagar.";
}
?>
