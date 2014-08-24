<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\Mokejimai;


class Payment extends \Ip\Payment
{
    public function name()
    {
        return '2checkout';
    }

    public function icon($width = null, $height = null)
    {
        return ipFileUrl('Plugin/Mokejimai/assets/2checkout.png');
    }

    public function html()
    {
        return ipView('view/paymentWindowHtml.php');
    }


    /**
     * This method should generate payment URL.
     * Typical actions of this method:
     * 1 write down all passed data to the database table
     * 2 return URL which starts payment method execution
     *
     * @param array $data subscription data
     * @return string
     */
    public function paymentUrl($data)
    {
        $paymentId = Model::createPayment($data);
        $payment = Model::getPayment($paymentId);
        $urlData = array(
            'paymentId' => $paymentId,
            'securityCode' => $payment['securityCode']
        );
        return ipRouteUrl('Mokejimai_pay', $urlData);
    }
}
