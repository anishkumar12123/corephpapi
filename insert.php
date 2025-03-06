<?php

header('content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,content-Type,Access-Control-Allow-Methods,Athorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);
$firstName = $data['firstName'];
$lastName = $data['lastName'];
$phone = $data['phone'];
$email = $data['email'];

include('db.php');

$sql = "INSERT INTO users(firstName,lastName,phone,email) VALUES('$firstName','$lastName','$phone','$email')";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('message' => 'Student Record Inserted.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Student Record Not Inserted', 'status' => false));
}