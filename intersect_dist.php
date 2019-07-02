<?php
include("config.php");
include("threeexpbox.php");
include("templates/header.php");
include("templates/footer.php");

$motivePart = $_GET['motive'];
$motifid = $_GET['motifid'];
$motiveName = '\''.$motivePart.'\'';
$exp1 = $_GET['exp1'];
$exp2 = $_GET['exp2'];
$exp3 = $_GET['exp3'];
$limit = $_GET['limit'];
$low_limit = $_GET['low_limit'];
$setop = $_GET['slice'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql ="SELECT distance, count 
FROM paired_shift_view
where experiment_experiment_id = $exp1
and consensus_motif_motif_id = $motifid
&& distance <= $limit
&& distance >=  $low_limit
ORDER BY distance";

if($setop === "A"){
  $qexp1 = $exp1; $qexp2 = $exp2; $qexp3 = $exp3; $qoper1 = "NOT IN"; $qoper2 = "NOT IN";
}
elseif($setop === "B"){
  $qexp1 = $exp2; $qexp2 = $exp1; $qexp3 = $exp3; $qoper1 = "NOT IN"; $qoper2 = "NOT IN";
}
elseif($setop === "C"){
  $qexp1 = $exp3; $qexp2 = $exp2; $qexp3 = $exp1; $qoper1 = "NOT IN"; $qoper2 = "NOT IN";
}
elseif($setop === "AB"){
}
elseif($setop === "AC"){
}
elseif($setop === "BC"){
}
else{
}

$sql = "SELECT COUNT(*) as count, distance
    FROM summit
    INNER JOIN motif_pos ON motif_pos_motifpos_id = motifpos_id AND motif_pos_motifpos_id IN
    (
         SELECT motif_pos_motifpos_id FROM venn_view 
         WHERE 
             consensus_motif_motif_id = $motifid AND 
             experiment_experiment_id = $qexp1 AND
             motif_pos_motifpos_id $qoper1 ( SELECT motif_pos_motifpos_id FROM venn_view WHERE consensus_motif_motif_id = $motifid AND experiment_experiment_id = $qexp2 ) AND
             motif_pos_motifpos_id $qoper2 ( SELECT motif_pos_motifpos_id FROM venn_view WHERE consensus_motif_motif_id = $motifid AND experiment_experiment_id = $qexp3 )
    )
    INNER JOIN peak ON peak_peak_id = peak_id
    WHERE 
       experiment_experiment_id = $qexp1 AND consensus_motif_motif_id = $motifid
    GROUP BY distance,consensus_motif_motif_id,experiment_experiment_id;";

//generating results
$expData1 = getExpCellAntiBody($conn, $exp1);
$expData2 = getExpCellAntiBody($conn, $exp2);
$expData3 = getExpCellAntiBody($conn, $exp3);

$pos1 = getMotifPos($conn, $motifid, $exp1);
$pos2 = getMotifPos($conn, $motifid, $exp2);
$pos3 = getMotifPos($conn, $motifid, $exp3);

$result = $conn->query($sql);
//genrating data into jsondata

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

$conn->close();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">

<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="master.css" />
<script src="jquery.js"></script>
<script src="d3.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script>

  var xlowlimit = <?php echo $low_limit;?>;
  var xhilimit  = <?php echo $limit;?>;
</script>
</head>
<body>
<?php show_full_navigation("Venn diagram>
Display the overlap information between selected experiments as a Venn diagram. 

To jbrowser>
Browse the genomic data of selected experiments in genome browser.

 Experiment view>
 Read the details of selected ChIP-seq experiment in Experiment view. 
");?>
<h4>Shift values are shown using the  <?php echo $motiveName;?> motif's center as point zero.</h4>

<script>
function dochange(target) { window.open(target,"_blank");};
</script>
<div id="chart" >

<table class="venntable">
  <thead>
    <tr>
      <td>Experiment name</td>
      <td>Antibody</td>
      <td>Cell line</td>
      <td>Element number</td>
    </tr>
  </thead>
  <tbody>
    <tr class="exp1">
      <td id="texpName1"><?php echo $expData1[0]["name"];?></td>
      <td id="tantibody1"><?php echo $expData1[0]["antibody"];?></td>
      <td id="tcelline1"><?php echo $expData1[0]["cell_line"]?></td>
      <td id="telementnum1"><?php echo sizeof($pos1, JSON_NUMERIC_CHECK);?></td>
    </tr>
    <tr class="exp2">
      <td id="texpName2"><?php echo $expData2[0]["name"];?></td>
      <td id="tantibody2"><?php echo $expData2[0]["antibody"];?></td>
      <td id="tcelline2"><?php echo $expData2[0]["cell_line"];?></td>
      <td id="telementnum2"><?php echo sizeof($pos2, JSON_NUMERIC_CHECK);?></td>
    </tr>
    <tr class="exp3">
      <td id="texpName3"><?php echo $expData3[0]["name"]; ?></td>
      <td id="tantibody3"><?php echo $expData3[0]["antibody"]; ?></td>
      <td id="tcelline3"><?php echo $expData3[0]["cell_line"]; ?></td>
      <td id="telementnum3"><?php echo sizeof($pos3, JSON_NUMERIC_CHECK);?></td>
    </tr>
  </tbody>
</table>

</div>

<div name="logo_chart"  id="logo_chart">
	<?php echo "<img src=\"./logos/" . $motivePart . ".jpg\"> " ?>
<p>Position weight matrix of selected motif.</p>
</div>

<script>
var maxShift = 99;

var data = <?php 
if (json_encode($jsonData, JSON_NUMERIC_CHECK) == 'null'){ 
echo '[{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0}]'; 
}else {
echo json_encode($jsonData, JSON_NUMERIC_CHECK);
};
?>;
var data2 = 0;
var data3 = 0;
</script>

<script src="drawallshift.js">//this draws the canvas itself
</script>

<br />
<div id="maincontent">
This page is highly experimental. Bugs, unexpected behaviour can be expected. Please do not report bugs from this page. We already know it.
</div>
<?php show_footer(); ?>
</body>
</html>
