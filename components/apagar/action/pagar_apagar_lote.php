<?php
if (isset($_POST['cad-pag-lote'])) {
        $pagdao = new ApagarDAO();
        
        $ids = explode("&", $_POST['ids_parcelas']);
        for ($i=0; $i < count($ids); $i++) { 
            // $parcela = $pagdao->getPorIdParcela($ids[$i]);
            $pagou = $pagdao->pagar_prestacao($ids[$i], 2, $_POST['pag-forma_pag'], $_POST['data-lote'], '', 1);
            // echo $ids." ".$forma." ".$_POST['pag-lote-banco']." ".$_POST['data-lote']."<br>";
        }
    
            
    
        if ($pagou) { ?>
            <div class="alert border-faded bg-transparent text-secondary fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon">
                        <span class="icon-stack icon-stack-md">
                            <i class="base-7 icon-stack-3x color-success-600"></i>
                            <i class="fal fa-check icon-stack-1x text-white"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <span class="h5 color-success-600">Conta(s) paga!</span>
                        <br>

                    </div>

                </div>
            </div>
            <meta http-equiv="refresh" content="0;">
        <?php
                } else { ?>
            <div class="alert border-danger bg-transparent text-secondary fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="alert-icon">
                        <span class="icon-stack icon-stack-md">
                            <i class="base-7 icon-stack-3x color-danger-900"></i>
                            <i class="fal fa-times icon-stack-1x text-white"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <span class="h5 color-danger-900">Parece que alguma coisa deu errado... </span>
                    </div>
                    <a href="http://geeksistemas.com.br/#contact" target="_blank" class="btn btn-outline-danger btn-sm btn-w-m">Reportar</a>
                </div>
            </div>
<?php }
}
?>