<?php   //การตั้งค่าและการตรวจสอบข้อมูลนำเข้า
require_once 'config.php';

if (isset($_POST['query'])) {
    $inputText = $_POST['query'];

        // ทำการตรวจสอบและทำความสะอาดข้อมูลที่นำเข้า
    $inputText = filter_var($inputText, FILTER_SANITIZE_STRING);

   // ตรวจสอบว่าคำค้นหาว่างหรือสั้นเกินไปหรือไม่
    if (empty($inputText) || strlen($inputText) < 1) {
        echo 'Please enter a valid search term.';
    } else {
        // กำหนดคำค้น SQL เพื่อเลือกชื่อประเทศที่ขึ้นต้นด้วยตัวอักษรที่ใส่เข้ามา 
        $sql = "SELECT country_name FROM place_info WHERE country_name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['country' => $inputText . '%']);
        $result = $stmt->fetchAll();

        if ($result) {
            foreach ($result as $row) {
                // หลีกเลี่ยงการแทรกข้อมูลเพื่อป้องกัน XSS
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
// กำหนดที่ API endpoint
$apiEndpoint = 'http://localhost/pro1/api.php';

// รับคำค้นหา
$search = isset($_POST['search']) ? $_POST['search'] : '';

// ตรวจสอบว่าคำค้นหาว่างหรือสั้นเกินไปหรือไม่
if (empty($search) || strlen($search) < 3) {
    echo 'Please enter a valid search term (at least 3 characters).';
} else {
    // ดึงข้อมูลจาก API
    $apiResponse = callApi($apiEndpoint);

    // ตรวจสอบว่ามีข้อผิดพลาดในการเรียก API 
    if ($apiResponse === false) {
        echo 'Error calling API';
    } else {
        // ถอดรหัส JSON response จากไฟล์API
        $apiData = json_decode($apiResponse, true);

        // ตรวจสอบว่าการถอดรหัส JSON ประสบความสำเร็จหรือไม่
        if ($apiData === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            // ตรวจสอบว่ามีข้อมูลจาก ไฟล์ API 
            if (empty($apiData['data'])) {
                echo "No data from API";
            } else {
                $found = false;
                /// แสดงผลที่ตรงกับคำค้นหา
                foreach ($apiData['data'] as $data) {
                    if (stripos($data['country'], $search) !== false) {
                        // แสดงผล
                        echo '<div class="result-container">';
                        echo "<h5>Country id: {$data['id']}</h5>";
                        echo "<h5>Country Name: {$data['country']}</h5>";
                        echo "<h5>Country description: {$data['description']}</h5>";
                        echo "<h5>Country latitude: {$data['latitude']}</h5>";
                        echo "<h5>Country longitude: {$data['longitude']}</h5>";
                        if (isset($data['image'])) {
                            // เส้นทางไปรูปภาพ
                            $localImagePath = $data['image'];
                        
                            // แสดงภาพธงโดยใช้เส้นทางด้านบน
                            echo "<img src='{$localImagePath}' alt='Flag of {$data['country']}' style='max-width: 100%;'>";
                        }
                        
                        echo '</div>';
                        $found = true;
                    }
                }
                
                if (!$found) {
                    // ไปหน้าอื่นถ้า ไม่พบข้อมูล
                    header("Location: Error.php");
                    exit();
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