<?php
include("config.php");
include("threeexpbox.php");
include("templates/header.php");

$motivePart = $_GET['motive'];
$motifid = $_GET['motifid'];
$motiveName = '\''.$motivePart.'\'';
$exp1 = $_GET['exp1'];
$exp1Name = '\''.$exp1.'\'';
$exp2 = $_GET['exp2'];
$exp2Name = '\''.$exp2.'\'';
$exp3 = $_GET['exp3'];
$exp3Name = '\''.$exp3.'\'';
$limit = $_GET['limit'];
$low_limit = $_GET['low_limit'];
$formminelem = $_GET['formminelem'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql6 = "SELECT name, motif_id 
FROM consensus_motif";
//generating results

$result6 = $conn->query($sql6);

//genrating data into jsondata
while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}

$jsonData1 = getExpCellAntiBody($conn, $exp1);
$jsonData2 = getExpCellAntiBody($conn, $exp2);
$jsonData3 = getExpCellAntiBody($conn, $exp3);

$allExperiment = getAllExpCellAnti($conn, $motifid, $formminelem);

$conn->close();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">

<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="master.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="threeexpbox.js"></script>
<script src="dosearch.js"></script>
<script>
var motive = <?php echo "\"" . $motivePart . "\""; ?>;

$(document).ready(function(){
  <?php expJS($allExperiment, $jsonData1, $jsonData2, $jsonData3);?>
})
function dochange(target) { window.open(target,"_self");};
</script>
</head>
<body>
<?php show_full_navigation();?>
<div id="maincontent">
<br>
<p>Set the three experiments. You can narrow down the experiment by choosing the cell line and the antibody for it:</p><br>

<div>

<div class="wrapper1" style="height:4em;">
<p class="one">cell type</p>
<p class="two">antibody</p>
<p class="three">experiment name</p>

</div>

<?php expBoxes();?>

<p>Here you will be able to set the upper and bottom limit of the distance shown. (the parameter set here is the max x and the negative of the minimum x value) </p>

<br>
<p>distance from motif center maximum</p>
<input id="limit" type="number" min="20" max="35" step="5">
<br>
<p>distance from motif center minimum</p>
<input id="low_limit" type="number" min="-35" max="-20" step="5">

<br>
<p>Minimum overlap number between motifs and peaks of experiment</p>

<form action="#" id="min_field"> <input type="text" id="textboxmnelem" value="100">
</form>
<br>


<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option value=". $item['motif_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>

<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchShift('_self')" style="width: 14em;"><p>Open paired shift view</p></button>
</div>


<br>
<br>

<script>
document.getElementById("formmotive").value = <?php echo '"'. $motifid . '"'; ?>;
document.getElementById("limit").value = <?php echo  $limit ; ?>;
document.getElementById("low_limit").value = <?php echo  $low_limit ; ?>;
document.getElementById("textboxmnelem").value = <?php echo $formminelem; ?>;
</script>

<p>
PairShiftView

In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The maximum value of the curves shows the most frequent distance, which is supposed to be the same what is shown on the X-axis at the MotifView.
In the PairShiftView mode, the data range and the consensus motif binding site set can be changed. There is also a possibility to select an experiment and see it in the ExperimentView.
</p>


</body>

</html>
