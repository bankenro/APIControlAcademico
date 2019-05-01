<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 2/02/2018
 * Time: 09:40
 */

//define('GOOGLE_API_KEY', 'AIzaSyC5_XaSB_Br8YbR-j95WRvRMwBm95zrtZ0');
define('GOOGLE_API_KEY', 'AAAA3yz0Ckk:APA91bG3Ns97p96ZH1q6e8QaQ2D_OuKzPvCzlwWYVWTayu5vRQiSUEhokRByM8yuubOEkf4Eo_kjTzzqx0cvqfL1nlkBzwUdEX-D2Y1bKuY1QDyZG3Wg6Dek43bIP0g1L0Dekeg9jK6G');

class Notificaciones {
    static function aanotificaciones($nombre,$token,$fecha,$asistio){

        ignore_user_abort();
        ob_start();

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array('to' => $token,
            'data' => array('titulo' => $nombre,'fecha'=> $fecha, 'mensaje'=>$asistio));


        $headers = array(
            'Authorization:key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === false)
            die('Curl failed ' . curl_error($ch));
        curl_close($ch);
        return $result;
    }

}