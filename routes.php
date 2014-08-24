<?php

$routes['Paysera/pay/{paymentId}/{securityCode}'] = array(
    'name' => 'Paysera_pay',
    'plugin' => 'Paysera',
    'controller' => 'SiteController',
    'action' => 'pay'
);


$routes['Paysera/return'] = array(
    'name' => 'Paysera_return',
    'plugin' => 'Paysera',
    'controller' => 'PublicController',
    'action' => 'userBack'
);



$routes['Paysera/status/{paymentId}/{securityCode}'] = array(
    'name' => 'Paysera_status',
    'plugin' => 'Paysera',
    'controller' => 'SiteController',
    'action' => 'status'
);
