<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 2/02/2018
 * Time: 09:14
 */

class Conexion {
    static function conecction(){
        try {
            //$con = new PDO('mysql:host=localhost;dbname=u113784787_ca1;charset=utf8', 'u113784787_cag', 'FIDxE6wcRvFJ');
            $con = new PDO('mysql:host=localhost;dbname=ca1;charset=utf8', 'root', '');
            //URtzZ82Dc7A
            return $con;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}