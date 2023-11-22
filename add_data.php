<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    $country_name = $_POST['country_name'];
    $description = $_POST['description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "webservice";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO place_info (id, country_name, description, latitude, longitude) VALUES (:id, :country_name, :description, :latitude, :longitude)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':country_name', $country_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->execute();

        // After inserting into the local database, make a cURL request
        $remoteServerURL = 'https://example.com/api'; // Change this to the actual remote server URL
        $curlData = array(
            'id' => $id,
            'country_name' => $country_name,
            'description' => $description,
            'latitude' => $latitude,
            'longitude' => $longitude
        );

        $ch = curl_init($remoteServerURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlData));

        // Execute cURL and get the response
        $remoteResponse = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        response(201, "Data Inserted. Remote Response: $remoteResponse", null);

    } catch (PDOException $e) {
        response(500, "Internal Server Error", $e->getMessage());
    }

    $conn = null;
} else {
    response(400, "Bad Request", null);
}

function response($status, $status_message, $data) {
    header("HTTP/1.1 $status");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    $json_response = json_encode($response);
    echo $json_response;
}
?>
