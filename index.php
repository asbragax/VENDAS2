 <?php
  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
  date_default_timezone_set('America/Sao_Paulo');
  require "components/login/loginheader.php";
  include_once "includes/includes.php";
  include_once "includes/json_encode.php";
  // include_once "aniversariantes.php";
  include_once "env.php";
  
  $dao = new StatusDAO();
  $NAOPAGOU = trim($dao->getPorId(1)['status']);
?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <?php
  include_once('includes/head.php');
  ?>

 <body>
   	<!-- BEGIN #loader -->
    <!-- <div id="loader" class="app-loader">
      <span class="spinner"></span>
    </div> -->
    <!-- END #loader -->
   <!-- BEGIN #app -->
	<div id="app" class="app app-header-fixed app-sidebar-fixed">
    <?php 
        include_once('includes/theme.php'); 
        include_once('includes/header.php'); 
        include_once('includes/nav.php'); 
        include_once('routes/main.php');
        include_once('includes/extra.php');
    ?>

   </div>
   <!-- END app -->
   <?php include_once('includes/js.php'); ?>


 </body>

 </html>