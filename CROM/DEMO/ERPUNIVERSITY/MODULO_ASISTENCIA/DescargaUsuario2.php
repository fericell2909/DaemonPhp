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
$data = $marcacionDAO->usuarioConsultar('03','');
//print_r(count($data));exit;



if(count($data) > 0){
    $options = array(
//        'ip'        => '192.168.220.60', # TRUJILLO: AGUAMARINA  asist_usuariobencor_respaldo  Lcocal_antes
//        'ip'        => '192.168.100.159', # rectorado asist_usuariobencor_respaldo_2
//        'ip'        => '192.168.220.6', # convenciones asist_usuariobencor_respaldo_3
//        'ip'        => '209.45.65.2:8090', # ayacucho asist_usuariobencor_respaldo_4
//        'ip'        => '209.45.65.2:8091', # ayacucho asist_usuariobencor_respaldo_5
//        'ip'        => '209.45.65.162:8022', # cañete asist_usuariobencor_respaldo_6  varios datos basura
//        'ip'        => '209.45.112.196:8081', # chiclayo asist_usuariobencor_respaldo_7
//        'ip'        => '209.45.65.115:8030', # huanuco asist_usuariobencor_respaldo_8
//        'ip'        => '209.45.64.242:8023', # huaraz asist_usuariobencor_respaldo_9
//        'ip'        => '181.65.228.38:8089', # SULLANA: PIURA asist_usuariobencor_respaldo_10
//        'ip'        => '209.45.64.181:8028', # SULLANA: AYACUCHO N° 535 asist_usuariobencor_respaldo_11
//        'ip'        => '209.45.65.28:8083', #  	PUCALLPA: PETRO PERU asist_usuariobencor_respaldo_12
//        'ip'        => '209.45.112.59:8030', #  SATIPO: SATIPO asist_usuariobencor_respaldo_13
//        'ip'        => '209.45.64.186:8090', # TRUJILLO: VERA ENRIQUEZ asist_usuariobencor_respaldo_14  Falta
//        'ip'        => '209.45.64.50:8022', # TUMBES: CENTRO ACADEMICO asist_usuariobencor_respaldo_15
        'ip'        => '209.45.65.172:8084', # LIMA.: CAMPUS LIMA asist_usuariobencor_respaldo_16
//        'ip'        => '209.45.64.186:8083', # TRUJILLO: AGUAMARINA  actual asist_usuariobencor_respaldo_17
        'soap_port' => '80',
        'encoding'  => 'utf-8'
    );

//    $options = array(
//        'ip'        => '209.45.64.186:8083',
////        'soap_port' => '80',
//        'encoding'  => 'utf-8'
//    );
    $tad_factory = new \TADPHP\TADFactory($options);
    $tad = $tad_factory->get_instance();
//    $template_huella = 'TadTUzIxAAAE5OcECAUHCc7QAAAk5XMBAAAAhAksgOS1AB8LmgA4ACbpvwCbACULhAC15OQPaQB3ALYPx+QKAaUPQgDEAeLrNwCHAO8NWQAq5ZQPzgBoAOUOKeR6AGgNSwD1AfrrxAA8AZAP0AAY5ecJLgBBATAPhOThAI0ObQA2AHDotwCNAJkLYwAP5aMNjwAVAV8NUuQKAQcOdwCkAADqZwAmAX0PugBQ5H4NtABYAE4PLuQLAeIP6gDeAaTs1AA1AZUPbwAp5I0PXwAjAK8Kt+TEAKMPygAHAC3r1QC8AKUPkgD55PUO2ACWAOQOjORiAIUN8wBrAJvspABXAA8OIACF5J4OAQHNAGoEOOQfAfEP4wDiAZ7vWwA+AP8PngAu5OwPppdzfZb/hWWwiwKWBYyQB4JmU/tPf5/LIHPyFef2XQfuBz8PkRGs4g0HOYgPD4OZmP+69foHP5SGZbuLPXhLh9L3Iep0g+4J4fwf+XobfAee9sLzs/la4jcTVRsWbn9zeWbs625sEXQ3ecafgIFNCt3/EPq9nxQHPRQNImOMUWCAgNWTdYNreIprWHwt/AZyvHwKiK8Dkf/B88T/Mew/DHL/XQQI/c4QO38uA1sPqX5Zi0Lv2X7WAW+DRGPQig4GRH8PCVbh0OwFEX2C8IbdG+uJgYClCCt4VhkT8YKBdYQnjPJ2OIKGgUt8RxFn6FqKtfYxE58MuRhIBU4NRRWMl55naYbV8bty1F2Mn2VqIEABAnUnMOwBqQkQUUDBAMfoEkcKAJcMyf5mGcM6DACFD8nAOyUuTxIARBoy/zrSQsA/SgQAmCV0qgsANCnw//bBRfUBXCr6L0b9U8TQFQAtPvA+g/9EJP5VRBEAXfv6+qVOVv//wErRACyu8VU1OP//icE66AElUvFMODpDDOR6UoaJZgnFe1KZcWf/EQCDkwb6Gzn/ZMAsf84ApbKOwm7AwsGcDQRMXRD+PsI+BfvF4QG6XBr+bNMAN53xSv5AMf4E/8Uawv/9WQoArXl1rX/BwgMAK79rxeABLX9mZRHFFYQAM0zA//z/hFQA5OuEIlsLAPyG6Rs9wP7//f/UAL1znXXCwsNZBMFuJQQA2Zokc88AxXglwf7B/cOQBARZniRlGgAJb9w8Jv3/wDD//zj/+oD+XsHBCwCEsOLc/P78/zAMxYC2YsXCwmpUwsgAjFcbPlVudAnFhLz4NkX+BwDMBinEgMARALHFpLnEnyTDwf/C/oPMALMtKMD/wXjA3wANNN9W//5GPOL/Myf8/10bAAgb2kgm///9wjH978AyJMFwwQgAfhuTqpIaAArm3lgFwi4kK/39PMJFBMB08wEZ7dr//wVPMBn8/8D+U3EFBASW+BzA/w4QgADiJP75/DLAhwQHFLYBacDBwDrWEAvh48DAZED83sBfJQYQWQwA/DrASucRyQ8ewRbVDBQCwcJS/jQbn//FlAoQjReXwATFwJpFExAYGu2wwPsa/PsiZsFswBCR/h/BcAkQPdrr+hn9/1oZEArn1/glbD39/flDB/zHJHk8CRBlJkbEcHQMEE0v+v47/XSORgMQozIQOgYUkzqQk8IDEA4+FCUFEQxCVmjIEDWg9Tv/wvzBocEX9A5J2v/9ROT/dCTAwU4MELCdjFkmY4IIEIxYTG3FkgAAAAAAAA==';
//    $template = [
//        'pin' => '000057',
//        'finger_id' => 6, // La primera huella digital tiene 0 como índice.
//        'size' => 1258,    // Tenga cuidado, esto no es una longitud de cadena de $ template1_vx9 var.
//        'valid' => 1,
//        'template' => $template_huella
//    ];
//    $infouser = $tad->execute_command_via_tad_soap('get_user_info',array('pin' => '000057'));
////    $infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => '151214'));
////    $infouser = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => '000057'));
////    $marcacionesFilter = $tad->execute_command_via_tad_soap('get_att_log',array())->filter_by_date(['start' => date("Y-m-d"), 'end' => date("Y-m-d")]);
////    $respuesta = $tad->execute_command_via_tad_soap('set_user_template',$template);
//    print_r($infouser);
////    $infouser = $tad->execute_command_via_tad_soap('set_user_info',array('pin' => '000057'));



    foreach ($data as $id=>$xpin){
        $xLista = '';
        $pin = '';
        $usuario = '';
        $grupo ='';
        $privilegio = '';
        $card = '';
        $persona = '';
        $zonahoraria1 = '';
        $zonahoraria2 = '';
        $zonahoraria3 = '';
        $pin2 = '';
        $fingerid =  '';
        $size = '';
        $valid =  '';
        $template =  '';
//        print_r($xpin); exit;
        $xClave = $xpin['pin'];
        $infouser = $tad->execute_command_via_tad_soap('get_user_info',array('pin' => $xClave));
        if (!$infouser->is_empty_response()) {
//            echo $persona['pin'].' - 1';
            $infouser = $infouser->to_array()['Row'];
            //        print_r($infouser);
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
            $pin = isset($infouser['PIN']) ? $infouser['PIN'] :'';
            $usuario = isset($infouser['Name']) ? $infouser['Name'] :'';
            $grupo = isset($infouser['Group']) ? $infouser['Group'] :'';
            $privilegio = isset($infouser['Privilege']) ? $infouser['Privilege'] :'';
            $card = isset($infouser['Card']) ? $infouser['Card'] :'';
            $persona = isset($infouser['PIN2']) ? $infouser['PIN2'] :'';
            $zonahoraria1 = isset($infouser['TZ1']) ? $infouser['TZ1'] :'';
            $zonahoraria2 = isset($infouser['TZ2']) ? $infouser['TZ2']:'';
            $zonahoraria3 = isset($infouser['TZ3']) ? $infouser['TZ3'] :'';
            $xLista .= $pin . '|' . $usuario . '|' . $grupo . '|' . $privilegio . '|' . $card . '|' . $persona . '|' . $zonahoraria1 . '|' . $zonahoraria2 . '|' . $zonahoraria3 . '#';
            //        $infotemplate = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => 239250))->to_array()['Row'];
            $infotemplate = $tad->execute_command_via_tad_soap('get_user_template', array('pin' => $xClave)); #->to_array()['Row'];
//            $infotemplate = $tad->execute_command_via_tad_soap('get_user_template',array('pin' => $infouser['PIN2'])); #->to_array()['Row'];
            //        $infotemplate = $tad->get_user_template(array('pin' => $persona['persona']));
            //        $infotemplate = $tad->get_user_template(array('pin' => 224418))->to_array()['Row'];
            //        $infotemplate = $tad->get_user_template(array('pin' => 239250))->to_array()['Row'];
            //        print_r($infotemplate);
            if (!$infotemplate->is_empty_response()) {
                $infotemplate = $infotemplate->to_array()['Row'];
                $pin2 = isset($infotemplate['PIN']) ? $infotemplate['PIN'] : '';
                $fingerid = isset($infotemplate['FingerID']) ? $infotemplate['FingerID'] : '';
                $size = isset($infotemplate['Size']) ? $infotemplate['Size'] : '';
                $valid = isset($infotemplate['Valid']) ? $infotemplate['Valid'] : '';
                $template = isset($infotemplate['Template']) ? $infotemplate['Template'] : '';
                //            Array
                //            (
                //                [PIN] => 000057
                //                [FingerID] => 6
                //                [Size] => 1258
                //                [Valid] => 1
                //                [Template] => TadTUzIxAAAE5OcECAUHCc7QAAAk5XMBAAAAhAksgOS1AB8LmgA4ACbpvwCbACULhAC15OQPaQB3ALYPx+QKAaUPQgDEAeLrNwCHAO8NWQAq5ZQPzgBoAOUOKeR6AGgNSwD1AfrrxAA8AZAP0AAY5ecJLgBBATAPhOThAI0ObQA2AHDotwCNAJkLYwAP5aMNjwAVAV8NUuQKAQcOdwCkAADqZwAmAX0PugBQ5H4NtABYAE4PLuQLAeIP6gDeAaTs1AA1AZUPbwAp5I0PXwAjAK8Kt+TEAKMPygAHAC3r1QC8AKUPkgD55PUO2ACWAOQOjORiAIUN8wBrAJvspABXAA8OIACF5J4OAQHNAGoEOOQfAfEP4wDiAZ7vWwA+AP8PngAu5OwPppdzfZb/hWWwiwKWBYyQB4JmU/tPf5/LIHPyFef2XQfuBz8PkRGs4g0HOYgPD4OZmP+69foHP5SGZbuLPXhLh9L3Iep0g+4J4fwf+XobfAee9sLzs/la4jcTVRsWbn9zeWbs625sEXQ3ecafgIFNCt3/EPq9nxQHPRQNImOMUWCAgNWTdYNreIprWHwt/AZyvHwKiK8Dkf/B88T/Mew/DHL/XQQI/c4QO38uA1sPqX5Zi0Lv2X7WAW+DRGPQig4GRH8PCVbh0OwFEX2C8IbdG+uJgYClCCt4VhkT8YKBdYQnjPJ2OIKGgUt8RxFn6FqKtfYxE58MuRhIBU4NRRWMl55naYbV8bty1F2Mn2VqIEABAnUnMOwBqQkQUUDBAMfoEkcKAJcMyf5mGcM6DACFD8nAOyUuTxIARBoy/zrSQsA/SgQAmCV0qgsANCnw//bBRfUBXCr6L0b9U8TQFQAtPvA+g/9EJP5VRBEAXfv6+qVOVv//wErRACyu8VU1OP//icE66AElUvFMODpDDOR6UoaJZgnFe1KZcWf/EQCDkwb6Gzn/ZMAsf84ApbKOwm7AwsGcDQRMXRD+PsI+BfvF4QG6XBr+bNMAN53xSv5AMf4E/8Uawv/9WQoArXl1rX/BwgMAK79rxeABLX9mZRHFFYQAM0zA//z/hFQA5OuEIlsLAPyG6Rs9wP7//f/UAL1znXXCwsNZBMFuJQQA2Zokc88AxXglwf7B/cOQBARZniRlGgAJb9w8Jv3/wDD//zj/+oD+XsHBCwCEsOLc/P78/zAMxYC2YsXCwmpUwsgAjFcbPlVudAnFhLz4NkX+BwDMBinEgMARALHFpLnEnyTDwf/C/oPMALMtKMD/wXjA3wANNN9W//5GPOL/Myf8/10bAAgb2kgm///9wjH978AyJMFwwQgAfhuTqpIaAArm3lgFwi4kK/39PMJFBMB08wEZ7dr//wVPMBn8/8D+U3EFBASW+BzA/w4QgADiJP75/DLAhwQHFLYBacDBwDrWEAvh48DAZED83sBfJQYQWQwA/DrASucRyQ8ewRbVDBQCwcJS/jQbn//FlAoQjReXwATFwJpFExAYGu2wwPsa/PsiZsFswBCR/h/BcAkQPdrr+hn9/1oZEArn1/glbD39/flDB/zHJHk8CRBlJkbEcHQMEE0v+v47/XSORgMQozIQOgYUkzqQk8IDEA4+FCUFEQxCVmjIEDWg9Tv/wvzBocEX9A5J2v/9ROT/dCTAwU4MELCdjFkmY4IIEIxYTG3FkgAAAAAAAA==
                //            )
                $xLista .= $pin2 . '*' . $fingerid . '*' . $size . '*' . $valid . '*' . $template;
            }

            $result = $marcacionDAO->usuarioMantenimiento2('00',$xLista);
        }
//        echo $persona['pin'].' - 2';
    }














}
