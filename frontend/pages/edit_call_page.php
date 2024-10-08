<?php
include('../../backend/session/session_check.php');
$callId = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/webbrain-logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/index.css">
  <title>Editar chamado | Chamados TI</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="./dashboard.php">Chamados TI</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./new_call.php">Abrir chamado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./manage_call.php">Gerenciar chamados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../backend/session/session_destroy.php">Sair da conta</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h1>Editar Chamado</h1>
    <form id="newCallEditForm">
      <input type="hidden" id="callId" name="callId" value="<?php echo $callId; ?>">
      <div class="mb-3">
        <label for="description" class="form-label">Descrição da alteração</label>
        <input type="text" id="description" name="description" class="form-control" required></input>
      </div>
      <div class="mb-3">
        <label for="attachments" class="form-label">Anexos</label>
        <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
      </div>
      <div class="mb-3">
        <label for="status" class="form-label">Status do Chamado</label>
        <select id="status" name="status" class="form-select" required>
          <option value="Aberto">Aberto</option>
          <option value="Em Andamento">Em Andamento</option>
          <option value="Fechado">Fechado</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mb-3" id="createCall">Editar Chamado</button>
    </form>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(() => {
      $('#newCallEditForm').submit((e) => {
        e.preventDefault();
        var formData = new FormData();

        // Inserindo descricao da alteracao o id do chamado e o status no formData
        formData.append('callId', $('#callId').val());
        formData.append('description', $('#description').val());
        formData.append('status', $('#status').val());

        // Inserindo os anexos ao formData
        const files = $('#attachments')[0].files;
        for (let i = 0; i < files.length; i++) {
          formData.append('attachments[]', files[i]);
        };

        // Inserindo os novos anexos e a descricao
        $.ajax({
          url: '../../backend/edit_call.php',
          data: formData,
          type: 'POST',
          contentType: false,
          processData: false, // Para nao processar os anexos
          success: (response) => {
            let jsonResponse = typeof response === "string" ? JSON.parse(response) : response;
            if (jsonResponse.message === 'Chamado alterado com sucesso!') {
              alert(jsonResponse.message);
              location.href = './manage_call.php';
            }
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.log('Erro ao enviar o chamado: ' + textStatus);
          }
        });

      });
    });
  </script>
</body>

</html>