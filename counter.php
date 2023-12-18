<?php
session_start();
require_once("db.php");

// Get the visitor's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Check if a cookie is set for this visitor
if (!isset($_COOKIE['visitor_id'])) {
    // Generate a unique identifier for the visitor
    $visitor_id = uniqid('visitor_', true);

    // Set a cookie to identify the visitor
    setcookie('visitor_id', $visitor_id, time() + (365 * 24 * 60 * 60)); // Cookie lasts for a year

    // Insert the new visitor into the database
    $stmt = $conn->prepare("INSERT INTO visitors (ip_address, visitor_id, visit_date) VALUES (?, ?, NOW())");

    if (!$stmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    $stmt->bind_param("ss", $ip_address, $visitor_id);
    $stmt->execute();

    if ($stmt->error) {
        die('Error executing SQL query: ' . $stmt->error);
    }
}

// Get the visitor counts
$today = date("Y-m-d");
$dailyVisitorCount = $conn->query("SELECT COUNT(DISTINCT visitor_id) FROM visitors WHERE visit_date = '$today'")->fetch_row()[0];
$totalVisitorCount = $conn->query("SELECT COUNT(DISTINCT visitor_id) FROM visitors")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visitor Counter</title>
</head>

<body>

    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Visitor Counter</h1>
        <div class="container-xxl py-5">
            <div class="row wow fadeInUp" data-wow-delay="0.5s">

                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box colored">
                        <i class="fa fa-user text-white mb-4"></i>
                        <span class="counter" id="dailyVisitorCounter"><?php echo $dailyVisitorCount; ?></span>
                        <p>Daily Visitor</p>
                    </div>
                </div>
                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box">
                        <i class="fa fa-users text-primary mb-4"></i>
                        <span class="counter" id="totalVisitorCounter"><?php echo $totalVisitorCount; ?></span>
                        <p>Total Visitor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // You can include additional JavaScript or use a library for more advanced functionality.
    </script>

</body>

</html>
