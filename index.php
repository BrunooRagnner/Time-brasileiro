<?php
session_start(); // Inicia a sessão para armazenar os agendamentos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $horariosAgendados = isset($_SESSION["horarios_agendados"]) ? $_SESSION["horarios_agendados"] : [];

    // Captura os dados do agendamento
    $horario = $_POST["horario"];
    $cliente = $_POST["cliente"];
    $telefone = $_POST["telefone"];

    // Verifica se o horário já está agendado
    if (array_key_exists($horario, $horariosAgendados)) {
        header("Location: horario_agendado.html"); // Redireciona para a página horario_agendado.html
        exit(); // Encerra o script
    }

    // Adiciona o agendamento à lista de horários agendados
    $horariosAgendados[$horario] = ["cliente" => $cliente, "telefone" => $telefone];
    $_SESSION["horarios_agendados"] = $horariosAgendados;

    // Formata a mensagem para o WhatsApp do barbeiro
    $mensagem = "Novo agendamento para $cliente - Data: " . date("d/m/Y", strtotime("today")) . " - Horário: $horario - Telefone: $telefone";

    // Número de WhatsApp do barbeiro
    $numeroWhatsAppBarbeiro = "5584991612793";

    // URL do WhatsApp API
    $url = "https://api.whatsapp.com/send?phone=$numeroWhatsAppBarbeiro&text=" . urlencode($mensagem);

    // Redireciona para o WhatsApp do barbeiro
    header("Location: $url");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento - Barbearia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Agendamento de Horário - Barbeiro Hosman</h1>
        <div class="card mx-auto mt-5" style="max-width: 600px;">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horário:</label>
                        <select id="horario" name="horario" class="form-select" required>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Nome do Cliente:</label>
                        <input type="text" id="cliente" name="cliente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone do Cliente:</label>
                        <input type="tel" id="telefone" name="telefone" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_SESSION["horarios_agendados"])) {
            echo '<div class="mensagem mt-3">';
            echo "<h3>Horários Agendados:</h3>";
            foreach ($_SESSION["horarios_agendados"] as $horario => $dados) {
                echo "<p>Data: " . date("d/m/Y", strtotime("today")) . " Horário: $horario</p>";
            }
            echo '</div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
