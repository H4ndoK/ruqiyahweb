<?php

$column_params = array(
    array(
        "type" => "dropdown",
        "class" => "",
        "heading" => "Animation",
        "param_name" => "animation",
        "value" => array(
            "None" => "none",
            "Fade In" => "Fade In",
            "Fade In From Left" => "Fade In From Left",
            "Fade In Right" => "Fade In From Right",
            "Fade In From Bottom" => "Fade In From Bottom",
            "Grow In" => "Grow In"
        )
    ),
    array(
        "type" => "textfield",
        "class" => "",
        "heading" => "Animation Delay",
        "param_name" => "delay",
        "description" => ""
    ),

    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => "Boxed Column",
        "value" => array("Boxed Style" => "true"),
        "param_name" => "boxed",
        "description" => ""
    ),

    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => "Centered Content",
        "value" => array("Centered Content Alignment" => "true"),
        "param_name" => "centered_text",
        "description" => ""
    ),

    array(
        "type" => "textfield",
        "class" => "",
        "heading" => "Extra Class Name",
        "param_name" => "class",
        "value" => ""
    )
);

return array(
    "name" => __("Five Sixths", "js_composer"),
    "base" => "five_sixths_last",
    "class" => "",
    "icon" => "",
    "wrapper_class" => "",
    "controls"	=> "full",
    "allowed_container_element" => false,
    "content_element" => false,
    "is_container" => true,
    "params"=> $column_params,
    "js_view" => 'VcColumnView'
);