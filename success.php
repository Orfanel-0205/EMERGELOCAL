<?php

require "config.php";

// This page should only be opened by submitting the form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Get a submitted value as a trimmed string ("" if missing or not text)
function input($name)
{
    $value = $_POST[$name] ?? "";

    return is_string($value) ? trim($value) : "";
}

$data = [
    "first_name" => input("first_name"),
    "last_name"  => input("last_name"),
    "dob"        => input("dob"),
    "gender"     => input("gender"),
];

$errors = [];

// ---------- Validation ----------

// Names: must start with a letter, then letters, spaces, periods, apostrophes, or hyphens
// (\p{L} also accepts letters like ñ and é)
$namePattern = "/^\p{L}[\p{L} .'-]*$/u";
$nameFields  = ["first_name" => "First name", "last_name" => "Last name"];

foreach ($nameFields as $field => $label) {
    if ($data[$field] === "") {
        $errors[$field] = "$label is required.";
    } elseif (mb_strlen($data[$field]) > 50) {
        $errors[$field] = "$label must not exceed 50 characters.";
    } elseif (!preg_match($namePattern, $data[$field])) {
        $errors[$field] = "$label may only contain letters, spaces, periods, apostrophes, and hyphens.";
    }
}

// Date of birth: must be a real date (YYYY-MM-DD), not before 1900, and not in the future
$dob = DateTime::createFromFormat("!Y-m-d", $data["dob"]);

if ($data["dob"] === "") {
    $errors["dob"] = "Date of birth is required.";
} elseif (!$dob || $dob->format("Y-m-d") !== $data["dob"]) {
    $errors["dob"] = "Please enter a valid date.";
} elseif ($dob < new DateTime("1900-01-01")) {
    $errors["dob"] = "Date of birth must be on or after January 1, 1900.";
} elseif ($dob > new DateTime("today")) {
    $errors["dob"] = "Date of birth cannot be in the future.";
}

// Gender: must be one of the options in the form
if (!in_array($data["gender"], GENDER_OPTIONS, true)) {
    $errors["gender"] = "Please select your gender.";
}

// If something is wrong, go back to the form and show the errors
// (Post/Redirect/Get pattern, so refreshing the form won't resubmit it)
if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    $_SESSION["old"]    = $data;

    header("Location: index.php");
    exit;
}

// ---------- Success ----------

$age = $dob->diff(new DateTime("today"))->y;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="card text-center">

        <div class="success-icon" aria-hidden="true">&#10003;</div>

        <h1>Submission Successful</h1>
        <p class="subtitle">
            Thank you, <?= e($data["first_name"]) ?>. Your information has been received.
        </p>

        <dl class="details">
            <div>
                <dt>First Name</dt>
                <dd><?= e($data["first_name"]) ?></dd>
            </div>
            <div>
                <dt>Last Name</dt>
                <dd><?= e($data["last_name"]) ?></dd>
            </div>
            <div>
                <dt>Date of Birth</dt>
                <dd><?= e($dob->format("F j, Y")) ?> (<?= $age ?> years old)</dd>
            </div>
            <div>
                <dt>Gender</dt>
                <dd><?= e($data["gender"]) ?></dd>
            </div>
        </dl>

        <a href="index.php" class="btn btn-secondary">Submit Another Response</a>

    </main>

</body>
</html>
