<?php
  // Determina qual página carregar (padrão é 'lista_agendamentos')
  

  
  $page = isset($_GET['page']) ? $_GET['page'] : 'lista_agendamentos'; // Se não for especificado, exibe 'lista_agendamentos' por padrão
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <title>Salão</title>
  </head>
  <body>
  <div class="text-end">
    <a href="logout.php" class="btn btn-danger">
    <span class="icon"><i class="bi bi-person-slash"></i></span>
    <span class="txt-link">sair</span>
  </a>
</div>
    <nav class="menu-lateral">
      <div class="btn-expandir">
        <i class="bi bi-list-stars" id="btn-exp"></i>
        <ul>
          <li class="item-menu <?php echo ($page == 'listar_usuarios' ? 'ativo' : ''); ?>">
            <a href="index.php?page=listar_usuarios">
              <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
              <span class="txt-link">usuarios</span>
            </a>
          </li>
          <li class="item-menu">
            <a href="../index.php?page=lista_agendamentos">
              <span class="icon"><i class="bi bi-house-heart"></i></span>
              <span class="txt-link">home</span>
            </a>
          </li>
         </ul>
      </div>
    </nav>

    <div class="conteudo">
      <?php
        // Incluir o conteúdo de acordo com a página selecionada
        if ($page == 'listar_usuarios') {
          include('listar_usuarios.php'); // Lista de agendamentos
        } elseif ($page == 'gerenciar_servicos') {
          include('gerenciar_servicos.php'); // Gerenciar serviços
        } elseif ($page == 'deletar') {
          include('deletar.php'); // Página de deletar
        } else {
          include('listar_usuarios.php');
        }
      ?>
    </div>

    <script src="menu.js"></script>
  </body>
</html>
