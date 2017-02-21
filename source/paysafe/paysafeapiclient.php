<?php
/*
 * Copyright (c) 2014 Paysafe
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Paysafe;

class PaysafeApiClient
{
    /**
	 * The merchant's api key
	 *
	 * @var string
	 */
    private $keyID;

    /**
	 * The merchant's api secret
	 *
	 * @var string
	 */
    private $keyPassword;

    /**
	 * Specify whether to submit requests to production or testing
	 */
    private $environment;

    /**
	 * The endpoint to submit requests (based on specified environment)
	 *
	 * @var string
	 */
    private $apiEndPoint;

    /**
	 * Accout number used by cardpayments service
     *
	 * @var string
	 */
    private $account;

    /**
     * Path to Root CA cert
     *
     * @var string
     */
    protected static $caCertPath = null;

    /**
     * Set the path to the root CA certificate for use with cURL
     * @param string $path
     * @throws OptimalException if path is invalid
     */
    public static function setCACertPath($path)
    {
        if (!file_exists($path)) {
            throw new PaysafeException('Invalid CA cert path: ' . $path);
        }
        self::$caCertPath = realpath($path);
    }

    /**
     * Get the path to the root CA certificate for use with cURL.
     * @return string
     * @throws OptimalException if path is not set
     */
    public static function getCACertPath()
    {
        return self::$caCertPath;
    }


    /**
	 * Instantiates a new net banx api client.
	 *
	 * @param string $keyID
	 * @param string $keyPassword
	 * @param string $environment \OptimalPayments\Environment::TEST (default) or \OptimalPayments\Environment::LIVE
	 * @param string $account
	 * @throws OptimalException
	 */
    public function __construct($keyID, $keyPassword, $environment = null, $account = null)
    {
        if (!is_scalar($keyID)) {
            throw new PaysafeException('Invalid parameter $keyId. String Expected');
        }
        if (!is_scalar($keyPassword)) {
            throw new PaysafeException('Invalid parameter $keyPassword. String Expected');
        }

        if (is_null($environment)) {
            $environment = Environment::TEST;
        }

        if ($environment != Environment::TEST && $environment != Environment::LIVE) {
            throw new PaysafeException('Invalid parameter $environment');
        }

        $this->keyID = $keyID;
        $this->keyPassword = $keyPassword;
        $this->environment = $environment;

        if ($this->environment == Environment::TEST) {
            $this->apiEndPoint = "https://api.test.paysafe.com";
        } else {
            $this->apiEndPoint = "https://api.paysafe.com";
        }

        $this->account = $account;
    }

    /**
	 * Get the netbanx merchant account number
	 * @return string
	 */
    public function getAccount()
    {
        return $this->account;
    }

    /**
	 * Set the netbanx merchant account number
	 *
	 * @param string $account
	 */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
	 * Card payment service.
	 * @return \OptimalPayments\CardPaymentService
	 */
    public function cardPaymentService()
    {
        return new CardPaymentService($this);
    }

    /**
	 * Customer vault service.
	 *
	 * @return \OptimalPayments\CustomerVaultService
	 */
    public function customerVaultService()
    {
        return new CustomerVaultService($this);
    }


     /**
     * Direct Debit service.
     *
     * @return \OptimalPayments\DirectDebitService
     */
    public function directDebitService() {
        return new DirectDebitService($this);
    }

    /**
     * Threed Secure  service.
     *
     * @return \OptimalPayments\ThreedSecureService
     */
    public function threeDSecureService() {
        return new ThreeDSecureService($this);
    }

    /**
	 *
	 * @param \OptimalPayments\Request $request
	 * @return type
	 * @throws NetbanxException
	 * @throws \OptimalPayments\NetbanxException
	 */
    public function processRequest(Request $request)
    {
        $curl = curl_init();
        $opts = array(
             CURLOPT_URL => $request->buildUrl($this->apiEndPoint),
             CURLOPT_HTTPHEADER => array(
                  'Authorization: Basic ' . base64_encode($this->keyID . ':' . $this->keyPassword),
                  'Content-Type: application/json; charset=utf-8'
             ),
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_SSL_VERIFYPEER => true,
             CURLOPT_SSL_VERIFYHOST => 2,
        );
        if(($cert = static::getCACertPath())) {
            $opts[CURLOPT_CAINFO] = $cert;
        } elseif (($cert = getenv('SSL_CERT_FILE'))) {
            $opts[CURLOPT_CAINFO] = $cert;
        }
        if ($request->method != Request::GET) {
            $jsonData = ($request->body?$request->body->toJson():"");
            $opts[CURLOPT_CUSTOMREQUEST] = $request->method;
            $opts[CURLOPT_POSTFIELDS] = $jsonData;
            $opts[CURLOPT_HTTPHEADER][] = 'Content-Length: ' . strlen($jsonData);
        }
        curl_setopt_array($curl, $opts);
        $response = curl_exec($curl);
        if($response === false) {
            throw $this->getNetBanxException(null, 'cURL has encountered an error in connecting to the host: (' . curl_errno($curl) . ') ' . curl_error($curl) . '. See cURL error codes for explanations: http://curl.haxx.se/libcurl/c/libcurl-errors.html', curl_errno($curl));
        }
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (!($return = json_decode($response, true))) {
            if ($responseCode < 200 || $responseCode >= 206) {
                throw $this->getNetbanxException($responseCode);
            }
            return true;
        }

        if (is_array($return)) {
            if ($responseCode < 200 || $responseCode >= 206) {
                $error = $this->getNetbanxException($responseCode, $return['error']['message'], $return['error']['code']);
                $error->rawResponse = $return;
                if(array_key_exists('error', $return)) {
                    if (array_key_exists('fieldErrors', $return['error'])) {
                        $error->fieldErrors = $return['error']['fieldErrors'];
                    }
                    if (array_key_exists('links', $return['error'])) {
                        $error->links = $return['error']['links'];
                    }
                    if (array_key_exists('details', $return['error'])) {
                        $error->details = $return['error']['details'];
                    }
                }
                throw $error;
            }
            return $return;
        } else {
            throw $this->getNetbanxException($responseCode, $return);
        }
    }

    /**
	 * Return the correct exception type based on http code
	 *
	 * @param type $httpCode
	 * @param type $message
	 * @param type $code
	 * @return NetbanxException
	 */
    private function getNetbanxException($httpCode, $message = null, $code = null)
    {
        if(!$message) {
            $message = "An unknown error has occurred.";
        }
        if(!$code) {
            $code = $httpCode;
        }

        $exceptionType = '\Paysafe\NetbanxException';
        switch($httpCode) {
            case '400':
                $exceptionType = '\Paysafe\InvalidRequestException';
                break;
            case '401':
                $exceptionType = '\Paysafe\InvalidCredentialsException';
                break;
            case '402':
                $exceptionType = '\Paysafe\RequestDeclinedException';
                break;
            case '403':
                $exceptionType = '\Paysafe\PermissionException';
                break;
            case '404':
                $exceptionType = '\Paysafe\EntityNotFoundException';
                break;
            case '409':
                $exceptionType = '\Paysafe\RequestConflictException';
                break;
            case '406':
            case '415':
                $exceptionType = '\Paysafe\APIException';
                break;
            default:
                if($httpCode >= 500) {
                    $exceptionType = '\Paysafe\APIException';
                }
                break;

        }

        return new $exceptionType($message,$code);
    }

}
