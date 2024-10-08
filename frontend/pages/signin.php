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

  <div class="form-div">
    <form id="createUserForm">
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" placeholder="Digite seu nome" required>
      </div>

      <div class="mb-3">
        <label for="birthDate" class="form-label">Data de Nascimento</label>
        <input type="text" class="form-control" id="birthDate" placeholder="dd/mm/aaaa" required>
        <p class="warning" id="adultWarn"></p>
      </div>

      <div class="mb-3">
        <label for="user" class="form-label">Email</label>
        <input type="email" class="form-control" id="user" placeholder="Digite seu e-mail" required>
        <p class="warning" id="emailWarn"></p>
      </div>

      <div class="mb-3">
        <label for="telephone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="telephone" placeholder="(00) 0000-0000" required>
      </div>

      <div class="mb-3">
        <label for="cellphone" class="form-label">Whatsapp</label>
        <input type="text" class="form-control" id="cellphone" placeholder="(00) 00000-0000" required>
      </div>

      <div class="mb-3">
        <label for="state" class="form-label">Estado</label>
        <select class="form-select" id="state" required>
          <option value=""></option>
        </select>
      </div>

      <div class="mb-3">
        <label for="city" class="form-label">Cidade</label>
        <select class="form-select" id="city" required>
          <option value=""></option>
        </select>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
      </div>

      <div class="mb-3">
        <label for="passwordConfirm" class="form-label">Confirmar senha</label>
        <input type="password" class="form-control" id="passwordConfirm" placeholder="Repita a senha" required>
        <p class="warning" id="passwordWarn"></p>
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

  <!-- Scripts da página -->
  <script>
    // Criacao das mascaras
    $(document).ready(() => {
      $('#cellphone').mask('(00) 00000-0000');
      $('#telephone').mask('(00) 0000-0000');
      $('#birthDate').mask('00/00/0000');

      // Populando o select
      $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados", function(data) {
        data.sort(function(a, b) {
          return a.nome.localeCompare(b.nome);
        });

        $.each(data, function(key, estado) {
          $('#state').append('<option value="' + estado.id + '">' + estado.nome + '</option>');
        });
      });

      $('#state').on('change', function() {
        var estadoId = $(this).val();

        // Limpa as opções de cidades
        $('#city').empty().append('<option value=""></option>');

        if (estadoId) {
          $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + estadoId + "/municipios", function(data) {
            // Popula o select de cidades
            $.each(data, function(key, cidade) {
              $('#city').append('<option value="' + cidade.id + '">' + cidade.nome + '</option>');
            });
          });
        }
      });
    });

    // Funcao de verificar idade
    function verifyAge(birthDate) {
      var parts = birthDate.split('/');
      var birthDateObj = new Date(parts[2], parts[1] - 1, parts[0]); // ano, mês, dia

      var today = new Date();
      var age = today.getFullYear() - birthDateObj.getFullYear();
      var m = today.getMonth() - birthDateObj.getMonth();

      if (m < 0 || (m === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
      }

      if (age < 18) {
        $('#adultWarn').text('Você precisa ter pelo menos 18 anos para se cadastrar.');
        return false;
      }

      $('#adultWarn').text(''); // Limpa o aviso caso a idade seja válida
      return true;
    }

    // Funcao de verificar senha
    function verifyPassword(password, confirmPassword) {
      if (password.length < 4) {
        $('#passwordWarn').text('A senha precisa ter pelo menos 4 caracteres!');
        return false;
      } else if (password !== confirmPassword) {
        $('#passwordWarn').text('As senhas não coincidem!');
        return false;
      }

      $('#passwordWarn').text(''); // Limpa o aviso caso as senhas sejam válidas
      return true;
    }

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

      var validAge = verifyAge(birthDate);
      var validPassword = verifyPassword(password, confirmPassword);

      if (!validAge || !validPassword) {
        return;
      }

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
            alert(jsonResponse.message);
            location.href = './login.php'
          } else {
            alert(jsonResponse.message);
          };
        },

      });
    })
  </script>
</body>

</html>