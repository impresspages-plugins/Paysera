<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\Paysera;


class PublicController extends \Ip\Controller
{



    public function userBack()
    {
        $this->processNotification();

        $customData = json_decode(ipRequest()->getRequest('custom'), true);
        if (empty($customData['paymentId'])) {
            throw new \Ip\Exception("Unknown order ID");
        }
        if (empty($customData['securityCode'])) {
            throw new \Ip\Exception("Unknown order security code");
        }

        $payment = Model::getPayment($customData['paymentId']);

        if ($payment['isPaid']) {
            $response = Helper::responseAfterPayment($customData['paymentId'], $customData['securityCode']);
            return $response;
        } else {
            $viewData = array(
                'payment' => $payment
            );
            $response = ipView('view/paymentError.php', $viewData);
            $response = ipFilter('Paysera_userBackResponseError', $response);
            return $response;
        }


    }

    protected function processNotification()
    {
        $paymentModel = PaymentModel::instance();
        $postData = ipRequest()->getPost();
        ipLog()->info('Paysera.ipn: Paysera notification', $postData);
        $paymentModel->processCallback($postData);
    }

}
