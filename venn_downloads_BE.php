<?php

$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$exp = $_GET['exp1'];
$exp2 = $_GET['exp2'];
$exp3 = $_GET['exp3'];
$motive = $_GET['motive'];
$motiveName = '\''.$motive.'\'';
$filename = $exp . '_' . $exp2 . '_' . $exp3 . '_'  . $motive . '.bed' ;
$header = "track name=$exp" . "_$motive" . " description=\"overlapping $motive consensus motifs with the $exp peaks\"\n";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection

// $con=mysqli_connect($host,$user,$password);

mysqli_select_db($conn,$dbname); 
//To select the database

session_start(); //To start the session

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$filename");

$output = fopen('php://output', 'w');

#fputcsv($output, array('Elso', 'Column 2', 'Column 3', 'Column 4' , $motive, 'colour'));


fwrite ($output , $header);

$sql = "SELECT
CONCAT('chr', motif_pos.chr),
motif_pos.start,
motif_pos.end,
CONCAT_WS('#',experiment.name,consensus_motif.name,peak.findPeaks_score,summit.hight,motif_pos.Homer_score) AS peakscore_summitheight_homerscore, 'red'
FROM 
motif_pos
LEFT JOIN summit ON motif_pos.motifpos_id = summit.motif_pos_motifpos_id
LEFT JOIN peak ON summit.peak_peak_id = peak.peak_id
LEFT JOIN experiment ON peak.experiment_experiment_id = experiment.experiment_id
LEFT JOIN consensus_motif ON motif_pos.consensus_motif_motif_id = consensus_motif.motif_id
WHERE 
   experiment.experiment_id = $exp
&& consensus_motif.name = $motiveName
";


$sql2 = "SELECT
CONCAT('chr', motif_pos.chr),
motif_pos.start,
motif_pos.end,
CONCAT_WS('#',experiment.name,consensus_motif.name,peak.findPeaks_score,summit.hight,motif_pos.Homer_score) AS peakscore_summitheight_homerscore, 'blue'
FROM 
motif_pos
LEFT JOIN summit ON motif_pos.motifpos_id = summit.motif_pos_motifpos_id
LEFT JOIN peak ON summit.peak_peak_id = peak.peak_id
LEFT JOIN experiment ON peak.experiment_experiment_id = experiment.experiment_id
LEFT JOIN consensus_motif ON motif_pos.consensus_motif_motif_id = consensus_motif.motif_id
WHERE 
   experiment.experiment_id = $exp2
&& consensus_motif.name = $motiveName
";

$sql3 = "SELECT
CONCAT('chr', motif_pos.chr),
motif_pos.start,
motif_pos.end,
CONCAT_WS('#',experiment.name,consensus_motif.name,peak.findPeaks_score,summit.hight,motif_pos.Homer_score) AS peakscore_summitheight_homerscore, 'green'
FROM 
motif_pos
LEFT JOIN summit ON motif_pos.motifpos_id = summit.motif_pos_motifpos_id
LEFT JOIN peak ON summit.peak_peak_id = peak.peak_id
LEFT JOIN experiment ON peak.experiment_experiment_id = experiment.experiment_id
LEFT JOIN consensus_motif ON motif_pos.consensus_motif_motif_id = consensus_motif.motif_id
WHERE 
   experiment.experiment_id = $exp3
&& consensus_motif.name = $motiveName
";



$result=mysqli_query($conn,$sql);
$result2=mysqli_query($conn,$sql2);
$result3=mysqli_query($conn,$sql3);


while ($row = mysqli_fetch_assoc($result)) fputcsv($output, $row, "\t");
while ($row2 = mysqli_fetch_assoc($result2)) fputcsv($output, $row2, "\t");
while ($row3 = mysqli_fetch_assoc($result3)) fputcsv($output, $row3, "\t");


$conn->close();

fclose ($output);

?>

