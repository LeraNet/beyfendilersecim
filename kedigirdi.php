<?php
$before = $_GET["before"] ?? "/";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedi kaçtı amkkkk :DDDDD</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;400;700&display=swap');

        body {
            background-color: #1D2145;
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
    </style>
</head>

<body>
    <?php
    $ananınamı = random_int(0, 10);
    if ($ananınamı == 5) {
        echo "<p>ananın amına kedi kaçtı :DDDDD</p>";
    } else {
        echo "<p>trafoya kedi kaçtı amkk :DDDDD</p>";
    }
    ?>
    <img style="width: 100%;" src="https://cdn.discordapp.com/attachments/1116682807373209721/1126943450001047702/Adsz.jpg" alt="" srcset="">
    <script>
        function updateKedi() {
            fetch('api/kediApi.php?' + Math.random(0, 999))
                .then(response => response.json())
                .then(data => {
                    if (data != 100) {
                        window.location.href = "<?= $before ?>";
                    }
                });
        }
        setInterval(updateKedi, 1000);
    </script>
</body>

</html>