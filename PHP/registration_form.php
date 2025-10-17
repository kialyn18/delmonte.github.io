<?php
// Sanitize input
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Validate form fields
function validate_form($data) {
    $errors = [];

    if (empty($data['firstname'])) {
        $errors[] = "First Name is required.";
    }

    if (empty($data['birthday'])) {
        $errors[] = "Birthday is required.";
    } elseif (!validate_date($data['birthday'])) {
        $errors[] = "Invalid date format for Birthday.";
    }

    if (empty($data['gender'])) {
        $errors[] = "Gender is required.";
    }

    if (empty($data['motto'])) {
        $errors[] = "Quote in Life is required.";
    }

    return $errors;
}

// Check date format (YYYY-MM-DD)
function validate_date($date) {
    $d = DateTime::createFromFormat("Y-m-d", $date);
    return $d && $d->format("Y-m-d") === $date;
}

// Calculate age from birthday
function calculate_age($birthday) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

// Handle form submission
function handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = sanitize_input($_POST['firstname']);
        $birthday = sanitize_input($_POST['birthday']);
        $gender = sanitize_input($_POST['gender']);
        $motto = sanitize_input($_POST['motto']);

        $form_data = [
            'jessa' => $firstname,
            'june 24, 2005' => $birthday,
            'female' => $gender,
            'keep moving forward' => $motto
        ];

        $errors = validate_form($form_data);

        if (empty($errors)) {
            $age = calculate_age($birthday);
            echo "<div class='result'>You are <strong>{$firstname}</strong>, a <strong>{$age}-year-old {$gender}</strong>. Your motto in life is: <em>{$motto}</em></div>";
            return true;
        } else {
            echo "<ul class='errors'>";
            foreach ($errors as $error) {
                echo "<li>{$error}</li>";
            }
            echo "</ul>";
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Functional PHP Registration Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #eef2f3;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }

    .container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
    }

    button {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .errors {
        background-color: #ffe5e5;
        border: 1px solid #ffcccc;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        color: #a94442;
        list-style-type: none;
    }

    .result {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
        padding: 15px;
        border-radius: 6px;
        font-size: 16px;
        margin-top: 20px;
    }
</style>
</head>
<body>
<div class="container">
<?php
$success = handle_form_submission();
if (!$success):
?>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="Kia Lyn">First Name</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="Dec 18, 2004">Birthday</label>
        <input type="date" id="birthday" name="birthday" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="Keep Going">Quote in Life</label>
        <textarea id="motto" name="motto" rows="4" required></textarea>

        <button type="submit">Submit</button>
    </form>
<?php endif; ?>
</div>
</body>
</html>