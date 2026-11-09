<?php

// Shared settings and helpers used by index.php and success.php

// Use Philippine time so "today" is correct when checking the date of birth
date_default_timezone_set("Asia/Manila");

// Sessions are used to send validation errors back to the form
session_start();

// Gender options shown in the form and accepted by the server
const GENDER_OPTIONS = ["Male", "Female", "Prefer not to say"];

// Escape a value before printing it in HTML (prevents HTML/script injection)
function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
