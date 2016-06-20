<?php

function geraPaginaConteudo($sqlresult)
{
    if (isset($sqlresult)) {
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '<div class="col-md-8">';
        echo '<div class="jumbotron">';

        foreach ($sqlresult as $linhas) {
            $cmdAlt = $linhas['comandoAlt'];
            $linhaHT = $linhas['linhaHTML'];
            switch ($cmdAlt) {
                case "data":
                    if (count($cmdAlt) > 0 and !empty($cmdALt)) {
                        echo "<$cmdAlt>";
                    }
                    $varData = $linhaHT;
                    echo date($varData);
                    break;
                default:
                    if (count($linhaHT) > 0 and !empty($linhaHT)) {
                        echo $linhaHT;
                    }
                    break;
            }
        }

        echo '</div>';
        echo '</div>';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

function geraFormulario($form_acao, $form_botoes, $form_texto, $form_campos)
{
    echo '<div class="container-fluid">';
    echo '<div class="row">';
    echo '<div class="col-md-4">';
    if (isset($form_texto)) {
        echo '<blockquote>';
        echo '<p>' . $form_texto['form_action'] . '</p>';
        echo '</blockquote>';
    } else {
        echo '<p> Por favor, preencha o formulário! </p>';
    }
    echo '</div>';

    if (isset($form_acao)) {
        echo '<div class="col-md-8">';
        echo '<div class="jumbotron">';
        printf('<form action="/%s" method="get">', $form_acao['form_action']);
    } else {
        echo '<p> Erro na configuração do Formulário </p>';
    }

    if (isset($form_campos)) {
        foreach ($form_campos as $key => $value) {
            echo '<div class="form-group">';
            printf('<label class="control-label" for="%s">%s</label>', $form_campos[$key]['form_campo'], $form_campos[$key]['form_label']);
            printf('<input class="form-control" id="%s" name="%s" type="%s"/>', $form_campos[$key]['form_campo'], $form_campos[$key]['form_campo'], $form_campos[$key]['form_tipo']);
            echo '</div>';
        }
    } else {
        echo '<p> Formulário não tem campos definidos!</p>';
    }
    if (isset($form_botoes)) {
        foreach ($form_botoes as $key => $value) {
            echo '<div class="form-group">';
            printf('<button class="btn btn-primary" name="%s" type ="%s">%s</button>', htmlspecialchars($form_botoes[$key]['form_campo']), $form_botoes[$key]['form_campo'], $form_botoes[$key]['form_label']);
            echo '</div>';
        }
    } else {
        echo '<p> Formulário não tem campos definidos!</p>';
    }
    if (isset($form_acao)) {    // Fecha o FORM ao fim do formulário, caso tenha sido criado lá em cima
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';

}


function geraRodape($sqlresult)
{
    if (isset($sqlresult)) {
        echo '<div class="container-fluid">';
        echo '<div class="row-fluid">';

        foreach ($sqlresult as $linhas) {
            $cmdAlt = $linhas['comandoAlt'];
            $linhaHT = $linhas['linhaHTML'];
            switch ($cmdAlt) {
                case "data":
                    if (count($cmdAlt) > 0 and !empty($cmdAlt)) {
                        echo "<$cmdAlt>";
                    }
                    $varData = $linhaHT;
                    echo date($varData);
                    break;
                default:
                    if (count($linhaHT) > 0 and !empty($linhaHT)) {
                        echo $linhaHT;
                    }
            }
        }
        echo '</div>';
        echo '</div>';
    }
}

function geraResposta($responseGet)
{
    if (isset($responseGet)) {
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '<div class="col-md-8">';
        echo '<div class="jumbotron">';
        echo '<p>Recebemos com exito as seguintes informações. Seus dados serão analisados e responderemos em até 5 dias úteis</p>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Campo</th>';
        echo '<th>Dado</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($responseGet as $key => $value) {
            if (!empty($key) and !empty($value)) {
                echo '<tr>';
                printf('<td>%s</td><td>%s</td>', $key, $value);
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
        echo '<a href="/home">Voltar para Home</a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    } else {
        echo '<p> Nenhum dado recebido. Avalie o preenchimento do formulario.</p>';
    }

}

function geraResultadoBusca($sqlresult, $textobusca)
{
    if (empty($sqlresult)) {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Não foram encontrados resultados para: <b>' . $textobusca . '</b>.</div>';
    } else {
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Resultado da Pesquisa</div>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Página</th>';
        echo '<th>Linha</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($sqlresult as $searchresult) {
            echo '<tr>';
            echo '<td><li><a href="' . $searchresult['rotas_arquivo'] . '">' . $searchresult['rotas_arquivo'] . '</a></td><td>' . $searchresult['linhaHTML'] . '</td></li>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}

function geraFormEscolhePaginaParaEditar($sqlresult)
{
    if (empty($sqlresult)) {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Não foi encontrada a página para editar!</div>';
    } else {
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>'; // col-md-2
        echo '<div class="col-md-8">';
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Páginas para Edição</div>';
        echo '<div class="panel-body">';
        echo '<form class="form" role="form" id="optaEdita" action="/ckedit" method="GET">';
        echo '<div class="control-group">';
        echo '<div class="controls">';
        foreach ($sqlresult as $rota_menu) {
            echo '<div class="radio">';
            echo '<label>' . '<input type="radio" name="editSelect" id="' . $rota_menu['arquivo'] . '" value="' . $rota_menu['arquivo'] . '">' . $rota_menu['rota'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '<input class="btn btn-primary" type="submit" value="Edita página selecionada!"/>';
        echo '</form>';
        echo '</div>'; // panel-body
        echo '</div>'; // col-md-8
        echo '<div class="col-md-2">';
        echo '</div>'; // col-md-2
        echo '</div>';
        echo '</div>';
    }
    echo '</div>'; // panel-heading ou row
    echo '</div>'; // panel-default ou container-fluid
}

function geraFormComCkeditor($sqlresult, $paginaSelecionada)
{
    if (empty($sqlresult)) {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">A consulta não trouxe resultados!</div>';
    } else {
        echo '<br>' . 'sqlresult';
        $conteudo = $sqlresult['linhaHTML'];
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>'; // col-md-2
        echo '<div class="col-md-8">';
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">Edite a página selecionada e clique em Gravar ao final da Edição.</div>';
        echo '<div class="panel-body">';
        echo '<form class="navbar - form navbar - left" role="gravar" action="/gravar" method="POST">';
        echo '<input type="text" class="form-control" name="paginaSelecionada" value="' . $paginaSelecionada  . '" readonly>';
        echo '<div class="form - group">';
        echo '<textarea name="editor1">' . $conteudo . '</textarea>';
        echo '</div>';
        echo '<br>';
        echo '<button type="submit" class="btn btn -default">Gravar</button>';
        echo '</form>';
        echo '</div>'; // panel-body
        echo '</div>'; // panel-default
        echo '</div>'; // col-md-8
        echo '<div class="col-md-2">';
        echo '</div>'; // col-md-2
    }
    echo '</div>'; // panel-heading ou row
    echo '</div>'; // panel ou container-fluid
}