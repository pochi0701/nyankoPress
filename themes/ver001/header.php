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
  <style>
    .jumbotron {
      background-image: url("img/photo.jpg");
      background-size: cover;
      background-position: center 60%;
    }
    @media (min-width:767px){
      .dropdown:hover > .dropdown-menu{
        display: block;
      }
    }
  </style>
  <script src="<?php global $jquery_js;echo $jquery_js;?>"></script>
  <script src="<?php global $bootstrap_js;echo $bootstrap_js;?>"></script>
  <?php echo $head; ?>
</head>
<body style="padding-top:53px;">
    <?php
    global $navbar;
    $navbar(array('title'=>$title,'bland'=>$bland,'menu'=>$menu));
    ?>
    <div class="container">
