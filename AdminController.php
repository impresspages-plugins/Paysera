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

namespace Plugin\Mokejimai;


class AdminController {
    public function index()
    {
        $config = array(
            'table' => 'Mokejimai',
            'orderBy' => '`id` desc',
            'fields' => array(
                array(
                    'label' => __('Order ID', 'Mokejimai', false),
                    'field' => 'orderId',
                    'allowUpdate' => false,
                    'allowInsert' => false
                ),
                array(
                    'label' => __('Title', 'Mokejimai', false),
                    'field' => 'title'
                ),
                array(
                    'label' => __('Price', 'Mokejimai', false),
                    'field' => 'price',
                    'type' => 'Currency',
                    'currencyField' => 'currency'
                ),
                array(
                    'label' => __('Currency', 'Mokejimai', false),
                    'field' => 'currency'
                ),
                array(
                    'label' => __('Paid', 'Mokejimai', false),
                    'field' => 'isPaid',
                    'type' => 'Checkbox'
                ),
                array(
                    'label' => __('User ID', 'Mokejimai', false),
                    'field' => 'userId',
                    'type' => 'Integer'
                ),
                array(
                    'label' => __('First Name', 'Mokejimai', false),
                    'field' => 'payer_first_name'
                ),
                array(
                    'label' => __('Last Name', 'Mokejimai', false),
                    'field' => 'payer_last_name'
                ),
                array(
                    'label' => __('Email', 'Mokejimai', false),
                    'field' => 'payer_email'
                ),
                array(
                    'label' => __('Country', 'Mokejimai', false),
                    'field' => 'payer_country'
                ),
                array(
                    'label' => __('Created At', 'Mokejimai', false),
                    'field' => 'createdAt'
                ),



            )
        );
        return ipGridController($config);
    }
}
