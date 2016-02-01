<?php

if ( !isset($_GET['o']) ) {
    require_once 'optomedia/404.php';
} else {
    switch ( $_GET['o'] ) {
	case 'customer_origin_list': require_once 'optomedia/customer_origin/list.php'; break;
        case 'customer_origin_add': require_once 'optomedia/customer_origin/list.php'; break;
        case 'customer_origin_edit': require_once 'optomedia/customer_origin/list.php'; break;
        case 'customer_origin_del': require_once 'optomedia/customer_origin/list.php'; break;
	default: require_once 'optomedia/404.php'; break;
    }
}
