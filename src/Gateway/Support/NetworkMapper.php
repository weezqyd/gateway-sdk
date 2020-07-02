<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 1/28/19
 * Time: 8:07 PM
 */

namespace Roamtech\Gateway\Support;


class NetworkMapper
{
    public static function getNetwork($msisdn)
    {
        $networkRegexPatterns = [
            /* Safaricom KE Suffix */
            'safaricom' => "/^\+?(?:254|0)(7(?:[0129]\d{7}|5[789]\d{6}|4[01234568]\d{6}|6[89]\d{6})|1(?:1[01]\d{6}))$/",
            /* Airtel KE Suffix */
            'airtel' => "/^\+?(?:254|0)(7(?:[38]\d{7}|5[0123456]\d{6})|1(?:0[1]\d{6}))$/",
            /* Telkom KE Suffix */
            'telkom' => "/^\+?(?:254|0)7(?:[7]\d{7})$/",
            /* Equitel KE Suffix */
            'equitel' => "/^\+?(?:254|0)7(?:6[345]\d{6})$/",
            /* Faiba 4G KE network*/
            'faiba' => "/^\+?(?:254|0)7(?:4[7]\d{6})$/",
            /* Vodacom TZ Suffix */
            'vodacom' => '/^\+?2557(?:[654]\d{7})$/',
        ];
        foreach ($networkRegexPatterns as $network => $regex) {
            if (preg_match($regex, $msisdn)) {
                return $network;
            }
        }
        return false;
    }
}
