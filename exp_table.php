<?php
include("config.php");
include("dbutil.php");

$expID = $_GET['exp'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql1 = "SELECT distinct(experiment.name), experiment.peaks_after_filtering AS peaks, sra_url, sra_record_url as record_url, 
antibody.name as antibody, cell_lines.name as cellline, total_tags
FROM experiment
LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id
LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id
LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id
WHERE experiment_id = $expID
";

$sql2 = "select name,count(*) as c from peak inner join summit on (peak_peak_id = peak_id) inner join motif_pos on (motif_pos_motifpos_id = motifpos_id) inner join consensus_motif on (consensus_motif_motif_id = motif_id) where experiment_experiment_id = $expID group by name order by c desc";

$overlapmotifs = sql2array($conn, $sql2);

//generating results

$result1 = $conn->query($sql1);

//genrating data into jsondata

$jsonData = fetchAssoc($result1);

$sql2 = "select count(*) as c from consensus_motif where name = '" . $jsonData[0]["antibody"] . "'";
$res  = $conn->query($sql2);
$r    = mysqli_fetch_assoc($res);
$count= $r["c"];

$conn->close();

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="exp.css" />

<body class="whiteboard">

<div>
 <table class="exptable">
  <tr>
    <td>experiment name</td>
    <td id="expName"><?php echo $jsonData[0]["name"];?></td>
  
  
    <td>number of peaks</td>
    <td id="peakNum"><?php echo $jsonData[0]["peaks"];?></td>
  </tr>
 <tr>
    <td>antibody</td>
    <td id="antiBod"><?php echo $jsonData[0]["antibody"];?></td>
    <td><?php 
  if($count > 0){
    echo '<a href="' . 'https://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=' . $jsonData[0]["antibody"] . '" id="motview" target="_blank">link to motif view if antibody and consensus motif is the same</a>';
  } else {
    echo '';
  }
   ?></td>
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
    <td><a href="<?php echo "denovo/" . $jsonData[0]["name"] . "/homer/" . $jsonData[0]["name"] . "_homermotifs_10_13_16/homerResults.html";?>" id="homer" target="_blank">link</a></td>
  </tr>
  <tr>
    <td>Genome view</td>
    <td><a href="https://summit.med.unideb.hu/jbrowse/?loc=chr11%3A8937800..115533288&tracks=DNA%2Cucsc-known-genes%2Cexp-<?php echo $expID;?>" target="_blank">link</a></td>
  </tr>

</table> 
</div>
<p>Overlapping motifs:</p>
<table>
  <thead>
    <tr>
      <th>Motif name</th>
      <th>Number of overlap</th>
    </tr>
  </thead>
  <tbody>
<?php
  foreach($overlapmotifs as $motif){
    echo "<tr>\n";
    echo "<td><a href=\"https://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=" . $motif[0] . "\" target=\"_blank\">" . $motif[0] . "</a></td>";
    echo "<td>" . $motif[1] . "</td>\n";
    echo "</tr>\n";
  }
?>
  </tbody>
</table>
</body>
</html>
