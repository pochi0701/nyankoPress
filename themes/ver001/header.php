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
      $position = count($settings['widget_main']);
      if( $position>0){
          foreach( $settings['widget_main'] as $wgt ){
              $widget( array('name'=>$wgt,'location' =>'header' ) );
          }
      }
      echo $head;
  ?>
</head>
<body style="padding-top:53px;">
    <?php
    global $navbar;
    $navbar(array('target'=>$title,'bland'=>$bland,'menu'=>$menu));
    ?>
    <div class="container">
