<?php
include 'db_connection.php';

if ($connection) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $message = $_POST['message'];
        $show_modal = false;

        try {
            $statement = $connection->prepare("INSERT INTO user_messages (name, mobile, email, address, message) VALUES (?, ?, ?, ?, ?)");

            $statement->bindParam(1, $name);
            $statement->bindParam(2, $mobile);
            $statement->bindParam(3, $email);
            $statement->bindParam(4, $address);
            $statement->bindParam(5, $message);

            if ($statement->execute()) {
                echo "<script type='text/javascript'>
                alert('Your message has been submitted successfully');
                window.location.href = 'index.php';
                </script>";
            } else {
                echo "<script type='text/javascript'>
                alert('Failed to submit message. Please try again.');
                window.location.href = 'index.php#contactForm';
                </script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Failed to establish connection to the database.";
}
?>
