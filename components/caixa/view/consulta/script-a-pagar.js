$(document).ready(function() {
    $('#divvencimento').hide();
    $('#divprestacao').hide();
    $('#divparcelas').hide();
    $('#cadPagar').prop('disabled', false);

    $(document).on('change', '#pag', function() {
        if ($(this).prop('checked')) {
            $('#divcontapaga').show();
        } else {
            $('#divcontapaga').hide();
        }
    });

    $(document).on('change', '.formaPag', function() {
        if ($('#aprazo').prop('checked')) {
            $('#divpaga').hide();
            $('#divprestacao').show();
            $('#divvencimento').show();
            $('#divparcelas').show();
            $('#divcontapaga').hide();
            criaCamposParcelas();
        } else {
            $('#divpaga').show();
            $('#divprestacao').hide();
            $('#divvencimento').hide();
            $('#divparcelas').empty();
            $('#divparcelas').hide();
            $('#divcontapaga').show();

            $('.pag-select2').select2({
                placeholder: "Selecione...",
                allowClear: true,
                dropdownParent: $("#modal-cad-pagar")
            });

        }
    });

   

    $(document).on('change keyup', '#prestacao', function() {
        criaCamposParcelas();
    });

    $(document).on("keyup", "#valor, #prestacao", function() {
        var valor = $("#valor").val();
        if (valor.length <= 0) {
            valor = 0;
        } else {
            valor = valor.split("$ ");
            valor = (valor[1].replace(".", "").replace(".", "").replace(",", ".") * 100);
        }
        // var prestacao = $("#prestacao").val();

        // $("#label-total-select2").text('TOTAL: $ ' + ((+valor * +prestacao) / 100).toFixed(2).replace(".", ","));
    });

    $(document).on("change", "#valor, #prestacao", function() {
        var valor = $("#valor").val();
        if (valor.length <= 0) {
            valor = 0;
        } else {
            valor = valor.split("$ ");
            valor = (valor[1].replace(".", "").replace(".", "").replace(",", ".") * 100);
        }
        // var prestacao = $("#prestacao").val();

        // $("#label-total-select2").text('TOTAL: $ ' + ((+valor * +prestacao) / 100).toFixed(2).replace(".", ","));
    });

    function criaCamposParcelas() {
        const parcelas = $("#prestacao").val();
        let div = $("#divparcelas");
        let html = '';
        // div.empty();
        let vencimento = moment($("#data").val()).format('YYYY-MM-DD');

        const qtde = $(".parcelas").length;
        if (+qtde < +parcelas) {
            for (let i = 0; i < +parcelas; i++) {
                if ($(`#vencimento${i}`).length) {

                } else {
                    html += '<div class="col-sm-3 campo_vencimento" id="campo_vencimento' + i + '">';
                    html += '<label class="form-label">Vencimento ' + (i + 1) + 'ª parcela</label>';
                    html += '<input type="date" name="vencimento' + i + '" id="vencimento' + i + '" value="' + vencimento + '" class="form-control border-primary parcelas" />';
                    html += '</div>';

                    html += '<div class="col-sm-3 campo_valor" id="campo_valor' + i + '">';
                    html += '<label class="form-label">Valor ' + (i + 1) + 'ª parcela</label>';
                    html += '<input type="text" value="'+ valor +'" name="valor' + i + '" id="valor' + i + '" class="form-control border-primary valores" data-inputmask="\'alias\': \'currency\'" />';
                    html += '</div>';

                    html += '<div class="col-sm-6 campo_extra">';
                    html += '</div>';
                }
                vencimento = moment(vencimento).add(1, 'month').format('YYYY-MM-DD');


            }
        } else {
            if (+qtde > +parcelas) {
                const dif = +qtde - +parcelas;
                let i = dif;
                $($(".campo_vencimento").get().reverse()).each(function() {
                    if (i > 0) {
                        $(this).remove();
                    }
                    i--;
                });
                i = dif;
                $($(".campo_valor").get().reverse()).each(function() {
                    if (i > 0) {
                        $(this).remove();
                    }
                    i--;
                });
                i = dif;
                $($(".campo_extra").get().reverse()).each(function() {
                    if (i > 0) {
                        $(this).remove();
                    }
                    i--;
                });
            }
        }

        div.append(html);
        $(":input").inputmask();

        var valor = $("#valor").val();
        if (valor.length <= 0) {
            valor = 0;
        } else {
            valor = valor.split("$ ");
            valor = (valor[1].replace(",", ".") * 100);
        }

        var prestacao = $("#prestacao").val();
        $(".valores").val(((+valor/100)/+prestacao).toFixed(2).replace(".", ","));
    }

    $(document).on("click", ".inc_parcela", function() {
        var qtde = $("#prestacao").val();
        $("#prestacao").val(+qtde + 1).change();
    });

    $(document).on("click", ".dec_parcela", function() {
        var qtde = $("#prestacao").val();
        $("#prestacao").val(+qtde - 1).change();
    });

});