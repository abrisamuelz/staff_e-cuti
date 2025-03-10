<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out</title>
    <script>
        setTimeout(() => {
            window.close();
        }, 500);
    </script>
    <style>
        body {
            background-color: #f7fafc;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .message-box {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message-box h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .message-box p {
            color: #4a5568;
            font-size: 1.125rem;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>You Have Been Logged Out</h1>
        <p>Your session has ended for security reasons. Please log in again when you are ready.</p>
    </div>
</body>
</html>
