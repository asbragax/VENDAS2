<?php include_once('components/conta/action/cadastrar_pagamento.php'); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Nova forma de pagamento</h4>
        <a href="?consPagamento" class="btn btn-primary btn-sm">Ver formas de pagamento</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control border-primary" name="nome" required autofocus>
                </div>
            </div>
            <div class="col-sm-12 text-end mt-2 px-0">
                <button type="submit" class="btn btn-success float-end" name="salvar">
                    <span class="fa fa-save me-1"></span>
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>