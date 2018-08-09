<?php
// Render view function
class TMP {
    public static function render_view($view_name){
       include("views/$view_name.html");
    }

    public static function render_component($component_name, $params = array()){
       $component = file_get_contents("components/parts/$component_name/component.html");
       $element_id = md5(rand(0,99999));

       $component = str_replace("root_element", "data-type='$component_name' data-uid='$element_id' id='$element_id' ", $component);

       $params["uid"] = $element_id;

       foreach($params as $key => $value){
       	  $component = str_replace('{' . "$key" . '}',$value,$component);
       }

       echo $component;
    }

    public static function render_base($component_name){
       require_once("components/layers/$component_name/component.html");
    }
}

?>
