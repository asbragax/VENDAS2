$(document).on('click', '#cad-areceber, #cad-apagar', function(e) {
    e.preventDefault();
});
$(document).ready(function() {
    $(":input").inputmask();

    $("#btnpag").hide();

    $('.select2').select2({
        containerCssClass: "border-primary"
    });

    $('.pag-select2').select2({
        placeholder: "Selecione...",
        allowClear: true,
        dropdownParent: $("#modal-cad-pagar"),
        containerCssClass: "border-primary"
    });

    $('.edt-pag-select2').select2({
        placeholder: "Selecione...",
        allowClear: true,
        dropdownParent: $("#modal-edt-pagar"),
        containerCssClass: "border-primary"
    });

    $('.lote-select2').select2({
        placeholder: "Selecione...",
        allowClear: true,
        dropdownParent: $("#modal-pag-lote"),
        containerCssClass: 'border-primary'
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $("#input-search").keyup(function() {
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if ($(this).val() != "") {
            $("." + tabela + " tbody>tr").hide();
            $("." + tabela + " td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        } else {
            $("." + tabela + " tbody>tr").show();
        }
    });
    $("#input-search-date").on("change keyup",function() {
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        var data = $(this).val();
        data = data.split('-');
        data = data[2]+'/'+data[1]+'/'+data[0];
        if (data != "" && data != 'undefined/undefined/') {
            $("." + tabela + " tbody>tr").hide();
            $("." + tabela + " td:contains-ci('" + data + "')").parent("tr").show();
        } else {
            $("." + tabela + " tbody>tr").show();
        }
    });
    
    $.extend($.expr[":"], {
        "contains-ci": function(elem, i, match, array) {
            return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

    $('#create_excel').click(function(e){  
        e.preventDefault();

        var htmls = "";
        var uri = 'data:application/vnd.ms-excel;charset=UTF-8;base64,';
        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
        var base64 = function(s) {
            return window.btoa(unescape(encodeURIComponent(s)))
        };

        var format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            })
        };

        htmls += $("#table-caixa0").html();
        htmls += $("#table-caixa1").html();
        htmls += $("#table-caixa2").html();
        htmls += $("#table-caixa3").html();
        htmls += $("#table-caixa4").html();
        htmls += $("#table-caixa5").html();
        htmls += $("#table-caixa6").html();
        htmls += $("#table-caixa7").html();
        htmls += $("#table-caixa8").html();
        htmls += $("#table-caixa9").html();

        var ctx = {
            worksheet : 'Worksheet',
            table : htmls
        }


        var link = document.createElement("a");
        link.download = "Caixa Mensal.xls";
        link.href = uri + base64(format(template, ctx));
        link.click();

   });



    $(document).on("click", ".edtApagar", function() {
        let id = $(this).val();
        id = id.split("_");
        const dados = "id=" + id[0];
        $.post("components/apagar/action/buscar_apagar.php", dados,
            function(data) {
                if (data != null) {
                    data = JSON.parse(data);
                    $("#edt_id_apagar").val(data.id);
                    $("#edt_referencia_apagar").val(data.nome);
                    $("#edt_fornecedor").val(data.fornecedor).change();
                    $("#edt_data").val(data.data);
                    $("#edt_valor").val((+data.valor / 100).toFixed(2).replace(".", ","));
                    if (data.forma_pag == 1) {
                        $("#edt_avista").attr("checked", true);
                    } else {
                        $("#edt_aprazo").attr("checked", true);
                    }
                    $(".edt_formaPag").attr("readonly", true);
                    $(".edt_dec_parcela").attr("disabled", true);
                    $(".edt_inc_parcela").attr("disabled", true);
                    $("#edt_prestacao").val(data.prestacao);
                    $("#edt_nota").val(data.nota);
                    $("#edt_data_pag").val(data.data_pag);
                    if (data.status == 1) {
                        $("#edt_pag").attr("checked", true);
                    }
                    if (id[1] == 1) {
                        $("#edt_divprestacao").hide();
                    } else if (id[1] == 2) {
                        $.post("components/apagar/action/buscar_parcelas.php", dados,
                            function(data) {
                                if (data != null) {
                                    data = JSON.parse(data);
                                    // console.log(data);
                                    let div = $("#edt_divparcelas");
                                    let html = '';
                                    for (let i = 0; i < data.length; i++) {
                                        html += '<div class="col-sm-4 campo_vencimento" id="campo_vencimento' + data[i].num + '">';
                                        if (data[i].status == 1) {
                                            html += '<label class="form-label">Vencimento ' + (+data[i].num + 1) + 'ª parcela (PAGO)</label>';
                                            html += '<input type="date" readonly name="vencimento' + data[i].num + '" id="vencimento' + data[i].num + '" value="' + data[i].vencimento + '" class="form-control border-secondary parcelas"/>';
                                        } else {
                                            html += '<label class="form-label">Vencimento ' + (+data[i].num + 1) + 'ª parcela</label>';
                                            html += '<input type="date" name="vencimento' + data[i].num + '" id="vencimento' + data[i].num + '" value="' + data[i].vencimento + '" class="form-control border-primary parcelas"/>';
                                        }
                                        html += '</div>';

                                        html += '<div class="col-sm-4 campo_valor" id="campo_valor' + data[i].num + '">';
                                        if (data[i].status == 1) {
                                            html += '<label class="form-label">Valor ' + (+data[i].num + 1) + 'ª parcela (PAGO)</label>';
                                            html += '<input type="text" readonly name="valor' + data[i].num + '" id="valor' + data[i].num + '" value="' + (data[i].valor / 100).toFixed(2).replace('.', ',') + '" class="form-control border-secondary valores" data-inputmask="\'alias\': \'currency\'"/>';
                                        } else {
                                            html += '<label class="form-label">Valor ' + (+data[i].num + 1) + 'ª parcela</label>';
                                            html += '<input type="text" name="valor' + data[i].num + '" id="valor' + data[i].num + '" value="' + (data[i].valor / 100).toFixed(2).replace('.', ',') + '" class="form-control border-primary valores" data-inputmask="\'alias\': \'currency\'"/>';
                                        }
                                        html += '<input type="hidden" name="edt_id_apagar_prestacao' + data[i].num + '" value="' + data[i].id + '" >';
                                        html += '<input type="hidden" name="edt_status_apagar_prestacao' + data[i].num + '" value="' + data[i].status + '" >';
                                        html += '</div>';

                                        html += '<div class="col-sm-2 text-left pt-4">';
                                        if (data[i].status == 1) {
                                            html += '<a class="btn btn-success btn-sm btn-icon" href="?pagApagar=' + data[i].id + '"> <i class="fa fa-edit"></i> </a>';
                                        }else{
                                            html += '<button class="btn btn-danger btn-sm btn-icon confirmDeletarParcela" name="excluir_apagar_parcela" value="id=' + data[i].id + '&id_apagar=' + id[0] + '&num=' + data[i].num + '&prestacao=' + prestacao + '"> <i class="fa fa-trash"></i> </button>';
                                        }
                                        html += '</div>';

                                        html += '<div class="col-sm-2">';
                                        if (data[i].arquivo_recibo != '' && data[i].arquivo_recibo != null) {
                                            html += '<label class="form-label">Recibo ' + (+data[i].num + 1) + 'ª parcela</label>';

                                            html += '<div class="col-sm-12 text-center">';
                                            html += '<a href="arquivos/recibos/' + data[i].arquivo_recibo + '"> <i class="fa-2x fa fa-file-pdf color-primary"></i> </a>';
                                            html += '</div>';
                                        }
                                        html += '</div>';
                                    }
                                    div.append(html);
                                    $(":input").inputmask();
                                }
                            }, "html");
                    }
                }
            }, "html");

        $("#modal-edt-pagar").modal("show");
    });
    $(document).on("click", "#btnpag", function() {
        $("#modal-pag-lote").modal("show");
    });

    $(document).on("change", ".pags", function() {
        if($(".pags:checked").length > 0){
            $("#btnpag").show();
            $("#num_pags").html($(".pags:checked").length);

            var ids = $.map($(':checkbox[name=pags\\[\\]]:checked'), function(n, i){
                return n.value;
            }).join('&');

            let valor = 0;

            valor = $.map($(':checkbox[name=pags\\[\\]]:checked'), function(n, i){
                var id  = n.id.split("_");
                return parseInt(id[2]);
            });

            const soma = valor => valor.reduce((acc, val) => acc+val);

            $("#ids_parcelas").val(ids);
            $("#val_contas").html('Valor total: $'+(soma(valor)/100).toFixed(2).replace(".", ","));
            $("#num_contas").html('Contas selec.: '+$(".pags:checked").length);
        }else{
            $("#btnpag").hide();
        }
    });

    $(document).on("click", ".btnDeleteSaida", function() {
        var dados = $(this).val();
        var url = $(this).attr('name');

        swal({
            title: "EXCLUIR CONTA A PAGAR?",
            text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa conta será apagado.",
            icon: 'warning',
            buttons: {
            cancel: {
                text: 'Não',
                value: 'cancel',
                visible: true,
                className: 'btn btn-default',
                closeModal: true,
            },
            confirm: {
                text: 'Sim',
                value: 'proceed',
                visible: true,
                className: 'btn btn-primary',
                closeModal: true
            }
            }
        }) .then(function(result) {
            switch (result) {
            case "cancel":
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            break;

            case 'proceed':
                $.post("components/apagar/action/" + url + ".php", dados,
                function(data) {
                    debugger
                    if (data!= null && data != false) {
                        swal({
                            icon: 'success',
                            text: "Registro apagado com sucesso."
                        });
                        location.reload();
                    }else{
                        swal({
                            icon: 'danger',
                            text: "Um erro ocorreu, impossível excluir a conta a pagar."
                        });
                    }

                }, "html");
               
            break;

            default:
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            }
        })
        .catch(err => {
            if(err){
                swal({
                    icon: 'danger',
                    text: "Um erro ocorreu, impossível excluir a conta a pagar."
                });
            } else {
                swal.stopLoading();
                swal.close();
            }
        });
    });

    $(document).on("click", ".confirmDeletarParcela", function(e) {
        var dados = $(this).val();
        var url = $(this).attr('name');
        e.preventDefault();
        swal({
            title: "EXCLUIR PARCELA DA CONTA A PAGAR?",
            text: "Tem certeza do que está fazendo? Esses dados não serão recuperados e tudo associado a essa parcela será apagado.",
            icon: 'warning',
            buttons: {
            cancel: {
                text: 'Não',
                value: 'cancel',
                visible: true,
                className: 'btn btn-default',
                closeModal: true,
            },
            confirm: {
                text: 'Sim',
                value: 'proceed',
                visible: true,
                className: 'btn btn-primary',
                closeModal: true
            }
            }
        }) .then(function(result) {
            switch (result) {
            case "cancel":
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            break;

            case 'proceed':
                $.post("components/apagar/action/" + url + ".php", dados,
                function(data) {
                    debugger
                    if (data!= null && data != false) {
                        swal({
                            icon: 'success',
                            text: "Registro apagado com sucesso."
                        });
                        location.reload();
                    }else{
                        swal({
                            icon: 'danger',
                            text: "Um erro ocorreu, impossível excluir a conta a pagar."
                        });
                    }

                }, "html");
               
            break;

            default:
            swal({
                icon: 'info',
                text: "Ufa! Seus dados estão a salvo."
            });
            }
        })
        .catch(err => {
            if(err){
                swal({
                    icon: 'danger',
                    text: "Um erro ocorreu, impossível excluir a conta a pagar."
                });
            } else {
                swal.stopLoading();
                swal.close();
            }
        });
    });

    
});