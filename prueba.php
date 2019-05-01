<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 5/02/2018
 * Time: 21:47
 */
/*
   Un string que no contiene el delimitador simplemente
   devolverá un array de longitud uno con el string original.
*/
$entrada1 = "07:13";
var_dump( explode( ':', $entrada1 ) );

require_once ("func/Fecha.php");

echo Fecha::_dia();// 1,2,3,4,5,6,7
echo Fecha::_date("Y-m-d", false, 'America/Lima'); //0000-00-00
echo Fecha::_dian();//lunes,martes,.....
echo Fecha::_hora(); //00:00:00
