<?php

$menu['customers']['submenu'][] = [
    'name' => trans('Origins'),
    'link' => '?m=optomedia&o=customer_origin_list',
    'tip' => trans('List of customer origins'),
    'prio' => 62
];
$menu['customers']['submenu'][] = [
    'name' => trans('New origin'),
    'link' => '?m=optomedia&o=customer_origin_add',
    'tip' => trans('Add a customer origin'),
    'prio' => 64,
];
