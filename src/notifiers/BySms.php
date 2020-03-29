<?php

use FlexiPeeHP\Reminder\SmsByAxfone;
use FlexiPeeHP\Reminder\SmsByGnokii;
use FlexiPeeHP\Reminder\SmsBySshGnokii;
use FlexiPeeHP\Reminder\Upominac;
use FlexiPeeHP\Reminder\Upominka;

/**
 * FlexiPeeHP - Remind by SMS class 
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2018-2020 Spoje.Net, Vitex Software
 */
class BySms extends \Ease\Sand {

    /**
     *
     * @var boolean status 
     */
    public $result = null;

    /**
     * eMail notification
     * 
     * @param Upominac $reminder
     * @param int                          $score     weeks of due
     * @param array                        $debts     array of debts by current customer
     */
    public function __construct($reminder, $score, $debts) {
        $result = false;
        if (defined('SMS_ENGINE')) {
            if ($reminder->customer->adresar->getAnyPhoneNumber()) {
                $message = $this->compile($score, $reminder->customer, $debts);

                switch (constant('SMS_ENGINE')) {
                    case 'axfone':
                        $smsEngine = new SmsByAxfone($reminder->customer->adresar,
                                $message);
                        break;
                    case 'gnokii':
                        $smsEngine = new SmsByGnokii($reminder->customer->adresar,
                                $message);
                        break;
                    case 'sshgnokii':
                        $smsEngine = new SmsBySshGnokii($reminder->customer->adresar,
                                $message);
                        break;
                    default:
                        $smsEngine = null;
                        break;
                }

                if ($smsEngine) {

//            file_put_contents('/var/tmp/upominka.txt',$message);
                    if (($score > 0) && ($score < 4) && $result) {
                        setData(['id' => $reminder->customer->adresar->getRecordID(),
                            'stitky' => 'UPOMINKA' . $score], true);
                        $reminder->addStatusMessage(sprintf(_('Set Label %s '),
                                        'UPOMINKA' . $score),
                                $reminder->customer->adresar->sync() ? 'success' : 'error' );
                    }

                    $this->result = $result;
                }
            } else {
                $this->addStatusMessage(sprintf(_('Client %s without phone neumber %s !!!'),
                                $reminder->customer->adresar->getDataValue('nazev'),
                                $reminder->customer->adresar->getApiURL()), 'warning');
            }
        }
    }

    
    /**
     * Compile SMS reminder
     * 
     * @param type $score
     * @param type $customer
     * @param type $clientDebts
     * 
     * @return string
     */
    public function compile($score, $customer, $clientDebts) {
        $result = false;
        $nazev = $customer->adresar->getDataValue('nazev');


        $upominka = new Upominka();
        switch ($score) {
            case 1:
                $upominka->loadTemplate('prvniUpominka');
                break;
            case 2:
                $upominka->loadTemplate('druhaUpominka');
                break;
            case 3:
                $upominka->loadTemplate('pokusOSmir');
                break;
            default :
                $upominka->loadTemplate('inventarizace');
        }



        $dnes = new DateTime();
        $subject = $upominka->getDataValue('hlavicka') . ' ke dni ' . $dnes->format('d.m.Y');
        $heading = $upominka->getDataValue('uvod') . ' ' . $nazev . "\n" . $upominka->getDataValue('textNad') . "\n" . Upominac::formatTotals(Upominka::getSums($clientDebts));
        $result = $subject . ':' . $heading;


        return $result;
    }

}
