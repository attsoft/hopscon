<?php

/*
* Template Name: Testing page
*/

global $wpdb;
$id =17133;
$data = $wpdb->get_row("SELECT*FROM wp_usermeta WHERE umeta_id =$id");
$new = $data->meta_value;

$new = maybe_unserialize($new);
// print_r(); 
var_dump($new);
?>