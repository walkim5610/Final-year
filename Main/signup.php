<?php
// Include config file
require_once '../sql.php';

// Define variables and initialize with empty values
$name = $username = $email = $password = $phone = $address = $category = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = trim($_POST["name"]);
    $username = trim($_POST["uname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = trim($_POST["phone"]); // Added phone number
    $address = trim($_POST["addr"]);
    $category = isset($_POST["category"]) ? $_POST["category"] : '';

    // Prepare SQL statement based on category
    if ($category === "1") { // Farmer
        $sql = "INSERT INTO farmer (fname, fusername, femail, fpassword, fphone, faddress) VALUES (?, ?, ?, ?, ?, ?)";
    } elseif ($category === "0") { // Customer
        $sql = "INSERT INTO customer (cname, cusername, cemail, cpassword, cphone, caddress) VALUES (?, ?, ?, ?, ?, ?)";
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters and execute the statement
        if ($stmt) {
            if ($category === "1") { // Farmer
                $stmt->execute([$name, $username, $email, $password, $phone, $address]);
            } elseif ($category === "0") { // Customer
                $stmt->execute([$name, $username, $email, $password, $phone, $address]);
            }

            // Display window alert on successful signup
            echo "<script>alert('Signup successful!. Kindly Login');</script>";

            // Redirect to the index page
            header("location: ../index.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    
    unset($stmt);
    unset($pdo);
}
?>
