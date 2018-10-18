<?php
include("config.php");

$exp1Name = '\''.$_GET['exp'].'\'';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql1 = "SELECT  experiment.name, experiment.peaks_after_filtering AS peaks, sra_url, sra_record_url as record_url, 
antibody.name as antibody, cell_lines.name as cellline, consensus_motif.name as motif, total_tags
FROM experiment
LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id
LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id
LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
WHERE experiment_id = $exp1Name
";

//generating results

$result1 = $conn->query($sql1);

//genrating data into jsondata

while($r = mysqli_fetch_assoc($result1)) {
    $jsonData[] = $r;}

$conn->close();

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">
<link rel="stylesheet" type="text/css" href="style.css">

<style>
td {font-size:1.2em;}
</style>
</head>

<body style="background-color: white;">

<div id="chart_venn" style="width=100%;display:block;float:none;" >
 <table style="width:75%">
  <tr>
    <td>experiment name</td>
    <td id="expName">0</td>
  
  
    <td>number of peaks</td>
    <td id="peakNum"><?php echo $jsonData[0]["peaks"]?></td>
  </tr>
 <tr>
    <td>antibody</td>
    <td id="antiBod">0</td>
    <td><a href="" id="motview" target="_blank">link to motif view if antibody and consensus motif is the same</a></td>
  </tr>

 <tr>
    <td>cell line</td>
    <td id="cellLine"><?php echo $jsonData[0]['cellline'];?></td>
  
    <td>Number of reads</td>
    <td id="reads"><?php echo $jsonData[0]['total_tags'];?></td>
  </tr>
  <tr>
    <td>sra ftp link</td>
    <td><a href="<?php echo $jsonData[0]['sra_url'];?>" id="sraRecord">link</a></td>
  
    <td>SRX search</td>
    <td><a id="Record" href="<?php echo $jsonData[0]['record_url'];?>">link</a></td>
  </tr>
 <tr>
    <td>homer denovo motifs</td>
    <td><a href="" id="homer" target="_blank">link</a></td>
  </tr>

</table> 
</div>
<script>

var data = <?php echo json_encode($jsonData, JSON_NUMERIC_CHECK); ?>;

var val_expName = data[0].name;
document.getElementById('expName').innerHTML = val_expName;

var val_antiBod = data[0].antibody;
document.getElementById('antiBod').innerHTML = val_antiBod;

var homera = "denovo/" + val_expName + "/homer/" + val_expName + "_homermotifs_10_13_16/homerResults.html";
document.getElementById('homer').href = homera;

var motv = "http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=" + val_antiBod;
document.getElementById('motview').href = motv;

</script>
</body>
</html>
