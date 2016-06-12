<?php
require_once "conexaoDB.php";

echo "#### Executando Fixture ####\n";
$conn = conexaoDB();

echo "Removendo tabelas\n";
try {
    $conn->query("DROP TABLE IF EXISTS paginasHTML, formsHTML, rotas");
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
              taginicial VARCHAR(10) CHARACTER SET utf8,
              tagfinal VARCHAR(10) CHARACTER SET utf8,
              linhaHTML TEXT CHARACTER SET utf8,
                  CONSTRAINT fk_arquivo
                  FOREIGN KEY (rotas_arquivo)
                  REFERENCES rotas(arquivo)
                  ON DELETE CASCADE)
                  ");
} catch (\PDOException $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "Criando tabela formularios \n";
try {
    $conn->query("CREATE TABLE formsHTML (
              rotas_arquivo VARCHAR(45) CHARACTER SET utf8,
              form_campo VARCHAR(45) CHARACTER SET utf8,
              form_label VARCHAR(45) CHARACTER SET utf8,
              form_tipo VARCHAR(10) CHARACTER SET utf8,
              form_action VARCHAR(450) CHARACTER SET utf8,
                  CONSTRAINT fk_form_arquivo
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
$arr_rotas = ['Home' => 'home', 'Empresa' => 'empresa', 'Produtos' => 'produtos', 'Servicos' => 'servicos'];
echo "Inserindo dados na rota\n";
foreach ($arr_rotas as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'P')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

// Array de rotas de formularios
$arr_forms = ['Contato' => 'contato'];
echo "Inserindo dados na rota\n";
foreach ($arr_forms as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'F')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

// Array de rotas válidas para resposta (resposta de formulário de contato, p.ex.)
$arr_response = ['formresult' => 'formresult', 'rodape' => 'rodape'];
foreach ($arr_response as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'R')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

// Array de rotas válidas para resposta de busca
$arr_response = ['busca' => 'busca'];
foreach ($arr_response as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'B')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}


echo "Inserindo paginas html\n";
$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, taginicial, tagfinal, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Empresa'), 'p', '/p',  'Nossa empresa iniciou seus trabalhos em 1980, com alta tecnologia, voltada para o crescimento sustentável a longo prazo.' )
");
echo "v--v\n";
echo "-- Empresa --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, taginicial, tagfinal, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), 'p', '', 'Nossos produtos são da mais alta qualidade!' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Produtos'), '', '/p', 'e toda nossa linha está ao seu dispor para você e sua família.' )
");
echo "v--v\n";
echo "-- Produtos --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, taginicial, tagfinal, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Servicos'), 'p', '/p', 'Temos serviços adequados a sua realidade!' )
");
echo "v--v\n";
echo "-- Servicos --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, taginicial, tagfinal, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Home'), 'p', '/p', 'Página inicial, a.k.a., Home.' )
");
echo "v--v\n";
echo "-- Home --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";

$smt = $conn->query("
INSERT INTO glicolog.paginasHTML (rotas_arquivo, taginicial, tagfinal, linhaHTML) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), 'h3', '', 'Todos os direitos reservados - ' ),
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='rodape'), 'data', '/h3', 'Y' )
");
echo "v--v\n";
echo "-- Rodape --\n";
echo $conn->errorCode();
echo "\n";
print_r($conn->errorInfo());
echo "\n";
echo "^--^\n";


$smt = $conn->query("
INSERT INTO glicolog.formsHTML (rotas_arquivo, form_campo, form_label, form_tipo, form_action) VALUES
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), null, null, 'A', 'formresult' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), null, null, 'T', 'Nós estamos interesados em ouvir você. Use este canal de comunicação para sugerir, elogiar, reclamar e dizer o que você pensa sobre nossos serviços e nossa maneira de atendê-lo. Nós iremos ler sua mensagem e responder em até 5 dias úteis!' ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), 'nome', 'Nome:', 'text', null ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), 'email', 'Email:', 'email', null ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), 'assunto', 'Assunto:', 'text', null ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), 'mensagem', 'Mensagem:', 'text', null ) ,
( (SELECT arquivo from glicolog.rotas WHERE rotas.rota ='Contato'), 'submit', 'Enviar', 'botao', null )
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
