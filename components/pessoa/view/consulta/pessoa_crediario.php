
<?php
$dao = new Pessoa_crediarioDAO();
$listaParcelas = $dao->listar_parcelas_abertas_todas();
?>

<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Lista de parcelas em aberto</h4>
  </div>
  <div class="panel-body">
    <div class="table-responsive overflow-hidden">
        <table id="table-pessoa-crediario" class="table table-bordered table-hover table-striped w-100">
            <thead class="bg-primary">
                <tr>
                <th>Id venda</th>
                <th>Cliente</th>
                <th>CPF</th>
                <th>Vendedor</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                <?php for ( $i = 0; $i < count($listaParcelas); $i++ ) {?>
                    <tr>
                        <td><?php echo $listaParcelas[$i]["id_venda"]; ?></td>
                        <td><?php echo $listaParcelas[$i]["nome"]; ?></td>
                        <td><?php echo $listaParcelas[$i]["cpf"]; ?></td>
                        <td><?php echo $listaParcelas[$i]["nome_vendedor"]; ?></td>
                        <td>R$ <?php echo number_format($listaParcelas[$i]["valor_pag"]/100, 2, ",", "."); ?></td>
                        <td><?php echo $listaParcelas[$i]["vencimentof"]; ?></td>
                        <td class="text-center">
                            <a class="btn btn-success btn-icon btn-sm" href="?pagPrestacao=<?php echo $listaParcelas[$i]["id"]; ?>"><span class="fa fa-dollar-sign"></span>
                            </a>
                            <?php if($_SESSION['nivel'] >= 2){ ?>
                                <a class="btn btn-warning btn-icon btn-sm" href="?edtVenda=<?php echo $listaParcelas[$i]["id_venda"]; ?>"><span class="fa fa-edit"></span>
                                </a>
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

        

        var table = $('#table-pessoa-crediario').DataTable({
            responsive: true,
            lengthChange: true,
            colReorder: true,
            ordering: false,
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

        // Setup - add a text input to each footer cell
        $('#table-pessoa-crediario thead tr').clone(true).appendTo('#table-pessoa-crediario thead');
        $('#table-pessoa-crediario thead tr:eq(1) th').each(function(i)
        {

            
            var title = $(this).text();
            $(this).html('<input type="text" id="filter_'+i+'" class="form-control form-control-sm" placeholder="Filtrar ' + title + '" />');

            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
        // Restore state, search and column level filter
        var state = table.state.loaded();
        if (state) {
            table.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('#filter_'+colIdx).val(colSearch.search);
                }
            });

            table.draw();
        }
    });
</script>
