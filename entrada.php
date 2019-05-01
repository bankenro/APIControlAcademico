<?php

require 'func/Funciones.php';

if (isset($_REQUEST['accion'])) {
    $accion = $_REQUEST['accion'];
    switch ($accion) {
        case "5940569cd1d60781f856f93235b072ee":
            if (isset($_POST['nombre1']) && isset($_POST['apellidop1']) && isset($_POST['apellidom1']) &&
                isset($_POST['correo1']) && isset($_POST['sexo1']) && isset($_POST['foto1']) && isset($_POST['codigo1'])
                && isset($_POST['password']) && isset($_POST['verificacion1']) && isset($_POST['telefono1']) &&
                isset($_POST['fecha1']) && isset($_POST['tdocumento1']) && isset($_POST['documento1']) && isset($_POST['1'])
                && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $nombre1 = $_POST['nombre1'];
                $apellidop1 = $_POST['apellidop1'];
                $apellidom1 = $_POST['apellidom1'];
                $correo1 = $_POST['correo1'];
                $sexo1 = $_POST['sexo1'];
                $foto1 = base64_decode($_POST['foto1']);
                $codigo1 = $_POST['codigo1'];
                $password = $_POST['password'];
                $verificacion1 = $_POST['verificacion1'];
                $telefono1 = $_POST['telefono1'];
                $fecha1 = $_POST['fecha1'];
                $tdocumento1 = $_POST['tdocumento1'];
                $documento1 = $_POST['documento1'];
                $nacimiento = $_POST['1'];
                $activo = $_POST['2'];
                $escuela = $_POST['3'];
                $sede = $_POST['4'];
                $doc = "1";
                $est = "2";
                $secr = "3";

                $comprobar = Funciones::ComprobarCodigo($codigo1);

                if ($comprobar != null){
                    echo json_encode($comprobar);
                }else{
                    $comprobar1 = Funciones::ComprobarCorreo($correo1);
                    if ($comprobar1 != null){
                        echo json_encode($comprobar1);
                    }else{
                        $comprobar2 = Funciones::ComprobarTelefono($telefono1);
                        if ($comprobar2 != null){
                            echo json_encode($comprobar2);
                        }else{
                            $comprobar3 = Funciones::ComprobarDNI($documento1);
                            if ($comprobar3 != null){
                                echo json_encode($comprobar3);
                            }else{
                                switch ($verificacion1) {
                                    case 1:
                                        Funciones::registrarUsuario($nombre1, $apellidop1, $apellidom1, $correo1, $sexo1, $foto1, $codigo1,
                                            $password, $verificacion1, $telefono1, $fecha1, $tdocumento1, $documento1, $nacimiento, $activo,
                                            $escuela, $sede);
                                        break;
                                    case 2:
                                        Funciones::registrarUsuario($nombre1, $apellidop1, $apellidom1, $correo1, $sexo1, $foto1, $codigo1,
                                            $password, $verificacion1, $telefono1, $fecha1, $tdocumento1, $documento1, $nacimiento, $activo,
                                            $escuela, $sede);
                                        break;
                                    case 3:
                                        Funciones::registrarUsuario($nombre1, $apellidop1, $apellidom1, $correo1, $sexo1, $foto1, $codigo1,
                                            $password, $verificacion1, $telefono1, $fecha1, $tdocumento1, $documento1, $nacimiento, $activo,
                                            $escuela, $sede);
                                        break;
                                }
                            }
                        }
                    }
                }
            }
            break;

        case "e4452df117298af83e41e929fa8f4399":
            if (isset($_REQUEST['codd']) && isset($_REQUEST['coda'])) {
                $codd = $_REQUEST['codd'];
                $coda = $_REQUEST['coda'];
                $asistio = 1;
                $comprobar = Funciones::ComprobarHoraAsistencia($coda);
                if ($comprobar != null) {
                    $respuesta = Funciones::registrarAsistenciaA($codd, $coda, $asistio);
                    if ($respuesta != null) {
                        echo json_encode($respuesta);
                        Funciones::NotificarRAA($coda);
                    }else{
                        echo "error";
                    }
                } else {
                    $horario = Funciones::MostrarHorAsig($coda);
                    if ($horario != null) {
                        echo json_encode($horario);
                    }
                }
            }
            break;

        case "4d266f086151f518fbab74ece237012d":
            if (isset($_POST['codd']) && isset($_POST['coda'])) {
                $codd = $_POST['codd'];
                $coda = $_POST['coda'];
                $asistio = '1';
                $comprobar = Funciones::ComprobarHoraAsistencia($coda);
                if ($comprobar != null) {
                    $respuesta = Funciones::registrarAsistenciaN($codd, $coda, $asistio);

                    if ($respuesta != null) {
                        echo json_encode($respuesta);
                        Funciones::NotificarRAN($coda);
                    }
                } else {
                    $horario = Funciones::MostrarHorAsig($coda);
                    if ($horario != null) {
                        echo json_encode($horario);
                    }
                }
            }
            break;

        case "19edb6a9510fb757b6d8e973e71114cc":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $asistio = $_POST['1'];
                $codigoest = $_POST['2'];
                $codigodoc = $_POST['3'];
                $codigoasig = $_POST['4'];

                $respuesta = Funciones::actualizarAsistencia($asistio, $codigoest, $codigodoc, $codigoasig);
                if ($respuesta != null) {
                    echo $respuesta;
                    Funciones::NotificacionAA($asistio, $codigoest, $codigoasig);
                }
            }
            break;
        case "8d1822fd62f2f6c2ed1e6d00490c06a9":
            if (isset($_POST['s']) && isset($_POST['fecha'])) {
                $s = $_POST['s'];
                $fecha = $_POST['fecha'];
                $respuesta = Funciones::mostrarAsistencia($s, $fecha);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "ccf39604f11cf50c5cf67b8e61694b82":
            if (isset($_POST['s']) && isset($_POST['fecha'])) {
                $s = $_POST['s'];
                $fecha = $_POST['fecha'];

                $respuesta = Funciones::mostrarAsistencia1($s, $fecha);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "d2779ae956aa2e47cb6784dcf326e335":
            if (isset($_POST['s']) && isset($_POST['1']) && isset($_POST['2'])) {
                $s = $_POST['s'];
                $s1 = $_POST['1'];
                $s2 = $_POST['2'];

                $respuesta = Funciones::estudiantesN($s, $s1, $s2);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "234648d8264abac1b59bc843552d0e36":
            if (isset($_POST['s']) && isset($_POST['1']) && isset($_POST['2'])) {
                $s = $_POST['s'];
                $s1 = $_POST['1'];
                $s2 = $_POST['2'];

                $respuesta = Funciones::estudiantesA($s, $s1, $s2);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "d56b699830e77ba53855679cb1d252da":
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['token'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $token = $_POST['token'];

                $respuesta = Funciones::loginU($username, $password, $token);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'Usuario o contraseña incorrectos';
                }
            }
            break;
        case "b504a826844534c9fc56d4f23b985160":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $a = $_POST['1'];
                $b = $_POST['2'];

                $respuesta = Funciones::registrarAsign($a, $b);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se registro la asignatura';
                }
            }
            break;
        case "cd42d6230ac35c4a6a74f79d4191d3db":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $a = $_POST['1'];
                $b = $_POST['2'];
                $c = $_POST['3'];
                $d = $_POST['4'];
                $comprobar = Funciones::VerificarAsignaturaDocente($b, $c, $d);
                if ($comprobar != null) {
                    echo json_encode($comprobar);
                } else {
                    $respuesta = Funciones::registrarAsignD($a, $b, $c, $d);
                    if ($respuesta != null){
                        echo json_encode($respuesta);
                    }else {
                        echo 'No se registro la asignatura al docente';
                    }
                }
            }
            break;
        case "2d11dc2fb6c01ebfe32375cd852c82d6":
            if (isset($_POST['baucher1']) && isset($_POST['codigo1']) && isset($_POST['matricula1']) && isset($_POST['anio'])
                && isset($_POST['escuela']) && isset($_POST['an']) && isset($_POST['tipom']) && isset($_POST['1']) &&
                isset($_POST['2'])) {
                $baucher1 = $_POST['baucher1'];
                $codigo1 = $_POST['codigo1'];
                $matricula1 = $_POST['matricula1'];
                $anio = $_POST['anio'];
                $escuela = $_POST['escuela'];
                $an = $_POST['an'];
                $tipom = $_POST['tipom'];
                $a = $_POST['1'];
                $s = $_POST['2'];

                if ($matricula1 == 'matriculan') {
                    $respuesta = Funciones::matriculaN($baucher1, $codigo1, $an, $anio, $escuela, $tipom, $a, $s);
                    if ($respuesta != null){
                        echo json_encode($respuesta);
                    }else {
                        echo 'No se registro la asignatura al docente';
                    }
                } else if ($matricula1 == 'matriculaa') {
                    $respuesta = Funciones::matriculaA($baucher1, $codigo1, $an, $anio, $escuela, $tipom, $a, $s);
                    if ($respuesta != null){
                        echo json_encode($respuesta);
                    }else {
                        echo 'No se registro la asignatura al docente';
                    }
                }
            }
            break;
        case "34ce3356ab05a54f448e8681763c5c89":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $a = $_POST['1'];
                $b = $_POST['2'];

                $respuesta = Funciones::registrarSem($a, $b);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se registro el semestre';
                }
            }
            break;
        case "cad0a4a29d1e35f8db13330ca55ed125":
            if (isset($_POST['s1'])) {
                $s1 = $_POST['s1'];

                $respuesta = Funciones::asignaturas($s1);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron las asignaturas';
                }
            }
            break;
        case "1a90d2a034cff65deca89648670e3d9d":
            $codigo = $_POST['codigo'];

            $respuesta = Funciones::asignaturasD($codigo);
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron las asignaturas de los docentes';
            }
            break;
        case "78f90bedbee38d58ad9bd7473b7bdfc6":
            if (isset($_POST['s'])) {
                $s = $_POST['s'];

                $respuesta = Funciones::escuelas($s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron las escuelas';
                }
            }
            break;
        case "4e8b4e0844bd0bcf6511d41ab6ce1627":
            if (isset($_POST['s1'])) {
                $s1 = $_POST['s1'];

                $respuesta = Funciones::semestres($s1);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los semestres';
                }
            }
            break;
        case "70a76dcb551d1008f244577f0106052a":

            $respuesta = Funciones::facultades();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los facultades';
            }
            break;
        case "6183b37347b357daa37d3a5d6404f519":

            $respuesta = Funciones::matricula();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los matriculas';
            }
            break;
        case "0e547954d2aae61eee4bb738b4254a27":

            $respuesta = Funciones::unidades();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los unidades';
            }
            break;

        case "982f9688ff43c8529bd91dba4eb6c235":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['4']) && isset($_POST['5'])) {
                $coda = $_POST['1'];
                $codu = $_POST['2'];
                $cod = $_POST['4'];
                $an = $_POST['5'];

                $respuesta = Funciones::registrarNotaA($coda, $codu, $cod, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se registraron las notas';
                }
            }
            break;
        case "903c16ef37c43d22a7ffe94767576835":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['4']) && isset($_POST['5'])) {
                $coda = $_POST['1'];
                $codu = $_POST['2'];
                $cod = $_POST['4'];
                $an = $_POST['5'];

                $respuesta = Funciones::registrarNotaN($coda, $codu, $cod, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se registraron las notas';
                }
            }
            break;
        case "f4f09334af626edf50c1f3f48f1fbdfc":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $coduni = $_POST['1'];
                $codasi = $_POST['2'];
                $cod = $_POST['3'];
                $an = $_POST['4'];

                $respuesta = Funciones::mostrarNotas($coduni, $codasi, $cod, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se registraron las notas';
                }
            }
            break;
        case "8499127942a7e1d3ebfd89e962763829":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['5']) &&
                isset($_POST['6']) && isset($_POST['7'])) {
                $coduni = $_POST['1'];
                $codasi = $_POST['2'];
                $codest = $_POST['3'];
                $nota = $_POST['5'];
                $cod = $_POST['6'];
                $an = $_POST['7'];

                $respuesta = Funciones::actualizarNotas($codest, $coduni, $codasi, $nota, $cod, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se actualizaron las notas';
                }
            }
            break;
        case "f8b9fafca53494bab6c77e5d31257a44":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $codigoest = $_POST['1'];
                $s1 = $_POST['2'];

                $respuesta = Funciones::asignaturaa($codigoest, $s1);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "ff8d230ab1c51d8e5495a2d942dffee9":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $codigoest = $_POST['1'];
                $s1 = $_POST['2'];

                $respuesta = Funciones::asignaturan($codigoest, $s1);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "e8c7c1ce12a6999592eca9fe8a7f954c":
            $respuesta = Funciones::departamento();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los datos';
            }
            break;
        case "a1917ee89e7001c1d1904305b7dc5f41":
            if (isset($_POST['1'])) {
                $id = $_POST['1'];

                $respuesta = Funciones::provincia($id);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "7402d0bc898ad8c049abd8d8d157cef4":
            if (isset($_POST['1'])) {
                $id = $_POST['1'];

                $respuesta = Funciones::distrito($id);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "e84533c062abaa7cea4bed1009de8196":
            $respuesta = Funciones::sedes();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los datos';
            }
            break;
        case "0b97504fc4747fa8098d4899d1d08347":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['4'])) {
                $ide = $_POST['1'];
                $e = $_POST['2'];
                $s = $_POST['4'];

                $respuesta = Funciones::estudiantes($ide, $e, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "b74df323e3939b563635a2cba7a7afba":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $ide = $_POST['1'];
                $e = $_POST['2'];
                $a = $_POST['3'];
                $s = $_POST['4'];

                $respuesta = Funciones::m2($ide, $e, $a, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "412566367c67448b599d1b7666f8ccfc":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3']) && isset($_POST['4'])) {
                $ide = $_POST['1'];
                $e = $_POST['2'];
                $a = $_POST['3'];
                $s = $_POST['4'];

                $respuesta = Funciones::m1($ide, $e, $a, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "316c9c3ed45a83ee318b1f859d9b8b79":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])) {
                $a = $_POST['1'];
                $b = $_POST['2'];
                $c = $_POST['3'];
                switch ($c) {
                    case "1c52bdae8bad70e82da799843bb4e831":

                        $respuesta = Funciones::actualizarusuarioactivo($a, $b);
                        if ($respuesta != null){
                            echo json_encode($respuesta);
                        }else {
                            echo 'No se actualizaron los datos';
                        }
                        break;
                    case "ae7be26cdaa742ca148068d5ac90eaca":

                        $respuesta = Funciones::actualizarmatriculan($a, $b);
                        if ($respuesta != null){
                            echo json_encode($respuesta);
                        }else {
                            echo 'No se actualizaron los datos';
                        }
                        break;
                    case "aaf2f89992379705dac844c0a2a1d45f":

                        $respuesta =  Funciones::actualizarmatriculaa($a, $b);
                        if ($respuesta != null){
                            echo json_encode($respuesta);
                        }else {
                            echo 'No se actualizaron los datos';
                        }
                        break;
                }
            }
            break;
        case "39a0168fb541c6b13b485f1c530f9dbe":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $c = $_POST['1'];
                $t = $_POST['2'];

                $respuesta = Funciones::ElimarToken($c, $t);

                if ($respuesta != null) {
                    echo json_encode($respuesta);
                }
            }
            break;
        case "c6dfb15cab81b9a83ade09529ff082db":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['4'])) {
                $idd = $_POST['1'];
                $e = $_POST['2'];
                $s = $_POST['4'];
                $respuesta = Funciones::MostrarDocentes($idd, $e, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "d36ef148e7d528f45a0c1409762820d7":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3']) && isset($_POST['4'])) {
                $idd = $_POST['1'];
                $e = $_POST['2'];
                $a = $_POST['3'];
                $s = $_POST['4'];
                $respuesta = Funciones::MostrarAsignaturasDocentes($idd, $e, $a, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "6843023606e501b553a9be96e911df40":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3']) && isset($_POST['4'])) {
                $idd = $_POST['1'];
                $e = $_POST['2'];
                $a = $_POST['3'];
                $s = $_POST['4'];
                $respuesta = Funciones::MostrarHorariosDocentes($idd, $e, $a, $s);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "d8b96676087b7d96d24d04ceb184af92":
            $respuesta = Funciones::DiasSemana();
            if ($respuesta != null){
                echo json_encode($respuesta);
            }else {
                echo 'No se cargaron los datos';
            }
            break;
        case "0326c5264dc2140869e48ede7f0d24db":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])
                && isset($_POST['4']) && isset($_POST['5']) && isset($_POST['6'])) {
                $as = $_POST['1'];
                $di = $_POST['2'];
                $se = $_POST['3'];
                $in = $_POST['4'];
                $fi = $_POST['5'];
                $an = $_POST['6'];

                $comprobar1 = Funciones::ComprobarAsignaturaDia($as, $di, $an, $se);
                if ($comprobar1 != null) {
                    echo json_encode($comprobar1);
                } else {
                    $comprobar2 = Funciones::ComprobarHorarioHoraIguales($di, $in, $fi, $se, $an);
                    if ($comprobar2 != null) {
                        echo json_encode($comprobar2);
                    } else {
                        $comprobar3 = Funciones::ComprobarHorario($di, $in, $fi, $se, $an);
                        if ($comprobar3 != null) {
                            echo json_encode($comprobar3);
                        } else {
                            $respuesta = Funciones::RegistrarHorario($as, $di, $se, $in, $fi, $an);
                            if ($respuesta != null){
                                echo json_encode($respuesta);
                            }else {
                                echo 'No se cargaron los datos';
                            }
                        }
                    }
                }
            }
            break;
        case "f631a47e884c4fc5fd9141ca2939db93":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])
                && isset($_POST['4']) && isset($_POST['5']) && isset($_POST['6'])) {
                $as = $_POST['1'];
                $di = $_POST['2'];
                $se = $_POST['3'];
                $in = $_POST['4'];
                $fi = $_POST['5'];
                $an = $_POST['6'];

                $respuesta = Funciones::EliminarHorario($as, $di, $se, $in, $fi, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "c8e92b8d6bbd861bde68787ee1533c11":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])
                && isset($_POST['4'])) {
                $co = $_POST['1'];
                $as = $_POST['2'];
                $se = $_POST['3'];
                $an = $_POST['4'];

                $respuesta = Funciones::EliminarAsignaturaDocente($co, $as, $se, $an);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "6c7968eac8bd4a16b981ca0195efc416":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])
                && isset($_POST['4']) && isset($_POST['5'])) {
                $co = $_POST['1'];
                $an = $_POST['2'];
                $se = $_POST['3'];
                $as = $_POST['4'];
                $asa = $_POST['5'];

                $respuesta = Funciones::ActualizarAsignaturaDocente($co, $an, $se, $as, $asa);
                if ($respuesta != null){
                    echo json_encode($respuesta);
                }else {
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "7587b8d6bb1056ae18daee092c1eee94":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])
                && isset($_POST['4']) && isset($_POST['5']) && isset($_POST['6'])) {
                $as = $_POST['1'];
                $an = $_POST['2'];
                $se = $_POST['3'];
                $di = $_POST['4'];
                $in = $_POST['5'];
                $fi = $_POST['6'];

                $comprobar = Funciones::ComprobarHorarioHoraIguales($di, $in, $fi, $se, $an);
                if ($comprobar != null) {
                    echo json_encode($comprobar);
                } else {
                    $comprobar1 = Funciones::ComprobarHorario($di, $in, $fi, $se, $an);
                    if ($comprobar1 != null) {
                        echo json_encode($comprobar1);
                    } else {
                        Funciones::ActualizarHorario($as, $an, $se, $di, $in, $fi);
                    }
                }
            }
            break;
        case "93fa62b91ffeccdf8ddafc1786266185":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3'])) {
                $sem = $_POST['1'];
                $sed = $_POST['2'];
                $an = $_POST['3'];

                $res1 = Funciones::MostrarHorarios($sem, $sed, $an);
                if ($res1 != null) {
                    echo json_encode($res1);
                }else{
                    echo 'No se cargaron los datos';
                }
            }
            break;
        case "493c5ad688fbd0a46be6b3756cb7ff64":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3'])) {
                $do = $_POST['1'];
                $sed = $_POST['2'];
                $an = $_POST['3'];

                $res1 = Funciones::MostrarHorarioD($do, $sed, $an);
                if ($res1 != null) {
                    echo json_encode($res1);
                }
            }
            break;
        case "da59cf6f9b845f7fd63d273ccfb6eacd":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3'])) {
                $us = $_POST['1'];
                $sed = $_POST['2'];
                $an = $_POST['3'];

                $res1 = Funciones::MostrarMiHorarioN($us, $sed, $an);
                if ($res1 != null) {
                    echo json_encode($res1);
                }
            }
            break;
        case "a6e489bb35c3a94671afb80ee3f0796a":
            if (isset($_POST['1']) && isset($_POST['2'])
                && isset($_POST['3'])) {
                $us = $_POST['1'];
                $sed = $_POST['2'];
                $an = $_POST['3'];

                $res1 = Funciones::MostrarHorarioA($us, $sed, $an);
                if ($res1 != null) {
                    echo json_encode($res1);
                }
            }
            break;
        case "e7bb339b9f17aee763aa1cea9c0b8fc3":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $an = $_POST['1'];
                $co = $_POST['2'];

                $res = Funciones::MostrarNotaD($an, $co);

                if ($res != null) {
                    echo json_encode($res);
                }
            }
            break;
        case "4b0c1f80ce9882cafee24e81bcaaeab6":
            if (isset($_POST['1']) && isset($_POST['2'])) {
                $an = $_POST['1'];
                $co = $_POST['2'];

                $res = Funciones::MostrarNotaE($an, $co);

                if ($res != null) {
                    echo json_encode($res);
                }
            }
            break;
        case "33d0d2809819a1001fc32890398eb768":
            if (isset($_POST['1']) && isset($_POST['2']) && isset($_POST['3'])) {
                $as = $_POST['1'];
                $fe = $_POST['2'];
                $ep = $_POST['3'];

                Funciones::ReporteAsistenci($ep, $as, $fe);

            }else{
                echo 'no se recibieron los datos';
            }
            break;
        case "prueba":
            Funciones::ReporteAsistenci(1, 23, '2018-02-28');
            break;
        default:
            break;
    }
}
