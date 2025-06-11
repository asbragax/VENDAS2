<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fa fa-user'></i> MINHAS INFORMAÇÕES
    </h1>
</div>

<?php
$dao = new UserDAO();
$user = $dao->getPorId($_SESSION['id']);

//ALTERA SENHA
if (isset($_POST['senhaatual'])) {
    if (password_verify($_POST['senhaatual'], $_SESSION['senha'])) {
        $dao = new UserDAO();
        $newpw = password_hash($_POST['novasenha'], PASSWORD_DEFAULT);
        $altera = $dao->alteraSenha($_SESSION['id'], $newpw);
        if ($altera) { ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Parabéns!</strong> Sua senha foi alterada com sucesso.
            </div>
        <?php
            $_SESSION['senha'] = $newpw;
        } else { ?>
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Atenção!</strong> Ocorreu um erro durante a operação, tente novamente mais tarde.
            </div>
        <?php }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Oh não!</strong> Parece que a senha informada não combina com a sua senha atual.
        </div>
    <?php
    }
}

//ALTERA AVATAR
if (isset($_POST['imagem'])) {
    $dao = new UserDAO();
    $altera = $dao->alteraAvatar($_SESSION['id'], $_POST['imagem']);

    if ($altera) { ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Parabéns!</strong> Seu avatar foi alterado com sucesso.
        </div>
    <?php
        $_SESSION['img'] = $_POST['imagem'];
    } else { ?>
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Atenção!</strong> Ocorreu um erro durante a operação, tente novamente mais tarde.
        </div>
<?php }
}

?>
<style>
    input[type="radio"].fam {
        display: none;

        &:not(:disabled)~label {
            cursor: pointer;
        }

        &:disabled~label {
            color: hsla(150, 5%, 75%, 1);
            border-color: hsla(150, 5%, 75%, 1);
            box-shadow: none;
            cursor: not-allowed;
        }
    }

    label.fam {
        width: 59px;
        height: 59px;
        display: inline-block;
        background: white;
        border: 2px solid #252525;
        border-radius: 50%;
        margin-bottom: 1px;
        /*margin: 1rem;*/

        box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
        position: relative;
    }

    input[type="radio"].fam:checked+label {
        background: #ef9c00;
        color: hsla(215, 0%, 100%, 1);
        -webkit-box-shadow: 0px 1px 28px 10px rgba(121, 106, 238, 1);
        -moz-box-shadow: 0px 1px 28px 10px rgba(121, 106, 238, 1);
        box-shadow: 0px 1px 28px 10px rgba(121, 106, 238, 1);

        &::after {
            color: hsla(215, 5%, 25%, 1);
            border: 2px solid hsla(225, 76%, 49%, 1);
            content: "\f00c";
            font-size: 24px;
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 55px;
            height: 55px;
            line-height: 50px;
            border-radius: 70%;
            background: white;
        }
    }
</style>
<div class="row">
    <div class="col-lg-4 col-xl-3 order-lg-1 order-xl-1">
        <!-- profile summary -->
        <div class="card mb-g rounded-top">
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        <img src="../assets_coloradmin/img/avatares/<?php echo $user['img']; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="" style="max-height: 100px">
                        <h5 class="mb-0 fw-700 text-center mt-3">
                            <?php echo $user['nome']; ?>
                            <small class="text-muted mb-0">Nível <?php echo $user['nivel']; ?></small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-xl-6 order-lg-1 order-xl-1">
        <!-- profile summary -->
        <div class="card mb-g rounded-top">
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                        <li class="nav-item">
                            <a href="#profile-timeline" data-bs-toggle="tab" role="tab" class='nav-link active'>Resetar senha</a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-about" data-bs-toggle="tab" role="tab" class='nav-link'>Alterar avatar</a>
                        </li>
                    </ul>
                    <div id="pillContent3" class="tab-content border border-top-0 p-3">
                        <div class="tab-pane show active" id="profile-timeline">
                            <form class="form-signup form-horizontal" id="editsenha" name="editsenha" method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-11 col-sm-offset-1">
                                        <article>
                                            <div class="card card-comment">
                                                <div class="card-body">
                                                    <form class="form-horizontal">
                                                        <div class="form-group mb-3 is-empty">
                                                            <label for="senhaatual" class="col-md-3 control-label">Senha
                                                                atual</label>
                                                            <div class="col-md-7">
                                                                <input type="password" class="form-control border-primary" name="senhaatual" id="senhaatual" placeholder="Senha atual" autocomplete="false">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3 is-empty">
                                                            <label for="novasenha" class="col-md-3 control-label">Nova
                                                                senha</label>
                                                            <div class="col-md-7">
                                                                <input type="password" class="form-control border-primary" name="novasenha" id="novasenha" placeholder="Nova senha" autocomplete="false">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3 is-empty">
                                                            <label for="novasenha2" class="col-md-3 control-label">Repita
                                                                a senha</label>
                                                            <div class="col-md-7">
                                                                <input type="password" class="form-control border-primary" name="novasenha2" id="novasenha2" placeholder="Repita a senha" autocomplete="false">
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="card-footer  p-10 text-end">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-round"><i class="fa fa-save"></i>
                                                        Alterar</button>
                                                </div>

                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="profile-about">
                            <form class="form-signup form-horizontal" id="editavatar" name="editavatar" method="post">
                                <div class="card-body p-t-0">
                                    <h3 class="card-title">Masculinos</h3>
                                    <?php for ($i = 35; $i <= 64; $i++) { ?>
                                        <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem" value="<?php echo $i; ?>">
                                        <label class="fam" for="fam<?php echo $i; ?>">
                                            <img src="../assets_coloradmin/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                        </label>
                                    <?php } ?>

                                    <h3 class="card-title mt-2">Femininos</h3>
                                    <?php for ($i = 1; $i <= 30; $i++) { ?>
                                        <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem" value="<?php echo $i; ?>">
                                        <label class="fam" for="fam<?php echo $i; ?>">
                                            <img src="../assets_coloradmin/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                        </label>
                                    <?php } ?>
                                </div>

                                    <div class="card-footer p-10 text-end">
                                        <button type="submit" class="btn btn-lg btn-primary btn-round"><i class="fa fa-save"></i> Alterar</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
