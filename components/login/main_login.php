<?php
session_start();
if (isset($_SESSION['username'])) {
    header("location:../../index.php");
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Sistema de vendas | André Braga - Sistemas e Aplicativos"</title>
    <meta name="description" content="Sistema de vendas | André Braga - Sistemas e Aplicativos">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
   	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="../../../assets_coloradmin/css/vendor.min.css" rel="stylesheet" />
	<link href="../../../assets_coloradmin/css/default/app.min.css" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
    <link rel="icon" type="image/png" sizes="32x32" href="../../../assets_coloradmin/img/logo/logo.png">
 
</head>
<body class='pace-top'>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->

	
	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN login -->
		<div class="login login-v2 fw-bold">
			<!-- BEGIN login-cover -->
			<div class="login-cover">
				<div class="login-cover-img" style="background-image: url(../../../assets_coloradmin/img/login-bg/login-bg-<?php echo random_int(1, 18) ?>.jpg)" data-id="login-cover-image"></div>
				<div class="login-cover-bg"></div>
			</div>
			<!-- END login-cover -->
			
			<!-- BEGIN login-container -->
			<div class="login-container">
				<!-- BEGIN login-header -->
				<div class="login-header">
					<div class="brand">
						<div class="d-flex align-items-center">
							<span class="logo"></span> <b>GK</b> Admin
						</div>
						<small>A modernidade acessível</small>
					</div>
					<div class="icon">
						<i class="fa fa-lock"></i>
					</div>
				</div>
				<!-- END login-header -->
				
				<!-- BEGIN login-content -->
				<div class="login-content">
                    <form method="post" action="action/checklogin.php">
						<div class="form-floating mb-20px">
							<input type="text" class="form-control fs-13px h-45px border-0" placeholder="Usuário" id="myusername" name="myusername" />
							<label for="myusername" class="d-flex align-items-center text-gray-600 fs-13px">Usuário</label>
						</div>
						<div class="form-floating mb-20px">
							<input type="password" class="form-control fs-13px h-45px border-0" placeholder="Senha" id="mypassword" name="mypassword" />
							<label for="mypassword" class="d-flex align-items-center text-gray-600 fs-13px">Senha</label>
						</div>
                        <div id="message"></div>
						<div class="mb-20px">
							<button type="submit" id="submit" class="btn btn-success d-block w-100 h-45px btn-lg">Entrar</button>
						</div>
					</form>
				</div>
				<!-- END login-content -->
			</div>
			<!-- END login-container -->
		</div>
		<!-- END login -->
		
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-bs-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->

    	<!-- ================== BEGIN core-js ================== -->
	<script src="../../../assets_coloradmin/js/vendor.min.js"></script>
	<script src="../../../assets_coloradmin/js/app.min.js"></script>
	<script src="../../../assets_coloradmin/js/theme/default.min.js"></script>
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="../../../assets_coloradmin/js/demo/login-v2.demo.js"></script>
	<!-- ================== END page-js ================== -->
    <script src="js/login.js"></script>
    <script>
        // $(document).ready(function() {

        // });
    </script>
</body>

</html>