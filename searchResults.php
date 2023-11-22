<?php
// Assume that your API endpoint is http://localhost/pro1/api.php
$apiEndpoint = 'http://localhost/pro1/api.php';

// Call the API
$apiResponse = callApi($apiEndpoint);

// Decode the API response
$apiData = json_decode($apiResponse, true);

if ($apiData && isset($apiData['data'])) {
    foreach ($apiData['data'] as $data) {
        // Display the results from the API
        echo '<div class="result-container">';
        echo "<h5>API Country ID: {$data['id']}</h5>";
        echo "<h5>API Country Name: {$data['country']}</h5>";
        echo "<h5>API Country description: {$data['description']}</h5>";
        echo "<h5>API Country latitude: {$data['latitude']}</h5>";
        echo "<h5>API Country longitude: {$data['longitude']}</h5>";
        echo "------------------------<br>";
        echo '</div>';
    }
} else {
    echo 'No data from API';
}

// Function to call the API using cURL
function callApi($url, $data = [])
{
    $ch = curl_init($url);

    if ($ch === false) {
        return false;
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute the cURL request
    $response = curl_exec($ch);

    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
        return false;
    }

    curl_close($ch);

    return $response;
}
?>
