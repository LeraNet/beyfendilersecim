<?php
function calculatePercentage($part, $total)
{
    if ($total != 0) {
        return ($part / $total) * 100;
    }
    return 0;
}

$totalVotes = array();

$files = glob($_SERVER["DOCUMENT_ROOT"] . '/data/*.json');

foreach ($files as $file) {
    $jsonData = file_get_contents($file);
    $data = json_decode($jsonData, true);

    foreach ($data['oylar'] as $candidate => $votes) {
        if (isset($totalVotes[$candidate])) {
            $totalVotes[$candidate] += $votes;
        } else {
            $totalVotes[$candidate] = $votes;
        }
    }
}

$leraVotes = $totalVotes['Lera'];

$totalVoteCount = array_sum($totalVotes);

$leraPercentage = calculatePercentage($leraVotes, $totalVoteCount);

if ($leraPercentage < 20 && $totalVoteCount > 10) {
    header('Location: /kedigirdi.php?before=' . $_SERVER["REQUEST_URI"]);
    exit;
}
?>
