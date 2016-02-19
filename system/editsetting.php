<?php
    unset($settings);
    unset($attribute);
    include( "$path/settings.php");
    function form($opt,$req,$dispname,$id,$name,$value){
    if( $opt=='T'){
    echo"  <div class=\"form-group\">\n";
    echo"    <label class=\"col-sm-3 control-label\" for=\"{$id}\">{$dispname}</label>\n";
    echo"    <div class=\"col-sm-9 form-inline\">\n";
    echo"      <input type=\"text\" class=\"form-control\" id=\"{$id}\" name=\"{$name}\" maxlength=\"80\" size=\"80\" value=\"{$value}\" placeholder=\"{$dispname}\"".(($req=='R')?' required':'').">\n";
    echo"    </div>\n";
    echo"  </div>\n";
    }else if ( $opt=='C'){
    echo"  <div class=\"form-group\">\n";
    echo"    <div class=\"col-sm-offset-3 col-sm-9\">\n";
    echo"      <div class=\"checkbox\">\n";
    echo"        <label>\n";
    echo"          <input type=\"checkbox\" name=\"{$name}\"".(($value=='on')?' checked':'').">{$dispname}\n";
    echo"        </label>\n";
    echo"      </div>\n";
    echo"    </div>\n";
    echo"  </div>\n";
    }};
    //////////////////////////////////////////////////////////////////////////////////
    if( isset($_POST['submit'] )){
        foreach($settings as $key => $value) $settings[$key] = array_get($_POST,$key);
        foreach($settings as &$value) if(isset($value) && is_array($value)) $value = array_filter($value);
        unset($value);
        file_put_contents("$path/settings.php","<?php\n\$settings = json_decode('".json_encode($settings)."',true);\n\$attribute = json_decode('".json_encode($attribute)."',true);\n");
    }
    //////////////////////////////////////////////////////////////////////////////////
    echo "<form class=\"form-horizontal\" role=\"form\" method=\"post\">\n";
    foreach($attribute as $key => $value ){
        foreach($value as $dispname => $option){
            $opt = preg_replace('/[^TC]/','', $option);
            $req = preg_replace('/[^R]/','', $option);
            //配列
            if( strpos($option,'A') !== false ){
                 $num = preg_replace('/[^0-9]/', '', $option);
                 if( $num==0 ) $num = count($settings[$key])+1;
                 $cnt = 0;
                 if( isset($settings[$key]) ){
                     foreach($settings[$key] as $value2){
                         form($opt,$req,$dispname,$key,$key.'[]',$value2);
                         $cnt += 1;
                     }
                 }
                 for( $i = $cnt ; $i < $num ; $i++ ){
                     form($opt,$req,$dispname,$key,$key.'[]','');
                 }
            //単純入力
            }else{
                 form($opt,$req,$dispname,$key,$key,$settings[$key]);
            }
        }
    }
    echo"  <div class=\"form-group\">\n";
    echo"    <div class=\"col-sm-offset-3 col-sm-9\">\n";
    echo"      <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-primary\">設定</button>\n";
    echo"    </div>\n";
    echo"   </div>\n";
    echo "</form>\n";
