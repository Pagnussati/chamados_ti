<?php
include('../../backend/session_check.php')
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
            <a class="nav-link" href="">Abrir chamado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gerenciar chamado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h1>Abrir Chamado</h1>
    <form id="newCallForm">
      <div class="mb-3">
        <label for="description" class="form-label">Descrição do Problema</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label for="incidentType" class="form-label">Tipo de Incidente</label>
        <input type="text" id="incidentType" name="incidentType" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="attachments" class="form-label">Anexos</label>
        <input type="file" id="attachments" name="attachments[]" class="form-control" multiple required>
      </div>
      <div id="contacts">
        <h5>Contatos Telefônicos</h5>
        <div class="contact mb-3">
          <input type="text" name="contactName[]" id="contactName" class="form-control mb-2" placeholder="Nome" required>
          <input type="text" name="contactPhone[]" id="contactPhone" class="form-control mb-2 phone-mask" placeholder="Telefone" required>
          <input type="text" name="contactObservation[]" id="contactObs" class="form-control mb-2" placeholder="Observação" required>
        </div>
      </div>
      <button type="button" id="addContact" class="btn btn-secondary mb-3">Adicionar Contato</button>
      <button type="submit" class="btn btn-primary mb-3" id="createCall">Registrar Chamado</button>
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
      // Mascaras e summernote
      $("#description").summernote();
      $(".phone-mask").mask("(00) 00000-0000");

      // Botao de adicionar contatos
      $('#addContact').click(() => {
        const newContact = `
              <div class="contact mb-3">
                  <input type="text" name="contactName[]" class="form-control mb-2" placeholder="Nome" required>
                  <input type="text" name="contactPhone[]" class="form-control mb-2 phone-mask" placeholder="Telefone" required>
                  <input type="text" name="contactObservation[]" class="form-control mb-2" placeholder="Observação" required>
                  <button type="button" class="btn btn-danger removeContact">Remover</button>
              </div>`;
        $('#contacts').append(newContact);
        $(".phone-mask").mask("(00) 00000-0000")
      });

      // Botao de remover contato
      $('#contacts').on('click', '.removeContact', function() {
        $(this).closest('.contact').remove();
      });

      // Acao de submit no formulario
      $('#newCallForm').submit((e) => {
        var formData = new FormData();

        // Adiciona os dados do formulário
        formData.append('description', $('#description').val());
        formData.append('incidentType', $('#incidentType').val());

        // Adiciona os anexos ao FormData
        const files = $('#attachments')[0].files;
        for (let i = 0; i < files.length; i++) {
          formData.append('attachments[]', files[i]);
        }

        // Adiciona contatos ao FormData
        $('#contacts .contact').each(function() {
          const contactName = $(this).find('input[name="contactName[]"]').val();
          const contactPhone = $(this).find('input[name="contactPhone[]"]').val();
          const contactObservation = $(this).find('input[name="contactObservation[]"]').val();

          formData.append('contactName[]', contactName);
          formData.append('contactPhone[]', contactPhone);
          formData.append('contactObservation[]', contactObservation);
        });

        // formData.forEach((value, key) => {
        //   console.log(`${key}: ${value}`);
        // });

        $.ajax({
          type: 'POST',
          url: 'http://localhost/teste-webbrain/backend/create_call.php',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            alert(response);
            location.reload();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Erro ao enviar o chamado: ' + textStatus);
          }
        });
      });
    });
  </script>
</body>

</html>