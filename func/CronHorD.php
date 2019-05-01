<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 3/03/2018
 * Time: 09:08
 */

require 'Conexion.php';
require 'Fecha.php';
require 'Notificaciones.php';

$con = Conexion::conecction();
$dia = Fecha::_dia();
$hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
$act = 1;

$stmt = $con->prepare("SELECT asignatura.nombre, token.tokenu, horario.inicio, horario.fin FROM asignatura
        INNER JOIN asignaturad ON asignatura.id = asignaturad.asignatura
        INNER JOIN horario ON asignatura.id = horario.id_asignatura
        INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
        INNER JOIN token ON usuarios.user = token.id_user
        WHERE horario.id_dia LIKE ?");
$stmt->bindParam(1,$dia,PDO::PARAM_INT);
$stmt->execute();
while ($res = $stmt->fetch()){
    Notificaciones::aanotificaciones($res['nombre'],$res['tokenu'],$hoy,'Tiene que dar catedra a las: '.$res['inicio'].' hasta las: '.$res['fin']);
}