<div class="container-fluid">

    <div class="row">
        <div class="col-md-2">
                <span class="text-info">
                    <p>Agradecemos seu contato!</p>
                </span>
        </div>
        <div class="col-md-8">
            <?php if (strlen($_GET["nome"]) != 0) {
                echo "<h3>Prezado " . $_GET["nome"] . "</h3>";
            } else {
                echo "<h3>Erro no parametro Nome</h3>";
            } ?>
            <?php if (strlen($_GET["email"]) != 0 && strlen($_GET["assunto"]) != 0) {
                echo "<h4>Recebemos seu contato para o email:" . $_GET["email"] . "</br> para o assunto: " . $_GET["assunto"] . ".</h4>";
            } else {
                echo "<h4>Erro no parametro Email ou Assunto</h4>";
            } ?>
            <?php if (strlen($_GET["mensagem"]) != 0) {
                echo '<span class="text-warning">
                    <p>Em breve trataremos da sua mensagem: </p>
                </span>
                <span class="text-justify">' .
                    $_GET["mensagem"] . '</p>
            </span>';
            } else {
                echo "<p>Erro no parametro Mensagem</p>";
            } ?>
        </div>
        <div class="col-md-2 text-info">
            <p>Sua mensagem será lida e tratada em até 5 dias úteis!</p>
        </div>
    </div>
</div>
