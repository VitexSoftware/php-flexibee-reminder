<?php

/**
 * FlexiBee Reminder obtauin SMS number for FlexiBee Address
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2020 Vitex Software
 */

namespace FlexiPeeHP\Reminder;

use Ease\Functions;
use FlexiPeeHP\Adresar;

/**
 * Description of SmsToCustomer
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class SmsToAddress extends Sms {

    /**
     * Send SMS to default Phone number
     * 
     * @param Adresar $address
     * @param string              $message
     */
    public function __construct($address, $message = '') {
        if (Functions::cfg('MUTE') && (Functions::cfg('MUTE') == 'true')) {
            $smsNo = Functions::cfg('SMS_SENDER');
        } else {
            $smsNo = $address->getAnyPhoneNumber();
        }
        parent::__construct($smsNo, $message);
        if (empty($smsNo)) {
            $address->addStatusMessage($address->getRecordIdent() . ' ' . $address->getApiURL() . ' ' . _('Address or primary contact without any phone number'),
                    'warning');
        }
    }

}
