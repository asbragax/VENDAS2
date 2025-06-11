
                    <div class="subheader">
                        <h1 class="subheader-title">
                            <i class='subheader-icon fa fa-users'></i> USUÁRIOS
                        </h1>
                        <div class="subheader-block">
                            <a href="?cadUser" class="btn btn-success btn-pills">Novo usuário</a>
                        </div>
                    </div>

<?php
include "components/login/action/listar_nivel.php";

$dao = new UserDAO();

$id = $_GET['edtUser'];
$user = $dao->getPorId($id);

//ALTERA SENHA
if (isset($_POST['novasenha']) && isset($_POST['novasenha2'])) {

    $dao = new UserDAO();
    $newpw = password_hash($_POST['novasenha'], PASSWORD_DEFAULT);
    $altera = $dao->alteraSenha($user['id'], $newpw);
    if ($altera) {?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <strong>Parabéns!</strong> A senha foi alterada com sucesso.
</div>
<meta http-equiv="refresh" content="0;">
<?php
} else {?>
<div class="alert alert-warning" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <strong>Atenção!</strong> Ocorreu um erro durante a operação, tente novamente mais tarde.
</div>
<?php }
}

//ALTERA AVATAR
if (isset($_POST['imagem'])) {
    $dao = new UserDAO();
    $altera = $dao->alteraAvatar($user['id'], $_POST['imagem']);

    if ($altera) {?>
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <strong>Parabéns!</strong> O avatar foi alterado com sucesso.
    </div>
    <meta http-equiv="refresh" content="0;">
<?php
} else { ?>
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <strong>Atenção!</strong> Ocorreu um erro durante a operação, tente novamente mais tarde.
    </div>
<?php }
}
if (isset($_POST['nivel'])) {
    $dao = new UserDAO();
    $altera = $dao->alteraNivel($user['id'], $_POST['nivel']);

if ($altera) { ?>
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <strong>Parabéns!</strong> Nível de acesso alterado com sucesso.
    </div>
    <meta http-equiv="refresh" content="0;">
<?php
} else { ?>
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <strong>Atenção!</strong> Ocorreu um erro durante a operação, tente novamente mais tarde.
    </div>
<?php }

}
if (isset($_POST['novonome'])) {
    echo 1;
    $dao = new UserDAO();
    $altera = $dao->alterar($user['id'], $_POST['novonome'], $_POST['novousername']);

if ($altera) { ?>
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <strong>Parabéns!</strong> Nome e Username alterado com sucesso.
    </div>
    <meta http-equiv="refresh" content="0;">
<?php
} else { ?>
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
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
                    <div class="d-flex flex-column align-items-center justify-content-center p-4" >
                        <img src="../assets_coloradmin/img/avatares/<?php echo $user['img']; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="" style="max-height: 100px">
                        <h5 class="mb-0 fw-700 text-center mt-3">
                            <?php echo $user['nome']; ?>
                            <small class="text-muted mb-0"><?php echo $user['nivel']; ?></small>
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
                        <li class="nav-item">
                            <a href="#profile-level" data-bs-toggle="tab" role="tab" class='nav-link'>Alterar nível</a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-nome" data-bs-toggle="tab" role="tab" class='nav-link'>Alterar nome/username</a>
                        </li>
                    </ul>
                    <div id="pillContent3" class="tab-content border border-top-0 p-3">
                        <div class="tab-pane fade show active" id="profile-timeline">
                            <form class="form-signup form-horizontal" id="editsenha" name="editsenha" method="post">
                                    <div class="form-group mb-3 is-empty">
                                        <label for="novasenha"
                                            class="col-md-3 control-label">Nova
                                            senha</label>
                                        <div class="col-md-7">
                                            <input type="password"
                                                class="form-control border-primary"
                                                name="novasenha"
                                                id="novasenha"
                                                placeholder="Nova senha"
                                                autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 is-empty">
                                        <label for="novasenha2"
                                            class="col-md-3 control-label">Repita
                                            a senha</label>
                                        <div class="col-md-7">
                                            <input type="password"
                                                class="form-control border-primary"
                                                name="novasenha2"
                                                id="novasenha2"
                                                placeholder="Repita a senha"
                                                autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="card-footer  p-10 text-end">
                                        <button type="submit"
                                            class="btn btn-lg btn-primary btn-round"><i
                                                class="fa fa-save"></i>
                                            Alterar</button>
                                    </div>
                            </form>
                        </div>
                         <div class="tab-pane fade" id="profile-about">

                                <form class="form-signup form-horizontal" id="editavatar" name="editavatar" method="post">
                                    <div class="card-body p-t-0">
                                        <h3 class="card-title">Masculinos</h3>
                                        <?php for ($i = 35; $i <= 64; $i++) {?>
                                        <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem"
                                            value="<?php echo $i; ?>">
                                        <label class="fam" for="fam<?php echo $i; ?>">
                                            <img src="../assets_coloradmin/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                        </label>
                                        <?php }?>

                                        <h3 class="card-title mt-2">Femininos</h3>
                                        <?php for ($i = 1; $i <= 30; $i++) {?>
                                        <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem"
                                            value="<?php echo $i; ?>">
                                        <label class="fam" for="fam<?php echo $i; ?>">
                                            <img src="../assets_coloradmin/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                        </label>
                                        <?php }?>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-lg btn-primary btn-round"><i
                                                class="fa fa-save"></i> Alterar</button>
                                    </div>
                                </form>
                            </div>
                             <div class="tab-pane fade" id="profile-level">
                                <form class="form-signup form-horizontal" id="editlevel" name="editlevel" method="post">
                                    <div class="card-body p-t-0">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3">Nível de acesso</label>
                                            <div class="col-lg-9">
                                                <select class="form-control select" name="nivel" id="nivel">
                                                    <?php for ($i = 0; $i < count($listaNivel); $i++) {?>
                                                    <option value="<?php echo $listaNivel[$i]["id"]; ?>">
                                                        <?php echo $listaNivel[$i]["nome"]; ?>
                                                    </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-10 text-end">
                                        <button type="submit" class="btn btn-lg btn-primary btn-round"><i
                                                class="fa fa-save"></i> Alterar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile-nome">
                                <form class="form-signup form-horizontal" id="editnome" name="editnome" method="post">
                                    <div class="form-group mb-3 is-empty">
                                        <label for="novonome"
                                            class="col-md-3 control-label">Novo
                                            nome</label>
                                        <div class="col-md-7">
                                            <input type="text"
                                                class="form-control border-primary"
                                                name="novonome"
                                                id="novonome"
                                                value="<?php echo $user['nome']; ?>"
                                                autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 is-empty">
                                        <label for="novousername"
                                            class="col-md-3 control-label">Novo
                                            username</label>
                                        <div class="col-md-7">
                                            <input type="text"
                                                class="form-control border-primary"
                                                name="novousername"
                                                id="novousername"
                                                value="<?php echo $user['username']; ?>"
                                                autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="card-footer  p-10 text-end">
                                        <button type="submit" class="btn btn-lg btn-primary btn-round"><i class="fa fa-save"></i>
                                            Alterar
                                        </button>
                                    </div>
                            </form>
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
