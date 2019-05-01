<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 6/10/2018
 * Time: 19:58
 */
require 'Fecha.php';

echo Fecha::_date("Y-m-d", false, 'America/Lima');
echo Fecha::_hora();

echo '</br>';
$fecha = Fecha::_date("Y-m-d", false, 'America/Lima').' '.Fecha::_hora();
echo $fecha;