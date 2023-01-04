<?php session_start(); ?>
<?php include_once('header.php') ?>
<main class="container-fluid">
  <?php 
  $page = isset($_GET['page']) ? $_GET['page'] : "draw";
  include("{$page}.php"); 
  ?>
</main>
<?php include_once('footer.php') ?>