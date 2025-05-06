<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LCC Tanauan HRMS Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            color: #666666;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 0 0 8px 8px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to LCC Tanauan HRMS Portal</h1>
        </div>
        <div class="content">
            <h2>Hello, <?= $name; ?>!</h2>
            <p>We are excited to have you on board. Welcome to the LCC Tanauan HRMS Portal. Here, you can manage your personal information, view your payslips, apply for leaves, and much more.</p>
            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
            <p>Thank you for joining us!</p>
            <p>Best regards,</p>
            <p>LCC Tanauan HRMS Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 LCC Tanauan HRMS Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>