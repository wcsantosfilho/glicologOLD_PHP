<?php
// Parse da Url para separar os elementos
$rota = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// Tratamento com Expressoes Regulares para tirar a '/' do inicio da string
$caminho = preg_replace('/^\//', '', $rota['path']);

try {
    $conexao = new \PDO("mysql:host=localhost;dbname=glicolog", "root", "root");
} catch (\PDOException $e) {
    echo "Erro na conexão ao Banco de Dados \n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

/*
 * Função para verificar se a rota está no array de rotas válidas (principais ou de resposta) e se o arquivo existe.
 */
$rota_found = function ($conexao, $caminho) {
    try {
        $sqlcmd = "Select arquivo from rotas where rota = :rota"; // Monta SELECT para buscar na tabela Rotas
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
        return false;
    } else {
        return true;
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
                    $sqlcmd = "Select rota, arquivo from rotas where tipo = 'P' "; // Seleciona Rotas do tipo P(ágina)
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
        </div><!--/.nav-collapse -->
    </div><!-- container -->
</nav>
<!-- Fim do Header -->
<!-- Chamada para página de conteúdo conforme rota -->
<div class="container-fluid">
    <?php // monta a página armazenada no banco de dados
    if (strlen($caminho) == 0) {
        $caminho = "home";
    }
    if ($rota_found($conexao, $caminho)) {
        try {
            $sqlcmd = "Select linhaHTML from paginasHTML where rotas_arquivo = :arquivo"; // Busca as linhas de HTML que formam a página
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
            echo "<li>A página solicitada não está configurada. Por favor, contate o administrador.</li>";
            http_response_code(404);
        } else {
            foreach ($sqlresult as $linhas) {
                echo $linhas['linhaHTML'];
            }
        }
    } else {
        echo "<li>Página não encontrada.</li>li>";
        http_response_code(404);
    }
    ?>
</div>
<!-- Fim da chamada para página de conteúdo -->
<!-- Carrega o rodapé -->
<?php
try {
    $sqlcmd = "Select linhaHTML from paginasHTML where rotas_arquivo = 'rodape'"; // Busca as linhas de HTML que formam a página
    $stmt = $conexao->prepare($sqlcmd);
    $stmt->bindParam(":arquivo", $caminho);
    $stmt->execute();
    $sqlresult = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna FALSO se o resultado do SELECT for vazio
} catch (\PDOException $e) {
    echo "Erro na seleção ao Banco de Dados \n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

foreach ($sqlresult as $linhas) {
    echo $linhas['linhaHTML'];
}
?>
<!-- Fim da carga do rodapé -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.js"></script>
</body>
</html>
