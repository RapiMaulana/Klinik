<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/klinik.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$obat = new klinik($conn);
$obat->id = isset($_GET['id']) ? $_GET['id'] : die();

$obat->get();

$response = [];

if ($request == 'GET') {
    if ($obat->id != null) {
        $data = array(
            'id' => $obat->id,
            'nama_obat' => $obat->nama_obat,
            'kegunaan' => $obat->kegunaan,
            'harga_obat' => $obat->harga_obat,
        );
        $response = array(
            'status' =>  array(
                'messsage' => 'Success', 'code' => (http_response_code(200))
            ), 'data' => $data
        );
    } else {
        http_response_code(404);
        $response = array(
            'status' =>  array(
                'messsage' => 'No Data Found', 'code' => http_response_code()
            )
        );
    }
} else {
    http_response_code(405);
    $response = array(
        'status' =>  array(
            'messsage' => 'Method Not Allowed', 'code' => http_response_code()
        )
    );
}

echo json_encode($response);