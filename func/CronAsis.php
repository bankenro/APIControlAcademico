<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 2/03/2018
 * Time: 17:37
 */

require 'Conexion.php';
require 'Fecha.php';
require 'Notificaciones.php';

$con = Conexion::conecction();
$hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
$hora = Fecha::_hora();
$dia = Fecha::_dia();

$stmt = $con->prepare("SELECT id_asignatura FROM horario
        WHERE id_dia LIKE ? AND horario.inicio <= ? AND horario.fin >= ?");

$stmt->bindParam(1, $dia, PDO::PARAM_INT);
$stmt->bindParam(2, $hora, PDO::PARAM_STR);
$stmt->bindParam(3, $hora, PDO::PARAM_STR);

$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;
foreach ($res as $re) {
    $stmt = $con->prepare("SELECT * FROM asistencia WHERE codigoasig LIKE ? AND fecha LIKE ?");
    $stmt->bindParam(1, $re['id_asignatura'], PDO::PARAM_INT);
    $stmt->bindParam(2, $hoy, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() <= 0) {
        $stmt1 = $con->prepare("SELECT token.tokenu, asignatura.nombre FROM asignaturad
                INNER JOIN asignatura ON asignaturad.asignatura = asignatura.id
                INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
                INNER JOIN token ON usuarios.user = token.id_user 
                WHERE asignaturad.asignatura LIKE ? ");
        $stmt1->bindParam(1, $re['id_asignatura'], PDO::PARAM_INT);
        $stmt1->execute();
        while ($res1 = $stmt1->fetch()) {
            Notificaciones::aanotificaciones('Asignatura: '.$res1['nombre'], $res1['tokenu'], $hoy, 'Registre la asistencia');
        }
    }
}