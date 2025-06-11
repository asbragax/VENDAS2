	<!-- ================== BEGIN core-js ================== -->
	<script src="../assets_coloradmin/js/vendor.min.js"></script>
	<script src="../assets_coloradmin/js/app.min.js"></script>
	<script src="../assets_coloradmin/js/theme/default.min.js"></script>
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="../assets_coloradmin/plugins/d3/d3.min.js"></script>
	<script src="../assets_coloradmin/plugins/nvd3/build/nv.d3.min.js"></script>
	<script src="../assets_coloradmin/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
	<script src="../assets_coloradmin/plugins/jvectormap-next/jquery-jvectormap-world-mill.js"></script>
	<script src="../assets_coloradmin/plugins/apexcharts/dist/apexcharts.min.js"></script>
	<script src="../assets_coloradmin/plugins/moment/min/moment.min.js"></script>
	<script src="../assets_coloradmin/plugins/moment/locale/pt-br.js"></script>
	<script src="../assets_coloradmin/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="../assets_coloradmin/js/theme/default.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../assets_coloradmin/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../assets_coloradmin/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="../assets_coloradmin/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="../assets_coloradmin/plugins/jszip/dist/jszip.min.js"></script>
	<script src="../assets_coloradmin/plugins/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../assets_coloradmin/plugins/chart.js/dist/chart.min.js"></script>
	<!-- <script src="../assets_coloradmin/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script> -->
	<script src="../assets_coloradmin/plugins/switchery/dist/switchery.min.js"></script>
	<script src="../assets_coloradmin/plugins/select2/dist/js/select2.full.min.js"></script>
	<script src="../assets_coloradmin/js/inputmask.bundle.js"></script>
	<script src="../assets_coloradmin/plugins/spectrum-colorpicker2/dist/spectrum.min.js"></script>


	<!-- ================== END page-js ================== -->
<script>
const MENU_CLASS = <?php echo safe_json_encode($MENUCLASS); ?>;
const SUBMENU_CLASS = <?php echo safe_json_encode($SUBMENUCLASS); ?>;
const DTINI = <?php echo safe_json_encode($dataini); ?>;
const DTFIM = <?php echo safe_json_encode($datafim); ?>;
const NIVEL = <?php echo safe_json_encode($_SESSION['nivel']); ?>;
$(document).ready(function() {
	$(".menu-item").removeClass("active");	
	$(`.menu_${MENU_CLASS}`).addClass("active");
	$(".menu-subitem").removeClass("active");	
	if(SUBMENU_CLASS != '0'){
		// console.log(`.submenu_${MENU_CLASS}_${SUBMENU_CLASS}`);
		$(`.submenu_${MENU_CLASS}_${SUBMENU_CLASS}`).addClass("active");
	}

	let url = window.location.href.toString();
	url = url.split("?");
	if(url[1]){
		url = url[1].split("=")
		if(url[0] == 'dtlPessoa'){
			$("#content").addClass('p-0');
		}else{
			$("#content").removeClass('p-0');
		}
	}else{
		$("#content").removeClass('p-0');
	}

	$(document).on("click", ".confirmImprimir", function() {
		var dados = $(this).val();
		var url = $(this).attr('name');
		swal({
			title: "DESEJA IMPRIMIR O CUPOM?",
			text: "Tem certeza do que está fazendo?",
			icon: 'info',
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
		})
		.then(function(result) {
			switch (result) {
			case "cancel":
			swal({
				icon: 'info',
				text: "Cancelado!"
			});
			break;

			case 'proceed':
				$.post("components/venda/action/" + url + ".php", dados,
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
							text: "Um erro ocorreu, impossível imprimir o cupom."
						});
					}

				}, "html");
				
			break;

			default:
			swal({
				icon: 'info',
				text: "Cancelado!"
			});
			}
		})
		.catch(err => {
			if(err){
				swal({
					icon: 'danger',
					text: "Um erro ocorreu, impossível imprimir o cupom."
				});
			} else {
				swal.stopLoading();
				swal.close();
			}
		});
	});
	$("#advance-daterange span").html(moment(DTINI).format("MMMM D, YYYY") + " - " + moment(DTFIM).format("MMMM D, YYYY"));

	if(NIVEL > 2){
		$("#advance-daterange").daterangepicker({
			format: "MM/DD/YYYY",
			startDate: moment(),
			endDate: moment(),
			minDate: "01/01/2016",
			// maxDate: "12/31/2015",
			dateLimit: { days: 180 },
			showDropdowns: true,
			showWeekNumbers: false,
			timePicker: false,
			timePickerIncrement: 1,
			timePicker12Hour: true,
			ranges: {
				"Hoje": [moment(), moment()],
				"Ontem": [moment().subtract(1, "days"), moment().subtract(1, "days")],
					"Últimos 7 dias": [moment().subtract(6, "days"), moment()],
					"Últimos 30 dias": [moment().subtract(29, "days"), moment()],
					"Este mês": [moment().startOf("month"), moment().endOf("month")],
					"Mês passado": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
				
			},
			opens: "right",
			drops: "down",
			buttonClasses: ["btn", "btn-sm"],
			applyClass: "btn-primary",
			cancelClass: "btn-default",
			separator: " até ",
			todayHighlight: true,
			locale: {
				applyLabel: "Aplicar",
				cancelLabel: "Cancelar",
				fromLabel: "De",
				toLabel: "Até",
				customButton: true,
				customRangeLabel: "Personalizado",
				daysOfWeek: ["Do", "Se", "Te", "Qa", "Qi", "Sx","Sa"],
				monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				firstDay: 1
			}
		}, function(start, end, label) {
			$("#advance-daterange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
			$('#dtini').val(start.format('YYYY-MM-DD'));
			$('#dtfim').val(end.format('YYYY-MM-DD'));
		});
	}else{
		$("#advance-daterange").daterangepicker({
			format: "MM/DD/YYYY",
			startDate: moment(),
			endDate: moment(),
			minDate: "01/01/2016",
			// maxDate: "12/31/2015",
			dateLimit: { days: 180 },
			showDropdowns: true,
			showWeekNumbers: false,
			timePicker: false,
			timePickerIncrement: 1,
			timePicker12Hour: true,
			ranges: {
				"Hoje": [moment(), moment()],
				"Ontem": [moment().subtract(1, "days"), moment().subtract(1, "days")]				
			},
			opens: "right",
			drops: "down",
			buttonClasses: ["btn", "btn-sm"],
			applyClass: "btn-primary",
			cancelClass: "btn-default",
			separator: " até ",
			locale: {
				applyLabel: "Aplicar",
				cancelLabel: "Cancelar",
				fromLabel: "De",
				toLabel: "Até",
				customButton: false,
				daysOfWeek: ["Do", "Se", "Te", "Qa", "Qi", "Sx","Sa"],
				monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				firstDay: 1
			}
		}, function(start, end, label) {
			$("#advance-daterange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
			$('#dtini').val(start.format('YYYY-MM-DD'));
			$('#dtfim').val(end.format('YYYY-MM-DD'));
		});
	}
	$(document).on("change", "#system_status", function() {
		var status = null;
		if($(this).prop("checked")){
			status = 1;
		}else{
			status = 0;
		}
		debugger
		var dados = "status="+status;
		$.post("components/status/action/altera_status_sistema.php", dados,
			function(data) {
				if (data != false) {
				    location.replace('index.php');
				}
			}, "html");
		
	});
	
});
</script>
