<!-- BEGIN #header -->
<div id="header" class="app-header">
    <!-- BEGIN navbar-header -->
    <div class="navbar-header">
        <a href="index.php" class="navbar-brand"><span class="navbar-logo"></span> <b>GK</b> Admin</a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- END navbar-header -->
    <!-- BEGIN header-nav -->
    <div class="navbar-nav">
        <div class="navbar-item dropdown">
            <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
                <i class="fa fa-bell"></i>
                <span class="badge"><?php echo count($contas); ?></span>
            </a>
            <div class="dropdown-menu media-list dropdown-menu-end" style="max-height: 90vh !important; overflow-y: auto">
                <div class="dropdown-header"><?php echo count($contas); ?> Notificações</div>
                <?php 
                $dao = new ApagarDAO();
                for ($i = 0; $i < count($contas); $i++) { 
                    if($PAGAR_CONTAS_AO_VENCER == 1 && $contas[$i]['vencimento'] <= date("Y-m-d")){
                        $dao->pagar_prestacao($contas[$i]['id_parcela'], 2, 1, $contas[$i]['vencimento'], '', 1 );
                    }else{
                    ?>
                    <a href="?pagApagar=<?php echo $contas[$i]['id_parcela']; ?>" class="dropdown-item media">
                        <div class="media-left">
                            <i class="fa fa-dollar-sign media-object bg-gray-500"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading"><?php echo $contas[$i]['nome']; ?> <i class="fa fa-exclamation-circle text-danger"></i></h6>
                            <h6 class="media-heading"><?php echo $contas[$i]['nome_fornecedor']; ?></h6>
                            <div class="text-muted fs-10px"><?php echo $contas[$i]['vencimentof']; ?></div>
                        </div>
                    </a>
                <?php } } ?>
            </div>
        </div>
        <?php if($_SESSION['nivel'] >= 4){ ?>
            <div class="navbar-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
                    <i class="fa fa-lock"></i>
                </a>
                <div class="dropdown-menu media-list dropdown-menu-end">
                    <div class="dropdown-header">Status do sistema</div>
                    <div class="form-check form-switch my-3 ms-2">
                        <input type="checkbox" class="form-check-input btn btn-switch system_status" id="system_status" name="system_status" value="1" <?php echo $NAOPAGOU == 1 ? "checked" : ""; ?>>
                        <label class="form-check-label" for="system_status">BLOQUEADO</label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img src="../assets_coloradmin/img/avatares/<?php echo $_SESSION['img']; ?>.jpg" alt="" /> 
                <span>
                    <span class="d-none d-md-inline"><?php echo $_SESSION['nome']; ?></span>
                    <b class="caret"></b>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a href="?profile" class="dropdown-item">Editar perfil</a>
                <?php if($_SESSION['nivel'] >= 3){ ?>
                    <a href="?consUser" class="dropdown-item">Usuários</a>
                <?php } ?>
                <?php if($_SESSION['nivel'] >= 4){ ?>
                    <a href="?consNivel" class="dropdown-item">Níveis</a>
                    <a href="?acesso" class="dropdown-item">Log de acesso</a>
                <?php } ?>
                <div class="dropdown-divider"></div>
                <a href="components/login/action/logout.php" class="dropdown-item">Sair</a>
            </div>
        </div>
    </div>
    <!-- END header-nav -->
</div>
<!-- END #header -->
