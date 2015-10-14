<?php

function asset_url(){
    return base_url().'assets/';
}

function img_url($img='') {
    return base_url().'assets/img/'.$img;
}

function js_url($js='') {
    return base_url().'assets/js/'.$js;
}

function css_url($css='') {
    return base_url().'assets/css/'.$css;
}