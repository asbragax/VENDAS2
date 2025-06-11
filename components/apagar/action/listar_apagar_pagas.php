<?php
    $dao = new ApagarDAO();
    $listaApagar = $dao->listar_pagas_mes($mes, $ano);

    $listaApagar2 = $dao->listar_parcelas_pagas_mes($mes, $ano);

?>