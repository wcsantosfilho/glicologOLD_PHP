<?php
session_start();
$tipoUsuarioLogado = "";
$validaSessionLogado = isset($_SESSION['Logado']);
$validaTipoUsuario = isset($_SESSION['TipoUsuarioLogado']);
if ($validaSessionLogado) {
    if ($_SESSION['Logado'] == 1) {
        $tipoUsuarioLogado = $_SESSION['TipoUsuarioLogado'];
    }
}

// Chamada das funções para formatação das páginas HTML
require_once "conteudoHTML.php";

// Parse da Url para separar os elementos
$rota = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// Tratamento com Expressoes Regulares para tirar a '/' do inicio da string
$caminho = preg_replace('/^\//', '', $rota['path']);

// Estabelece conexao com banco de dados
try {
    $conexao = new \PDO("mysql:host=localhost;dbname=glicolog", "root", "root");
} catch (\PDOException $e) {
    echo "Erro na conexão ao Banco de Dados \n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

/*
 * Função para verificar se a rota está no array de rotas válidas. Retorna o Tipo da Rota, quando encontrada
 */
$tipo_rota = function ($conexao, $caminho) {
    try {
        $sqlcmd = "Select arquivo, tipo from rotas where rota = :rota"; // Monta SELECT para buscar na tabela Rotas
        $stmt = $conexao->prepare($sqlcmd);
        $stmt->bindValue("rota", $caminho);
        $stmt->execute();
        $sqlresult = $stmt->fetch(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
    } catch (\PDOException $e) {
        echo "Erro na conexão ao Banco de Dados \n";
        echo $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
    }

    if (empty($sqlresult)) {
        return '';
    } else {
        return $sqlresult['tipo'];
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
                <?php
                try {
                    if ($tipoUsuarioLogado == 'A') {
                        $sqlcmd = "Select rota, arquivo from rotas where  ( tipo = 'P' or tipo = 'F' or tipo = 'E' ) "; // Seleciona Rotas do tipo P(ágina) ou F(ormulario) ou E(ditar)
                    } else {
                        $sqlcmd = "Select rota, arquivo from rotas where  ( tipo = 'P' or tipo = 'F' ) "; // Seleciona Rotas do tipo P(ágina) ou F(ormulario)
                    }
                    $stmt = $conexao->prepare($sqlcmd);
                    $stmt->execute();
                    $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
                } catch (\PDOException $e) {
                    echo "Erro na conexão ao Banco de Dados \n";
                    echo $e->getMessage() . "\n";
                    echo $e->getTraceAsString() . "\n";
                }

                foreach ($sqlresult as $rota_menu) {
                    echo '<li><a href="' . $rota_menu['arquivo'] . '">' . $rota_menu['rota'] . '</a></li>';
                }
                ?>
            </ul>
            <?php
            $validaSessionLogado = isset($_SESSION['Logado']);
            if ($validaSessionLogado and $_SESSION["Logado"] == 1) {
                echo '<ul class="nav navbar-nav navbar-right">';
                echo '<li class="active"><a href="#">Olá ' . $_SESSION['Usuario'] . '. </a></li>';
                echo '<li><a href="/login?acao=sair">Sair</a></li>';
                echo '</ul>';
            } else {
                echo '<form class="navbar-form navbar-right" role="login" action="/login" method="POST">';
                echo '<div class="form-group" >';
                echo '<input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario">';
                echo '</div >';
                echo '<div class="form-group" >';
                echo '<input type="password" class="form-control" placeholder="Senha" id="senha" name="senha">';
                echo '</div >';
                echo '<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in" aria-hidden="true" >';
                echo '</span ></button >';
                echo '</form >';
            }
            ?>
            <form class="navbar-form navbar-right" role="search" action="/busca" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Busca" id="textobusca" name="textobusca">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"
                                                                    aria-hidden="true"></span></button>
            </form>
        </div><!--/.nav-collapse -->
    </div><!-- container -->
</nav>
<!-- Fim do Header -->
<!-- Chamada para página de conteúdo conforme rota -->

<?php // monta a página armazenada no banco de dados
if (strlen($caminho) == 0) {
    $caminho = "home";
}
// EXECUTA BUSCA E MONTA RESULTADO
$testa_rota = $tipo_rota($conexao, $caminho);
switch ($testa_rota) {
    case "P":
        // LEITURA DAS LINHAS DO BANCO DE DADOS
        try {
            $sqlcmd = "Select comandoAlt, linhaHTML from paginasHTML where rotas_arquivo = :arquivo"; // Busca as linhas de HTML que formam a página
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":arquivo", $caminho);
            $stmt->execute();
            $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
        } catch (\PDOException $e) {
            echo "Erro na seleção ao Banco de Dados \n";
            echo $e->getMessage() . "\n";
            echo $e->getTraceAsString() . "\n";
        }

        if (empty($sqlresult)) {
            // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
            echo "<li>A página solicitada não está configurada. Por favor, contate o administrador.</li>";
            http_response_code(404);
        } else {
            // DEU TUDO CERTO? ENVIA AS LINHAS HTML
            geraPaginaConteudo($sqlresult);
        }
        break;
    case "F":
        // LEITURA DAS LINHAS DO BANCO DE DADOS
        try {
            // Leitura específica da ACAO
            $sqlcmd = "Select form_campo, form_label, form_tipo, form_action from formsHTML where rotas_arquivo = :arquivo and form_tipo = 'A' "; // Busca dados nos formularios
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":arquivo", $caminho);
            $stmt->execute();
            $form_acao = $stmt->fetch(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            // Leitura específica do TEXTO
            $sqlcmd = "Select form_campo, form_label, form_tipo, form_action from formsHTML where rotas_arquivo = :arquivo and form_tipo = 'T' "; // Busca dados nos formularios
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":arquivo", $caminho);
            $stmt->execute();
            $form_texto = $stmt->fetch(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            // Leitura específica dos botoes
            $sqlcmd = "Select form_campo, form_label, form_tipo, form_action from formsHTML where rotas_arquivo = :arquivo and form_tipo = 'botao' "; // Busca dados nos formularios
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":arquivo", $caminho);
            $stmt->execute();
            $form_botoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            // Leitura dos campos
            $sqlcmd = "Select form_campo, form_label, form_tipo, form_action from formsHTML where rotas_arquivo = :arquivo and form_tipo != 'botao' and form_tipo != 'T' and form_tipo != 'A' "; // Busca dados nos formularios
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":arquivo", $caminho);
            $stmt->execute();
            $form_campos = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
        } catch (\PDOException $e) {
            echo "Erro na seleção ao Banco de Dados \n";
            echo $e->getMessage() . "\n";
            echo $e->getTraceAsString() . "\n";
        }

        if (empty($sqlresult)) {
            // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
            echo "<li>A página solicitada não está configurada. Por favor, contate o administrador.</li>";
            http_response_code(404);
        } else {
            // DEU TUDO CERTO? ENVIA AS LINHAS HTML
            geraFormulario($form_acao, $form_botoes, $form_texto, $form_campos);
        }
        break;
    case "R":
        geraResposta($_GET);
        break;
    case "B":
        try {
            $textobusca = "%" . $_GET['textobusca'] . "%";
            $sqlcmd = "SELECT rotas_arquivo, linhaHTML FROM glicolog.paginasHTML INNER JOIN glicolog.rotas ON paginasHTML.rotas_arquivo = rotas.rota WHERE rotas.tipo = 'P' and linhaHTML LIKE :searchtext"; // Busca as linhas de HTML contendo o texto de busca
            $stmt = $conexao->prepare($sqlcmd);
            $stmt->bindParam(":searchtext", $textobusca, PDO::PARAM_STR);
            $stmt->execute();
            $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
        } catch (\PDOException $e) {
            echo "Erro na seleção ao Banco de Dados \n";
            echo $e->getMessage() . "\n";
            echo $e->getTraceAsString() . "\n";
        }
        geraResultadoBusca($sqlresult, $_GET['textobusca']);
        break;
    case "E":
        // VALIDA SE É UMA SESSAO VALIDA DE ADMINISTRADOR
        if ($tipoUsuarioLogado == 'A') {
            try {
                $sqlcmd = "Select rota, arquivo from rotas where  ( tipo = 'P' ) "; // Seleciona Rotas do tipo P(ágina)
                $stmt = $conexao->prepare($sqlcmd);
                $stmt->execute();
                $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            } catch (\PDOException $e) {
                echo "Erro na conexão ao Banco de Dados \n";
                echo $e->getMessage() . "\n";
                echo $e->getTraceAsString() . "\n";
            }
            // DEU TUDO CERTO? CONSTROI O FORM com RADIOBUTTON
            geraFormEscolhePaginaParaEditar($sqlresult);
        } else {
            // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
            echo "<li>Acesso não permitido!</li>";
        }
        break;
    case "C":
        // VALIDA SE É UMA SESSAO VALIDA DE ADMINISTRADOR
        $paginaSelecionada = $_GET['editSelect'];
        if ($tipoUsuarioLogado == 'A' and $caminho == 'ckedit') {
            try {
                $sqlcmd = "SELECT rotas_arquivo, linhaHTML FROM glicolog.paginasHTML WHERE rotas_arquivo = :paginaEdita FOR UPDATE"; // Busca as linhas de HTML contendo o texto de busca
                $stmt = $conexao->prepare($sqlcmd);
                $stmt->bindParam(":paginaEdita", $paginaSelecionada, PDO::PARAM_STR);
                $stmt->execute();
                $sqlresult = $stmt->fetch(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            } catch (\PDOException $e) {
                echo "Erro na conexão ao Banco de Dados \n";
                echo $e->getMessage() . "\n";
                echo $e->getTraceAsString() . "\n";
            }
            // DEU TUDO CERTO? CONSTROI O FORM com RADIOBUTTON
            geraFormComCkeditor($sqlresult, $paginaSelecionada);
        } else {
            // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
            echo "<li>Acesso não permitido!</li>";
        }
        break;
    case "G":
        // VALIDA SE É UMA SESSAO VALIDA DE ADMINISTRADOR
        $paginaSelecionada = $_POST['paginaSelecionada'];
        $conteudoParaGravar = $_POST['editor1'];
        if ($tipoUsuarioLogado == 'A' and $caminho == 'gravar') {
            try {
                // UPDATE child_codes SET counter_field = LAST_INSERT_ID(counter_field + 1);
                $sqlcmd = "UPDATE paginasHTML SET linhaHTML = :conteudo WHERE rotas_arquivo = :paginaEdita";
                $stmt = $conexao->prepare($sqlcmd);
                $stmt->bindParam(":paginaEdita", $paginaSelecionada, PDO::PARAM_STR);
                $stmt->bindParam(":conteudo", $conteudoParaGravar, PDO::PARAM_STR);
                $stmt->execute(); // retorna FALSO se erro, VERDADEIRO se OK
            } catch (\PDOException $e) {
                echo "Erro no update \n";
                echo $e->getMessage() . "\n";
                echo $e->getTraceAsString() . "\n";
            }
            // DEU TUDO CERTO? chama a página editada
            // LEITURA DAS LINHAS DO BANCO DE DADOS
            $urlPagina = '/' . $paginaSelecionada;
            if ($stmt) {
                echo '<div class="alert alert-success">';
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo '<strong>Successo!</strong> Alteração realizada com sucesso. ';
                echo 'Retorna para <a href="' . $urlPagina . '">' . $paginaSelecionada . '</a> ou para <a href="/home">Home</a>';
                echo '</div>';
            }
        } else {
            // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
            echo "<li>Acesso não permitido!</li>";
        }
        break;
    case "L":
        // LEITURA DO USUARIO DO FORMULARIO DE LOGIN
        if (isset($_GET['acao'])) {
            $form_acao = $_GET['acao'];
        }
        if (isset($form_acao) and $form_acao == 'sair') {
            unset($_SESSION['Logado']);
            unset($_SESSION['TipoUsuarioLogado']);
            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=/home">';
        } else {
            $form_usuario = $_POST['usuario'];
            $form_senha = $_POST['senha'];
            try {
                $sqlcmd = "Select usuario, senha, tipo from usuarios where usuario = :form_user"; // Busca usuário e senha no BD
                $stmt = $conexao->prepare($sqlcmd);
                $stmt->bindParam(":form_user", $form_usuario);
                $stmt->execute();
                $sqlresult = $stmt->fetch(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
            } catch (\PDOException $e) {
                echo "Erro na seleção ao Banco de Dados \n";
                echo $e->getMessage() . "\n";
                echo $e->getTraceAsString() . "\n";
            }
            if (empty($sqlresult)) {
                // MENSAGEM SE A PAGINA NAO ESTIVER INSERIDA NO BANCO DE DADOS
                echo "<li>Usuário não existe.</li>";
            } else {
                // DEU TUDO CERTO NO SELECT? TESTA SE A SENHA ESTÁ CORRETA
                if (password_verify($form_senha, $sqlresult['senha'])) {
                    $_SESSION['Logado'] = 1;
                    $tipoUsuarioLogado = $sqlresult['tipo'];
                    $_SESSION['TipoUsuarioLogado'] = $tipoUsuarioLogado;
                    $_SESSION['Usuario'] = $form_usuario;
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="5; URL=/home">';
                    echo '<div class="alert alert-success">';
                    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    echo '<strong>Successo!</strong> Usuário e senha corretos. ';
                    echo '<br>Retornando para <a href="/home">Home</a> em 5 segundos.';
                    echo '</div>';
                } else {
                    $_SESSION['Logado'] = 0;
                    if (isset($_SESSION['Usuario'])) { unset($_SESSION['Usuario']); };
                    if (isset($_SESSION['TipoUsuarioLogado'])) { unset($_SESSION['TipoUsuarioLogado']); };
                    $tipoUsuarioLogado = "";
                    echo '<div class="alert alert-danger">';
                    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    echo '<strong>Ops!</strong> Usuário ou Senha incorretos! ';
                    echo 'Retorna para <a href="/home">Home</a>';
                    echo '</div>';
                }
            }
        }
        break;
    default:
        // MENSAGEM SE A ROTA NAO ESTIVER CADASTRADA NO BD
        echo "<li>Página não encontrada.</li>";
        http_response_code(404);
}
?>

<!-- Fim da chamada para página de conteúdo -->
<!-- Carrega o rodapé -->
<?php
try {
    $sqlcmd = "Select comandoAlt, linhaHTML from paginasHTML where rotas_arquivo = 'rodape'"; // Busca as linhas de HTML que formam a página
    $stmt = $conexao->prepare($sqlcmd);
    $stmt->bindParam(":arquivo", $caminho);
    $stmt->execute();
    $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
} catch (\PDOException $e) {
    echo "Erro na seleção ao Banco de Dados \n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

if ($sqlresult != false and count($sqlresult) >= 0) {
    geraRodape($sqlresult);
} else {
    echo '<p> Rodapé não formatado </p>';
}
?>
<!-- Fim da carga do rodapé -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>
<script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
</script>

</body>
</html>
