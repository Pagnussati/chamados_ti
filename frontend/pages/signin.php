<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/webbrain-logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/signin.css">
  <title>Cadastro | Chamados TI</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../../index.html">Chamados TI</a>
      <!-- <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div> -->
    </div>
  </nav>

  <div class="container form-div mt-4">
    <div id="flash-message-success" class="alert alert-success d-none" role="alert">
      <!-- MENSAGEM VINDA DO BAKCKEND -->
    </div>
    <div id="flash-message-warning" class="alert alert-danger d-none" role="alert">
      <!-- MENSAGEM VINDA DO BAKCKEND -->
    </div>
    <form id="createUserForm">
      <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="name" placeholder="Digite seu nome" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="birthDate" class="col-sm-2 col-form-label">Data de Nascimento</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="birthDate" placeholder="dd/mm/aaaa" required>
          <p class="warning" id="adultWarn"></p>
        </div>
      </div>

      <div class="row mb-3">
        <label for="user" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="user" placeholder="Digite seu e-mail" required>
          <p class="warning" id="emailWarn"></p>
        </div>
      </div>

      <div class="row mb-3">
        <label for="telephone" class="col-sm-2 col-form-label">Telefone</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="telephone" placeholder="(00) 0000-0000" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="cellphone" class="col-sm-2 col-form-label">Whatsapp</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="cellphone" placeholder="(00) 00000-0000" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="state" class="col-sm-2 col-form-label">Estado</label>
        <div class="col-sm-10">
          <select class="form-select" id="state" required>
            <option value=""></option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <label for="city" class="col-sm-2 col-form-label">Cidade</label>
        <div class="col-sm-10">
          <select class="form-select" id="city" required>
            <option value=""></option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">Senha</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
        </div>
      </div>

      <div class="row mb-3">
        <label for="passwordConfirm" class="col-sm-2 col-form-label">Confirmar senha</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="passwordConfirm" placeholder="Repita a senha" required>
          <p class="warning" id="passwordWarn"></p>
        </div>
      </div>

      <div class="mb-3 text-center">
        <p>Já tem um usuário? <a href="./login.php" id="loginButton">Entre aqui!</a></p>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Criar</button>
      </div>
    </form>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <!-- Jquery mask plugin para as máscaras -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <!-- Script de verificacao da pagina -->
  <script src="../scripts/loginVerify.js"></script>
  <!-- Script para popular o select -->
  <script src="../scripts//selectConfiguration.js"></script>

  <!-- Scripts da página -->
  <script>
    // Criacao das mascaras
    $(document).ready(() => {
      $('#cellphone').mask('(00) 00000-0000');
      $('#telephone').mask('(00) 0000-0000');
      $('#birthDate').mask('00/00/0000');

      // Verificando antes de enviar para o backend
      $('#createUserForm').submit((e) => {
        e.preventDefault();

        var name = $('#name').val();
        var birthDate = $('#birthDate').val();
        var email = $('#user').val();
        var telephone = $('#telephone').val();
        var cellphone = $('#cellphone').val();
        var city = $('#city option:selected').text();
        var state = $('#state option:selected').text();
        var password = $('#password').val();
        var confirmPassword = $('#passwordConfirm').val();

        $('#flash-message-success').addClass('d-none').text(''); // limpando o alert anterior
        $('#flash-message-warning').addClass('d-none').text('');

        var validAge = verifyAge(birthDate);
        var validPassword = verifyPassword(password, confirmPassword);

        if (!validAge || !validPassword) {
          return;
        }

        var parts = birthDate.split('/');
        var birthDateFormatted = parts[2] + '/' + parts[1] + '/' + parts[0];

        var formData = {
          name: name,
          birthDate: birthDateFormatted,
          email: email,
          telephone: telephone,
          cellphone: cellphone,
          city: city,
          state: state,
          password: password
        };

        // Inserindo no banco de dados
        $.ajax({
          type: 'POST',
          url: '../../backend/create_user.php',
          data: formData,
          success: (response) => {
            // convertendo a resposta JSON para string
            let jsonResponse = typeof response === "string" ? JSON.parse(response) : response;
            if (jsonResponse.message === 'Usuário criado com sucesso!') {
              $('#flash-message-success').removeClass('d-none').text(response);
              location.href = './login.php'
            } else {
              $('#flash-message-warning').removeClass('d-none').text(response);
            };
          },

        });
      });
    });
  </script>
</body>

</html>