<?php
include("config.php");
include("templates/header.php");
include("templates/footer.php");

$maxID = $_GET['maxid'];
$minID = $_GET['minid'];
$minElem = $_GET['mnelem'];
$maxElem = $_GET['mxelem'];
$motivePart = $_GET['motive'];
$motiveName = '\''.$motivePart.'\'';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT
antibody.name AS antibody, 
average_deviation.average_deviation_name as avg_name,
average_deviation.deviation_id AS average_deviation_id,
average_deviation.element_num AS element_num, 
average_deviation.average AS average, 
average_deviation.experiment_experiment_id AS exp_ID, 
average_deviation.std_dev AS std_dev, 
experiment.name AS exp_name, 
cell_lines.name AS cell_line,
s3.avgstd_dev,
s3.avg_avg,
s3.avg_elem,
antibody.is_it_cofactor AS factor_type,
antibody.colour_hex
FROM 
average_deviation
LEFT JOIN experiment ON experiment.experiment_id = average_deviation.experiment_experiment_id 
LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id 
LEFT JOIN consensus_motif ON average_deviation.consensus_motif_motif_id = consensus_motif.motif_id 
LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id 
LEFT JOIN (SELECT  experiment.antibody_antibody_id, avg(std_dev) as avgstd_dev, avg(average) AS avg_avg, avg(element_num) AS avg_elem 
           FROM average_deviation 
           LEFT JOIN experiment on experiment.experiment_id = average_deviation.experiment_experiment_id 
           LEFT JOIN consensus_motif ON average_deviation.consensus_motif_motif_id = consensus_motif.motif_id 
           WHERE
              average_deviation.std_dev <= $maxID 
              && average_deviation.std_dev >= $minID 
              && average_deviation.element_num >= $minElem 
              && average_deviation.element_num <= $maxElem 
              && consensus_motif.name LIKE $motiveName 
           GROUP BY antibody_antibody_id) s3 ON s3.antibody_antibody_id = experiment.antibody_antibody_id 
WHERE 
  average_deviation.std_dev <= $maxID 
  && average_deviation.std_dev >= $minID 
  && average_deviation.element_num >= $minElem 
  && average_deviation.element_num <= $maxElem 
  && consensus_motif.name LIKE $motiveName ";



$sql2 = "SELECT motif_id 
FROM consensus_motif WHERE name LIKE $motiveName";

$sql3 = "SELECT antibody.name FROM anti2cons LEFT JOIN antibody ON antibody_id = antibody_antibody_id LEFT JOIN consensus_motif ON consensus_motif_motif_id = motif_id WHERE consensus_motif.name = $motiveName";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";


$result  = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result6 = $conn->query($sql6);

$jsonData = array();
if ($result->num_rows > 0) {
        // output data 
        //      genrating data into thisrow

        while($r = mysqli_fetch_assoc($result)) {
                $jsonData[] = $r;
        }
}


$jsonData2 = array();

while($r2 = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $r2;
}

while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}

$directbind = array();
while($r = mysqli_fetch_array($result3)){
  array_push($directbind, $r[0]);
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
<link rel="stylesheet" type="text/css" href="motif.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-121648705-1');

  function dochange(target) { window.open(target,"_blank");};
</script>
</head>
<body>
<div class="bootstraptooltip" id="motiftooltip">
Select a motif from the dropdown box and click on the ”Refresh Page” button. After updating the page, you can invetigate the occupying proteins on the instances of the adjusted transcription factor motif.
</div>
<div class="bootstraptooltip" id="settingtooltip">
These settings can filter the displayed data. You can set the minimum and maximum standard deviation and/or element number. After updating the page with “Refresh Page” button, the experiments with out of range values will be vanished from scatterplot.
</div>
<div class="bootstraptooltip" id="antisort1tooltip">
Sort the antibodies according to their names (alphabetically)
</div>
<div class="bootstraptooltip" id="antisort2tooltip">
Sort the antibodies according to the number of experiments.
</div>
<div class="bootstraptooltip" id="cellsorttooltip">
These buttons will modify the labels. The antibody names will be replaced with cell type names. Following the logic of the previous buttons, the experiment can be sorted by name of the cell line or the number of their occurrences.
</div>
<div class="bootstraptooltip" id="categorytooltip">
In this panel, you can see a list of proteins which had ChIP-seq signal in proximity to instances of the adjusted motif. The numbers next to the protein names indicate the number of (with the motif) corresponding experiments which were targeted the given protein and had ChIP-seq summits near to the motif instances.  These numbers are equal with the number of dots on scatterplot. The colours of squares also congruent with the fill colour of dots.  Clicking on the name of a factor hide/show its dots on scatterplot.
</div>
<?php show_full_navigation();
echo " <h4>Consensus motif: ". $motivePart . " </h4>"
?>

<div id="topbuttons">
<button id="nodotz" title="Mask all dots out from scatterplot"><p> Hide all scatter</p></button>
<button id="yesdotz" class="clicked" title="Restore all dots to the scatterplot"><p>Show all scatter</p></button>
<button id="onlydb"><p>Only direct binding</p></button>
</div>

<div id="motifchart1">
<div class="bootstraptooltip" id="scattertooltip">
Every dot on the scatterplot represent one ChIP-seq experiment. The dots are colored according to the type of target protein. X axis: A point are placed according to the average position of summits of the experiment relative to the motif centers. The Y axis is adjustable, you can choose to display the number of summit-motif overlaps or the standard deviation of summit positions (with buttons below ”Set Y value”). If you hover the cursor on a given dot, a tool-tip will appear, which gives information about the ChIP-seq experiment, including the name of the experiment, cell type, target protein, and quantified information about summit positions (average/median distance, standard deviation of distances, and overlap number). You can click on experiments (maximum 3) to investigate them in other views or download their corresponding data. The selected experiments are listed below the scatterplot.
</div>
<div class="bootstraptooltip" id="yaxistooltip">
The Y axis is adjustable, you can choose to display the element number or the standard deviation of summit positions (with buttons below ”Set Y value”).  Element number means the number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set.
</div>
<div class="bootstraptooltip" id="xaxistooltip">
The dots are placed depending on the relation between the positioning information and the adjusted motif center. The X axis represents the distance from the center of the adjusted JASPAR CORE motif which can be seen on the right bottom corner of scatterplot. The “0” point is the middle base pair of the motif.   The distance is measured in base pairs.
</div>

<img src="images/info.png" class="infobutton" id="canvashelp" />
</div>
<div id="motifchart2">
<img src="images/info.png" class="infobutton" id="categoryhelp" />
</div>
<div id="motifchart3">
  <div class="bootstraptooltip" id="threetooltip">
  If you click on maximum 3 points on scatterplot, information about the corresponding ChIP-seq experiments will appear. This information consists of the cell type origin, the antibody name and the element number (The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set). If you click on these information boxes, you will be navigated to the Experiment view. You can read detail about the selected experiments in this view.  The selected experiments can be investigated in other views, if you click on the appearing boxes under the scatterplot. The selections can be vanished with „Clear all  selected” button. 
  </div>
  <div class="bootstraptooltip" id="cleartooltip">
  If you want to modify the list of selected experiments, you can vanish it with this button.
  </div>
</div>

<div name="chart4"  id="motifchart4">
<p>Position weight matrix for selected motif.</p>
 <?php echo "<img src=\"./logos/" . $motivePart . ".jpg\" alt=\"No picture available!\" > " ?>
</div>

<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;
var data = <?php echo json_encode($jsonData, JSON_NUMERIC_CHECK);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;
var motifid = <?php echo json_encode($jsonData2, JSON_NUMERIC_CHECK);?>;

//the cubes are named here by the antiagents or the cellines
var antiagentCount = d3.nest()
  .key(function(d) { return d.antibody; })
  .key(function(d) { return d.colour_hex; })
  .rollup(function(v) { return v.length; })
  .entries(data);

var antiagentCount2 = d3.nest()
  .key(function(d) { return d.cell_line; })
  .rollup(function(r) { return r.length; })
  .key(function(d) { return "#444666"; })
  .entries(data);

var directbinding = <?php echo( json_encode($directbind)); ?>;
/* 
 * value accessor - returns the value to encode for a given data object.
 * scale - maps value to a visual display encoding, such as a pixel position.
 * map function - maps from data value to display value
 * axis - sets up axis
 */ 

<?php 
  if($result->num_rows == 0 ){
    echo "d3.select('#motifchart1').append('div').style('position', 'relative').style('top', '20%').style('left', '40%').style('border', '5px solid red').style('width', '20%').text('Using this settings there is no results. Please, try to decrease minimum overlap or minimum standard deviation.');";
  }
?>
</script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="drawall.js">//this draws the canvas itself
</script>

<script src="drawcubes.js">//this draws the cubes next to the canvas
</script>

<script src="threechosen.js">//this one deals with the three choices in the chart3 div
</script>


<script>
// lets draw the things we need when the page loads
var nameOfX = "Distance from " + motive + " center (bp)";
var formminid = getAllUrlParams().minid;
var formmaxid = getAllUrlParams().maxid;
var formminelem = getAllUrlParams().mnelem;
var formmaxelem = getAllUrlParams().mxelem;
var formmotive = <?php echo '"'. $motivePart . '"'; ?>;
DrawAllShizStand_dev("std_dev", "average", "Standard deviation of positions", nameOfX);
DrawAllShizCubes("data", "notnew", "motive");
$(".legend").addClass("selected");
choosethree("Not yet selected");

// this will count the cubes in chart2 so it wont be too long or short

</script>

<script src="dosearch.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="buttons.js">//this will make the buttons work
</script>
<div id="mbuttons">
<p>Set a motif:</p>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option>" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>
<img src="images/info.png" class="infobutton" id="sethelp" />
<p>This form will change the maximum and minimum average deviation value of the dots shown. Try using integers please. </p> 
<p>Minimum standard deviation</p>
<form action="#" id="form_field" >
<input type="text" id="textboxmin" value="integer please"> 

<p>Maximum standard deviation</p>

<input type="text" id="textboxmax" value="integer please"> 

<p>Minimum overlap number between motifs and peaks of experiment</p>

<input type="text" id="textboxmnelem" value="integer please"> 

<p>Maximum overlap number between motifs and peaks of experiment</p>

<input type="text" id="textboxmxelem" value="integer please"> 

<p>When te parameters have been set, this button will refresh the page.</p>

</form>
<button id="resend" onclick="doSearch('_self')" ><p>Refresh Page</p></button>
</div>

<script>
var motivefilter = getAllUrlParams().motive;
</script>

<div id="buttons2">

  <p>The following buttons change the display of data. With the following buttons you can change the Y value.</p>
  <p><b title="Average distance: The average of distances between every summit and motif center pair at a given ChIP-seq experiment and consensus motif pair.">X value:</b> average distance. <br>Set Y value.</p>
  <button class="yselector" id="y1" onclick="updatestand_dev()" title="Standard deviation (of shift values): Here, it is calculated from the shift values between peak summits and the centers of the consensus motif binding sites, which are closer than 50 bp."> <p>standard deviation</p></button><br><br>
  <button class="yselector" id="y2" onclick="updateelem_num()"  title="Element (number): The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set. "> <p>element number</p></button><br><br>
  <p><b title="Values (average distance values) of ChIP-seq experiment with same antibody is averaged">X value:</b> average of average distances. <br>Set Y value.</p>
  <button class="yselector" id="y3" onclick="update_avg_std()" title="The average value of the standard deviation of the distances between the peak summits and motif centers obtained for the same antibody in different experiments."> <p>average standard deviation</p></button><br><br>
  <button class="yselector" id="y4" onclick="update_avg_elem()" title="The average value of the element numbers obtained for the same antibody in different experiments."> <p>average element numbers</p></button><br><br>
<br>
</div>
<div id="refresh">
<h2>Plot options</h2>
<p>Switch the legend to antibody (default view)  and sort by using the two buttons below.</p>
<p>Choose a sorting method</p>
<img src="images/info.png" class="infobutton" id="plothelp" />
    <button onclick="update_alphabet()" class="cubefiddler" > <p>Alphabetical by name</p></button><br><br>
    <button onclick="update_nonalphabet()" class="cubefiddler" > <p>Number of experiments</p></button><br><br>
 <p>Switch the legend to cell line and sort by using the two buttons below.</p>
<div>
    <button onclick="update_alphabet_cell()" class="cubefiddler"> <p>Alphabetical by name</p></button><br><br>
    <button onclick="update_nonalphabet_cell()" class="cubefiddler"> <p>Number of experiments</p></button><br><br>
</div>
</div>


<script>
// this will give the y1 button a nice shadow
document.getElementById("y1").style.boxShadow = "4px 6px 8px #555555";
document.getElementById("y1").style.color = "#111111";
document.getElementById("y1").style.backgroundColor = "#EEEEEE";
document.getElementById("y2").style.boxShadow = "1px 2px 3px #555555";
document.getElementById("y2").style.color = "#DDDDDD";
document.getElementById("y3").style.boxShadow = "1px 2px 3px #555555";
document.getElementById("y3").style.color = "#DDDDDD";
document.getElementById("y4").style.boxShadow = "1px 2px 3px #555555";
document.getElementById("y4").style.color = "#DDDDDD";

//here we will set the form boxes to be by default what they were in the url originally

document.getElementById("textboxmax").value = formmaxid;
document.getElementById("textboxmin").value = formminid;
document.getElementById("textboxmnelem").value = formminelem;
document.getElementById("textboxmxelem").value = formmaxelem;
document.getElementById("formmotive").value = formmotive;

// these will make our legends work (because heroes never die, but the legends sadly do)
$("#refresh").children().click(function(){
   $(".legend.new").click(function(event){
      $('.'+  $(this).data('targets')).fadeToggle("slow");
      $(this).toggleClass("selected");
   });
   $(".legend").removeClass("new");
});

$(document).ready(function(){
   $(".legend").click(function(event){
      $('.'+  $(this).data('targets')).fadeToggle("slow");
      $(this).toggleClass("selected");
      $(".clicked").removeClass("clicked");
   });
   $("#canvashelp").click(function(event){
      $("#scattertooltip").toggle();
      $("#yaxistooltip").toggle();
      $("#xaxistooltip").toggle();
   });
   $("#categoryhelp").click(function(event){
      $("#categorytooltip").toggle();
   });
   $("#threeexphelp").click(function(event){
      $("#threetooltip").toggle();
      $("#cleartooltip").toggle();
   });
   $("#sethelp").click(function(event){
      $("#motiftooltip").toggle();
      $("#settingtooltip").toggle();
   });
   $("#plothelp").click(function(event){
      $("#antisort1tooltip").toggle();
      $("#antisort2tooltip").toggle();
      $("#cellsorttooltip").toggle();
   });
});

$(document).ready(function(){
  $(".legend").removeClass("new")
});

//these two rows will make the chart2 with the cubes fit like a glove

var cubechartheight = $(".legend").length;
$(document).ready(function() { $('#motifchart2').on("scroll", function() { $('.cubechart').css('height', cubechartheight * 1.8 + "em")}) });
</script>


<div id="maincontent">
<p>

MotifView <br>
In this mode, the average distances between the peak of the reads obtained in a ChIP-seq experiment and a given consensus motif on a scatterplot graph is visualized. Each scatter represents an experiments
The displayed data can be filtered by the number of overlapping peaks (element number) or by the standard deviation. Data can be also displayed based on the used antibody or cell type. Averages of experiments
After selecting maximum three experiments, links are available to switch to other views.
</p>
</div>
<?php show_footer();?>
</body>
</html>
