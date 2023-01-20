<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/klinik.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$obat = new klinik($conn);

$data = json_decode(file_get_contents("php://input"));

$response = [];

if ($request == 'POST') {
    if (
        !empty($data->id) &&
        !empty($data->nama_obat) &&
        !empty($data->kegunaan)&&
        !empty($data->harga_obat)
    ) {
        $obat->id = $data->id;
        $obat->nama_obat = $data->nama_obat;
        $obat->kegunaan = $data->kegunaan;
        $obat->harga_obat = $data->harga_obat;

        $data = array(
            'id' => $obat->id,
            'nama_obat' => $obat->nama_obat,
            'kegunaan' => $obat->kegunaan,
            'harga_obat' => $obat->harga_obat,
        );

        if ($obat->add()) {
            $response = array(
                'status' =>  array(
                    'messsage' => 'Success', 'code' => (http_response_code(200))
                ), 'data' => $data
            );
        } else {
            http_response_code(400);
            $response = array(
                'messsage' => 'Add Failed',
                'code' => http_response_code()
            );
        }
    } else {
        http_response_code(400);
        $response = array(
            'status' =>  array(
                'messsage' => 'Add Failed - Wrong Parameter', 'code' => http_response_code()
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