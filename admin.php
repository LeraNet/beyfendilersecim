<?php
$ajans = $_GET["ajans"] ?? null;

$password = $_GET["pw"] ?? null;

if ($ajans == null || $password == null) {
    die("şifre veya ajans yok");
}

$passwords = array(
    "ltv" => "K4A632s2xBm",
    "beyf" => "841ZkFsMgTi"
);

if ($password != $passwords[$ajans]) {
    die("sifre yanlis");
}

$jsonData = file_get_contents("data/$ajans.json");

$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data["sunucu_uyesayisi"] = intval($_POST["uyeler"]);

    foreach ($_POST['oylar'] as $candidate => $votes) {
        $data['oylar'][$candidate] = intval($votes);
    }

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    file_put_contents("data/$ajans.json", $jsonData);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> <!-- Toastr library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> <!-- Toastr styles -->
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?php echo $_SERVER['PHP_SELF']; ?>?ajans=<?php echo $ajans; ?>&pw=<?php echo $password; ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success('Changes saved successfully');
                        console.log(response);
                    },
                    error: function(err) {
                        toastr.error('An error occurred');
                        console.log(err);
                    }
                });
            });
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        h1 {
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            color: #fff;
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        #toast-container {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <a href="/">geri</a>
    <h1>GAMER SİSTEMİ - <?= $ajans ?></h1>
    <form>
        <label for="uyeler">Oy Kullanacak Üye Sayısı:</label>
        <input type="text" name="uyeler" id="uyeler" value="<?= $data["sunucu_uyesayisi"] ?>">

        <label for="oylar">Oylar:</label><br>
        <?php foreach ($data['oylar'] as $candidate => $votes) : ?>
            <label for="oylar[<?php echo $candidate; ?>]"><?php echo $candidate; ?>:</label>
            <input type="text" name="oylar[<?php echo $candidate; ?>]" value="<?php echo $votes; ?>"><br>
        <?php endforeach; ?>

        <button type="submit">Save Changes</button>
    </form>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000
        };
    </script>
</body>

</html>