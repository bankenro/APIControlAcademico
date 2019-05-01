<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 28/02/2018
 * Time: 14:40
 */

date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'spanish');
class Fecha {

    static function _date($format = "r", $timestamp = false, $timezone = false) {
        $userTimezone = new DateTimeZone(!empty($timezone) ? $timezone : 'GMT');
        $gmtTimezone = new DateTimeZone('GMT');
        $myDateTime = new DateTime(($timestamp != false ? date("r", (int)$timestamp) : date("r")), $gmtTimezone);
        $offset = $userTimezone->getOffset($myDateTime);
        return date($format, ($timestamp != false ? (int)$timestamp : $myDateTime->format('U')) +$offset);
    }

    static function _hora(){
        return utf8_encode(strftime('%H:%M:%S'));
    }
    static function _dia(){
        return utf8_encode(strftime('%u'));
    }
    static function _dian(){
        return utf8_encode(strftime('%A'));
    }
}