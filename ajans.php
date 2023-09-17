<?php include "api/kedisystem.php" ?>
<?php
$ajans = $_GET["ajans"] ?? null;

if ($ajans == null || !file_exists("data/$ajans.json")) {
    die("Ajans Seçin");
}

$data = json_decode(file_get_contents("data/$ajans.json"), true);

$allVotes = 0;

for ($i = 0; $i < count($data["adaylar"]); $i++) {
    $allVotes = $allVotes + $data["oylar"][$data["adaylar"]["$i"]];
}


$sandik = round(($allVotes / $data["sunucu_uyesayisi"]) * 100);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeyfendilerSecim</title>
    <link rel="stylesheet" href="style.css?<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <audio id="jumpscare" src="https://cdn.discordapp.com/attachments/989920686065725490/1127018947632447628/radarjumpscare.wav"></audio>
    <div class="kediradar" id="kediradar">
        <center>
            <img src="https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExcjBwYW9pZGhzNGYxN3h6bDJsc2oycDFwM2EzNnlzeGY2NW45OG43biZlcD12MV9naWZzX3NlYXJjaCZjdD1n/ki1rmMhjvLlm/giphy.gif" alt="" srcset="">
        </center>
        <p style="text-align: center;">Kedi Radarı</p>
        <p style="text-align: center;">Risk : <span id="kedilore">0%</span></p>
    </div>
    <a href="/">geri</a>
    <p id="debug" <?php if (isset($_COOKIE["dismiss"])) {
                        echo "style='display: none'";
                    } ?>>
        Ama abi bu 100% olmuyoki :DDDDDD <button onclick="document.getElementById('debug').style.display = 'none'; cokilebenibebegim()">x</button> <br>
        Son Kontrol Edildi : <span id="ms"></span></p>
    <div class="adaylar">
        <center>
            <img class="logo" src="images/<?= $ajans ?>.png" alt="" srcset="" draggable="false">
        </center>
        <h1 style="text-align: center;">CUMHURBAŞKANI SEÇİMİ 1. TUR</h1>
        <h2 style="text-align: center;">Açılan Sandık : <span id="acilan-sandik">0</span></h2>
        <div class="fr">
            <?php
            foreach ($data["adaylar"] as $aday) :
            ?>
                <div class="aday">
                    <h3><?= $aday ?></h3>
                    <div class="xd">
                        <img src="/images/aday/<?= $aday ?>.webp" alt="" draggable="false">
                        <div class="yuzde" id="<?= $aday ?>-yuzde">
                            <?= round(($data["oylar"]["$aday"] / $data["sunucu_uyesayisi"]) * 100); ?>%
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <canvas id="chart"></canvas>
    <script>
        let last = 0;
        let ses = false;

        function updateData() {
            fetch('data/<?= $ajans ?>.json?' + Math.random(0, 999))
                .then(response => response.json())
                .then(data => {
                    const adaylar = data.adaylar;
                    const oylar = data.oylar;
                    const sunucuUyeSayisi = data.sunucu_uyesayisi;

                    let totalVotes = 0;

                    adaylar.forEach(aday => {
                        totalVotes += oylar[aday];
                    });

                    adaylar.forEach(aday => {
                        const yuzdeDiv = document.getElementById(`${aday}-yuzde`);
                        if(oylar[aday] == 0) {
                            let prev = yuzdeDiv.textContent.replace('%', '') ?? 0;
                            animateValue(yuzdeDiv, prev, `0%`, 1000);
                            return;
                        }
                        const votePercentage = Math.round((oylar[aday] / totalVotes) * 100);
                        let prev = yuzdeDiv.textContent.replace('%', '');
                        animateValue(yuzdeDiv, prev, `${votePercentage}%`, 1000);
                    });

                    const sandikElement = document.getElementById('acilan-sandik');
                    if (sandikElement) {
                        const updatedSandik = Math.round((totalVotes / sunucuUyeSayisi) * 100);
                        let prev = sandikElement.textContent.replace('%', '');
                        animateValue(sandikElement, prev, `${updatedSandik}%`, 1000);
                    }
                });
            last = 0;
        }

        function updateKedi() {
            fetch('api/kediApi.php?' + Math.random(0, 999))
                .then(response => response.json())
                .then(data => {
                    const kediradar = document.getElementById("kediradar");
                    const kedilore = document.getElementById('kedilore');
                    if (data === false) {
                        kediradar.style.right = "-120px";
                        kedilore.textContent = "0%"
                        ses = true;
                    } else {
                        kediradar.style.right = "15px";
                        
                        if(ses == true) {
                            var sess = document.getElementById("jumpscare");
                            sess.play();
                            ses = false;
                        }

                        let prev = kedilore.textContent.replace('%', '');
                        animateValue(kedilore, prev, `${data}%`, 1000);

                        if (data == 100) {
                            window.location.href = "/kedigirdi.php?before=<?= $_SERVER["REQUEST_URI"] ?>";
                        }
                    }
                });
        }

        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const range = parseInt(end) - parseInt(start);
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * range + parseInt(start));
                element.textContent = `${value}%`;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        function lastCheck() {
            last++;
            let ms = document.getElementById("ms");
            ms.textContent = last / 10 + " saniye";
        }

        function cokilebenibebegim() {
            document.cookie = "dismiss=ok";
        }

        updateData();

        setInterval(lastCheck, 100);
        setInterval(updateData, 1000);
        setInterval(updateKedi, 1000);
    </script>



</body>

</html>