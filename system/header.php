<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?php global $bootstrap_css;echo $bootstrap_css;?>" rel="stylesheet">
  <?php echo (isset($head)?$head:"");?>
  <script src="<?php global $jquery_js;echo $jquery_js;?>"></script>
  <script src="<?php global $bootstrap_js;echo $bootstrap_js;?>"></script>
  <style>
    @media (min-width:767px){
      .dropdown:hover > .dropdown-menu{
        display: block;
      }
    }
  </style>
</head>
<body>
    <?php
    global $sysnav;
    $sysnav(array('target'=>$title,'bland'=>$bland,'menu'=>$menu));
    ?>
    <div class="container">
