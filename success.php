<?php

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

// Retrieve and trim submitted values
$firstName = trim($_POST["first_name"] ?? "");
$lastName  = trim($_POST["last_name"] ?? "");
$dob       = trim($_POST["dob"] ?? "");
$gender    = trim($_POST["gender"] ?? "");

// Validate required fields
if (
    $firstName === "" ||
    $lastName === "" ||
    $dob === "" ||
    $gender === ""
) {
    exit("Error: All fields are required.");
}

// Validate date format
$date = DateTime::createFromFormat('!Y-m-d', $dob);

if (!$date || $date->format('Y-m-d') !== $dob) {
    exit("Error: Invalid date of birth.");
}

// Validate that the date is not in the future
if ($date > new DateTime('today')) {
    exit("Error: Date of birth cannot be in the future.");
}

// Validate gender
$allowedGenders = ["Male", "Female", "Prefer not to say"];

if (!in_array($gender, $allowedGenders, true)) {
    exit("Error: Invalid gender selection.");
}

// Escape output to prevent HTML injection
$firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
$lastName  = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');
$dob       = htmlspecialchars($dob, ENT_QUOTES, 'UTF-8');
$gender    = htmlspecialchars($gender, ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
</head>
<body>

    <h2>Submission Successful!</h2>

    <p>Your information has been received.</p>

    <h3>Submitted Information:</h3>

    <p><strong>First Name:</strong> <?php echo $firstName; ?></p>

    <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>

    <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>

    <p><strong>Gender:</strong> <?php echo $gender; ?></p>

    <a href="index.php">Go Back</a>

</body>
</html>