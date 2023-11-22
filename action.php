<?php
    require_once 'config.php';

    if (isset($_POST['query'])) {
        $inputText = $_POST['query'];
        
        // Validate and sanitize input (example, you may need more depending on your requirements)
        $inputText = filter_var($inputText, FILTER_SANITIZE_STRING);

        $sql = "SELECT country_name FROM place_info WHERE country_name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['country' => '%' . $inputText . '%' ]);
        $result = $stmt->fetchAll();

        if ($result) {
            foreach($result as $row) {
                // Escape output to prevent XSS
                echo '<a class="list-group-item list-group-item-action border-1">' . htmlspecialchars($row['country_name']) . '</a>';
            }
        } else {
            echo '<p class="list-group-item border-1">No record.</p>';
        }
    }
?>
