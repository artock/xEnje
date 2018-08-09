<?php

header("Content-type: text/css");

$layers = glob("../../components/layers/*");
$parts = glob("../../components/parts/*");

foreach ($parts as $style) {
    if(is_dir($style) && file_exists("$style/component.css")){
        echo str_replace("\r\n","",file_get_contents("$style/component.css"));
    }
}

foreach ($layers as $style) {
    if(is_dir($style) && file_exists("$style/component.css")){
        echo str_replace("\r\n","",file_get_contents("$style/component.css"));
    }
}

?>
