<?php
require_once 'config.php';

if (isset($_POST['query'])) {
    $inputText = $_POST['query'];

    // Validate and sanitize input
    $inputText = filter_var($inputText, FILTER_SANITIZE_STRING);

    // Check if the search term is empty or too short
    if (empty($inputText) || strlen($inputText) < 1) {
        echo 'Please enter a valid search term.';
    } else {
        // Set the SQL query to select country names starting with the input letter
        $sql = "SELECT country_name FROM place_info WHERE country_name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['country' => $inputText . '%']);
        $result = $stmt->fetchAll();

        if ($result) {
            foreach ($result as $row) {
                // Escape output to prevent XSS
                echo '<a class="list-group-item list-group-item-action border-1">' . htmlspecialchars($row['country_name']) . '</a>';
            }
        } else {
            echo '<p class="list-group-item border-1">No record.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .result-container {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .result-container {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<?php
// Set the API endpoint
$apiEndpoint = 'http://localhost/pro1/api.php';

// Get the search term
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Check if the search term is empty or too short
if (empty($search) || strlen($search) < 3) {
    echo 'Please enter a valid search term (at least 3 characters).';
} else {
    // Fetch data from the API
    $apiResponse = callApi($apiEndpoint);

    // Check if there's an error calling the API
    if ($apiResponse === false) {
        echo 'Error calling API';
    } else {
        // Decode the JSON response
        $apiData = json_decode($apiResponse, true);

        // Check if JSON decoding was successful
        if ($apiData === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            // Check if there is data from the API
            if (empty($apiData['data'])) {
                echo "No data from API";
            } else {
                $found = false;
                // Display results matching the search term
                foreach ($apiData['data'] as $data) {
                    if (stripos($data['country'], $search) !== false) {
                        // Display only the country name
                        echo '<div class="result-container">';
                        echo "<h5>Country id: {$data['id']}</h5>";
                        echo "<h5>Country Name: {$data['country']}</h5>";
                        echo "<h5>Country country: {$data['country']}</h5>";
                        echo "<h5>Country description: {$data['description']}</h5>";
                        echo "<h5>Country latitude: {$data['latitude']}</h5>";
                        echo "<h5>Country longitude: {$data['longitude']}</h5>";
                        echo '</div>';
                        $found = true;
                    }
                }

                if (!$found) {
                    echo 'No matching data found.';
                }

                echo '<div> <a href="index.php" class="btn">Back to Home</a> </div>';
            }
        }
    }
}

// Function to call the API using cURL
function callApi($url)
{
    $ch = curl_init($url);

    if ($ch === false) {
        return false;
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    return $response;
}
?>

</body>
</html>