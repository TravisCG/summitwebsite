<?php
include("config.php");
include("threeexpbox.php");

$exp1 = $_GET['exp1'];
$exp1Name = '\''.$exp1.'\'';
$exp2 = $_GET['exp2'];
$exp2Name = '\''.$exp2.'\'';
$exp3 = $_GET['exp3'];
$exp3Name = '\''.$exp3.'\'';
$motifPart = $_GET['motifid'];
$motifName = '\''.$motifPart.'\'';
$motiveText = $_GET['motiftext'];
$minElem = $_GET['mnelem'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

//generating results
$allExperiment = getAllExpCellAnti($conn, $motifPart, $minElem);

$jsonData1start = getExpCellAntiBody($conn, $exp1Name);
$jsonData2start = getExpCellAntiBody($conn, $exp2Name);
$jsonData3start = getExpCellAntiBody($conn, $exp3Name);

$result6 = $conn->query($sql6);

//genrating data into jsondata
while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}

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
<script src="threeexpbox.js"></script>
<script>
  $(document).ready(function(){
    <?php expJS($allExperiment, $jsonData1start, $jsonData2start, $jsonData3start);?>
  });
</script>
</head>

<body>
<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<br>
<div>
<br>
<br>
<br>


<p>Set the three experiments. You can narrow down the experiment by choosing the cell line and the antibody for it:</p><br>

<p>Set the minimum overlap number between motifs and peaks of experiment</p>

<form action="#" id="form_field"> <input type="text" id="textboxmnelem" value="1000"> 
</form>
<br>

<div>

<?php expBoxes();?>

<p style="grid-column:1;">Set a motif:</p>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option value=". $item['motif_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>

<br>
<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchpreVenn()" style="width: 14em;"><p>Open venn diagramm view</p></button>

</div>


<br>
<br>
</div>
<script>
var formmotive = <?php echo '"'. $motifPart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js">
</script>

<script src="dosearchvenn.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>
<p>
VennView<br><br>
In this mode, two or three experiment can be compared. The values in the sections of the diagram indicates the number  of overlapping peaks at the consensus motif binding sites of a given motif. Considering one TFBS in a genome (among the thousands defined in the Consensus motif binding site set) it can overlap (between 50bp at both sides) one, any of the two or all three experiments examined in this view. In the Venn diagram, we count these occurrences. In this view, the consensus motif and the experiment can be selected.
</p>

</body>

</html>
