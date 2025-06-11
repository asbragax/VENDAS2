<!-- BEGIN Left Aside -->
<div id="sidebar" class="app-sidebar">
   <!-- BEGIN scrollbar -->
   <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                            <?php echo $_SESSION['nome']; ?>
                            </div>
                            <div class="menu-caret ms-auto"></div>
                        </div>
                        <small><?php echo $EMPRESA_REDUZIDO; ?></small>
                    </div>
                </a>
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
                <div class="menu-item pt-5px">
                    <a href="?profile" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-cog"></i></div>
                        <div class="menu-text">Perfil</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>

        <?php include_once('includes/menu.php'); ?>
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar -->