<?php include "api/kedisystem.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeyfendilerSecim</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;400;700&display=swap');

        body {
            background-color: #1D2145;
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        h1,h2 {
            margin: 0 !important;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        p {
            text-align: center;
            margin-top: 30px;
            font-size: 18px;
        }

        ul {
            padding: 0;
            margin-top: 30px;
        }

        li {
            margin: 0;
        }

        a {
            color: #ff0000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #ff6666;
        }

        .content {
            background-color: #0000009e;
            padding: 10px;
            width: 100vw;
            height: 100vh;
            backdrop-filter: blur(5px);
        }

        .big {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 10vw;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body style="background-image: url(https://cdn.discordapp.com/attachments/1116682807373209721/1126901385888280687/Adsz1.png); background-position: center; background-size: cover; background-repeat: no-repeat; min-height: 100vh;">
    <div class="content">
        <h1>Beyfendiler Seçim 2023-2023</h1>
        <h2 class="big">Ajanslar:</h2>
        <ul>
            <ul><a href="/ajans.php?ajans=ltv">LTV Ajansı</a></ul>
            <ul><a href="/ajans.php?ajans=beyf">Beyfendiler Ajansı</a></ul>
        </ul>
    </div>
</body>

</html>