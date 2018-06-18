<?php
include 'Functions.php';

$address = trim(mb_strtolower($_SERVER['REQUEST_URI']), '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    if (LinkExists($address)) {
        $redirect = GetOriginalLink($address);
        header('Location: ' . $redirect);
    }
} else
if ($method == "POST" && $address = 'update') {
    $jsonData = json_decode(file_get_contents('php://input'));
    $minutes = ($jsonData->Minutes);
    $deleted = ClearOld($minutes);
    echo json_encode(array("Deleted:" => $deleted));
}
