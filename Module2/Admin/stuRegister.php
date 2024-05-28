<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        .registration-form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .registration-form h2 {
            margin-bottom: 20px;
        }
        .registration-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .registration-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .registration-form button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        .registration-form button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php include '../../Layout/admin_layout.php'; ?>
    <div class="content">
        <div class="registration-form">
            <h2>Student Registration</h2>
            <form action="register_student.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
