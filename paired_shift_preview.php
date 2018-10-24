<?php
include("config.php");
include("threeexpbox.php");

$motivePart = $_GET['motive'];
$motifid = $_GET['motifid'];
$motiveplus = $motifid + 100;
$motiveName = '\''.$motivePart.'\'';
$exp1 = $_GET['exp1'];
$exp1Name = '\''.$exp1.'\'';
$exp2 = $_GET['exp2'];
$exp2Name = '\''.$exp2.'\'';
$exp3 = $_GET['exp3'];
$exp3Name = '\''.$exp3.'\'';
$limit = $_GET['limit'];
$low_limit = $_GET['low_limit'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries

$sql4 = "SELECT experiment_id, experiment.name AS name, antibody_antibody_id AS antibody_id, cell_lines_cellline_id
FROM experiment";

$sql5 = "SELECT , motif_id 
FROM consensus_motif WHERE name = $motivePart";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

$sql7 = "SELECT DISTINCT cell_lines_cellline_id, cell_lines.name AS cell_line 
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
ORDER BY cell_line";

$sql8 = "SELECT DISTINCT  antibody.name AS antibody, experiment.antibody_antibody_id AS antibody_id, GROUP_CONCAT(cell_lines.cellline_id SEPARATOR ' ') AS cellline_id
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
group by antibody_antibody_id, antibody
ORDER BY antibody";

//generating results

$result4 = $conn->query($sql4);
$result5 = $conn->query($sql5);
$result6 = $conn->query($sql6);

//genrating data into jsondata

while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}

while($ews = mysqli_fetch_assoc($result5)) {
    $jsonData5[] = $ews;}


while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}

$jsonData1 = getExpCellAntiBody($conn, $exp1Name);
$jsonData2 = getExpCellAntiBody($conn, $exp2Name);
$jsonData3 = getExpCellAntiBody($conn, $exp3Name);

$allExperiment = getAllExpCellAnti($conn, $motifPart, $minElem);

$conn->close();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">

<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="dosearch.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="buttons.js">//this will make the buttons work
</script>
<script>
var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;
var data5 = <?php echo json_encode($jsonData5, JSON_NUMERIC_CHECK);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;

$(document).ready(function(){
  <?php expJS($allExperiment, $jsonData1, $jsonData2, $jsonData3);?>
})i

</script>
</head>
<body>
<div>
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

<button id="resend" onclick="doSearchpreShift()" style="width: 14em;"><p>Open paired shift view</p></button>
</div>


<br>
<br>

<script>

var formmotive = <?php echo '"'. $motifid . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var limit = <?php echo  $limit ; ?>;
document.getElementById("limit").value = limit;

var low_limit = <?php echo  $low_limit ; ?>;
document.getElementById("low_limit").value = low_limit;

var formminelem = getAllUrlParams().formminelem;
document.getElementById("textboxmnelem").value = formminelem;

</script>

<p>
PairShiftView

In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The maximum value of the curves shows the most frequent distance, which is supposed to be the same what is shown on the X-axis at the MotifView.
In the PairShiftView mode, the data range and the consensus motif binding site set can be changed. There is also a possibility to select an experiment and see it in the ExperimentView.
</p>


</body>

</html>
