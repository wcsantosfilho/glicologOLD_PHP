<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <blockquote>
                <p>Nós estamos interesados em ouvir você. Use este canal de comunicação para sugerir, elogiar, reclamar
                    e dizer o que você pensa sobre nossos serviços e nossa maneira de atendê-lo. Nós iremos ler sua
                    mensagem e responder em até 5 dias úteis!</p>
                <footer>A direção</footer>
            </blockquote>
        </div>
        <div class="col-md-8">
            <div class="jumbotron">
                <form action="/formresult" method="get">
                    <div class="form-group">
                        <label class="control-label" for="nome">Nome:</label>
                        <input class="form-control" id="nome" name="nome" type="text"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input class="form-control" id="email" name="email" type="email"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="assunto">Assunto:</label>
                        <input class="form-control" id="assunto" name="assunto" type="text"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="mensagem">Mensagem:</label>
                        <textarea class="form-control" id="mensagem" rows=5 name="mensagem"></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary " name="submit" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

