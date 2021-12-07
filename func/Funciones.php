<?php
/**
 * Created by PhpStorm.
 * User: GlobalTIC's
 * Date: 2/02/2018
 * Time: 09:37
 */

require 'Notificaciones.php';
require 'Conexion.php';
require 'Fecha.php';
require $_SERVER['DOCUMENT_ROOT'] . '/APIControlAcademico/reportes/Reporte.php';
//require '../reportes/Reporte.php';
//rfROLXhZjS
//hosting cWD0P305iIPZ
//bd pssrd $i$tema$1
class Funciones {

    static function ComprobarCodigo($codigo1) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT user FROM usuarios WHERE user LIKE ?");
        $stmt->bindParam(1, $codigo1, PDO::PARAM_INT);
        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data [] = array('mensaje' => 'El codigo ' . $res['user'] . ' ya esta en uso');
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function ComprobarCorreo($correo1) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT correo FROM usuarios WHERE usuarios.correo LIKE ?");
        $stmt->bindParam(1, $correo1, PDO::PARAM_STR);
        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data [] = array('mensaje' => 'El correo ' . $res['correo'] . ' ya esta en uso');
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function ComprobarTelefono($telefono1) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT ntelefono FROM usuarios WHERE usuarios.ntelefono LIKE ?");
        $stmt->bindParam(1, $telefono1, PDO::PARAM_INT);
        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data [] = array('mensaje' => 'El numero de telefono ' . $res['ntelefono'] . ' ya esta en uso');
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function ComprobarDNI($documento1) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT ndoc FROM usuarios WHERE usuarios.ndoc LIKE ?");
        $stmt->bindParam(1, $documento1, PDO::PARAM_INT);
        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data [] = array('mensaje' => 'El numero de documento ' . $res['ndoc'] . ' ya esta en uso');
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function registrarUsuario($nombre1, $apellidop1, $apellidom1, $correo1, $sexo1, $foto1, $codigo1,
                                     $password, $doc, $telefono1, $fecha1, $tdocumento1, $documento1, $nacimiento,
                                     $activo, $escuela, $sede) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO usuarios (nombres,apellidop,apellidom,foto,correo,tdoc,ndoc,user,
							          password,tipo,genero,ntelefono,fnacimiento,lnacimiento,activo,ep,sede) 
							    		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $nombre1, PDO::PARAM_STR);
        $stmt->bindParam(2, $apellidop1, PDO::PARAM_STR);
        $stmt->bindParam(3, $apellidom1, PDO::PARAM_STR);
        $stmt->bindParam(4, $foto1, PDO::PARAM_LOB);
        $stmt->bindParam(5, $correo1, PDO::PARAM_STR);
        $stmt->bindParam(6, $tdocumento1, PDO::PARAM_INT);
        $stmt->bindParam(7, $documento1, PDO::PARAM_INT);
        $stmt->bindParam(8, $codigo1, PDO::PARAM_INT);
        $stmt->bindParam(9, $password, PDO::PARAM_STR);
        $stmt->bindParam(10, $doc, PDO::PARAM_INT);
        $stmt->bindParam(11, $sexo1, PDO::PARAM_INT);
        $stmt->bindParam(12, $telefono1, PDO::PARAM_INT);
        $stmt->bindParam(13, $fecha1, PDO::PARAM_STR);
        $stmt->bindParam(14, $nacimiento, PDO::PARAM_INT);
        $stmt->bindParam(15, $activo, PDO::PARAM_INT);
        $stmt->bindParam(16, $escuela, PDO::PARAM_INT);
        $stmt->bindParam(17, $sede, PDO::PARAM_INT);


        if ($stmt->execute()) {

            $data[] = array('mensaje' => 'Usuario registrado con exito');

            echo json_encode($data);

        }
    }

    static function ComprobarHoraAsistencia($coda) {

        $con = Conexion::conecction();
        $hora = Fecha::_hora();
        $dia = Fecha::_dia();
        $stmt = $con->prepare("SELECT asignatura.nombre,horario.inicio,horario.fin FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                WHERE horario.id_asignatura LIKE ? AND horario.id_dia LIKE ? AND horario.inicio <= ? AND horario.fin >= ?");
        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $dia, PDO::PARAM_INT);
        $stmt->bindParam(3, $hora, PDO::PARAM_STR);
        $stmt->bindParam(4, $hora, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function MostrarHorAsig($coda) {
        $con = Conexion::conecction();
        $dia = Fecha::_dia();
        $data = array();
        $stmt = $con->prepare("SELECT asignatura.nombre,horario.inicio,horario.fin FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                WHERE horario.id_asignatura LIKE ? AND horario.id_dia LIKE ?");
        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $dia, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() >= 1) {
            while ($res = $stmt->fetch()) {
                $data[] = array('mensaje' => 'El horario de la asignatura ' . $res['nombre'] . ' inicia ' . $res['inicio'] . ' a ' . $res['fin']);
            }
        } else {
            $data[] = array('mensaje' => 'El horario de la asignatura no esta registrado este dia ' . Fecha::_dian());
        }
        return $data;
    }

    static function registrarAsistenciaA($codd, $coda, $asistio) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO asistencia (codigoest,codigodoc,codigoasig,fecha,asistio)
		SELECT usuarios.user,?,?,?,? FROM asignatura
		INNER JOIN matriculaa ON matriculaa.asignatura = asignatura.id
		INNER JOIN usuarios ON matriculaa.user = usuarios.user
		WHERE asignatura.id LIKE ? AND matriculaa.activo LIKE ? AND NOT EXISTS(
		SELECT codigoest,codigoasig,fecha FROM asistencia
        WHERE asistencia.codigoest = usuarios.user AND asistencia.codigoasig LIKE ? AND asistencia.fecha LIKE ? )");;
        $activo = 1;
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
        $stmt->bindParam(1, $codd, PDO::PARAM_INT);
        $stmt->bindParam(2, $coda, PDO::PARAM_INT);
        $stmt->bindParam(3, $hoy, PDO::PARAM_STR);
        $stmt->bindParam(4, $asistio, PDO::PARAM_INT);
        $stmt->bindParam(5, $coda, PDO::PARAM_INT);
        $stmt->bindParam(6, $activo, PDO::PARAM_INT);
        $stmt->bindParam(7, $coda, PDO::PARAM_INT);
        $stmt->bindParam(8, $hoy, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $data[] = array('mensaje' => 'Asistencia Pasada');
            return $data;

        } else {
            return null;
        }

    }

    static function NotificarRAA($coda) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT asignatura.nombre, token.tokenu FROM matriculaa
                                  INNER JOIN asignatura ON matriculaa.asignatura = asignatura.id
                                  INNER JOIN usuarios ON matriculaa.user = usuarios.user
                                  INNER JOIN token ON usuarios.user = token.id_user WHERE matriculaa.asignatura LIKE ? AND matriculaa.activo LIKE ?");
        $activo = 1;
        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $activo, PDO::PARAM_INT);
        $stmt->execute();
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');

        while ($res = $stmt->fetch()) {
            Notificaciones::aanotificaciones('Asignatura: ' . $res['nombre'], $res['tokenu'], $hoy, 'Asistencia: presente');
        }

    }

    static function registrarAsistenciaN($codd, $coda, $asistio) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO asistencia (codigoest,codigodoc,codigoasig,fecha,asistio)
		SELECT usuarios.user,?,?,?,? FROM asignatura
		INNER JOIN semestre ON asignatura.semestre = semestre.id
		INNER JOIN matriculan ON matriculan.semestre = semestre.id
		INNER JOIN usuarios ON matriculan.user = usuarios.user
		WHERE asignatura.id LIKE ? AND matriculan.activo LIKE ? AND NOT EXISTS(
		SELECT codigoest,codigoasig,fecha FROM asistencia
        WHERE asistencia.codigoest = usuarios.user AND asistencia.codigoasig LIKE ? AND asistencia.fecha LIKE ?)");
        $activo = 1;
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
        $stmt->bindParam(1, $codd, PDO::PARAM_INT);
        $stmt->bindParam(2, $coda, PDO::PARAM_INT);
        $stmt->bindParam(3, $hoy, PDO::PARAM_STR);
        $stmt->bindParam(4, $asistio, PDO::PARAM_INT);
        $stmt->bindParam(5, $coda, PDO::PARAM_INT);
        $stmt->bindParam(6, $activo, PDO::PARAM_INT);
        $stmt->bindParam(7, $coda, PDO::PARAM_INT);
        $stmt->bindParam(8, $hoy, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $data[] = array('mensaje' => 'Asistencia Pasada');
            return $data;
        } else {
            return null;
        }

    }

    static function NotificarRAN($coda) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT asignatura.nombre, token.tokenu FROM matriculan 
                INNER JOIN usuarios ON matriculan.user = usuarios.user
                INNER JOIN semestre ON matriculan.semestre = semestre.id
                INNER JOIN asignatura ON semestre.id = asignatura.semestre
                INNER JOIN token ON usuarios.user = token.id_user
                WHERE asignatura.id LIKE ? AND matriculan.activo LIKE ?");
        $activo = 1;
        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $activo, PDO::PARAM_INT);
        $stmt->execute();
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
        while ($res = $stmt->fetch()) {
            Notificaciones::aanotificaciones('Asignatura: ' . $res['nombre'], $res['tokenu'], $hoy, 'Asistencia: presente');
        }
    }

    static function actualizarAsistencia($asistio, $codigoest, $codigodoc, $codigoasig) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE asistencia SET asistio = ? WHERE codigoest LIKE ? AND codigodoc LIKE ? 
                                      AND codigoasig LIKE ? AND fecha LIKE ? ");
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');

        $stmt->bindParam(1, $asistio, PDO::PARAM_INT);
        $stmt->bindParam(2, $codigoest, PDO::PARAM_INT);
        $stmt->bindParam(3, $codigodoc, PDO::PARAM_INT);
        $stmt->bindParam(4, $codigoasig, PDO::PARAM_INT);
        $stmt->bindParam(5, $hoy, PDO::PARAM_STR);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Asistencia Actualizada');

            return json_encode($data);

        } else {
            return null;
        }

    }

    static function NotificacionAA($asistio, $codigoest, $codigoasig) {
        $con = Conexion::conecction();
        $stmt1 = $con->prepare("SELECT tokenu FROM token WHERE id_user LIKE ?");
        $stmt1->bindParam(1, $codigoest, PDO::PARAM_INT);
        $stmt1->execute();
        $token = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $stmt2 = $con->prepare("SELECT nombre FROM asignatura WHERE id LIKE ?");
        $stmt2->bindParam(1, $codigoasig, PDO::PARAM_INT);
        $stmt2->execute();
        $nombre = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $nombre1 = '';
        $token1 = '';
        foreach ($nombre as $row) {
            $nombre1 = $row['nombre'];
        }
        foreach ($token as $row1) {
            $token1 = $row1['tokenu'];
        }
        $hoy = Fecha::_date("Y-m-d", false, 'America/Lima');
        if ($asistio == 0) {
            Notificaciones::aanotificaciones('Asignatura: ' . $nombre1, $token1, $hoy, 'Asistencia :falta');
        } else if ($asistio == 1) {
            Notificaciones::aanotificaciones('Asignatura: ' . $nombre1, $token1, $hoy, 'Asistencia: presente');
        }
    }

    static function mostrarAsistencia($s, $fecha) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
                                      usuarios.foto,usuarios.user,asistencia.asistio FROM asistencia
                                      INNER JOIN usuarios ON usuarios.user = asistencia.codigoest
                                      WHERE asistencia.codigoasig LIKE ? AND asistencia.fecha LIKE ? ORDER BY usuarios.apellidop ");
        $stmt->bindParam(1, $s, PDO::PARAM_INT);
        $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'codigo' => $res['user'], 'asistio' => $res['asistio']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function mostrarAsistencia1($s, $fecha) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
                                usuarios.foto,asistencia.asistio, asignatura.nombre AS asignatura FROM asistencia
                                INNER JOIN usuarios ON usuarios.user = asistencia.codigoest
                                INNER JOIN asignatura ON asistencia.codigoasig = asignatura.id
                                WHERE asistencia.codigoest LIKE ? AND asistencia.fecha LIKE ? ");
        $stmt->bindParam(1, $s, PDO::PARAM_INT);
        $stmt->bindParam(2, $fecha, PDO::PARAM_STR);
        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'asistio' => $res['asistio'], 'asignatura' => $res['asignatura']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function estudiantesN($s, $s1, $s2) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
                                usuarios.user,usuarios.foto,matriculan.activo FROM asignatura
                                INNER JOIN semestre ON asignatura.semestre = semestre.id
                                INNER JOIN matriculan ON matriculan.semestre = semestre.id
                                INNER JOIN usuarios ON matriculan.user = usuarios.user
                                WHERE asignatura.id LIKE ? AND matriculan.sede LIKE ? AND matriculan.anioa LIKE ? ORDER BY usuarios.apellidop");
        $stmt->bindParam(1, $s, PDO::PARAM_INT);
        $stmt->bindParam(2, $s1, PDO::PARAM_INT);
        $stmt->bindParam(3, $s2, PDO::PARAM_STR);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'codigo' => $res['user'], 'foto' => base64_encode($res['foto']), 'activo' => $res['activo']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function estudiantesA($s, $s1, $s2) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
                                usuarios.user,usuarios.foto,matriculaa.activo FROM asignatura
                                INNER JOIN matriculaa ON matriculaa.asignatura = asignatura.id
                                INNER JOIN usuarios ON matriculaa.user = usuarios.user
                                WHERE asignatura.id LIKE ? AND matriculaa.sede LIKE ? AND matriculaa.anioa LIKE ? ORDER BY usuarios.apellidop");
        $stmt->bindParam(1, $s, PDO::PARAM_INT);
        $stmt->bindParam(2, $s1, PDO::PARAM_INT);
        $stmt->bindParam(3, $s2, PDO::PARAM_STR);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'codigo' => $res['user'], 'foto' => base64_encode($res['foto']), 'activo' => $res['activo']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function loginU($username, $password, $token) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT usuarios.nombres, usuarios.apellidop, usuarios.apellidom, usuarios.foto, usuarios.correo, usuarios.tdoc, 
                                    usuarios.ndoc, usuarios.user, usuarios.tipo,usuarios.genero, usuarios.ntelefono, usuarios.fnacimiento, usuarios.lnacimiento, 
                                    usuarios.activo, usuarios.ep, usuarios.sede,concat(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre, 
                                    dtipo.nombre AS nombredocumento, utipo.nombre AS nombretipo, genero.nombre AS nombregenero, distrito.nombre AS nombredistrito,
                                    ep.nombre AS nombreescuela, distrito2.nombre AS nombresede
                                    FROM usuarios 
                                    INNER JOIN dtipo ON usuarios.tdoc LIKE dtipo.id
                                    INNER JOIN utipo ON usuarios.tipo LIKE utipo.id
                                    INNER JOIN genero ON usuarios.genero LIKE genero.id
                                    INNER JOIN distrito ON usuarios.lnacimiento LIKE distrito.id 
                                    INNER JOIN ep ON usuarios.ep LIKE ep.in
                                    INNER JOIN sede ON usuarios.sede LIKE sede.id
                                    INNER JOIN distrito distrito2 ON sede.id_distr LIKE distrito2.id 
                                    WHERE user LIKE ? AND password LIKE ?");
        $stmt->bindParam(1, $username, PDO::PARAM_INT);
        $stmt->bindParam(2, $password, PDO::PARAM_STR);
        $stmt->execute();
        $stmt1 = $con->prepare("INSERT INTO token (id_user, tokenu) VALUES (?,?)");
        $stmt1->bindParam(1, $username, PDO::PARAM_INT);
        $stmt1->bindParam(2, $token, PDO::PARAM_STR);
        if ($stmt1->execute()) {
            while ($row = $stmt->fetch()) {
                $data[] = array('nombres' => $row['nombres'], 'apellidop' => $row['apellidop'], 'apellidom' => $row['apellidom'], 'imagen' => base64_encode($row['foto']),
                    'correo' => $row['correo'], 'tdoc' => $row['tdoc'], 'ndoc' => $row['ndoc'], 'codigo' => $row['user'], 'tipoid' => $row['tipo'], 'genero' => $row['genero'],
                    'ntelefono' => $row['ntelefono'], 'fnacimiento' => $row['fnacimiento'], 'lnacimiento' => $row['lnacimiento'], 'activo' => $row['activo'],
                    'ep' => $row['ep'], 'sede' => $row['sede'], 'nombre' => $row['nombre'], 'nombredocumento' => $row['nombredocumento'], 'tipo' => $row['nombretipo'],
                    'nombregenero' => $row['nombregenero'], 'nombredistrito' => $row['nombredistrito'], 'nombreescuela' => $row['nombreescuela'], 'nombresede' => $row['nombresede']);
            }
            if ($stmt->rowCount() > 0) {
                return $data;
            } else {
                return null;
            }
        } else {
            $stmt2 = $con->prepare("UPDATE token SET tokenu = ? WHERE id_user LIKE ?");
            $stmt2->bindParam(1, $token, PDO::PARAM_STR);
            $stmt2->bindParam(2, $username, PDO::PARAM_INT);
            $stmt2->execute();
            while ($row = $stmt->fetch()) {
                $data[] = array('nombres' => $row['nombres'], 'apellidop' => $row['apellidop'], 'apellidom' => $row['apellidom'], 'imagen' => base64_encode($row['foto']),
                    'correo' => $row['correo'], 'tdoc' => $row['tdoc'], 'ndoc' => $row['ndoc'], 'codigo' => $row['user'], 'tipoid' => $row['tipo'], 'genero' => $row['genero'],
                    'ntelefono' => $row['ntelefono'], 'fnacimiento' => $row['fnacimiento'], 'lnacimiento' => $row['lnacimiento'], 'activo' => $row['activo'],
                    'ep' => $row['ep'], 'sede' => $row['sede'], 'nombre' => $row['nombre'], 'nombredocumento' => $row['nombredocumento'], 'tipo' => $row['nombretipo'],
                    'nombregenero' => $row['nombregenero'], 'nombredistrito' => $row['nombredistrito'], 'nombreescuela' => $row['nombreescuela'], 'nombresede' => $row['nombresede']);
            }
            if ($stmt->rowCount() > 0) {
                return $data;
            } else {
                return null;
            }
        }
    }

    static function registrarAsign($a, $b) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO asignatura (nombre,semestre) VALUES (?,?)");
        $stmt->bindParam(1, $a, PDO::PARAM_STR);
        $stmt->bindParam(2, $b, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Asignatura registrado con exito');

            echo json_encode($data);

        } else {
            return null;
        }

    }

    static function VerificarAsignaturaDocente($b, $c, $d) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,'',usuarios.apellidom,' ',usuarios.nombres) AS nombrec,
                                asignatura.nombre AS nombrea ,distrito.nombre AS nombred,asignaturad.anioa FROM asignaturad 
                                INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
                                INNER JOIN asignatura ON asignaturad.asignatura = asignatura.id
                                INNER JOIN sede ON asignaturad.sede = sede.id
                                INNER JOIN distrito ON sede.id_distr = distrito.id
                                WHERE asignaturad.asignatura LIKE ? AND asignaturad.sede LIKE ? AND asignaturad.anioa LIKE ?");
        $stmt->bindParam(1, $b, PDO::PARAM_INT);
        $stmt->bindParam(2, $c, PDO::PARAM_INT);
        $stmt->bindParam(3, $d, PDO::PARAM_STR);
        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data[] = array('mensaje' => 'El docente: ' . $res['nombrec'] . ' imparte la catedra ' . $res['nombrea'] . ' en '
                . $res['nombred'] . ' en el periodo ' . $res['anioa']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function registrarAsignD($a, $b, $c, $d) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO asignaturad (codigo,asignatura,sede,anioa)  VALUES (?,?,?,?)");
        $stmt->bindParam(1, $a, PDO::PARAM_INT);
        $stmt->bindParam(2, $b, PDO::PARAM_INT);
        $stmt->bindParam(3, $c, PDO::PARAM_INT);
        $stmt->bindParam(4, $d, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Asignatura Docente registrado con exito');

            echo json_encode($data);

        } else {
            return null;
        }

    }

    static function matriculaN($baucher1, $codigo1, $an, $anio, $escuela, $tipom, $a, $s) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO matriculan (recibo,user,semestre,anioa,ep,tipom,sede,activo) 
                                    VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $baucher1, PDO::PARAM_INT);
        $stmt->bindParam(2, $codigo1, PDO::PARAM_INT);
        $stmt->bindParam(3, $an, PDO::PARAM_INT);
        $stmt->bindParam(4, $anio, PDO::PARAM_STR);
        $stmt->bindParam(5, $escuela, PDO::PARAM_INT);
        $stmt->bindParam(6, $tipom, PDO::PARAM_INT);
        $stmt->bindParam(7, $s, PDO::PARAM_INT);
        $stmt->bindParam(8, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Matriculado');

            return $data;

        } else {

            return null;
        }
    }

    static function matriculaA($baucher1, $codigo1, $an, $anio, $escuela, $tipom, $a, $s) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO matriculaa (recibo,user,asignatura,anioa,ep,tipom,sede,activo) 
                            		VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $baucher1, PDO::PARAM_INT);
        $stmt->bindParam(2, $codigo1, PDO::PARAM_INT);
        $stmt->bindParam(3, $an, PDO::PARAM_INT);
        $stmt->bindParam(4, $anio, PDO::PARAM_STR);
        $stmt->bindParam(5, $escuela, PDO::PARAM_INT);
        $stmt->bindParam(6, $tipom, PDO::PARAM_INT);
        $stmt->bindParam(7, $s, PDO::PARAM_INT);
        $stmt->bindParam(8, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Matriculado');

            return $data;

        } else {

            return null;
        }

    }

    static function registrarSem($a, $b) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO semestre (nombre,ep) VALUES ('" . $b . "','" . $a . "')");
        $stmt->bindParam(1, $b, PDO::PARAM_STR);
        $stmt->bindParam(2, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Semestre registrado con exito');

            return $data;

        } else {
            return null;
        }

    }

    static function asignaturas($s1) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM asignatura WHERE semestre LIKE ? ");
        $stmt->bindParam(1, $s1, PDO::PARAM_INT);
        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function asignaturasD($codigo) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT asignatura.id,asignatura.nombre FROM asignaturad
                                    INNER JOIN asignatura ON asignaturad.asignatura = asignatura.id
                                    WHERE asignaturad.codigo LIKE  ?");
        $stmt->bindParam(1, $codigo, PDO::PARAM_INT);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function escuelas($s) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT * FROM ep WHERE facultad LIKE ? ");
        $stmt->bindParam(1, $s, PDO::PARAM_INT);
        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['in'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }


    }

    static function semestres($s1) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id, concat(ep.nombre,'-',semestre.nombre) as nombre
                            FROM semestre
                            inner join ep on semestre.ep = ep.`in` 
                            where semestre.ep LIKE ? ORDER BY nombre");
        $stmt->bindParam(1, $s1, PDO::PARAM_INT);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function facultades() {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM facultad");

        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function matricula() {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM tipom");

        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function unidades() {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM unidad");

        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function registrarNotaA($coda, $codu, $cod, $an) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO nota (codigoest,codigoasig,codigounid,coddoc,anioa)
                                SELECT usuarios.user,?,?,?,? FROM asignatura
                                INNER JOIN matriculaa ON matriculaa.asignatura = asignatura.id
                                INNER JOIN usuarios ON matriculaa.user = usuarios.user
                                WHERE asignatura.id LIKE ? AND NOT EXISTS(
                                SELECT codigoest,codigoasig,codigounid,coddoc,nota.anioa FROM nota
                                WHERE nota.codigoest LIKE usuarios.user AND nota.codigoasig LIKE ?
                                AND nota.codigounid LIKE ? AND nota.coddoc LIKE ? AND nota.anioa LIKE ?)");

        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $codu, PDO::PARAM_INT);
        $stmt->bindParam(3, $cod, PDO::PARAM_INT);
        $stmt->bindParam(4, $an, PDO::PARAM_STR);
        $stmt->bindParam(5, $coda, PDO::PARAM_INT);
        $stmt->bindParam(6, $coda, PDO::PARAM_INT);
        $stmt->bindParam(7, $codu, PDO::PARAM_INT);
        $stmt->bindParam(8, $cod, PDO::PARAM_INT);
        $stmt->bindParam(9, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Notas Pasadas');

            return $data;

        } else {
            return null;
        }
    }

    static function registrarNotaN($coda, $codu, $cod, $an) {

        $con = Conexion::conecction();
        $data = array();

        $stmt = $con->prepare("INSERT INTO nota (codigoest,codigoasig,codigounid,coddoc,anioa)
                                SELECT usuarios.user,?,?,?,? FROM asignatura
                                INNER JOIN semestre ON asignatura.semestre = semestre.id
                                INNER JOIN matriculan ON matriculan.semestre = semestre.id
                                INNER JOIN usuarios ON matriculan.user = usuarios.user
                                WHERE asignatura.id LIKE ? AND NOT EXISTS(
                                SELECT codigoest,codigoasig,codigounid,coddoc,nota.anioa FROM nota
                                WHERE nota.codigoest LIKE usuarios.user AND nota.codigoasig LIKE ?
                                AND nota.codigounid LIKE ? AND nota.coddoc LIKE ? AND nota.anioa LIKE ?)");

        $stmt->bindParam(1, $coda, PDO::PARAM_INT);
        $stmt->bindParam(2, $codu, PDO::PARAM_INT);
        $stmt->bindParam(3, $cod, PDO::PARAM_INT);
        $stmt->bindParam(4, $an, PDO::PARAM_STR);
        $stmt->bindParam(5, $coda, PDO::PARAM_INT);
        $stmt->bindParam(6, $coda, PDO::PARAM_INT);
        $stmt->bindParam(7, $codu, PDO::PARAM_INT);
        $stmt->bindParam(8, $cod, PDO::PARAM_INT);
        $stmt->bindParam(9, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Notas Pasadas');

            return $data;

        } else {
            return null;
        }

    }

    static function mostrarNotas($coduni, $codasi, $cod, $an) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
		usuarios.foto,usuarios.user,nota.nota FROM nota
		INNER JOIN usuarios ON usuarios.user = nota.codigoest
		WHERE nota.codigoasig LIKE ? AND nota.codigounid LIKE ? AND nota.coddoc LIKE ? AND nota.anioa LIKE ?
		ORDER BY usuarios.apellidop ");

        $stmt->bindParam(1, $codasi, PDO::PARAM_INT);
        $stmt->bindParam(2, $coduni, PDO::PARAM_INT);
        $stmt->bindParam(3, $cod, PDO::PARAM_INT);
        $stmt->bindParam(4, $an, PDO::PARAM_STR);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'codigo' => $res['user'], 'nota' => $res['nota']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }


    static function actualizarNotas($codest, $coduni, $codasi, $nota, $cod, $an) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE nota SET nota = ? WHERE codigoest LIKE ?  
                          AND codigoasig LIKE ? AND codigounid LIKE ? AND coddoc LIKE ? AND anioa LIKE ?");
        $stmt->bindParam(1, $nota, PDO::PARAM_INT);
        $stmt->bindParam(2, $codest, PDO::PARAM_INT);
        $stmt->bindParam(3, $codasi, PDO::PARAM_INT);
        $stmt->bindParam(4, $coduni, PDO::PARAM_INT);
        $stmt->bindParam(5, $cod, PDO::PARAM_INT);
        $stmt->bindParam(6, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Nota Actualizada');

            return $data;
        } else {
            return null;
        }
    }

    static function asignaturaa($codigoest, $s1) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT concat(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,usuarios.foto,usuarios.user AS id,
        asignatura.id AS ida,asignatura.nombre AS asig,tipom.nombre AS matr, matriculaa.activo 
        FROM matriculaa
		INNER JOIN usuarios ON usuarios.user = matriculaa.user
		INNER JOIN asignatura ON asignatura.id = matriculaa.asignatura
		INNER JOIN tipom ON tipom.id = matriculaa.tipom
		WHERE matriculaa.user LIKE ? AND matriculaa.anioa LIKE ? ORDER BY asignatura.nombre ");
        $stmt->bindParam(1, $codigoest, PDO::PARAM_INT);
        $stmt->bindParam(2, $s1, PDO::PARAM_STR);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'codigo' => $res['id'], 'ida' => $res['ida'], 'nombrea' => $res['asig'], 'modo' => $res['matr'], 'activo' => $res['activo']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function asignaturan($codigoest, $s1) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT concat(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,usuarios.foto,usuarios.user AS id,
        asignatura.id AS ida,asignatura.nombre AS asig,tipom.nombre AS matr, matriculan.activo
        FROM matriculan
		INNER JOIN usuarios ON usuarios.user = matriculan.user
		INNER JOIN semestre ON semestre.id = matriculan.semestre
		INNER JOIN asignatura ON asignatura.semestre = semestre.id
		INNER JOIN tipom ON tipom.id = matriculan.tipom
		WHERE matriculan.user LIKE ? AND matriculan.anioa LIKE ? ORDER BY asignatura.nombre ");
        $stmt->bindParam(1, $codigoest, PDO::PARAM_INT);
        $stmt->bindParam(2, $s1, PDO::PARAM_STR);

        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'codigo' => $res['id'], 'ida' => $res['ida'], 'nombrea' => $res['asig'], 'modo' => $res['matr'], 'activo' => $res['activo']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function provincia($id) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT * FROM provincia WHERE id_dep LIKE ?");

        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function distrito($id) {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM distrito WHERE id_prov LIKE ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function departamento() {

        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id,nombre FROM departamento");

        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }

        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }

    }

    static function sedes() {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT sede.id, distrito.nombre FROM sede INNER JOIN distrito ON sede.id_distr = distrito.id");

        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function estudiantes($ide, $e, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre, usuarios.foto, 
            usuarios.correo, usuarios.tdoc AS documentoid, usuarios.ndoc AS documento, usuarios.user AS codigo, usuarios.tipo AS tipoid, 
            usuarios.genero AS generoid, usuarios.ntelefono AS telefono, usuarios.fnacimiento AS nacimiento, usuarios.lnacimiento AS lnacimientoid, usuarios.activo, 
            usuarios.ep AS epid, dtipo.nombre AS documenton, genero.nombre AS genero, utipo.nombre AS tipo,distrito.nombre AS lnacimiento,ep.nombre AS ep,
            usuarios.sede,distrito2.nombre AS nombresede FROM usuarios
            INNER JOIN dtipo ON usuarios.tdoc LIKE dtipo.id
            INNER JOIN genero ON usuarios.genero LIKE genero.id
            INNER JOIN utipo ON usuarios.tipo LIKE utipo.id
            INNER JOIN distrito ON usuarios.lnacimiento LIKE distrito.id
            INNER JOIN ep ON usuarios.ep LIKE ep.in 
            INNER JOIN sede ON usuarios.sede LIKE sede.id
            INNER JOIN distrito distrito2 ON sede.id_distr LIKE distrito2.id 
            WHERE usuarios.user LIKE  ? AND usuarios.ep LIKE ? AND usuarios.tipo LIKE ? AND usuarios.sede LIKE ?");
        $param = '%' . $ide . '%';
        $est = 2;
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $est, PDO::PARAM_INT);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);

        $stmt->execute();


        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'correo' => $res['correo'], 'documentoid' => $res['documentoid'], 'documento' => $res['documento'],
                'codigo' => $res['codigo'], 'tipoid' => $res['tipoid'], 'generoid' => $res['generoid'], 'telefono' => $res['telefono'], 'nacimiento' => $res['nacimiento'],
                'lnacimientoid' => $res['lnacimientoid'], 'activo' => $res['activo'], 'epid' => $res['epid'], 'documenton' => $res['documenton'], 'genero' => $res['genero'], 'tipo' => $res['tipo'],
                'lnacimiento' => $res['lnacimiento'], 'ep' => $res['ep'], 'sede' => $res['sede'], 'nsede' => $res['nombresede']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function m1($ide, $e, $a, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT matriculan.recibo, matriculan.user, matriculan.semestre, matriculan.anioa, matriculan.ep, matriculan.tipom,
                matriculan.sede, matriculan.activo,concat(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre, semestre.nombre AS nombresemestre,
                ep.nombre AS nombreescuela, tipom.nombre AS matriculanombre, distrito.nombre AS nombredistrito,usuarios.foto FROM matriculan 
                INNER JOIN usuarios ON matriculan.user LIKE usuarios.user 
                INNER JOIN semestre ON matriculan.semestre LIKE semestre.id 
                INNER JOIN ep ON matriculan.ep LIKE ep.in 
                INNER JOIN tipom ON matriculan.tipom LIKE tipom.id 
                INNER JOIN sede ON matriculan.sede LIKE sede.id 
                INNER JOIN distrito ON sede.id_distr LIKE distrito.id
                WHERE matriculan.user LIKE  ? AND matriculan.ep LIKE ? AND matriculan.anioa LIKE ? AND matriculan.sede LIKE ?");
        $param = '%' . $ide . '%';
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $a, PDO::PARAM_STR);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('recibo' => $res['recibo'], 'user' => $res['user'], 'semestre' => $res['semestre'], 'anioa' => $res['anioa'], 'ep' => $res['ep'], 'tipom' => $res['tipom'], 'sede' => $res['sede'],
                'activo' => $res['activo'], 'nombre' => $res['nombre'], 'nombresemestre' => $res['nombresemestre'], 'nombreescuela' => $res['nombreescuela'], 'matriculanombre' => $res['matriculanombre'],
                'nombredistrito' => $res['nombredistrito'], 'foto' => base64_encode($res['foto']));

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function m2($ide, $e, $a, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT matriculaa.recibo, matriculaa.user, matriculaa.asignatura, matriculaa.anioa, matriculaa.ep, matriculaa.tipom,
                 matriculaa.sede, matriculaa.activo,concat(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre, asignatura.nombre AS nombreasignatura, 
                 ep.nombre AS nombreescuela, tipom.nombre AS matriculanombre, distrito.nombre AS nombrdistrito,usuarios.foto FROM matriculaa
                INNER JOIN usuarios ON matriculaa.user LIKE usuarios.user
                INNER JOIN asignatura ON matriculaa.asignatura LIKE asignatura.id
                INNER JOIN ep ON matriculaa.ep LIKE ep.in
                INNER JOIN tipom ON matriculaa.tipom LIKE tipom.id
                INNER JOIN sede ON matriculaa.sede LIKE sede.id
                INNER JOIN distrito ON sede.id_distr LIKE distrito.id
                WHERE matriculaa.user LIKE  ? AND matriculaa.ep LIKE ? AND matriculaa.anioa LIKE ? AND matriculaa.sede LIKE ?");
        $param = '%' . $ide . '%';
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $a, PDO::PARAM_STR);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);
        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('recibo' => $res['recibo'], 'user' => $res['user'], 'semestre' => $res['asignatura'], 'anioa' => $res['anioa'], 'ep' => $res['ep'], 'tipom' => $res['tipom'], 'sede' => $res['sede'],
                'activo' => $res['activo'], 'nombre' => $res['nombre'], 'nombresemestre' => $res['nombreasignatura'], 'nombreescuela' => $res['nombreescuela'], 'matriculanombre' => $res['matriculanombre'],
                'nombredistrito' => $res['nombrdistrito'], 'foto' => base64_encode($res['foto']));

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function actualizarusuarioactivo($a, $b) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE usuarios SET activo = ? WHERE user LIKE ? ");
        $stmt->bindParam(1, $b, PDO::PARAM_INT);
        $stmt->bindParam(2, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Accion Realizada');
            return $data;
        }else{
            return null;
        }
    }

    static function actualizarmatriculan($a, $b) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE matriculan SET activo = ? WHERE `user` LIKE ?");
        $stmt->bindParam(1, $b, PDO::PARAM_INT);
        $stmt->bindParam(2, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Accion Realizada');
            return $data;
        }else{
            return null;
        }
    }

    static function actualizarmatriculaa($a, $b) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE matriculaa SET activo = ? WHERE user LIKE ?");
        $stmt->bindParam(1, $b, PDO::PARAM_INT);
        $stmt->bindParam(2, $a, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $data[] = array('mensaje' => 'Accion Realizada');
            return $data;
        }else{
            return null;
        }
    }

    static function ElimarToken($c, $t) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("DELETE FROM token WHERE id_user LIKE ? AND tokenu LIKE ?");
        $stmt->bindParam(1, $c, PDO::PARAM_INT);
        $stmt->bindParam(2, $t, PDO::PARAM_STR);

        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Sesion Cerrada Exitosamente');
            return $data;
        } else {
            $data[] = array('mensaje' => 'Sesion Cerrada Exitosamente');
            return $data;
        }
    }

    static function MostrarDocentes($idd, $e, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre, usuarios.foto, 
            usuarios.correo, usuarios.tdoc AS documentoid, usuarios.ndoc AS documento, usuarios.user AS codigo, usuarios.tipo AS tipoid, 
            usuarios.genero AS generoid, usuarios.ntelefono AS telefono, usuarios.fnacimiento AS nacimiento, usuarios.lnacimiento AS lnacimientoid, usuarios.activo, 
            usuarios.ep AS epid, dtipo.nombre AS documenton, genero.nombre AS genero, utipo.nombre AS tipo,distrito.nombre AS lnacimiento,ep.nombre AS ep,
            usuarios.sede,distrito2.nombre AS nombresede FROM usuarios
            INNER JOIN dtipo ON usuarios.tdoc LIKE dtipo.id
            INNER JOIN genero ON usuarios.genero LIKE genero.id
            INNER JOIN utipo ON usuarios.tipo LIKE utipo.id
            INNER JOIN distrito ON usuarios.lnacimiento LIKE distrito.id
            INNER JOIN ep ON usuarios.ep LIKE ep.in 
            INNER JOIN sede ON usuarios.sede LIKE sede.id
            INNER JOIN distrito distrito2 ON sede.id_distr LIKE distrito2.id 
            WHERE usuarios.user LIKE  ? AND usuarios.ep LIKE ? AND usuarios.tipo LIKE ? AND usuarios.sede LIKE ?");
        $param = '%' . $idd . '%';
        $doc = 1;
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $doc, PDO::PARAM_INT);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);

        $stmt->execute();

        while ($res = $stmt->fetch()) {

            $data[] = array('nombre' => $res['nombre'], 'foto' => base64_encode($res['foto']), 'correo' => $res['correo'], 'documentoid' => $res['documentoid'], 'documento' => $res['documento'],
                'codigo' => $res['codigo'], 'tipoid' => $res['tipoid'], 'generoid' => $res['generoid'], 'telefono' => $res['telefono'], 'nacimiento' => $res['nacimiento'],
                'lnacimientoid' => $res['lnacimientoid'], 'activo' => $res['activo'], 'epid' => $res['epid'], 'documenton' => $res['documenton'], 'genero' => $res['genero'], 'tipo' => $res['tipo'],
                'lnacimiento' => $res['lnacimiento'], 'ep' => $res['ep'], 'sede' => $res['sede'], 'nsede' => $res['nombresede']);

        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }
    }

    static function MostrarAsignaturasDocentes($idd, $e, $a, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT usuarios.user, 
            CONCAT(usuarios.apellidop,' ', usuarios.apellidom,' ',usuarios.nombres) AS nombrec
            ,usuarios.foto, asignaturad.asignatura, asignatura.nombre
            AS nombrea,asignatura.semestre, ep.nombre AS nombree FROM asignaturad
            INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
            INNER JOIN sede ON asignaturad.sede = sede.id
            INNER JOIN asignatura ON asignaturad.asignatura = asignatura.id
            INNER JOIN semestre ON asignatura.semestre = semestre.id
            INNER JOIN ep ON semestre.ep = ep.`in`
            WHERE asignaturad.codigo LIKE ? AND usuarios.ep LIKE ? AND asignaturad.anioa LIKE ? AND asignaturad.sede LIKE ?  ");
        $param = '%' . $idd . '%';
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $a, PDO::PARAM_STR);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);

        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $data[] = array('codigo' => $res['user'], 'nombrec' => $res['nombrec'], 'foto' => base64_encode($res['foto']), 'codigoa' => $res['asignatura'],
                'nombrea' => $res['nombrea'], 'codigos' => $res['semestre'], 'nombree' => $res['nombree']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }
    }

    static function MostrarHorariosDocentes($idd, $e, $a, $s) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT horario.inicio,horario.fin,horario.id_asignatura,
                asignatura.nombre AS nombrea,horario.id_dia,dia.nombre AS nombred,
                CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres)
                AS nombrec,usuarios.foto,usuarios.user,ep.nombre AS nombree FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                INNER JOIN dia ON horario.id_dia = dia.id
                INNER JOIN asignaturad ON asignatura.id = asignaturad.asignatura
                INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
                INNER JOIN semestre ON asignatura.semestre = semestre.id
                INNER JOIN ep ON semestre.ep = ep.`in`
                WHERE asignaturad.codigo LIKE ? AND usuarios.ep LIKE ? AND horario.anioa LIKE ? AND horario.sede LIKE ?");
        $param = '%' . $idd . '%';
        $stmt->bindParam(1, $param, PDO::PARAM_STR);
        $stmt->bindParam(2, $e, PDO::PARAM_INT);
        $stmt->bindParam(3, $a, PDO::PARAM_STR);
        $stmt->bindParam(4, $s, PDO::PARAM_INT);

        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $data[] = array('inicio' => $res['inicio'], 'fin' => $res['fin'], 'codigoa' => $res['id_asignatura'],
                'nombrea' => $res['nombrea'], 'codigod' => $res['id_dia'], 'nombred' => $res['nombred'],
                'nombrec' => $res['nombrec'], 'foto' => base64_encode($res['foto']), 'nombree' => $res['nombree'], 'codigo' => $res['user']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }
    }

    static function DiasSemana() {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT id, nombre FROM dia");
        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $data[] = array('codigo' => $res['id'], 'nombre' => $res['nombre']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }

    }

    static function ComprobarAsignaturaDia($as, $di, $an, $se) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT asignatura.nombre, dia.nombre AS nombred FROM horario
                                 INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                                 INNER JOIN dia ON horario.id_dia = dia.id 
                                 WHERE horario.id_asignatura LIKE ? AND horario.id_dia LIKE ? 
                                 AND horario.sede LIKE ? AND horario.anioa LIKE ?");
        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->bindParam(2, $di, PDO::PARAM_INT);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->bindParam(4, $an, PDO::PARAM_STR);

        $stmt->execute();
        while ($res = $stmt->fetch()) {
            $data[] = array('mensaje' => 'La asignatura ' . $res['nombre'] . ' esta registrada en el dia ' . $res['nombred']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }

    }

    static function ComprobarHorarioHoraIguales($di, $in, $fi, $se, $an) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT asignatura.nombre,horario.inicio,horario.fin FROM horario
            INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
            WHERE horario.id_dia LIKE ? AND horario.inicio LIKE ? AND horario.fin LIKE ?
            AND horario.sede LIKE ? AND horario.anioa LIKE ?");
        $stmt->bindParam(1, $di, PDO::PARAM_INT);
        $stmt->bindParam(2, $in, PDO::PARAM_STR);
        $stmt->bindParam(3, $fi, PDO::PARAM_STR);
        $stmt->bindParam(4, $se, PDO::PARAM_INT);
        $stmt->bindParam(5, $an, PDO::PARAM_STR);

        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $data[] = array('mensaje' => 'La asignatura ' . $res['nombre'] . ' ya esta registrada en el rango de horas'
                . $res['inicio'] . '--' . $res['fin']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }
    }

    static function ComprobarHorario($di, $in, $fi, $se, $an) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("SELECT asignatura.nombre,horario.inicio,horario.fin FROM horario
            INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
            WHERE id_dia LIKE ? AND (
            (? < horario.inicio AND horario.fin > ?) OR 
            (? > horario.inicio AND horario.fin > ?) OR 
            (? < horario.fin AND horario.fin < ?)) AND horario.sede LIKE ? AND horario.anioa LIKE ?");
        $stmt->bindParam(1, $di, PDO::PARAM_INT);
        $stmt->bindParam(2, $in, PDO::PARAM_STR);
        $stmt->bindParam(3, $fi, PDO::PARAM_STR);
        $stmt->bindParam(4, $in, PDO::PARAM_STR);
        $stmt->bindParam(5, $fi, PDO::PARAM_STR);
        $stmt->bindParam(6, $in, PDO::PARAM_STR);
        $stmt->bindParam(7, $fi, PDO::PARAM_STR);
        $stmt->bindParam(8, $se, PDO::PARAM_INT);
        $stmt->bindParam(9, $an, PDO::PARAM_STR);

        $stmt->execute();

        while ($res = $stmt->fetch()) {
            $data[] = array('mensaje' => 'La asignatura ' . $res['nombre'] . ' ya esta registrada en el rango de horas'
                . $res['inicio'] . '--' . $res['fin']);
        }
        if ($stmt->rowCount() > 0) {
            return $data;
        }else{
            return null;
        }
    }

    static function RegistrarHorario($as, $di, $se, $in, $fi, $an) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("INSERT INTO horario (id_asignatura, id_dia, sede, inicio, fin, anioa) 
                                        VALUES (?,?,?,?,?,?)");
        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->bindParam(2, $di, PDO::PARAM_INT);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->bindParam(4, $in, PDO::PARAM_STR);
        $stmt->bindParam(5, $fi, PDO::PARAM_STR);
        $stmt->bindParam(6, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            $data[] = array('mensaje' => 'Registrado con exito');
            return $data;
        } else {
            $data[] = array('mensaje' => 'Algo salio mal...');
            return $data;
        }
    }

    static function EliminarHorario($as, $di, $se, $in, $fi, $an) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("DELETE FROM horario WHERE id_asignatura LIKE ?
AND id_dia LIKE ? AND sede LIKE ? AND inicio LIKE ? AND fin LIKE ? AND anioa LIKE ?");

        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->bindParam(2, $di, PDO::PARAM_INT);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->bindParam(4, $in, PDO::PARAM_STR);
        $stmt->bindParam(5, $fi, PDO::PARAM_STR);
        $stmt->bindParam(6, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Elemento eliminado corractamente');
            return $data;
        } else {
            $data[] = array('mensaje' => 'No se pudo eliminar');
            return $data;
        }
    }

    static function EliminarAsignaturaDocente($co, $as, $se, $an) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("DELETE FROM asignaturad WHERE codigo LIKE ? AND 
asignatura LIKE ? AND sede LIKE ? AND anioa LIKE ?");

        $stmt->bindParam(1, $co, PDO::PARAM_INT);
        $stmt->bindParam(2, $as, PDO::PARAM_INT);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->bindParam(4, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Elemento eliminado corractamente');
            return $data;
        } else {
            $data[] = array('mensaje' => 'No se pudo eliminar');
            return $data;
        }
    }

    static function ActualizarAsignaturaDocente($co, $an, $se, $as, $asa) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE asignaturad SET asignatura = ? WHERE codigo LIKE ?
                                        AND asignatura LIKE ? AND sede LIKE ? AND anioa LIKE ?");

        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->bindParam(2, $co, PDO::PARAM_INT);
        $stmt->bindParam(3, $asa, PDO::PARAM_INT);
        $stmt->bindParam(4, $se, PDO::PARAM_INT);
        $stmt->bindParam(5, $an, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Asignatura Docente Actualizada');
            return $data;
        } else {
            $data[] = array('mensaje' => 'No se pudo actualizar-' . $as . '-' . $co . '-' . $se . '-' . $an);
            return $data;
        }
    }

    static function ActualizarHorario($as, $an, $se, $di, $in, $fi) {
        $con = Conexion::conecction();
        $data = array();
        $stmt = $con->prepare("UPDATE horario SET id_dia = ?, inicio = ?, fin = ? 
                                        WHERE id_asignatura LIKE ?
                                        AND anioa LIKE ? AND sede LIKE ?");

        $stmt->bindParam(1, $di, PDO::PARAM_INT);
        $stmt->bindParam(2, $in, PDO::PARAM_STR);
        $stmt->bindParam(3, $fi, PDO::PARAM_STR);
        $stmt->bindParam(4, $as, PDO::PARAM_INT);
        $stmt->bindParam(5, $an, PDO::PARAM_STR);
        $stmt->bindParam(6, $se, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data[] = array('mensaje' => 'Horario Actualizado');
            return $data;
        } else {
            $data[] = array('mensaje' => 'No se pudo actualizar');
            return $data;
        }
    }

    static function MostrarHorarios($sem, $sed, $an) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT horario.inicio,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '1' THEN asignatura.nombre END) AS nombre1,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '2' THEN asignatura.nombre END) AS nombre2,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '3' THEN asignatura.nombre END) AS nombre3,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '4' THEN asignatura.nombre END) AS nombre4,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '5' THEN asignatura.nombre END) AS nombre5,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '6' THEN asignatura.nombre END) AS nombre6,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '7' THEN asignatura.nombre END) AS nombre7
                FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                INNER JOIN asignaturad ON asignatura.id = asignaturad.asignatura
                INNER JOIN semestre ON asignatura.semestre = semestre.id
                WHERE semestre.id LIKE ? AND horario.sede LIKE ? AND horario.anioa LIKE ? 
                GROUP BY inicio ORDER BY inicio,id_asignatura");
        $stmt->bindParam(1, $sem, PDO::PARAM_INT);
        $stmt->bindParam(2, $sed, PDO::PARAM_INT);
        $stmt->bindParam(3, $an, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $data;
        } else {
            return null;
        }
    }

    static function MostrarMiHorarioN($us, $se, $an) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT horario.inicio,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '1' THEN asignatura.nombre END) AS nombre1,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '2' THEN asignatura.nombre END) AS nombre2,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '3' THEN asignatura.nombre END) AS nombre3,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '4' THEN asignatura.nombre END) AS nombre4,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '5' THEN asignatura.nombre END) AS nombre5,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '6' THEN asignatura.nombre END) AS nombre6,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '7' THEN asignatura.nombre END) AS nombre7
                FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                INNER JOIN semestre ON asignatura.semestre = semestre.id
                INNER JOIN matriculan ON semestre.id = matriculan.semestre
                WHERE matriculan.user LIKE ? AND matriculan.anioa LIKE ? AND matriculan.sede LIKE ?
                GROUP BY inicio ORDER BY inicio,id_asignatura");
        $stmt->bindParam(1, $us, PDO::PARAM_INT);
        $stmt->bindParam(2, $an, PDO::PARAM_STR);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static function MostrarHorarioA($us, $se, $an) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT horario.inicio,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '1' THEN asignatura.nombre END) AS nombre1,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '2' THEN asignatura.nombre END) AS nombre2,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '3' THEN asignatura.nombre END) AS nombre3,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '4' THEN asignatura.nombre END) AS nombre4,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '5' THEN asignatura.nombre END) AS nombre5,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '6' THEN asignatura.nombre END) AS nombre6,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '7' THEN asignatura.nombre END) AS nombre7
                FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                INNER JOIN matriculaa ON asignatura.id = matriculaa.asignatura
                WHERE matriculaa.user LIKE ? AND matriculaa.anioa LIKE ? AND matriculaa.sede LIKE ?
                GROUP BY inicio ORDER BY inicio,id_asignatura");
        $stmt->bindParam(1, $us, PDO::PARAM_INT);
        $stmt->bindParam(2, $an, PDO::PARAM_STR);
        $stmt->bindParam(3, $se, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static function MostrarHorarioD($do, $se, $an) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT horario.inicio,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '1' THEN asignatura.nombre END) AS nombre1,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '2' THEN asignatura.nombre END) AS nombre2,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '3' THEN asignatura.nombre END) AS nombre3,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '4' THEN asignatura.nombre END) AS nombre4,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '5' THEN asignatura.nombre END) AS nombre5,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '6' THEN asignatura.nombre END) AS nombre6,
                GROUP_CONCAT(CASE WHEN horario.id_dia = '7' THEN asignatura.nombre END) AS nombre7
                FROM horario
                INNER JOIN asignatura ON horario.id_asignatura = asignatura.id
                INNER JOIN asignaturad ON asignatura.id = asignaturad.asignatura
                WHERE asignaturad.codigo LIKE ? AND asignaturad.sede LIKE ? AND asignaturad.anioa LIKE ?
                GROUP BY inicio ORDER BY inicio,id_asignatura");
        $stmt->bindParam(1, $do, PDO::PARAM_INT);
        $stmt->bindParam(2, $se, PDO::PARAM_INT);
        $stmt->bindParam(3, $an, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static function MostrarNotaD($an, $co) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT usuarios.nombres AS nombre,
                      GROUP_CONCAT(CASE WHEN nota.codigounid = '1' THEN nota.nota END) AS nota1,
                      GROUP_CONCAT(CASE WHEN nota.codigounid = '2' THEN nota.nota END) AS nota2,
                      GROUP_CONCAT(CASE WHEN nota.codigounid = '3' THEN nota.nota END) AS nota3,
                      GROUP_CONCAT(CASE WHEN nota.codigounid = '4' THEN nota.nota END) AS nota4,
                      ROUND(AVG(nota.nota)) AS promedio
                      FROM nota
                      INNER JOIN asignatura ON nota.codigoasig = asignatura.id
                      INNER JOIN usuarios ON nota.codigoest = usuarios.user
                      WHERE nota.anioa LIKE ? AND nota.codigoasig LIKE ?
                      GROUP BY usuarios.nombres");
        $stmt->bindParam(1, $an, PDO::PARAM_STR);
        $stmt->bindParam(2, $co, PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static function MostrarNotaE($an, $co) {
        $con = Conexion::conecction();
        $stmt = $con->prepare("SELECT DISTINCT asignatura.nombre,
                        GROUP_CONCAT(CASE WHEN nota.codigounid = '1' THEN nota.nota END) AS nota1,
                        GROUP_CONCAT(CASE WHEN nota.codigounid = '2' THEN nota.nota END) AS nota2,
                        GROUP_CONCAT(CASE WHEN nota.codigounid = '3' THEN nota.nota END) AS nota3,
                        GROUP_CONCAT(CASE WHEN nota.codigounid = '4' THEN nota.nota END) AS nota4,
                        ROUND(AVG(nota.nota)) AS promedio
                        FROM nota
                        INNER JOIN asignatura ON nota.codigoasig = asignatura.id
                        WHERE nota.anioa LIKE ? AND nota.codigoest LIKE ?
                        GROUP BY asignatura.nombre");
        $stmt->bindParam(1, $an, PDO::PARAM_STR);
        $stmt->bindParam(2, $co, PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static function ReporteAsistenci($ep, $as, $fe) {
        $con = Conexion::conecction();
        $pdf = new Reporte();
        $stmt = $con->prepare("SELECT nombre FROM asignatura WHERE id = ?");
        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->execute();
        $asignatura = '';
        while ($res = $stmt->fetch()) {
            $asignatura = $res['nombre'];
        }
        $stmt = null;

        $stmt = $con->prepare("SELECT nombre FROM ep WHERE 'in' LIKE ?");
        $stmt->bindParam(1, $ep, PDO::PARAM_INT);
        $stmt->execute();
        $escuela = '';
        while ($res = $stmt->fetch()) {
            $escuela = $res['nombre'];
        }
        $stmt = null;

        $stmt = $con->prepare("SELECT 
        CONCAT(usuarios.apellidop,' ',usuarios.apellidom, ' ',usuarios.nombres) AS nombre 
        FROM asignaturad
        INNER JOIN usuarios ON asignaturad.codigo = usuarios.user
        WHERE asignaturad.asignatura LIKE ?");
        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->execute();
        $docente = '';
        while ($res = $stmt->fetch()) {
            $docente = $res['nombre'];
        }
        $stmt = null;
        $titulo = 'Lista de Asistencia';
        $pdf->setNombreEp($escuela);
        $pdf->setTitulo($titulo);
        $pdf->setNombreAs($asignatura);
        $pdf->setNombreDOC($docente);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $stmt = $con->prepare("SELECT CONCAT(usuarios.apellidop,' ',usuarios.apellidom,' ',usuarios.nombres) AS nombre,
                usuarios.user,asistencia.asistio FROM asistencia
                INNER JOIN usuarios ON usuarios.user = asistencia.codigoest
                WHERE asistencia.codigoasig LIKE ? AND asistencia.fecha LIKE ?
                ORDER BY usuarios.apellidop");
        $stmt->bindParam(1, $as, PDO::PARAM_INT);
        $stmt->bindParam(2, $fe, PDO::PARAM_STR);

        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 6, 'N', 1, 0, 'C', 1);
        $pdf->Cell(100, 6, 'Apellidos y Nombres', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Codigo', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Asistencia', 1, 1, 'C', 1);
        $num = 1;
        $stmt->execute();
        while ($row = $stmt->fetch()) {

            $pdf->SetX(15);
            $pdf->Cell(20, 6, $num, 1, 0, 'C', 1);
            $pdf->Cell(100, 6, utf8_decode($row['nombre']), 1, 0);
            $pdf->Cell(30, 6, $row['user'], 1, 0);
            if ($row['asistio'] == 1) {
                $pdf->Cell(30, 6, 'asistio', 1, 1, 'C');
            } else {
                $pdf->Cell(30, 6, 'falto', 1, 1, 'C');
            }
            $num = $num + 1;
        }
        $pdf->Output();
    }
}