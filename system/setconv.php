<?php
include('settings.php');
//呼び出し
ob_start();
echo '<?php'."\n";
echo "\$settings=array();\n";
foreach( $settings as $key => $value){
    echo "\$settings['{$key}'] = ";
    if( is_array($value) ){
        $first = 1;
        echo "array(";
        foreach( $value as $value2){
            echo (($first)?'':',')."'{$value2}'";
            $first = 0;
        }
        echo ");\n"; 
    }else{
        echo "'$value';\n";
    }
}
echo "\$attribute=array();\n";
foreach( $attribute as $key => $value){
    echo "\$attribute['{$key}'] = ";
    if( is_array($value) ){
        $first = 1;
        echo "array(";
        foreach( $value as $key2 =>$value2){
            echo (($first)?'':',')."'{$key2}'=>'{$value2}'";
        }
        echo ");\n";
    }else{
        echo "'$value';\ ";
    }
}
$html = ob_get_contents();
ob_end_clean();
file_put_contents('settings.php',$html);
