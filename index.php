<?php
// Parse da Url para separar os elementos
$rota = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// Tratamento com Expressoes Regulares para tirar a '/' do inicio da string
$caminho = preg_replace('/^\//', '', $rota['path']);
// Array de rotas válidas para montar o menu
$arr_rotas = ['Home' => 'home', 'Empresa' => 'empresa', 'Produtos' => 'produtos', 'Servicos' => 'servicos', 'Contato' => 'contato'];
// Array de rotas válidas para resposta (resposta de formulário de contato, p.ex.)
$arr_response = ['formresult' => 'formresult'];


/*
 * Função para verificar se a rota está no array de rotas válidas (principais ou de resposta) e se o arquivo existe.
 */
$rota_found = function ($caminho, $arr_rotas, $arr_response) {
    $filename = $caminho . '.php';
    if (file_exists($filename)) {
        return in_array($caminho, $arr_rotas) || in_array($caminho, $arr_response);
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlicoLog - Seu registro de glicemias</title>
    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="navbar-fixed-top.css" rel="stylesheet">
</head>
<body>
<!-- Header -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navegador responsivo</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">GlicoLog</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php // loop no array de rotas para montar o menu
                foreach ($arr_rotas as $chave_rota => $rota_menu) {
                    echo '<li><a href="' . $rota_menu . '">' . $chave_rota . '</a></li>';
                }
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!-- container -->
</nav>
<!-- Fim do Header -->
<!-- Chamada para página de conteúdo conforme rota -->
<div class="container-fluid">
    <?php // valida as rotas chamadas
    if (strlen($caminho) == 0) {
        require_once('home.php');
    } else {
        if ($rota_found($caminho, $arr_rotas, $arr_response, $rota_ant)) {
            require_once($caminho . '.php');
        } else {
            require_once('pagina404.php');
            http_response_code(404);
        }
    }
    ?>
</div>
<!-- Fim da chamada para página de conteúdo -->
<!-- Carrega o rodapé -->
<?php require_once("rodape.php"); ?>
<!-- Fim da carga do rodapé -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>
</body>
</html>
