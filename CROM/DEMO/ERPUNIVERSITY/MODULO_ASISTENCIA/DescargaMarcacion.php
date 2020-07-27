<?php
define('GL_DIR_FS_APP','/var/www/CROM/DEMO');
define('GL_DIR_FS_LIB','/var/www/LIBRERIAS');
//define('GL_DIR_FS_APP','d:/proyectos/daemonsuladech/CROM/DEMO');
//define('GL_DIR_FS_LIB','d:/proyectos/daemonsuladech/LIBRERIAS');

require_once(GL_DIR_FS_APP . "/index.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/TADFactory.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/TADResponse.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Providers/TADSoap.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/class.soapclient.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Providers/TADZKLib.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Exceptions/ConnectionError.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Exceptions/FilterArgumentError.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Exceptions/UnrecognizedCommand.php");
require_once(GL_DIR_FS_LIB . "/tad/lib/Exceptions/UnrecognizedCommand.php");


$marcacionDAO = new General();
$data = $marcacionDAO->Asis_MarcadorConsultar('00','');
$xListaMarcaciones = '';

if(date_default_timezone_get() != 'America/Lima'){
    date_default_timezone_set('America/Lima');
}

//if(count($data) > 0){
//    $xTotal = 0;
//    foreach ($data as $indice=>$marcador) {
//        $persona            = '';
//        $usuario            = '';
//        $personaaux         = '';
//        $marcacion          = '';
//        $xListaMarcacion    = '';
//        $xFlag              = '';
//        $xAnio              = '';
//        $xResumenMarcacion  = '';
//        $xUsuarioCrea       = '';
//        $xOnline            = '0';
//        $verificado         = '';
//        $result             = '';
//        $options = array(
//                    'ip'        => $marcador['ip'],
//                    'udp_port'  => $marcador['puerto_udp'],
//                    'soap_port' => $marcador['puerto_tcp'],
//                    'encoding'  => 'utf-8'
//                );
//        $tad_factory = new \TADPHP\TADFactory($options);
//        $tad = $tad_factory->get_instance();
//        if($marcador['filial'] == '0'){  ## trabajadmos con sockets upd
//            if ($tad->is_alive()) {
//                $mac = $tad->get_mac_address()->to_array()['Row'];
//                if ($mac['Information'] == $marcador['mac']) {
//                    $marcaciones = $tad->get_att_log();
////                    $marcacionesFilter = $marcaciones->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
//                    $marcacionesFilter = $marcaciones->filter_by_date(['start' =>"2019-08-08", 'end' => "2019-08-08"]);
//                    if (!$marcacionesFilter->is_empty_response()) {
//                        $marcacionesDetalle = $marcacionesFilter->to_array()['Row'];
//                        //[PIN]       => 239250
//                        //[DateTime]  => 2019-07-04 12:26:59
//                        //[Verified]  => 1
//                        //[Status]    => 0
//                        // [WorkCode] => 0
//                        foreach ($marcacionesDetalle as $id => $detalle) {
//                            $infouser = $tad->get_user_info(['pin' => $detalle['PIN']])->to_array()['Row'];
//                            //[PIN]         => 1640
//                            //[Name]        => svergaraa
//                            //[Password]    => Array
//                            //                (
//                            //                )
//                            //[Group]       => 1
//                            //[Privilege]   => 0
//                            //[Card]        => 0
//                            //[PIN2]        => 239250
//                            //[TZ1]         => 0
//                            //[TZ2]         => 0
//                            //[TZ3]         => 0
//                            $persona = $detalle['PIN'];
//                            $usuario = $infouser['Name'];
//                            $personaaux = $infouser['PIN2'];
//                            $marcacion = $detalle['DateTime'];
//                            $verificado = $detalle['Verified'];
//                            $xListaMarcacion .= $persona . '|' . $usuario . '|' . $personaaux . '|' . $marcacion . '|' . $verificado . '#';
//                        }
//                        $xFlag = '00';
//                        $xAnio = date('Y');
//                        $xResumenMarcacion = date('YmdHis') . '|' . $marcador['acti_codigo'];
//                        $xUsuarioCrea = 'ULADECHAUTO';
//                        $xOnline = '1';
//                        $xTotalRegistrosMarcador = $marcacionesFilter->count();
//                        $xTotal = $xTotal + $xTotalRegistrosMarcador;
//                        $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag, $xAnio, $xListaMarcacion, $marcador['ip'], $mac['Information'], $marcador['acti_codigo'], $xTotalRegistrosMarcador, $xResumenMarcacion, $xOnline, $xUsuarioCrea);
//                    } else {
//                        $xFlag = '00';
//                        $xAnio = date('Y');
//                        $xResumenMarcacion = date('YmdHis') . '|' . $marcador['acti_codigo'];
//                        $xUsuarioCrea = 'ULADECHAUTO';
//                        $xOnline = '1';
//                        $xTotalRegistrosMarcador = 0;
//                        $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag, $xAnio, $xListaMarcacion, $marcador['ip'], $mac['Information'], $marcador['acti_codigo'], $xTotalRegistrosMarcador, $xResumenMarcacion, $xOnline, $xUsuarioCrea);
//                    }
//                }
//            } else {
//                $xFlag                  = '00';
//                $xAnio                  = date('Y');
//                $xResumenMarcacion      = date('YmdHis').'|'.$marcador['acti_codigo'];
//                $xUsuarioCrea           = 'ULADECHAUTO';
//                $xOnline                = '0';
//                $xTotalRegistrosMarcador = 0;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
//            }
//
//            if($result[0]['mensaje'] =='ERROR'){
//                echo 'ERROR EN BASE DE DATOS';
//                continue;
//            }
//        }else{ ## trabajadmos con soap
////            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
//            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => "2019-08-08", 'end' => "2019-08-08"]);
////            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' =>"2019-07-01", 'end' => "2019-08-01"]);
////            $marcacionesFilter = $marcaciones->filter_by_date(['start' =>"2019-07-01", 'end' => "2019-08-01"]);
////            var_dump($marcacionesFilter->is_empty_response());
//            if (!$marcacionesFilter->is_empty_response()) {
//                $marcacionesDetalle = $marcacionesFilter->to_array()['Row'];
//                //[PIN]       => 239250
//                //[DateTime]  => 2019-07-04 12:26:59
//                //[Verified]  => 1
//                //[Status]    => 0
//                // [WorkCode] => 0
//                foreach ($marcacionesDetalle as $id => $detalle) {
//                    $infouser = $tad->get_user_info(['pin' => $detalle['PIN']])->to_array()['Row'];
//                    //[PIN]         => 1640
//                    //[Name]        => svergaraa
//                    //[Password]    => Array
//                    //                (
//                    //                )
//                    //[Group]       => 1
//                    //[Privilege]   => 0
//                    //[Card]        => 0
//                    //[PIN2]        => 239250
//                    //[TZ1]         => 0
//                    //[TZ2]         => 0
//                    //[TZ3]         => 0
//                    $persona          = $detalle['PIN'];
//                    $usuario          = $infouser['Name'];
//                    $personaaux       = $infouser['PIN2'];
//                    $marcacion        = $detalle['DateTime'];
//                    $verificado       = $detalle['Verified'];
//                    $xListaMarcacion .= $persona.'|'.$usuario.'|'.$personaaux.'|'.$marcacion.'|'.$verificado.'#';
//                }
//                $xFlag              = '00';
//                $xAnio              = date('Y');
//                $xResumenMarcacion  = date('YmdHis').'|'.$marcador['acti_codigo'];
//                $xUsuarioCrea       = 'ULADECHAUTO';
//                $xOnline            = '1';
//                $xTotalRegistrosMarcador = $marcacionesFilter->count();
//                $xTotal = $xTotal + $xTotalRegistrosMarcador;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
//            }else{
//                $xFlag              = '00';
//                $xAnio              = date('Y');
//                $xResumenMarcacion  = date('YmdHis').'|'.$marcador['acti_codigo'];
//                $xUsuarioCrea       = 'ULADECHAUTO';
//                $xOnline            = '1';
//                $xTotalRegistrosMarcador = 0;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
//            }
//        }
////        print_r($tad->restart());
////        print_r($tad->get_com_key());
////        print_r($tad::soap_commands_available());exit;
////        print_r($tad->execute_command_via_tad_soap('restart',[]));
////        print_r($tad->execute_command_via_tad_soap('get_att_log',[])->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")])->to_array());
////        print_r($tad->execute_command_via_tad_soap('get_option',[])->to_array()['Row']);
////        exit;
//
//
//
//    }
//    ## termina de insertar marcaciones :
//    ## inicio de sincronizacion en las tarjetas
//    sleep(45);
////    '{$xFlag}',
////    '{$xFechaInicio}',
////    '{$xFechaTermino}',
////    '{$xListaPersona}',
////    '{$xTotalPersona}',
////    '{$xListaEstructura}',
////     {$xTotalEstructura},
////    '{$xUsuario}'
//
////    $fechasincroniza = date("Y-m-d");
//    if($xTotal > 0){
//
//        $fechasincroniza = date("Y-m-d");
//        $marcacionDAO->Asis_MarcadorSincronizacion(
//            '00',
//            $fechasincroniza,
//            $fechasincroniza,
//            '',
//            0,
//            '',
//            0,
//            'ASISTENCIAAUTO');
//    }
//}


if(count($data) > 0){
    $xTotal = 0;
    foreach ($data as $indice=>$marcador) {
        $persona            = '';
        $usuario            = '';
        $personaaux         = '';
        $marcacion          = '';
        $xListaMarcacion    = '';
        $xFlag              = '';
        $xAnio              = '';
        $xResumenMarcacion  = '';
        $xUsuarioCrea       = '';
        $xOnline            = '0';
        $verificado         = '';
        $pin                = '';
        $result             = '';
        $options = array(
            'ip'        => $marcador['ip'],
            'udp_port'  => $marcador['puerto_udp'],
            'soap_port' => $marcador['puerto_tcp'],
            'encoding'  => 'utf-8'
        );
        $tad_factory = new \TADPHP\TADFactory($options);
        $tad = $tad_factory->get_instance();

        print_r($tad->get_user_info(array()));exit;
        if($marcador['filial'] == '0'){  ## trabajadmos con sockets upd
            if ($tad->is_alive()) {
                $mac = $tad->get_mac_address()->to_array()['Row'];
//                if ($mac['Information'] == $marcador['mac']) {
                if (true) {
//                    $marcaciones = $tad->get_att_log();
                    $marcacionesFilter = $tad->get_att_log();
//                    $marcacionesFilter = $marcaciones->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
//                    $marcacionesFilter = $marcaciones->filter_by_date(['start' => "2019-08-12", 'end' => "2019-08-12"]);
                    if (!$marcacionesFilter->is_empty_response()) {
                        $marcacionesDetalle = $marcacionesFilter->to_array()['Row'];
                        //[PIN]       => 239250
                        //[DateTime]  => 2019-07-04 12:26:59
                        //[Verified]  => 1
                        //[Status]    => 0
                        // [WorkCode] => 0
                        foreach ($marcacionesDetalle as $id => $detalle) {
//                            $infouser = $tad->get_user_info(['pin' => $detalle['PIN']])->to_array()['Row'];
                            $pin = isset($detalle['PIN']) ? $detalle['PIN'] : 'XXXXXX';
                            $infouser = $tad->get_user_info(['pin' => $pin]);
                            if (!$infouser->is_empty_response()){
                                $infouser = $infouser->to_array()['Row'];
                                //[PIN]         => 1640
                                //[Name]        => svergaraa
                                //[Password]    => Array
                                //                (
                                //                )
                                //[Group]       => 1
                                //[Privilege]   => 0
                                //[Card]        => 0
                                //[PIN2]        => 239250
                                //[TZ1]         => 0
                                //[TZ2]         => 0
                                //[TZ3]         => 0
                                $persona = isset($detalle['PIN']) ? $detalle['PIN'] : '';
                                $usuario = isset($infouser['Name']) ? $infouser['Name'] : '';
                                $personaaux = isset($infouser['PIN2']) ? $infouser['PIN2'] : '';
                                $marcacion = isset($detalle['DateTime']) ? $detalle['DateTime'] : '';
                                $verificado = isset($detalle['Verified']) ? $detalle['Verified'] : '';
                                $xListaMarcacion .= $persona . '|' . $usuario . '|' . $personaaux . '|' . $marcacion . '|' . $verificado . '#';
                            }
                        }
                        $xFlag = '00';
                        $xAnio = date('Y');
                        $xResumenMarcacion = date('YmdHis') . '|' . $marcador['acti_codigo'];
                        $xUsuarioCrea = 'ULADECHAUTO';
                        $xOnline = '1';
                        $xTotalRegistrosMarcador = $marcacionesFilter->count();
                        $xTotal = $xTotal + $xTotalRegistrosMarcador;
//                        $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag, $xAnio, $xListaMarcacion, $marcador['ip'], $mac['Information'], $marcador['acti_codigo'], $xTotalRegistrosMarcador, $xResumenMarcacion, $xOnline, $xUsuarioCrea);
                    } else {
                        $xFlag = '00';
                        $xAnio = date('Y');
                        $xResumenMarcacion = date('YmdHis') . '|' . $marcador['acti_codigo'];
                        $xUsuarioCrea = 'ULADECHAUTO';
                        $xOnline = '1';
                        $xTotalRegistrosMarcador = 0;
//                        $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag, $xAnio, $xListaMarcacion, $marcador['ip'], $mac['Information'], $marcador['acti_codigo'], $xTotalRegistrosMarcador, $xResumenMarcacion, $xOnline, $xUsuarioCrea);
                    }
                }
            } else {
                $xFlag                  = '00';
                $xAnio                  = date('Y');
                $xResumenMarcacion      = date('YmdHis').'|'.$marcador['acti_codigo'];
                $xUsuarioCrea           = 'ULADECHAUTO';
                $xOnline                = '0';
                $xTotalRegistrosMarcador = 0;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
            }
            print_r($xListaMarcacion);
//            if($result[0]['mensaje'] =='ERROR'){
//                echo 'ERROR EN BASE DE DATOS';
//                continue;
//            }
        }else{ ## trabajadmos con soap
//            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
//            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => "2019-08-12", 'end' => "2019-08-12"]);
            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array());
            if (!$marcacionesFilter->is_empty_response()) {
                $marcacionesDetalle = $marcacionesFilter->to_array()['Row'];
                //[PIN]       => 239250
                //[DateTime]  => 2019-07-04 12:26:59
                //[Verified]  => 1
                //[Status]    => 0
                // [WorkCode] => 0
                foreach ($marcacionesDetalle as $id => $detalle) {
//                    $infouser = $tad->get_user_info(['pin' => $detalle['PIN']])->to_array()['Row'];
                    $pin = isset($detalle['PIN']) ? $detalle['PIN'] : 'XXXXXX';
                    $infouser = $tad->execute_command_via_tad_soap('get_user_info',array('pin' => $pin));
                    if(!$infouser->is_empty_response()){
                        $infouser = $infouser->to_array()['Row'];
                        //[PIN]         => 1640
                        //[Name]        => svergaraa
                        //[Password]    => Array
                        //                (
                        //                )
                        //[Group]       => 1
                        //[Privilege]   => 0
                        //[Card]        => 0
                        //[PIN2]        => 239250
                        //[TZ1]         => 0
                        //[TZ2]         => 0
                        //[TZ3]         => 0
                        $persona          = isset($detalle['PIN']) ? $detalle['PIN']:'';
                        $usuario          = isset($infouser['Name']) ? $infouser['Name']: '';
                        $personaaux       = isset($infouser['PIN2']) ? $infouser['PIN2'] : '';
                        $marcacion        = isset($detalle['DateTime']) ? $detalle['DateTime'] : '';
                        $verificado       = isset($detalle['Verified']) ? $detalle['Verified'] : '';
                        $xListaMarcacion .= $persona.'|'.$usuario.'|'.$personaaux.'|'.$marcacion.'|'.$verificado.'#';
                    }
                }
                $xFlag              = '00';
                $xAnio              = date('Y');
                $xResumenMarcacion  = date('YmdHis').'|'.$marcador['acti_codigo'];
                $xUsuarioCrea       = 'ULADECHAUTO';
                $xOnline            = '1';
                $xTotalRegistrosMarcador = $marcacionesFilter->count();
                $xTotal = $xTotal + $xTotalRegistrosMarcador;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
            }else{
                $xFlag              = '00';
                $xAnio              = date('Y');
                $xResumenMarcacion  = date('YmdHis').'|'.$marcador['acti_codigo'];
                $xUsuarioCrea       = 'ULADECHAUTO';
                $xOnline            = '1';
                $xTotalRegistrosMarcador = 0;
//                $result = $marcacionDAO->Asis_MarcadorMantenimiento($xFlag,$xAnio,$xListaMarcacion,$marcador['ip'],$marcador['mac'],$marcador['acti_codigo'],$xTotalRegistrosMarcador,$xResumenMarcacion,$xOnline,$xUsuarioCrea);
            }
            print_r($xListaMarcacion);
        }
    }
    ## termina de insertar marcaciones :
    ## inicio de sincronizacion en las tarjetas
//    sleep(30);
//    if($xTotal > 0){
//        $fechasincroniza = "2019-08-12";
////        $fechasincroniza = date("Y-m-d");
//        $result = $marcacionDAO->Asis_MarcadorSincronizacion(
//            '00',
//            $fechasincroniza,
//            $fechasincroniza,
//            '',
//            0,
//            '',
//            0,
//            'ASISTENCIAAUTO');
//    }
}
