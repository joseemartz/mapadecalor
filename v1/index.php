<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');

include_once '../include/Config.php';
require_once '../include/DbConnect.php'; 

require '../libs/Slim/Slim.php'; 
\Slim\Slim::registerAutoloader(); 
$app = new \Slim\Slim();

$app->get('/contagiados', 'authenticate', function() {
    
    $response = array();
    $contagios = array();

    $query = "SELECT * FROM coordenadas";
    try{
        $db = new DbConnect();
        $conn = $db->connect();
        $result = $conn->query($query);
        if($result->rowCount() > 0){
            $contagiados = $result->fetchAll(PDO::FETCH_OBJ);
            //echo json_encode(count($contagiados))   ;
            foreach ($contagiados as $contagiado) {
                array_push($contagios, array('type'=>'Contagiado', 'id'=>$contagiado->id, 'geometry'=>array('type'=>'Point','coordinates'=>[$contagiado->lon, $contagiado->lat]))); 
            }
        }
        else{
            echo json_encode("vacio");
        }
    }
    catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}}';
    }

    //array_push($contagios, array('type'=>'Contagiado', 'id'=>'22121', 'geometry'=>array('type'=>'Point','coordinates'=>[-76.995080, -12.051469])));                  
    
    $response["conteo"] = "Numero de Contagios: " . count($contagios); 
    $response["features"] = $contagios;
	

    echoResponse(200, $response);
});

$app->run();

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

function authenticate(\Slim\Route $route) {
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    if (isset($headers['Authorization'])) {
        $token = $headers['Authorization'];
        if (!($token == API_KEY)) { 
            
            $response["error"] = true;
            $response["message"] = "Acceso denegado. Token inválido";
            echoResponse(401, $response);
            
            $app->stop();     
        } 
    } else {
        $response["error"] = true;
        $response["message"] = "Falta token de autorización";
        echoResponse(400, $response);
        $app->stop();
    }
}
?>