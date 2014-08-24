<?php

$routes['2checkout/pay/{paymentId}/{securityCode}'] = array(
    'name' => 'Mokejimai_pay',
    'plugin' => 'Mokejimai',
    'controller' => 'SiteController',
    'action' => 'pay'
);


$routes['2checkout/return'] = array(
    'name' => 'Mokejimai_return',
    'plugin' => 'Mokejimai',
    'controller' => 'PublicController',
    'action' => 'userBack'
);



$routes['2checkout/status/{paymentId}/{securityCode}'] = array(
    'name' => 'Mokejimai_status',
    'plugin' => 'Mokejimai',
    'controller' => 'SiteController',
    'action' => 'status'
);
