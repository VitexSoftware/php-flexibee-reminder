<?php

use FlexiPeeHP\Reminder\SmsToAddress;
/**
 * FlexiBee Reminder Axfone API client
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2020 Vitex Software
 */


namespace FlexiPeeHP\Reminder;

/**
 * Description of Axone
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class SmsByAxfone extends SmsToAddress {

    public $api_url_protocol = "https://";
    public $api_user_name = "";
    public $api_password = "";
    public $api_url_host = "sms.axfone.eu";
    public $api_user_id = "";
    public $api_function = "";
    public $api_parameter = "";
    public $api_full_url = null;
    public $api_parameters = [];
    private $curl = null;
    public $numberSent = null;
    public $lastResponseCode;

    
    public function __construct($smsNo = null, $message = null) {
        parent::__construct($smsNo, $message);
        $this->setup();
        $this->curlInit();
    }

    public function setup() {
        $this->api_url_protocol = "https://";
        $this->api_user_name = constant('AXFONE_USERNAME');
        $this->api_password = constant('AXFONE_PASSWORD');
        $this->api_url_host = "sms.axfone.eu";
        $this->api_user_id = $this->api_user_name;
        $this->api_parameters = ["MT_Source" => urlencode(constant('SMS_SENDER'))];
        $this->api_full_url = $this->api_url_protocol . $this->api_url_host . "/" . $this->api_user_id . "/";
    }

    public function curlInit() {
        $this->curl = \curl_init(); // create curl resource
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true); // return content as a string from curl_exec
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true); // follow redirects (compatibility for future changes in FlexiBee)
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, true);       // HTTP authentication
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false); // FlexiBee by default uses Self-Signed certificates
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_VERBOSE, false); // For debugging

        curl_setopt($this->curl, CURLOPT_USERPWD,
                $this->api_user_name . ':' . $this->api_password); // set username and password
    }

    function callAxfoneApi($api_full_url, $api_function, $api_parameters) {
        switch ($api_function) {
            case "send_sms":

                $mt_source = $api_parameters["MT_Source"];
                $mt_destination = preg_replace('/^420/', '',
                        $api_parameters["MT_Destination"]);

                if (substr($mt_destination, 0, 6) !== "%2b420") {
                    $mt_destination = "%2b420" . $mt_destination;
                }
                $mt_data = rawurlencode($this->api_parameters["MT_Data"]);
                $mt_refid = $this->api_parameters["MT_RefID"];
                $api_url_params = "?MT_Source=" . $mt_source . "&MT_Destination=" . $mt_destination . "&MT_Data=" . $mt_data . "&MT_RefID=" . $mt_refid;
                break;
        }

        $url = ($this->api_full_url . $api_function . "/" . $api_url_params);




        curl_setopt($this->curl, CURLOPT_URL, $url);
// Nastavení samotné operace
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
//Vždy nastavíme byť i prázná postdata jako ochranu před chybou 411
//        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postFields);
//        $httpHeaders = $this->defaultHttpHeaders;
//
//        $formats = Formats::bySuffix();
//
//        if (!isset($httpHeaders['Accept'])) {
//            $httpHeaders['Accept'] = $formats[$format]['content-type'];
//        }
//        if (!isset($httpHeaders['Content-Type'])) {
//            $httpHeaders['Content-Type'] = $formats[$format]['content-type'];
//        }
//        $httpHeadersFinal = [];
//        foreach ($httpHeaders as $key => $value) {
//            if (($key == 'User-Agent') && ($value == 'FlexiPeeHP')) {
//                $value .= ' v'.self::$libVersion;
//            }
//            $httpHeadersFinal[] = $key.': '.$value;
//        }
//
//        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $httpHeadersFinal);
// Proveď samotnou operaci
        $this->lastCurlResponse = curl_exec($this->curl);
        $this->curlInfo = curl_getinfo($this->curl);
        $this->curlInfo['when'] = microtime();
        $this->lastCurlError = curl_error($this->curl);
        $this->lastResponseCode = $this->curlInfo['http_code'];

        if (($this->lastResponseCode != 200) || strstr($this->lastResponseCode,
                        'ERROR')) {
            $this->addStatusMessage(urldecode($mt_destination) . ': ' . str_replace("\n",
                            ' ', strip_tags($this->lastCurlResponse)), 'error');
        }
        return $this->lastResponseCode == 200;
    }

    /**
     * 
     * @param string $sms
     * 
     * @return boolean
     */
    function sendSmsMessage($sms) {

        $sms_id = $this->getMyKey();
        $sms_klient_id = $this->getDataValue('specSym');

        $this->api_parameters["MT_Destination"] = self::unifyTelNo($this->number);
        $this->api_parameters["MT_Data"] = $sms;
        $this->api_parameters["MT_RefID"] = $sms_id . "|" . $sms_klient_id . "|" . time();

        $sms_action_result["status"] = $this->callAxfoneApi($this->api_full_url,
                "send_sms", $this->api_parameters);

        $this->addStatusMessage($this->api_parameters["MT_Destination"] . ':' . $sms,
                !$sms_action_result["status"] ? 'error' : 'success');

        if (!$sms_action_result["status"]) {
            //echo "Nastala chyba při odesílání SMS!";
            return false;
        }
        $sms_action_result["ref_id"] = $sms_id;
        return $sms_action_result;
    }

    public function sendMessage() {
        return $this->sendSmsMessage($this->message);
    }

}
