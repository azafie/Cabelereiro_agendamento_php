<?php
  // Determina qual página carregar (padrão é 'lista_agendamentos')
  $page = isset($_GET['page']) ? $_GET['page'] : 'lista_agendamentos'; // Se não for especificado, exibe 'agendar.php' por padrão
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Salão</title>
  </head>
  <body>
    <nav class="menu-lateral">
      <div class="btn-expandir">
        <i class="bi bi-list-stars" id="btn-exp"></i>
        <ul>
          <li class="item-menu <?php echo ($page == 'agendamentos' ? 'ativo' : ''); ?>">
            <a href="index.php?page=agendamentos">
              <span class="icon"><i class="bi bi-journal-bookmark-fill"></i></span>
              <span class="txt-link">Agendar</span>
            </a>
          </li>
          <li class="item-menu <?php echo ($page == 'fila' ? 'ativo' : ''); ?>">
            <a href="index.php?page=fila">
              <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
              <span class="txt-link">Fila</span>
            </a>
          </li>
          <li class="item-menu <?php echo ($page == 'quem_somos' ? 'ativo' : ''); ?>">
            <a href="index.php?page=quem_somos">
              <span class="icon"><i class="bi bi-postcard-heart"></i></span>
              <span class="txt-link">Quem Somos</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="conteudo">
      <?php
        // Incluir o conteúdo de acordo com a página selecionada
        if ($page == 'agendamentos') {
          include('agendar.php'); // Lista de agendamentos
        } elseif ($page == 'fila') {
          include('fila.php'); // Gerenciar serviços
        } elseif ($page == 'quem_somos') {
          include('quem_somos.php'); // Página de deletar
        } else {
            include('agendar.php'); // agendar
        }
      ?>
    </div>

    <script src="menu.js"></script>
  </body>
</html>
