<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fa fa-user-plus'></i> NOVO USUÁRIO
    </h1>
    <div class="subheader-block">
        <a href="?consUser" class="btn btn-info btn-pills">Ver usuários</a>
    </div>
</div>

<?php

if (isset($_SESSION['username'])) {
    session_start();
}

// include("action/listar_membro.php");
include "components/login/action/listar_nivel.php";


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
<div class="flex-1" style="background: url(assets/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
        <form id="usersignup" name="usersignup" method="post" action="components/login/action/createuser.php">
            <div class="row">
                <div class="col-sm-6 ml-auto me-auto">
                    <div class="card p-4 rounded-plus bg-faded">

                        <div class="form-group mb-3 row">
                            <label class="col-xl-12 form-label" for="fname">Nome</label>
                            <div class="col-12 pr-1">
                                <input name="nome" id="nome" type="text" class="form-control border-primary" placeholder="Nome">
                                <div class="invalid-feedback">No, you missed this one.</div>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="col-xl-12 form-label" for="fname">Senha</label>
                            <div class="col-6 pr-1">
                                <input name="password1" id="password1" type="password" class="form-control border-primary" placeholder="Senha">
                                <div class="invalid-feedback">No, you missed this one.</div>
                            </div>
                            <div class="col-6 pl-1">
                                <input name="password2" id="password2" type="password" class="form-control border-primary" placeholder="Repita a senha">
                                <div class="invalid-feedback">No, you missed this one.</div>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-6 pr-1">
                                <label class="form-label">
                                    Nível
                                </label>
                                <select class="select2-placeholder form-control" id="nivel" name="nivel">
                                    <option></option>
                                    <?php for ($i = 0; $i < count($listaNivel); $i++) { 
                                        if($listaNivel[$i]['id'] <= $_SESSION['nivel']) {?>
                                        <option value="<?php echo $listaNivel[$i]["id"]; ?>">
                                            <?php echo $listaNivel[$i]["nome"]; ?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-6 pl-1">
                                <label class="form-label">
                                    Usuário
                                </label>
                                <input name="newuser" id="newuser" type="text" class="form-control border-primary" placeholder="Usuário">
                                <div class="invalid-feedback">No, you missed this one.</div>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-12 pl-1">
                                <label class="form-label">
                                    E-mail
                                </label>
                                <input name="email" id="email" type="email" class="form-control border-primary" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-md-4 ml-auto text-end">
                                <button name="Submit" id="submit" type="submit" class="btn btn-info">Salvar</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 ml-auto me-auto">
                    <div class="card p-4 rounded-plus bg-faded" style="display:block">
                        <h3 class="card-title mt-2">Masculinos</h3>
                        <?php for ($i = 35; $i <= 64; $i++) { ?>
                            <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem" value="<?php echo $i; ?>">
                            <label class="fam" for="fam<?php echo $i; ?>">
                                <img src="assets/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle img-thumbnail shadow-2" alt="">
                            </label>
                        <?php } ?>
                        <h3 class="card-title mt-2">Femininos</h3>
                        <?php for ($i = 1; $i <= 30; $i++) {?>
                        <input type="radio" class="fam" id="fam<?php echo $i; ?>" name="imagem"
                            value="<?php echo $i; ?>">
                        <label class="fam" for="fam<?php echo $i; ?>">
                            <img src="assets/img/avatares/<?php echo $i; ?>.jpg" class="rounded-circle shadow-2 img-thumbnail" alt="">
                        </label>
                        <?php }?>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('.select2-placeholder').select2({
            placeholder: "Selecione...",
            allowClear: true
        });
        $(":input").inputmask();
    });
</script>
