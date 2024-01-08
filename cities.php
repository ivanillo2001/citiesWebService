<?php
header("Content-Type: application/json");
require_once "./City.php";
switch ($_SERVER['REQUEST_METHOD']){
    case 'GET':
        City::getCities();
        break;

    case 'POST'://para crear ciudades
        $_POST= json_decode(file_get_contents('php://input'),true);
    $city = new City($_POST['name'], $_POST['population'], $_POST['country']);
    $city->create();
    $city['message'] = "The city has been saved " . $_POST['name'];
    echo json_encode($city);
    break;


    case 'PUT':
        $input= json_decode(file_get_contents('php://input'),true);
        $city = new City($input['name'],$input['population'],$input['country']);
        $city->updateCity($input['id'],$input['name'],$input['population'],$input['country']);
        $result['message'] = "The city has been updated";
        echo json_encode($result);
        break;


    case 'DELETE'://borrar ciudades
        $input = json_decode(file_get_contents("php://input"), true); //para pasar los datos
        $cityName = $input['name'];
        City::deleteCity($cityName);
        echo json_encode(['message' => 'City deleted successfully']);
        break;
}