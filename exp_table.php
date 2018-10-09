<?php
include("config.php");

$exp1 = $_GET['exp'];
$exp1Name = '\''.$exp1.'\'';

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
    <td id="peakNum">0</td>
  </tr>
 <tr>
    <td>antibody</td>
    <td id="antiBod">0</td>
    <td><a href="" id="motview" target="_blank">link to motif view if antibody and consensus motif is the same</a></td>
  </tr>

 <tr>
    <td>cell line</td>
    <td id="cellLine">0</td>
  
    <td>Number of reads</td>
    <td id="reads">0</td>
  </tr>
  <tr>
    <td>sra ftp link</td>
    <td><a href="" id="sraRecord">link</a></td>
  
    <td>SRX search</td>
    <td><a href="" id="Record">link</a></td>
  </tr>
 <tr>
    <td>homer denovo motifs</td>
    <td><a href="" id="homer" target="_blank">link</a></td>
  </tr>



</table> 
</div>


<script>
//default elements
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;

var data = <?php 
echo json_encode($jsonData, JSON_NUMERIC_CHECK); 
?>;

//stuffing the cells with the data from the mysql query


var val_expName = data[0].name;
document.getElementById('expName').innerHTML = val_expName;


var val_peak = data[0].peaks;
document.getElementById('peakNum').innerHTML = val_peak;


var val_url = data[0].sra_url;
document.getElementById('sraRecord').href = val_url;


var val_recoUrl = data[0].record_url;
document.getElementById('Record').href = val_recoUrl;


var val_antiBod = data[0].antibody;
document.getElementById('antiBod').innerHTML = val_antiBod;


var val_cellLine = data[0].cellline;
document.getElementById('cellLine').innerHTML = val_cellLine;


var val_reads = data[0].total_tags;
document.getElementById('reads').innerHTML = val_reads;


var homera = "denovo/" + val_expName + "/homer/" + val_expName + "_homermotifs_10_13_16/homerResults.html";
document.getElementById('homer').href = homera;

var motv = "http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=" + val_antiBod;
document.getElementById('motview').href = motv;

var motif = data[0].motif;
document.getElementById('motif').innerHTML = motif;


</script>



</body>

</html>
