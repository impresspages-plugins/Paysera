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


        if (!empty($data['orderid'])) {
            $paymentId = $data['orderid'];
            $securityCode = $data['parameters'];
            if (!empty($securityCode)) {
                $payment = Model::getPayment($paymentId);
                if ($payment) {
                    if ($payment['isPaid']) {
                        $response = Helper::responseAfterPayment($paymentId, $securityCode);
                    } else {
                        $viewData = array(
                            'payment' => $payment
                        );
                        $response = ipView('view/page/paymentError.php', $viewData);
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
        ipLog()->info('Paysera.ipn: Paysera notification', ['get' => ipRequest()->getQuery(), 'post' => ipRequest()->getPost()]);
        $data = $paymentModel->processCallback();
        return $data;
    }

    public function sms()
    {
        $paymentModel = PaymentModel::instance();
        $data = $paymentModel->processSMS();

        // default
        $content = 'ERROR';

        if ($data) {
            ipEvent('Paysera_smsReceived', $data);

            $content = 'OK';
            $content = ipFilter('Paysera_smsResponse', $content, $data);
        }

        $response = new \Ip\Response();
        $response->setContent($content);

        return $response;
    }

}
