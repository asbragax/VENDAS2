
<?php
include "components/banner/action/cadastrar_post.php";
?>
<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Novo banner</h4>
    <a href="?consPost" class="btn btn-primary btn-sm">Ver banners</a>
  </div>
  <div class="panel-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" role="form">
            <div class="row">

                <div class="form-group col-sm-6">
                    <label class="form-label">Texto</label>
                    <textarea class="form-control" autofocus name="texto" id="texto"></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Imagem</label>
                    <input type="file" name="arquivo" id="arquivo" class="form-control">
                </div>

                <div class="col-sm-12 text-end">
                    <button type="submit" class="btn btn-md btn-primary" name="salvar">
                        <i class="fa fa-save mr-1"></i>Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>