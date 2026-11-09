<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information Form</title>
</head>
<body>

    <h2>Personal Information</h2>

    <form action="success.php" method="POST">

        <label for="first_name">First Name:</label>
        <input
            type="text"
            id="first_name"
            name="first_name"
            required
        >
        <br><br>

        <label for="last_name">Last Name:</label>
        <input
            type="text"
            id="last_name"
            name="last_name"
            required
        >
        <br><br>

        <label for="dob">Date of Birth:</label>
        <input
            type="date"
            id="dob"
            name="dob"
            required
        >
        <br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Prefer not to say">Prefer not to say</option>
        </select>
        <br><br>

        <button type="submit">Submit</button>

    </form>

</body>
</html>