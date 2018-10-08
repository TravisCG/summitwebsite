<?php

$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$exp = $_GET['exp'];
$motive = $_GET['motive'];
$expName = '\''.$exp.'\'';
$motiveName = '\''.$motive.'\'';
$filename = $exp . '_' . $motive . '.bed' ;
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

#fputcsv($output, array('Elso', 'Column 2', 'Column 3', 'Column 4' , $motive));


fwrite ($output , $header);

$sql = "SELECT
CONCAT('chr', motif_pos.chr),
motif_pos.start,
motif_pos.end,
CONCAT_WS('#',experiment.name,consensus_motif.name,peak.findPeaks_score,summit.hight,motif_pos.Homer_score) AS peakscore_summitheight_homerscore
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

$result=mysqli_query($conn,$sql);


while ($row = mysqli_fetch_assoc($result)) fputcsv($output, $row, "\t");

$conn->close();

fclose ($output);

?>

