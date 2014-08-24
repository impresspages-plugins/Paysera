<?php

$routes['2checkout/pay/{paymentId}/{securityCode}'] = array(
    'name' => 'Paysera_pay',
    'plugin' => 'Paysera',
    'controller' => 'SiteController',
    'action' => 'pay'
);


$routes['2checkout/return'] = array(
    'name' => 'Paysera_return',
    'plugin' => 'Paysera',
    'controller' => 'PublicController',
    'action' => 'userBack'
);



$routes['2checkout/status/{paymentId}/{securityCode}'] = array(
    'name' => 'Paysera_status',
    'plugin' => 'Paysera',
    'controller' => 'SiteController',
    'action' => 'status'
);
