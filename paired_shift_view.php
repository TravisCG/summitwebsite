<?php
include("config.php");
include("threeexpbox.php");
include("templates/header.php");
include("templates/footer.php");

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
$minelem = $_GET['mnelem'];

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

$sql2 = "SELECT distance, count 
FROM paired_shift_view
where experiment_experiment_id = $exp2
and consensus_motif_motif_id = $motifid
&& distance <= $limit
&& distance >=  $low_limit
ORDER BY distance";

$sql3 = "SELECT distance, count 
FROM paired_shift_view
where experiment_experiment_id = $exp3
and consensus_motif_motif_id = $motifid
&& distance <= $limit
&& distance >=  $low_limit
ORDER BY distance";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

//generating results
$expData1 = getExpCellAntiBody($conn, $exp1);
$expData2 = getExpCellAntiBody($conn, $exp2);
$expData3 = getExpCellAntiBody($conn, $exp3);

$allExperiment = getAllExpCellAnti($conn, $motifid, $minelem);

$pos1 = getMotifPos($conn, $motifid, $exp1);
$pos2 = getMotifPos($conn, $motifid, $exp2);
$pos3 = getMotifPos($conn, $motifid, $exp3);

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result6 = $conn->query($sql6);

//genrating data into jsondata

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

while($w = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $w;}


while($e = mysqli_fetch_assoc($result3)) {
    $jsonData3[] = $e;}

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

<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="master.css" />
<link rel="stylesheet" type="text/css" href="paired_shift_view.css" />
<script src="jquery.js"></script>
<script src="d3.js"></script>
<script src="threeexpbox.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121648705-1');

  $(document).ready(function(){
    <?php expJS($allExperiment, $expData1, $expData2, $expData3);?>
  })
  var xlowlimit = <?php echo $low_limit;?>;
  var xhilimit  = <?php echo $limit;?>;
</script>
</head>
<body>
<div class="bootstraptooltip" id="paneltooltip">
In this panel, you can see some basic information about the adjusted ChIP-seq experiments: name; antibody; cell line and element number (The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set). The background colours indicate the histogram colours of the experiments on the plot.
</div>
<div class="bootstraptooltip" id="histogramtooltip">
The histograms shows the summit distance distributions of the selected ChIP-seq data (a maximum of 3) related to a motif center. 
The PairShiftView allows users to examine the distribution of individual summi- consensus motif distances for three experiments. To smooth the graph, a 5 bp rolling bin is used in the histogram. Each curve represents one ChIP-seq experiment. 
The X axis represents the distance (measured in base pairs) from the middle of the given motif, which is marked as the “0” point. The numbering of the axis is consistent with the position weight matrix below the diagram. The Y axis shows the frequency of summit occurrences at the relative position (at a given base pair) relative to the motif center. In the case of well-defined protein topology with high overlap frequency and close DNA localization, the curve has a bell-like pattern (normal distribution-like).
</div>
<div class="bootstraptooltip" id="navitooltip">
These buttons navigate you to other view. You can browse the genomic data in genome viewer or you can check the overlap information between selected experiments.
</div>
<div class="bootstraptooltip" id="settingtooltip">
These setting can filter the displayed data. You can set the minimum and maximum element number. After updating the page with “Refresh Page” button, the experiments with out of range values will be vanished from plot.
</div>
<div class="bootstraptooltip" id="motiftooltip">
Select a motif from the dropdown box and click on the ”Refresh Page” button. After updating the page, you can invetigate the occupying proteins on the instances of the adjusted transcription factor motif.
</div>

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
<img src="images/info.png" class="infobutton" id="histhelp" />
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

var data2 = <?php 
if (json_encode($jsonData2, JSON_NUMERIC_CHECK) == 'null'){ 
echo '[{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0}]'; 
}else {
echo json_encode($jsonData2, JSON_NUMERIC_CHECK);
};
?>;

var data3 = <?php 
if (json_encode($jsonData3, JSON_NUMERIC_CHECK) == 'null'){ 
echo '[{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0},{"distance":0,"count":0}]'; 
}else {
echo json_encode($jsonData3, JSON_NUMERIC_CHECK);
};
?>;
</script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="drawallshift.js">//this draws the canvas itself
</script>

<script src="dosearch.js">//this searches the brackets and makes the new url for the paired shift resend button THE NEW URL IS HERE IF IT HAS TO BE MODIFIED!!!! 
</script>
<script src="dosearchvenn.js">//this searches the brackets and makes the new url for the venn view buttonTHE NEW URL IS HERE IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="buttons.js">//this will make the buttons work
</script>
<br />
<div id="maincontent">
The following buttons will navigate you to different views of currently plotted data.
<button class="paired_button" onclick="doSearchpreVenn()">View data in VennView</button>
<a target="_black" href="https://summit.med.unideb.hu/jbrowse/index.html?loc=chr10%3A46391892..47806389&tracks=DNA%2Cucsc-known-genes%2Cmot-<?php echo $motifid;?>%2Cexp-<?php echo $exp1;?>%2Cexp-<?php echo $exp2;?>%2Cexp-<?php echo $exp3;?>&highlight=">
<button class="paired_button" onclick="">GenomeView</button>
</a>
<img src="images/info.png" class="infobutton" id="sethelp">
<br>
<p>Minimum overlap number between motifs and peaks of experiment: <?php echo $minelem;?></p>

<form action="#" id="min_field"> <input type="text" id="textboxmnelem" value="<?php echo $minelem;?>">
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

<p>Select the experiments in the rows of boxes below. Set from left to right: cell type > name of antibody > experiment. Then click on “Resend data” button to refresh the page. </p>

<div>

<div class="wrapper1">
<p class="one">cell type</p>
<p class="two">antibody</p>
<p class="three">experiment name</p>
</div>
<?php expBoxes();?>

<p>In the boxes below set the minimum and maximum distances from the centre of the motif. This is the value of x axis. </p>

<br>
<p>distance from motif center maximum</p>
<input id="limit" type="number" min="20" max="35" step="5">
<br>
<p>distance from motif center minimum</p>
<input id="low_limit" type="number" min="-35" max="-20" step="5">

<br>

<p>When the parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchShift('_self', '')" ><p>Refresh Page</p></button>
</div>
<p>If you want to start the selection and filtering the experiment list via antibody name, then use the following panels. Select the experiments in the rows of boxes below. Set from left to right: name of antibody > cell type > experiment. Then click on “Refresh Page” button to refresh the page.</p>

<div class="wrapper1">
<p class="one">antibody</p>
<p class="two">cell type</p>
<p class="three">experiment name</p>
</div>

<?php expBoxesCell(); ?>
<button id="resend2" onclick="doSearchShift('_self', 'v2')"><p>Refresh Page</p></button>
<br>
<script>
//here we will set the form boxes to be by default what they were in the url originally

var formmotiveval = <?php echo '"'. $motifid . '"' ;  ?>;
document.getElementById("formmotive").value = formmotiveval;

var limit = <?php echo  $limit ; ?>;
document.getElementById("limit").value = limit;

var low_limit = <?php echo  $low_limit ; ?>;
document.getElementById("low_limit").value = low_limit;

$("#histhelp").click(function(event){
  $("#paneltooltip").toggle();
  $("#histogramtooltip").toggle();
});

$("#sethelp").click(function(event){
  $("#navitooltip").toggle();
  $("#settingtooltip").toggle();
  $("#motiftooltip").toggle();
});

</script>
<br>
<p>
PairShiftView
<br><br>
In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The height of the curves shows the most frequent distance. In the PairShiftView mode, the data range and the consensus motif binding site can be set. An experiment can be also selected  and displayed in the ExperimentView. 
</p>
</div>
<?php show_footer(); ?>
</body>
</html>
