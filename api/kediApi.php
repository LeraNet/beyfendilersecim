<?php

$files = glob($_SERVER["DOCUMENT_ROOT"] . '/data/*.json');

function calculatePercentage($part, $total)
{
    if ($total != 0) {
        return ($part / $total) * 100;
    }
    return 0;
}

$totalVotes = array();

if(count($totalVotes) < 10) {
    
}

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

$threshold = 20;
$percentageDifference = $threshold - $leraPercentage;

$closeToThreshold = abs($percentageDifference);
$progress = 100 - $closeToThreshold;


if($totalVoteCount < 10) {
    echo "false";
    die();
}

if($leraPercentage <= 20) {
    echo 100;
}else if ($leraPercentage <= 90){
    echo $progress + rand(-10, 10);
}else {
    echo $progress;
}

?>