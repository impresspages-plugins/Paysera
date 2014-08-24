<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\Mokejimai;


class Model
{
    public static function createPayment($paymentData, $userId = null)
    {
        if ($userId == null) {
            $userId = ipUser()->userId();
        }





        $data = array(
            'title' => empty($paymentData['title']) ? '' : $paymentData['title'],
            'cancelUrl' => empty($paymentData['cancelUrl']) ? '' : $paymentData['cancelUrl'],
            'successUrl' => empty($paymentData['successUrl']) ? '' : $paymentData['successUrl'],
            'orderId' => $paymentData['id'],
            'currency' => $paymentData['currency'],
            'price' => $paymentData['price'],
            'userId' => $userId,
            'securityCode' => self::randomString(32),
            'createdAt' => date('Y-m-d H:i:s')
        );


        $paymentId = ipDb()->insert('Mokejimai', $data);
        return $paymentId;
    }



    public static function getPayment($paymentId)
    {
        $order = ipDb()->selectRow('Mokejimai', '*', array('id' => $paymentId));
        return $order;
    }
    public static function update($paymentId, $data)
    {
        ipDb()->update('Mokejimai', $data, array('id' => $paymentId));
    }


    protected static function randomString($length)
    {
        return substr(sha1(rand()), 0, $length);
    }
}
