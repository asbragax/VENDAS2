
<?php include_once('components/produto/action/listar_produto.php'); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Lista de produtos</h4>
        <a href="?cadProduto" class="btn btn-primary btn-sm">Novo produto</a>
    </div>
    <div class="panel-body">
        <div class="table-responsive overflow-hidden">
            <table id="table-produtos" class="table table-bordered table-hover table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th>Cód</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço de venda</th>
                        <th>Categoria</th>
                        <th>Fotos</th>
                        <th>Tipo</th>
                        <!-- <th>Preço de venda atacado</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dao = new ProdutoDAO();
                    for ($i = 0; $i < count($listaProdutos); $i++) { 
                        $grade = $dao->listar_grade($listaProdutos[$i]['id']);
                        $fotos = $dao->listar_fotos($listaProdutos[$i]['id']);
                        ?>
                        <tr>
                            <td><?php echo $listaProdutos[$i]["id"]; ?></td>
                            <td><?php echo $listaProdutos[$i]["nome"]; ?></td>
                            <td><?php echo array_sum(array_column($grade, 'quantidade')); ?></td>
                            <td><?php echo "R$" . number_format(($listaProdutos[$i]["valor_venda"] / 100), 2, ',', '.'); ?></td>
                            <td><?php echo $listaProdutos[$i]["nome_categoria"]; ?>
                            <td><?php echo count($fotos); ?></td>
                            <td><?php echo $listaProdutos[$i]["gender"] == "m" ? "Masculino" : "Feminino"; ?></td>
                            <!-- <td><?php //echo "R$" . number_format(($listaProdutos[$i]["valor_atacado"] / 100), 2, ',', '.'); ?></td> -->
                            <td class="text-center">
                                <?php if($_SESSION['nivel'] >= 2){ ?>
                                    <a class="btn btn-info btn-icon btn-sm" href="?dtlProduto=<?php echo $listaProdutos[$i]["id"]; ?>"><span class="fa fa-search"></span></a>
                                    <a class="btn btn-warning btn-icon btn-sm" href="?edtProduto=<?php echo $listaProdutos[$i]["id"]; ?>"><span class="fa fa-edit"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
       
        $('#table-produtos').dataTable({
            responsive: true,
            lengthChange: true,
            colReorder: true,
            stateSave: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Gerar PDF',
                    className: 'btn-outline-danger btn-sm me-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Gerar Excel',
                    className: 'btn-outline-success btn-sm me-1'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'Gerar CSV',
                    className: 'btn-outline-info btn-sm me-1'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copiar',
                    titleAttr: 'Copiar para área de transferência',
                    className: 'btn-outline-warning btn-sm me-1'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    titleAttr: 'Imprimir tabela',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });
        
       
    });
</script>