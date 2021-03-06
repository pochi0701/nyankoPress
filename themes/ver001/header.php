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
  <link href="themes/ver001/common.css" rel="stylesheet">
  <?php global $fontawesome;if( strlen($fontawesome)>0) echo "<link rel=\"stylesheet\" href=\"$fontawesome\">\n"; ?>
  <style>
    @media (min-width:767px){
      .dropdown:hover > .dropdown-menu{
        display: block;
      }
    }
  </style>
  <script src="<?php global $jquery_js;echo $jquery_js;?>"></script>
  <script src="<?php global $bootstrap_js;echo $bootstrap_js;?>"></script>
  <?php
      global $settings;
      global $widget;
      if( count($settings[$wgt_name])>0){
          foreach( $settings[$wgt_name] as $wgt ){
              $widget( array('name'=>$wgt,'location' =>'header' ) );
          }
      }
      echo $head;
  ?>
</head>
<body style="padding-top:53px;">
  <?php
      if( count($settings['header'])>0){
          foreach( $settings['header'] as $wgt ){
              $widget( array('name'=>$wgt) );
          }
      }
      global $navbar;
      $navbar(array('bland'=>$bland,'menu'=>$menu));
  ?>
  <div class="container">
