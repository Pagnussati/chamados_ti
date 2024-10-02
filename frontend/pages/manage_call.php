<?php
include('../../backend/session_check.php')
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <a class="nav-link" href="">Gerenciar chamado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="mb-4">Meus Chamados</h2>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>ID Chamado</th>
            <th>Tipo de incidente</th>
            <th>Data de abertura</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="chamados-list">
          <!-- Os chamados serão carregados aqui via AJAX -->
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
          <!-- Detalhes do chamado serão carregados aqui -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      // Carregar os chamados via AJAX
      function carregarChamados() {
        $.ajax({
          url: '../../backend/list_call.php',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            if (data.error) {
              alert(data.error);
              return;
            }

            let html = '';
            $.each(data, function(index, chamado) {
              html += `
                <tr>
                  <td>${chamado.id}</td>
                  <td>${chamado.tipo_incidente}</td>
                  <td>${new Date(chamado.data_abertura).toLocaleString('pt-BR')}</td>
                  <td>
                    <button class="btn btn-primary btn-sm visualizar-chamado" data-id="${chamado.id}">
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
      }

      // Carregar detalhes do chamado no modal
      $(document).on('click', '.visualizar-chamado', function() {
        const chamadoId = $(this).data('id');

        $.ajax({
          url: '../../backend/list_call_details.php',
          type: 'GET',
          data: {
            id: chamadoId
          },
          dataType: 'json',
          success: function(chamado) {
            if (!chamado || chamado.error) {
              alert('Erro ao carregar os detalhes do chamado.');
              return;
            }

            let modalContent = `
        <p><strong>Tipo de incidente:</strong> ${chamado.tipo_incidente}</p>
        <p><strong>Descrição:</strong> ${chamado.descricao_problema}</p>
        <p><strong>Data de Abertura:</strong> ${chamado.data_abertura}</p>
        <hr>
        <h5>Histórico</h5>
        <ul>
          ${Array.isArray(chamado.historico) && chamado.historico.length > 0 
              ? chamado.historico.map(hist => `<li>${new Date(hist.data_registro).toLocaleString()} - ${hist.descricao}</li>`).join('') 
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
            $('#modalChamado').modal('show');
          },
          error: function() {
            alert('Erro ao carregar os detalhes do chamado.');
          }
        });
      });

      // Inicializa a função ao carregar a página
      carregarChamados();
    });
  </script>
</body>

</html>