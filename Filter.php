<?php
/**
 * @package   ImpressPages
 */



namespace Plugin\Mokejimai;


class Filter
{
    public static function ipPaymentMethods($paymentMethods, $data)
    {
        $paymentMethod = new Payment();
        $paymentMethods[] = $paymentMethod;
        return $paymentMethods;
    }
}
