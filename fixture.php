<?php
require_once "conexaoDB.php";

echo "#### Executando Fixture ####\n";
$conn = conexaoDB();

echo "Removendo tabelas\n";
try {
    $conn->query("DROP TABLE IF EXISTS paginasHTML, rotas");
} catch (\PDOException $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}


echo "Criando tabela rotas \n";
try {
    $conn->query("CREATE TABLE rotas (
              id  INT NOT NULL AUTO_INCREMENT,
              rota VARCHAR(45) CHARACTER SET utf8,
              arquivo VARCHAR(45) CHARACTER SET utf8,
              tipo CHAR CHARACTER SET utf8,
              INDEX arquivo_ind (arquivo),
              PRIMARY KEY (id)
              )");
} catch (\PDOException $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}


echo "Criando tabela paginasHTML \n";
try {
    $conn->query("CREATE TABLE paginasHTML (
              rotas_arquivo VARCHAR(45) CHARACTER SET utf8,
              linhaHTML VARCHAR(450) CHARACTER SET utf8,
                  CONSTRAINT fk_arquivo
                  FOREIGN KEY (rotas_arquivo)
                  REFERENCES rotas(arquivo)
                  ON DELETE CASCADE)
                  ");
} catch (\PDOException $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
echo "v--v\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";


// Array de rotas válidas para montar o menu
$arr_rotas = ['Home' => 'home', 'Empresa' => 'empresa', 'Produtos' => 'produtos', 'Servicos' => 'servicos', 'Contato' => 'contato'];
echo "Inserindo dados na rota\n";
foreach ($arr_rotas as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'P')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

// Array de rotas válidas para resposta (resposta de formulário de contato, p.ex.)
$arr_response = ['formresult' => 'formresult', 'rodape' => 'rodape', 'busca' => 'busca'];
foreach ($arr_response as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'R')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

echo "Inserindo paginas html\n";
$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '    <div class=\"row\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        <div class=\"col-md-8\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '            <div class=\"jumbotron\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '                <p>Nossa empresa iniciou seus trabalhos em 1980, com alta tecnologia, voltada para o crescimento sustentável a longo prazo.</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '            </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), '</div>' )
");
echo "v--v\n";
echo "-- Empresa --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '    <div class=\"row\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        <div class=\"col-md-8\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '            <div class=\"jumbotron\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '                <p>Nossos produtos são da mais alta qualidade!</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '            </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '</div>' )
");
echo "v--v\n";
echo "-- Produtos --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '    <div class=\"row\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        <div class=\"col-md-8\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '            <div class=\"jumbotron\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '                <p>Temos serviços adequados a sua realidade!</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '            </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), '</div>' )
");
echo "v--v\n";
echo "-- Servicos --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '    <div class=\"row\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        <div class=\"col-md-8\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '            <div class=\"jumbotron\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '                <p>Página inicial, a.k.a., Home.</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '            </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), '</div>' )
");
echo "v--v\n";
echo "-- Home --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '    <div class=\"row-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '        <h3>Todos os direitos reservados -' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '            <span class=\"text-success\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '                <?php echo date(\'Y\'); ?>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '            </span>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '        </h3>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), '</div>' )
");
echo "v--v\n";
echo "-- Rodape --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '<div class=\"container-fluid\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '    <div class=\"row\">        ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '        <div class=\"col-md-4\">    ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '            <blockquote>               ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                <p>Nós estamos interesados em ouvir você. Use este canal de comunicação para sugerir, elogiar, reclamar' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    e dizer o que você pensa sobre nossos serviços e nossa maneira de atendê-lo. Nós iremos ler sua' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    mensagem e responder em até 5 dias úteis!</p>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                <footer>A direção</footer>                            ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '            </blockquote>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '        </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '        <div class=\"col-md-8\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '            <div class=\"jumbotron\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                <form action=\"/formresult\" method=\"get\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    <div class=\"form-group\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <label class=\"control-label\" for=\"nome\">Nome:</label>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <input class=\"form-control\" id=\"nome\" name=\"nome\" type=\"text\"/>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    <div class=\"form-group\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <label class=\"control-label\" for=\"email\">Email:</label>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <input class=\"form-control\" id=\"email\" name=\"email\" type=\"email\"/>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    <div class=\"form-group\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <label class=\"control-label\" for=\"assunto\">Assunto:</label>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <input class=\"form-control\" id=\"assunto\" name=\"assunto\" type=\"text\"/>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    <div class=\"form-group\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <label class=\"control-label\" for=\"mensagem\">Mensagem:</label>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <textarea class=\"form-control\" id=\"mensagem\" rows=5 name=\"mensagem\"></textarea>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    <div class=\"form-group\">' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                        <button class=\"btn btn-primary \" name=\"submit\" type=\"submit\">Enviar</button>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                    </div>' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '                </form> ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '            </div>  ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '        </div> ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '    </div>  ' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), '</div>' )
");
echo "v--v\n";
echo "-- Contato --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '<div class=\"container-fluid\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '    <div class=\"row\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        <div class=\"col-md-2\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '                <span class=\"text-info\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '                    <p>Agradecemos seu contato!</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '                </span>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        <div class=\"col-md-8\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '            <?php if (strlen(\$_GET[\'nome\']) != 0) { echo \"<h3>Prezado \" . \$_GET[\'nome\'] . \"</h3>\";  } else {  echo \"<h3>Erro no parametro Nome</h3>\"; } ?>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '            <?php if (strlen(\$_GET[\'email\']) != 0 && strlen(\$_GET[\'assunto\']) != 0) { echo \"<h4>Recebemos seu contato para o email:\" . \$_GET[\'email\'] . \"</br> para o assunto: \" . \$_GET[\'assunto\'] . \".</h4>\"; } else { echo \"<h4>Erro no parametro Email ou Assunto</h4>\"; } ?>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '            <?php if (strlen(\$_GET[\'mensagem\']) != 0) { echo \"<span class=\"text-warning\"><p>Em breve trataremos da sua mensagem: </p></span><span class=\"text-justify\">\" . \$_GET[\'mensagem\'] . \"</p> </span>\"; } else { echo \"<p>Erro no parametro Mensagem</p>\"; } ?>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        <div class=\"col-md-2 text-info\">' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '            <p>Sua mensagem será lida e tratada em até 5 dias úteis!</p>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '        </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '    </div>' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='formresult'), '</div>' )
");
echo "v--v\n";
echo "-- formresult --\n";
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";


echo "Validando Rotas\n";
$smt = $conn->prepare("Select * from rotas");
$smt->execute();
$result = $smt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $value) {
    echo $value['rota'] . " - " . $value['arquivo'] . "\n";
}

echo "Validando Paginas\n";
$smt = $conn->prepare("Select * from paginasHTML");
$smt->execute();
$result = $smt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $value) {
    echo $value['rotas_arquivo'] . " - " . $value['linhaHTML'] . "\n";
}


echo "#### Concluido ####\n";
