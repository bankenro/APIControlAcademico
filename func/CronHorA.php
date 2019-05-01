<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 2/03/2018
 * Time: 20:31
 */

require 'Conexion.php';
require 'Fecha.php';
require 'Notificaciones.php';

$con = Conexion::conecction();
$dia = Fecha::_dia();
$hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
$act = 1;

$stmt = $con->prepare("SELECT token.tokenu,asignatura.nombre,horario.inicio,horario.fin FROM usuarios
        INNER JOIN token ON usuarios.user = token.id_user
        INNER JOIN matriculaa ON usuarios.user = matriculaa.user
        INNER JOIN asignatura ON matriculaa.asignatura = asignatura.id
        INNER JOIN horario ON asignatura.id = horario.id_asignatura
        WHERE matriculaa.activo LIKE ? AND horario.id_dia LIKE ?");
$stmt->bindParam(1,$act,PDO::PARAM_INT);
$stmt->bindParam(2,$dia,PDO::PARAM_INT);
$stmt->execute();
while ($res = $stmt->fetch()){
    Notificaciones::aanotificaciones($res['nombre'],$res['tokenu'],$hoy,'Tiene clases a las: '.$res['inicio'].' hasta las: '.$res['fin']);
}