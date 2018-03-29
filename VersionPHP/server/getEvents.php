<?php
	
require('./conector.php');
/*enviar los parámertos de conexión mysqli*/
$con = new ConectorBD();
/*Conectarse a la base de datos agenda_db*/
$response['msg'] = $con->initConexion($con->database);

if ($response['msg']=='OK') {
  $resultado = $con->consultar(['eventos'],['*'], "WHERE fk_usuarios ='".$_SESSION['email']."'",'');
  
  $i = 0;

  
  while($fila = $resultado->fetch_assoc()){
    $response['eventos'][$i]['id']=$fila['id'];
    $response['eventos'][$i]['title']=$fila['titulo'];
    if ($fila['allday'] == 0){ /*Verificar si el registro es fullday*/
      $allDay = false;
       
      $response['eventos'][$i]['start']=$fila['fecha_inicio'].'T'.$fila['hora_inicio'];
    
      $response['eventos'][$i]['end']=$fila['fecha_fin'].'T'.$fila['hora_fin'];
    }else{
      $allDay= true;
       /*Si no es full day, no agregar la hora en el parametro start*/
      $response['eventos'][$i]['start']=$fila['fecha_inicio'];
       /*Si no es full day, el parametro end debe ser vacio*/
      $response['eventos'][$i]['end']="";
    }


    $response['eventos'][$i]['allDay']=$allDay;
   
    $i++;
  }
  
 $response['getData'] = "OK";
}
/*devolver el arreglo response en formato json*/
echo json_encode($response);


 ?>
