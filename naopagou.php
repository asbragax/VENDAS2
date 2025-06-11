<?php
$var = explode(".php", $_SERVER['HTTP_REFERER']);
if ($var[1] == '') {
    $path = 'index.php';
} else {
    $path = $var[1];
}
?>
<div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
    <div class="alert alert-danger bg-white pt-4 pr-5 pb-3 pl-5" id="demo-alert">
        <h1 class="fs-xxl fw-700 color-fusion-500 d-flex align-items-center justify-content-center m-0">
            <img class="profile-image-lg rounded-circle mr-1 p-1" width="60px" src="../assets_coloradmin/img/logo/logo.png">
            <span class="color-danger-700">Sistema indisponível</span>
        </h1>
        <h3 class="fw-500 mb-0 mt-3">
            Parece que o sistema está indisponível para essa empresa no momento.
        </h3>
        <p class="container container-sm mb-0 mt-1">
            WhatsApp: (31) 98877-8860
        </p>
        <p class="container container-sm mb-0 mt-1">
           E-mail: andre@geeksistemas.com.br
        </p>
        <div class="mt-4">
            <a href="<?php echo $path; ?>" class="btn btn-info">
                <i class="fa fa-arrow-left"></i><span class="fw-700"> VOLTAR</span>
            </a>
            <a href="index.php" class="btn btn-primary">
                <i class="fa fa-home"></i><span class="fw-700"> INÍCIO</span>
            </a>
        </div>
    </div>
</div>