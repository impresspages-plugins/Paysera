<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\Paysera;


class PublicController extends \Ip\Controller
{



    public function userBack()
    {
        $data = $this->processNotification();

        $customData = json_decode($data['parameters'], true);

        if (!empty($data['orderId'])) {

            $paymentId = $data['orderId'];
            if (!empty($customData['securityCode'])) {
                $securityCode = $customData['securityCode'];

                $payment = Model::getPayment($customData['paymentId']);


                if ($payment) {
                    if ($payment['isPaid']) {
                        $response = Helper::responseAfterPayment($paymentId, $securityCode);
                    } else {
                        $viewData = array(
                            'payment' => $payment
                        );
                        $response = ipView('view/paymentError.php', $viewData);
                    }

                }
            }
        }

        if (empty($response)) {
            $response = ipView('view/unknownError.php');
        }

        $response = ipFilter('Paysera_userBackResponseError', $response);
        return $response;

    }

    public function ipn()
    {
        $this->processNotification();
        $response = new \Ip\Response();
        $response->setContent('OK');
        return $response;
    }

    protected function processNotification()
    {
        $paymentModel = PaymentModel::instance();
        ipLog()->info('Paysera.ipn: Paysera notification', ipRequest()->getPost());
        $data = $paymentModel->processCallback();
        return $data;
    }

}
