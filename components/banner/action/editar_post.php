<?php

if (isset($_POST['nome'])) {
    $servico = new Servico();
    $dao = new ServicoDAO();

    $servico->setId($_POST['id']);
    $servico->setNome($_POST['nome']);

    $valorexp = explode("$ ", $_POST['valor']);
    $valor1 = str_replace('.', '', $valorexp[1]);
    $valor = 100 * str_replace(',', '.', $valor1);

    $servico->setValor($valor);

    $servico->setPorcentagem($_POST['porcentagem']/100);

    $gravou = $dao->alterar($servico);

    if ($gravou) {?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    Alterado com <strong>sucesso!</strong> Serviço: <?php echo $servico->getNome(); ?>
</div>
<?php
} else {
        ?>
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    Um <strong>erro</strong> aconteceu, tente novamente por favor!
</div>
<?php
}
}
?>