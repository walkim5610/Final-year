<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
require_once '../sql.php';

   
    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $_POST["uname"];
    $password = $_POST["pass"];

    $query = "SELECT * FROM farmer WHERE fusername = ? AND fpassword = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["username"] = $username;
        header("Location: Farmer/fdashboard.php");
        exit();
        
    } else {
        $query = "SELECT * FROM customer WHERE cusername = ? AND cpassword = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            
            $_SESSION["username"] = $username;
            header("Location: Customer/cdashboard.php");
            exit();
        } else {
          
            echo "Invalid username or password.";
    
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }

    
    $stmt->close();
    $conn->close();
}
?>
