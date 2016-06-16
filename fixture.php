<?php
require_once "conexaoDB.php";

echo "#### Executando Fixture ####\n";
$conn = conexaoDB();

echo "Removendo tabelas\n";
try {
    $conn->query("DROP TABLE IF EXISTS paginasHTML, formsHTML, rotas, usuarios");
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

echo "Criando tabela usuarios \n";
try {
    $conn->query("CREATE TABLE usuarios (
              id BIGINT NOT NULL AUTO_INCREMENT,
              usuario VARCHAR(45) CHARACTER SET utf8,
              senha VARCHAR(255) CHARACTER SET utf8,
              tipo CHAR CHARACTER SET utf8,
                  PRIMARY KEY (id)
                  )");
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

// Array de rotas válidas para pagina administrativa
$arr_response = ['Editar' => 'editar'];
foreach ($arr_response as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'E')");
    $smt->bindParam(":rota", $rota);
    $smt->bindParam(":arquivo", $arquivo);
    $smt->execute();
}

// Array de rotas válidas para edição propriamente dita com CkEditor
$arr_response = ['CkEdit' => 'ckedit'];
foreach ($arr_response as $rota => $arquivo) {
    $smt = $conn->prepare("INSERT INTO rotas (rota, arquivo, tipo) value (:rota, :arquivo, 'C')");
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

$arr_usuarios = ['admin' => 'admin', 'wfilho' => 'wfilho' ];

echo "Inserindo dados de usuarios\n";
foreach ($arr_usuarios as $usuario => $senhaU) {
    echo "\nUsuario:" . $usuario;
    echo "\nSenha  :" . $senhaU;
    $senhaMod = password_hash($senhaU, PASSWORD_DEFAULT);
    if ($usuario == 'admin') {
        $tipouser = 'A';
    } else {
        $tipouser = 'U';
    }
    $smt = $conn->prepare("INSERT INTO usuarios (usuario, senha, tipo) value (:user, :passwd, :tipoU)");
    $smt->bindParam(":user", $usuario);
    $smt->bindParam(":passwd", $senhaMod);
    $smt->bindParam(":tipoU", $tipouser);
    $smt->execute();
}

echo "\nv--v\n";
echo "-- usuarios --\n";
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

echo "Validando Usuarios\n";
$smt = $conn->prepare("Select * from usuarios");
$smt->execute();
$result = $smt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $value) {
    echo $value['usuario'] . " - " . $value['senha'] . " : " . $value['tipo'] . "\n";
}



echo "#### Concluido ####\n";
