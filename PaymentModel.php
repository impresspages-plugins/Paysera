<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\Paysera;


class PaymentModel
{

    const MODE_PRODUCTION = 'Production';
    const MODE_TEST = 'Test';
    const MODE_SKIP = 'Skip';


    protected static $instance;

    protected function __construct()
    {
        if ($this->projectId() == '' || $this->password() == '') {
            throw new \Ip\Exception('Please enter project ID and password in Paysera plugin configuration.');
        }
    }

    protected function __clone()
    {
    }

    /**
     * Get singleton instance
     * @return PaymentModel
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new PaymentModel();
        }

        return self::$instance;
    }

    public function processCallback()
    {
        require_once('WebToPay.php');

        $response = array();

        try {
            $response = WebToPay::validateAndParseData(ipRequest()->getQuery(), $this->projectId(), $this->password());

            if ($response['test'] != PaymentModel::isTestMode()) {
                ipLog()->error('Paysera.ipn: test mode parameter don\'t match', $response);
                return false;
            }
            if ($response['type'] !== 'macro') {
                ipLog()->error('Paysera.ipn: Only macro payment callbacks are accepted', $response);
                return false;
            }

            $paymentId = $response['orderid'];
            $amount = $response['amount'];
            $currency = $response['currency'];

            $payment = Model::getPayment($paymentId);

            if ($payment['isPaid']) {
                return $response;
            }

            if ($payment['price'] != $amount) {
                ipLog()->error('Paysera.ipn: Price don\'t match.', array_merge($response, array('expectedPrice' => $payment['price'], 'recieved' => $amount)));
                return false;
            }
            if ($payment['currency'] != $currency) {
                ipLog()->error('Paysera.ipn: currencies don\'t match.', array_merge($response, array('expectedCurrency' => $payment['currency'], 'recieved' => $currency)));
                return false;
            }

            $this->markAsPaid($paymentId);


            return $response;

        } catch (\Exception $e) {
            ipLog()->error('Paysera.ipn: ' . get_class($e) . ' ' . $e->getMessage(), $response);
        }

    }

    public function markAsPaid($paymentId, $dbData = array(), $eventData = array())
    {
        $payment = Model::getPayment($paymentId);

        $dbData['isPaid'] = 1;
        Model::update($paymentId, $dbData);

        $info = array(
            'id' => $payment['orderId'],
            'paymentId' => $payment['id'],
            'paymentMethod' => 'Paysera',
            'title' => $payment['title'],
            'userId' => $payment['userId']
        );
        $info = array_merge($info, $eventData);
        ipEvent('ipPaymentReceived', $info);

    }



    public function getPayseraForm($paymentId)
    {
        require_once('WebToPay.php');

        $payment = Model::getPayment($paymentId);
        if (!$payment) {
            throw new \Ip\Exception("Can't find order id. " . $paymentId);
        }



        $options = array(
            'projectid'     => $this->projectId(),
            'sign_password' => $this->password(),
            'orderid'       => $paymentId,
            'amount'        => $payment['price'],
            'currency'      => $payment['currency'],
            'accepturl'     => ipRouteUrl('Paysera_return'),
            'callbackurl'   => ipRouteUrl('Paysera_ipn'),
            'test'          => $this->isTestMode() ? "1" : "0",
            'cancelurl'     => ipConfig()->baseUrl(),
            'parameters'    => $payment['securityCode']
        );



        $request = WebToPay::redirectToPayment($options);
        var_dump($request);exit;



    }

    /**
     *
     *  Returns $data encoded in UTF8. Very useful before json_encode as it fails if some strings are not utf8 encoded
     * @param mixed $dat array or string
     * @return array
     */
    private function checkEncoding($dat)
    {
        if (is_string($dat)) {
            if (mb_check_encoding($dat, 'UTF-8')) {
                return $dat;
            } else {
                return utf8_encode($dat);
            }
        }
        if (is_array($dat)) {
            $answer = array();
            foreach ($dat as $i => $d) {
                $answer[$i] = $this->checkEncoding($d);
            }
            return $answer;
        }
        return $dat;
    }


    public function projectId()
    {
        return ipGetOption('Paysera.projectId');
    }


    public function password()
    {
        return ipGetOption('Paysera.password');
    }


    public function isTestMode()
    {
        return ipGetOption('Paysera.mode') == self::MODE_TEST;
    }


    public function isSkipMode()
    {
        return ipGetOption('Paysera.mode') == self::MODE_SKIP;
    }

    public function isProductionMode()
    {
        return ipGetOption('Paysera.mode') == self::MODE_PRODUCTION;
    }

    public function secretWord()
    {
        return ipGetOption('Paysera.secretWord');
    }

    public function correctConfiguration()
    {
        if ($this->getActive() && $this->getSid()) {
            return true;
        } else {
            return false;
        }
    }

}
