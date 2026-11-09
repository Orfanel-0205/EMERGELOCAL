<?php

require "config.php";

// If success.php found errors, it saves them (and the user's input) in the session
$errors = $_SESSION["errors"] ?? [];
$old    = $_SESSION["old"] ?? [];

// Remove them so they only show once
unset($_SESSION["errors"], $_SESSION["old"]);

$today = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="card">

        <header class="card-header">
            <h1>Personal Information</h1>
            <p>Please fill out the form below. Fields marked with <span class="required">*</span> are required.</p>
        </header>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                Please correct the highlighted fields and try again.
            </div>
        <?php endif; ?>

        <form action="success.php" method="POST">

            <div class="form-row">

                <div class="form-group">
                    <label for="first_name">First Name <span class="required">*</span></label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="<?= e($old["first_name"] ?? "") ?>"
                        class="<?= isset($errors["first_name"]) ? "is-invalid" : "" ?>"
                        placeholder="e.g. Juan"
                        maxlength="50"
                        pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ .'\-]*"
                        title="Letters, spaces, periods, apostrophes, and hyphens only"
                        autocomplete="given-name"
                        required
                    >
                    <?php if (isset($errors["first_name"])): ?>
                        <small class="error-text"><?= e($errors["first_name"]) ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name <span class="required">*</span></label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="<?= e($old["last_name"] ?? "") ?>"
                        class="<?= isset($errors["last_name"]) ? "is-invalid" : "" ?>"
                        placeholder="e.g. Dela Cruz"
                        maxlength="50"
                        pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ .'\-]*"
                        title="Letters, spaces, periods, apostrophes, and hyphens only"
                        autocomplete="family-name"
                        required
                    >
                    <?php if (isset($errors["last_name"])): ?>
                        <small class="error-text"><?= e($errors["last_name"]) ?></small>
                    <?php endif; ?>
                </div>

            </div>

            <div class="form-group">
                <label for="dob">Date of Birth <span class="required">*</span></label>
                <input
                    type="date"
                    id="dob"
                    name="dob"
                    value="<?= e($old["dob"] ?? "") ?>"
                    class="<?= isset($errors["dob"]) ? "is-invalid" : "" ?>"
                    min="1900-01-01"
                    max="<?= $today ?>"
                    autocomplete="bday"
                    required
                >
                <?php if (isset($errors["dob"])): ?>
                    <small class="error-text"><?= e($errors["dob"]) ?></small>
                <?php endif; ?>
            </div>

            <fieldset class="form-group">
                <legend>Gender <span class="required">*</span></legend>

                <div class="radio-group <?= isset($errors["gender"]) ? "is-invalid" : "" ?>">
                    <?php foreach (GENDER_OPTIONS as $option): ?>
                        <label class="radio-option">
                            <input
                                type="radio"
                                name="gender"
                                value="<?= e($option) ?>"
                                <?= ($old["gender"] ?? "") === $option ? "checked" : "" ?>
                                required
                            >
                            <span><?= e($option) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($errors["gender"])): ?>
                    <small class="error-text"><?= e($errors["gender"]) ?></small>
                <?php endif; ?>
            </fieldset>

            <button type="submit" class="btn">Submit</button>

        </form>

    </main>

</body>
</html>
