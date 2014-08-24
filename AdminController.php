<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 7/30/14
 * Time: 2:19 PM
 */

namespace Plugin\Paysera;


class AdminController {
    public function index()
    {
        $config = array(
            'table' => 'Paysera',
            'orderBy' => '`id` desc',
            'fields' => array(
                array(
                    'label' => __('Order ID', 'Paysera', false),
                    'field' => 'orderId',
                    'allowUpdate' => false,
                    'allowInsert' => false
                ),
                array(
                    'label' => __('Title', 'Paysera', false),
                    'field' => 'title'
                ),
                array(
                    'label' => __('Price', 'Paysera', false),
                    'field' => 'price',
                    'type' => 'Currency',
                    'currencyField' => 'currency'
                ),
                array(
                    'label' => __('Currency', 'Paysera', false),
                    'field' => 'currency'
                ),
                array(
                    'label' => __('Paid', 'Paysera', false),
                    'field' => 'isPaid',
                    'type' => 'Checkbox'
                ),
                array(
                    'label' => __('User ID', 'Paysera', false),
                    'field' => 'userId',
                    'type' => 'Integer'
                ),
                array(
                    'label' => __('First Name', 'Paysera', false),
                    'field' => 'payer_first_name'
                ),
                array(
                    'label' => __('Last Name', 'Paysera', false),
                    'field' => 'payer_last_name'
                ),
                array(
                    'label' => __('Email', 'Paysera', false),
                    'field' => 'payer_email'
                ),
                array(
                    'label' => __('Country', 'Paysera', false),
                    'field' => 'payer_country'
                ),
                array(
                    'label' => __('Created At', 'Paysera', false),
                    'field' => 'createdAt'
                ),



            )
        );
        return ipGridController($config);
    }
}
