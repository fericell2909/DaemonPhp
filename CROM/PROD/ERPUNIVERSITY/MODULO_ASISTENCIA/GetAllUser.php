<?php
define('GL_DIR_FS_APP','/var/www/CROM/PROD');
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

//print_r($data);exit;

//$data = $marcacionDAO->Asis_MarcadorConsultar('01','');
//$user = $marcacionDAO->Asis_MarcadorConsultar('02','');
//$data = $marcacionDAO->Asis_MarcadorConsultar('03','');
$marcadores = $marcacionDAO->Asis_MarcadorConsultar('04','');
//
/*
 * 192.168.100.159          rectorado
 * 192.168.100.160          rectorado  nuevo
 * 192.168.220.6            convenciones
 * 209.45.64.186:8083       trujillo aguamarina
 * 209.45.64.186:8092       trujillo veraenrriquez
 *  192.168.60.60           LEONCIO PRADO
 *  192.168.60.61           LEONCIO PRADO APAGADO
 * 192.168.90.19            JR. TACNA
 *  192.168.80.36           PARDO
 * 192.168.180.4            CAMPUS - UNIVERSITARIO
 * 192.168.180.5            CLINICA ODONTOLOGICA
 * 192.168.140.11           VIRGEN DE LA PUERTA
 * 192.168.28.71           INSTITUCION EDUCATIVA ULADECH
 * 192.168.120.10          SEDE CENTRAL	NUEVO CHIMBOTE
 * */

//Array
//(
//    [PIN] => 522
//            [Name] => ereveloa
//[Password] => Array
//(
//)
//
//[Group] => 1
//            [Privilege] => 1
//            [Card] => 0
//            [PIN2] => 280642
//            [TZ1] => 0
//            [TZ2] => 0
//            [TZ3] => 0
//        )
$persona        = '';
$codigo_activo  = '';
$mac            = '';
$finger         = '';
$xLista         = '';
$nroregistros   = 0;
$usuariosistema = 'ULADECHAUTO';
if(count($marcadores) > 0){
    foreach ($marcadores as $i=>$marcador) {
//        print_r($marcador);
        $codigo_activo  = $marcador['acti_codigo'];
        $mac            = $marcador['mac'];
        $options = array(
                            'ip'        => $marcador['ip'],
                            'udp_port'  => $marcador['puerto_udp'],
                            'soap_port' => $marcador['puerto_tcp'],
                            'encoding'  => 'utf-8'
                        );
        $tad_factory = new \TADPHP\TADFactory($options);
        $tad = $tad_factory->get_instance();

        $usuarios = $tad->execute_command_via_tad_soap('get_all_user_info', array(''));
        if(!$usuarios->is_empty_response()){
            $arrayusuarios = $usuarios->to_array()['Row'];
            $xLista .= $codigo_activo.'*'.$mac.'*'.$usuariosistema.'?';
            foreach ($arrayusuarios as $indice=>$usuario){
                $persona = $usuario['PIN2'];
                $infotemplate = $tad->execute_command_via_tad_soap('get_user_template',array('pin'=>$persona));
                if (!$infotemplate->is_empty_response()) {
                    $infotemplate = $infotemplate->to_array()['Row'];
                    $finger = $infotemplate['FingerID'];
//                    print_r($infotemplate);
                }else{
                    $finger = 'X';
                }
                $xLista .= $finger.'|'.$persona.'-';
            }
            $nroregistros = $usuarios->count();
            $result = $marcacionDAO->Asis_UsuarioMantenimiento('01',$xLista, $nroregistros);
            print_r('  en : '.$marcador['ip']. PHP_EOL);
            var_dump($result);

        }else{
            print_r('No hay respuesta'.'  en : '.$marcador['ip']. PHP_EOL);
        }

    }
}
//    $xTotal = 0;
////    foreach ($data as $indice=>$marcador) {
//$options = array(
//    'ip'        => '192.168.60.61',
//    'udp_port'  => '4370',
//    'soap_port' => '80',
//    'encoding'  => 'utf-8'
//);
//$tad_factory = new \TADPHP\TADFactory($options);
//$tad = $tad_factory->get_instance();
//
//        $user = $tad->execute_command_via_tad_soap('get_all_user_info', array(''));
//        if(!$user->is_empty_response()){
//            print_r($user->count());
//        }else{
//            print_r('No hay respuesta');
//        }

//        print_r($user->to_array()['Row']);




//        $r = $tad->execute_command_via_tad_soap('delete_data', ['value'=> '1']);
//        print_r($r->to_array()['Row']);


//
//if('1' == '0') {  ## trabajadmos con sockets upd
//    if ($tad->is_alive()) {
////                print_r($tad->is_alive());exit;
//        $mac = $tad->get_mac_address()->to_array()['Row'];
////                print_r($mac);exit;
////                if ($mac['Information'] == $marcador['mac']) {
//        if (true) {
//            ## Eliminar Usuario
////                    $r = $tad->execute_command_via_tad_soap('delete_data', ['value'=> '1']);
//            $contador = 0;
//            foreach ($user as $id=>$persona){
//                $contador++;
//                $r = $tad->execute_command_via_tad_soap('set_user_info',
//                    [
////                                                                'name'=> 'svergaraa',
//                        'name'=> $persona['usuario'],
////                                                                'pin'=> '002064',
////                                                                'pin'=> '239250',
//                        'pin'=> $persona['persona'],
//                        'privilege'=> 1,
////                                                            'password' => 5021983
//                    ]);
//
//                print_r($r->to_array()['Row']);
//            }
////                    print_r($r->to_array()['Row']);
//        }
//    }
//}else{
////            $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
////            if (!$marcacionesFilter->is_empty_response()) {
//    if (true) {
//        ## Eliminar Usuario
////                $r = $tad->execute_command_via_tad_soap('delete_data', ['value'=> '1']);
//        $contador = 0;
//        foreach ($user as $id=>$persona){
//            ++$contador;
//            $r = $tad->execute_command_via_tad_soap('set_user_info',
//                [
////                                                                'name'=> 'svergaraa',
//                    'name'=> $persona['usuario'],
////                                                                'pin'=> '002064',
////                                                                'pin'=> '239250',
//                    'pin'=> $persona['persona'],
//                    'privilege'=> 1,
////                                                            'password' => 5021983
//                ]);
//            $r = $r->to_array()['Row'];
//            print_r($r['Information'] .' USER----  '.$persona['usuario'].'  -- '.$contador);
//
//            $template = [
//                'pin' => $persona['persona'],
//                'finger_id' => $persona['finger'],
//                'size' => $persona['size'],
//                'valid' => $persona['validado'],
//                'template' => $persona['template']
//            ];
//
//            $respuesta = $tad->execute_command_via_tad_soap('set_user_template',$template);
//            $respuesta = $respuesta->to_array()['Row'];
//            print_r($respuesta['Information'] .' HUELLA----  '.$persona['usuario'].'  -- '.$contador );
//
//
//        }
////                print_r($r->to_array()['Row']);
//    }
//
////        }
//
////        print_r($r .'     ' . $marcador['ip']);
//}
//
//




//}
//
////print_r($data);exit;
//$options = array(
////        'ip'        => '192.168.220.6',
//    'ip'        => '192.168.220.60',
////        'soap_port' => '80',
//    'encoding'  => 'utf-8'
//);
//$tad_factory = new \TADPHP\TADFactory($options);
//$tad = $tad_factory->get_instance();
//
//## Enviar Usuario
//////    $data = $marcacionDAO->usuarioConsultar('04','32961935');
//////    foreach ($data as $id=>$persona){
//        $r = $tad->execute_command_via_tad_soap('set_user_info',
//                                                            [
//                                                                'name'=> 'svergaraa',
////                                                                'name'=> $persona['usuario'],
////                                                                'pin'=> '002064',
//                                                                'pin'=> '239250',
////                                                                'pin'=> $persona['persona'],
//                                                                'privilege'=> 14,
//                                                            'password' => '5021983'
//                                                            ]);
//
//        print_r($r->to_array()['Row']);
////    }
//
//$infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin'=>'239250'));
//$infouser = $tad->execute_command_via_tad_soap('get_user_template',array());
//print_r($infouser->to_array()['Row']);
//
//## Eliminar Usuario
////   // $data = $marcacionDAO->usuarioConsultar('04','32961935');
////
//        $r = $tad->execute_command_via_tad_soap('delete_data', ['value'=> '1']);
//        print_r($r->to_array()['Row']);
//
//
//
//
////## Enviar Huella
////$data = $marcacionDAO->usuarioConsultar('05','32961935');
///
/*$contador = 0;
foreach ($data as $id=>$persona){
    ++$contador;
    $template = [
        'pin' => $persona['persona'],
        'finger_id' => $persona['finger'],
        'size' => $persona['size'],
        'valid' => $persona['validado'],
        'template' => $persona['template']
    ];

    $respuesta = $tad->execute_command_via_tad_soap('set_user_template',$template);
    $respuesta = $respuesta->to_array()['Row'];
    print_r($respuesta['Information'] .' ----  '.$contador );
}*/
//
//
//








//    $infouser = $tad->execute_command_via_tad_soap('get_user_info',array('pin' => '989898'));
////    $infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => '151214'));
//    $infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => '000057'));
//    $infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => '989898'));
////    $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
//    $respuesta = $tad->execute_command_via_tad_soap('set_user_template',$template);
//    print_r($infouser->to_array()['Row']);
//    print_r($respuesta);
////    $infouser = $tad->execute_command_via_tad_soap('set_user_info',array('pin' => '000057'));








