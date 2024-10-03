<?php
include('../../backend/session/session_check.php')
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/webbrain-logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/index.css">
  <title>Gerenciar chamados | Chamados TI</title>
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
    <h2 class="mb-4">Meus Chamados</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>ID Chamado</th>
            <th>Tipo de incidente</th>
            <th>Data de abertura</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="chamados-list">
          <!-- Dados dos chamados -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal para Visualização do Chamado -->
  <div class="modal fade" id="modalChamado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalChamadoLabel">Detalhes do Chamado</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body-content">
          <!-- Detalhes do chamado -->
        </div>
        <div class="modal-footer">
          <a href="./edit_call_page.php"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Editar chamado</button></a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(() => {
      // Buscando os dados no banco
      $.ajax({
        url: '../../backend/list_call.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if (data.error) {
            alert(data.error);
            return;
          }

          // Inserindo na tabela HTML
          let html = '';
          $.each(data, (index, chamado) => {
            html += `
                <tr>
                  <td>${chamado.id}</td>
                  <td>${chamado.tipo_incidente}</td>
                  <td>${new Date(chamado.data_abertura).toLocaleString('pt-BR')}</td>
                  <td>
                    <button class="btn btn-secondary btn-sm view-call" data-id="${chamado.id}">
                      Visualizar
                    </button>
                  </td>
                </tr>
              `;
          });

          $('#chamados-list').html(html);
        },
        error: function() {
          alert('Erro ao carregar os chamados.');
        }
      });

      // Carregando modal
      $(document).on('click', '.view-call', () => {
        const chamadoId = $(this).data('id');

        $.ajax({
          url: '../../backend/list_call_details.php',
          type: 'GET',
          data: {
            id: chamadoId
          },
          dataType: 'json',
          success: (chamado) => {
            if (!chamado || chamado.error) {
              alert('Erro ao carregar os detalhes do chamado.');
              return;
            }

            // HTML do modal
            let modalContent = `
              <p><strong>Tipo de incidente:</strong> ${chamado.tipo_incidente}</p>
              <p><strong>Descrição:</strong> ${chamado.descricao_problema}</p>
              <p><strong>Data de Abertura:</strong> ${chamado.data_abertura}</p>
              <hr>
              <h5>Histórico</h5>
              <ul>
                ${Array.isArray(chamado.historico) && chamado.historico.length > 0 
                    ? chamado.historico.map(hist => `<li>${hist.nome_usuario} : ${new Date(hist.data_evento).toLocaleString("pt-BR")} - ${hist.descricao}</li>`).join('') 
                    : 'Nenhum histórico disponível'}
              </ul>
              <hr>
              <h5>Anexos</h5>
              <ul>
                ${Array.isArray(chamado.anexos) && chamado.anexos.length > 0 
                    ? chamado.anexos.map((anexo, index) => `<li><a href="data:image/jpeg;base64,${anexo.arquivo_base64}" download="anexo_${index + 1}.jpg" target="_blank">Anexo ${index + 1}</li>`).join('') 
                    : 'Nenhum anexo disponível'}
              </ul>
            `;

            $('#modal-body-content').html(modalContent);
            $('#modalChamado .modal-footer a').attr('href', `./edit_call_page.php?id=${chamadoId}`);
            $('#modalChamado').modal('show');
          },
          error: () => {
            alert('Erro ao carregar os detalhes do chamado.');
          }
        });
      });
    });
  </script>
</body>

</html>