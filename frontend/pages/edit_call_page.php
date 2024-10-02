<?php
include('../../backend/session_check.php');
$callId = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/index.css">
  <title>Teste | Web Brain</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Chamados TI</a>
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
            <a class="nav-link" href="./manage_call.php">Gerenciar chamado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
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
        <input type="text" id="description" name="description" class="form-control"></input>
      </div>
      <div class="mb-3">
        <label for="attachments" class="form-label">Anexos</label>
        <input type="file" id="attachments" name="attachments[]" class="form-control" multiple required>
      </div>
      <button type="submit" class="btn btn-primary mb-3" id="createCall">Editar Chamado</button>
    </form>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <!-- Jquery mask para mascaras -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <!-- Summernote -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

  <script>
    $(document).ready(() => {
      $('#newCallEditForm').submit((e) => {
        e.preventDefault();
        var formData = new FormData();

        // Descricao da alteracao e o id do chamado no formData
        formData.append('callId', $('#callId').val());
        formData.append('description', $('#description').val());

        // Adicionando os anexos ao formData
        const files = $('#attachments')[0].files;
        for (let i = 0; i < files.length; i++) {
          formData.append('attachments[]', files[i]);
        };

        $.ajax({
          url: '../../backend/edit_call.php',
          data: formData,
          type: 'POST',
          processData: false,
          contentType: false,
          success: (response) => {
            alert(response);
            location.href = 'http://localhost/teste-webbrain/frontend/pages/manage_call.php';
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