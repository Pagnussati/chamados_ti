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
  <title>Menu principal | Chamados TI</title>
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
    <h1 class="text-center">Bem-vindo, <?php echo $_SESSION['name']; ?>!</h1>
    <div class="card mt-4">
      <div class="card-header bg-secondary text-white">
        <h4>Informações do Sistema</h4>
      </div>
      <div class="card-body">
        <p>
          Você está logado como <strong><?php echo $_SESSION['name']; ?></strong>. Aqui estão algumas funcionalidades disponíveis:
        </p>
        <ul>
          <li><strong>Abrir Chamados:</strong> Registre novos chamados para problemas técnicos clicando na opção "Abrir chamado" logo acima.</li>
          <li><strong>Gerenciar Chamados:</strong> Visualize e edite os chamados que você abriu clicando na opção "Gerenciar chamados" logo acima.</li>
          <li><strong>Adicionar Anexos:</strong> Inclua arquivos relevantes aos seus chamados clicando na opção "Editar" na página "Gerenciar chamados".</li>
          <li><strong>Visualizar Histórico:</strong> Acompanhe todas as atualizações e atividades relacionadas aos seus chamados clicando na opção "Visualizar" da página "Gerenciar chamados".</li>
        </ul>
        <p>
          Utilize o menu acima para navegar pelo sistema.
        </p>
      </div>
      <div class="card-footer text-muted">
        Site desenvolvido com muito ☕ por <strong>João Gabriel Pagnussati</strong>
      </div>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>