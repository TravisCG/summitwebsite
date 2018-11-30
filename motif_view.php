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
antibody.antibody_id AS antiid, 
antibody.name AS antibody, 
named_average_deviation.average_deviation_name as avg_name,
named_average_deviation.deviation_id AS average_deviation_id,
named_average_deviation.element_num AS element_num, 
named_average_deviation.average AS average, 
named_average_deviation.median AS median, 
named_average_deviation.experiment_experiment_id AS exp_ID, 
named_average_deviation.consensus_motif_motif_id, 
named_average_deviation.std_dev AS std_dev, 
consensus_motif.motif_id, 
consensus_motif.name AS motive_name, 
experiment.experiment_id AS exp_IDv2, 
experiment.name AS exp_name, 
cell_lines.name AS cell_line,
s3.avgstd_dev,
s3.avg_avg,
s3.avg_elem,
colour.is_it_cofactor AS factor_type,
colour.colour_hex
FROM 
named_average_deviation
LEFT JOIN experiment ON experiment.experiment_id = named_average_deviation.experiment_experiment_id 
LEFT JOIN antibody ON experiment.antibody_antibody_id = antibody.antibody_id 
LEFT JOIN colour ON colour.antibody_name = antibody.name 
LEFT JOIN consensus_motif ON named_average_deviation.consensus_motif_motif_id = consensus_motif.motif_id 
LEFT JOIN cell_lines ON experiment.cell_lines_cellline_id = cell_lines.cellline_id 
LEFT JOIN (SELECT count(name) AS nameCount,name FROM antibody GROUP BY name) s2 ON s2.name = antibody.name 
LEFT JOIN (SELECT  experiment.antibody_antibody_id, avg(std_dev) as avgstd_dev, avg(average) as avg_avg, avg(element_num) as avg_elem 
FROM named_average_deviation 
LEFT JOIN experiment on experiment.experiment_id = named_average_deviation.experiment_experiment_id 
LEFT JOIN consensus_motif ON named_average_deviation.consensus_motif_motif_id = consensus_motif.motif_id 
WHERE
named_average_deviation.std_dev <= $maxID 
&& named_average_deviation.std_dev >= $minID 
&& named_average_deviation.element_num >= $minElem 
&& named_average_deviation.element_num <= $maxElem 
&& consensus_motif.name LIKE $motiveName 
GROUP BY antibody_antibody_id) s3 ON s3.antibody_antibody_id = experiment.antibody_antibody_id 
WHERE 
named_average_deviation.std_dev <= $maxID 
&& named_average_deviation.std_dev >= $minID 
&& named_average_deviation.element_num >= $minElem 
&& named_average_deviation.element_num <= $maxElem 
&& consensus_motif.name LIKE $motiveName 
ORDER BY s2.nameCount DESC, antibody.name ASC";



$sql2 = "SELECT motif_id 
FROM consensus_motif WHERE name LIKE $motiveName";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";


$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result6 = $conn->query($sql6);

if ($result->num_rows > 0) {
    // output data 
        $jsonData = array();
//      genrating data into thisrow

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

} else {
    echo "0 results found";
}


$jsonData2 = array();

while($r2 = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $r2;
}

while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}
$conn->close();


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
<script src="http://d3js.org/d3.v3.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-121648705-1');

  function dochange(target) { window.open(target,"_self");};
</script>


</head>
<body>
<?php show_full_navigation();?>

<script>
// this will toggle the glossary iframe
function glossToggle() {
    var x = document.getElementById("glossary");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>



<br>
 <?php echo " <h4>Consensus motif: ". $motivePart . " </h4>" ?>

<div id="glossary">
 <iframe id="ifrm" src="http://summit.med.unideb.hu/summitdb/glossary.html"  frameborder="0" scrolling="yes">
</iframe>
</div>

<div id="motifchart1"></div>
<div id="motifchart2"></div>
<div  id="motifchart3"></div>

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
var ujtomb = <?php echo json_encode($column3);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;
var nestedbyantiagent = d3.nest()
  .key(function(d) { return d.antibody; })
  .entries(data);
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
// .key(function(d) { return d.colour_hex; })
  .entries(data);




/* 
 * value accessor - returns the value to encode for a given data object.
 * scale - maps value to a visual display encoding, such as a pixel position.
 * map function - maps from data value to display value
 * axis - sets up axis
 */ 




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
var nameOfX = "Distance from " + motive + " center (bp)"
DrawAllShizStand_dev("std_dev", "average", "Standard deviation of positions", nameOfX);
DrawAllShizCubes("data", "notnew", "motive");
choosethree("not_yet_selected");

// this will count the cubes in chart2 so it wont be too long or short

</script>




<script src="dosearch.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="buttons.js">//this will make the buttons work
</script>

<script>
//this trims the array in this case for the options
function trimArray(arr)
{
    for(i=0;i<arr.length;i++)
    {
        arr[i] = arr[i].replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    }
    return arr;
}
 
</script>

<div id="mbuttons">

<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option>" . $item['name'] . "</option>" ;    // process the line read.
    }
?>


</select>

<p>This form will change the maximum and minimum average deviation value of the dots shown. Try using integers please. </p> <br> 
<p>Minimum standard deviation</p>
<form action="#" id="form_field"> <input type="text" id="textboxmin" value="integer please"> 
</form>

<p>Maximum standard deviation</p>

<form action="#" id="form_field"> <input type="text" id="textboxmax" value="integer please"> 
</form>

<p>Minimum overlap number between motifs and peaks of experiment</p>

<form action="#" id="form_field"> <input type="text" id="textboxmnelem" value="integer please"> 
</form>

<p>Maximum overlap number between motifs and peaks of experiment</p>

<form action="#" id="form_field"> <input type="text" id="textboxmxelem" value="integer please"> 
</form>

<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearch('_self')" ><p>Refresh Page</p></button>

</div>




<script>
//these scripts will allow to put all the motives in the select area
//resultz is the uniqued json data
var resultz = [];

//we must trim them
var trimresultz = trimArray(resultz);

        function addOptions(){
            var select = document.getElementById('formmotive');
            var option;
            for (var i = 0; i < trimresultz.length; i++) {
              option = document.createElement('option');
              option.text = resultz[i];
              select.add(option);
            }
        };
addOptions();

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

 <button id="nodotz" onclick="trimthemall()" title="Mask all dots out from scatterplot"> <p>Hide all scatter</p></button><br><br>
  <button id="yesdotz" onclick="" title="Restore all dots to the scatterplot"> <p>Show all scatter</p></button><br><br>
<h2>Plot options</h2>
 <p>Switch the legend to antibody (default view)  and sort by using the two buttons below.</p>
<p>Choose a sorting method</p>
    <button onclick="update_alphabet()" class="cubefiddler"> <p>Alphabetical by name</p></button><br><br>
    <button onclick="update_nonalphabet()" class="cubefiddler"> <p>Number of experiments</p></button><br><br>
 <p>Switch the legend to cell line and sort by using the two buttons below.</p>
    <button onclick="update_alphabet_cell()" class="cubefiddler"> <p>Alphabetical by name</p></button><br><br>
    <button onclick="update_nonalphabet_cell()" class="cubefiddler"> <p>Number of experiments</p></button><br><br>

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

// this function will bind the enter to the resend button
$(document).keypress(function(e){
    if (e.which == 13){
        $("#resend").click();
    }
});



//here we will set the form boxes to be by default what they were in the url originally

var formmaxid = getAllUrlParams().maxid;
document.getElementById("textboxmax").value = formmaxid;

var formminid = getAllUrlParams().minid;
document.getElementById("textboxmin").value = formminid;

var formminelem = getAllUrlParams().mnelem;
document.getElementById("textboxmnelem").value = formminelem;

var formmaxelem = getAllUrlParams().mxelem;
document.getElementById("textboxmxelem").value = formmaxelem;

var formmotive = <?php echo '"'. $motivePart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;



// these will make our legends work (because heroes never die, but the legends sadly do)
$("#refresh").children().click(function(){
 $(".legend.new").click(function(event){
 $('.'+  $(this).data('targets')).fadeToggle("slow");
});
});

$("#refresh").children().click(function(){
  $(".legend").removeClass("new")
});


$(document).ready(function(){
$(".legend").click(function(event){
 $('.'+  $(this).data('targets')).fadeToggle("slow");
});
});

$(document).ready(function(){
  $(".legend").removeClass("new")

});

//these two rows will make the chart2 with the cubes fit like a glove

var cubechartheight = $(".legend").length;
$(document).ready(function() { $('#chart2').on("scroll", function() { $('.cubechart').css('height', cubechartheight * 1.8 + "em")}) });
</script>


<div>
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
