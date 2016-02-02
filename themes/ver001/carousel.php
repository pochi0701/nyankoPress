<?php if(isset($slides) ){ ?>
<div id="carousel-sample" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php $cnt=0;
          foreach($slides as $value){
              echo "<li data-target=\"#carousel-sample\" data-slide-to=\"{$cnt}\" class=\"".(($cnt==0)?"active":"")."\"></li>\n";
              $cnt += 1;
          }
    ?>
  </ol>
  <!-- ここからCarouselの中身 -->
  <div class="carousel-inner">
    <!-- item = １ページ、activeを入れたところが最初に表示される -->
    <?php $cnt=0;
          foreach( $slides as $value){
              echo "<div class=\"item".(($cnt==0)?" active":"")."\"><img src=\"{$value}\" alt=\"the slide\"></div>\n";
              $cnt += 1;
          }
    ?>
  </div>
  <!-- ページ送りボタン、ここもCarouselのid名を合わせる -->
  <a class="left carousel-control" href="#carousel-sample" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-sample" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<?php } ?>
