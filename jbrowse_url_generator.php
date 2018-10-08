
<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$motivePart = $_GET['motive'];
$motiveName = '\''.$motivePart.'\'';
$exp1 = $_GET['exp1'];
$exp1Name = '\''.$exp1.'\'';
$exp2 = $_GET['exp2'];
$exp2Name = '\''.$exp2.'\'';
$exp3 = $_GET['exp3'];
$exp3Name = '\''.$exp3.'\'';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql ="SELECT average_deviation.deviation_id as count 
FROM summit left join peak on peak.peak_id = summit.peak_peak_id 
left join experiment on experiment.experiment_id = peak.experiment_experiment_id 
left join motif_pos on motif_pos.motifpos_id = summit.motif_pos_motifpos_id 
left join consensus_motif on consensus_motif.motif_id = motif_pos.consensus_motif_motif_id 
left join average_deviation on average_deviation.experiment_experiment_id = experiment.experiment_id 
where (experiment.experiment_id = $exp1 
|| experiment.experiment_id = $exp2 
|| experiment.experiment_id = $exp3 )
&& consensus_motif.name LIKE $motiveName
order by count asc"; 



$result = $conn->query($sql);
while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

// close connection
$conn->close();

$urlpart = array_column($jsonData, 'count');

?>

<head>
<mheta http-equiv="refresh" content="0; url=http://genomics.dote.hu/summitdb/jbrowse/?avg_devs=<?php echo implode("," , $urlpart); ?>" />
</head>
<body>
<script>
var data = <?php echo implode("," , $urlpart); ?>;
</script>
<a href="http://genomics.dote.hu/summitdb/jbrowse/?avg_devs=<?php echo implode("," , $urlpart); ?>" >Forward to the jbrowse page</a>
</body>


