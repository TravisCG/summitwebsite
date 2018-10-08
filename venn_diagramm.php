<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$exp1 = $_GET['exp1'];
$exp1Name = '\''.$exp1.'\'';
$exp2 = $_GET['exp2'];
$exp2Name = '\''.$exp2.'\'';
$exp3 = $_GET['exp3'];
$exp3Name = '\''.$exp3.'\'';
$limit = $_GET['limit'];
$low_limit = $_GET['low_limit'];
$complex_id1 = '"' . $motiveplus . $exp1 . '"';
$complex_id2 = '"' . $motiveplus . $exp2 .  '"';
$complex_id3 = '"' . $motiveplus . $exp3 .  '"';
$motifPart = $_GET['motifid'];
$motifName = '\''.$motifPart.'\'';
$motifText = $_GET['motive'];
$minElem = $_GET['mnelem'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql1 = "SELECT  motifpos_id
FROM venn_view
WHERE motif_id= $motifName
AND experiment_id = $exp1Name
";

$sql2 = "SELECT  motifpos_id
FROM venn_view
WHERE motif_id= $motifName
AND experiment_id = $exp2Name
";

$sql3 = "SELECT  motifpos_id
FROM venn_view
WHERE motif_id= $motifName
AND experiment_id = $exp3Name
"; 

$sql1start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody, antibody.antibody_id as antid, cell_lines.cellline_id as cellid
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
WHERE experiment.experiment_id = $exp1Name
";

$sql2start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody , antibody.antibody_id as antid, cell_lines.cellline_id as cellid
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
WHERE experiment.experiment_id = $exp2Name
";

$sql3start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody, antibody.antibody_id as antid, cell_lines.cellline_id as	cellid
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
WHERE experiment.experiment_id = $exp3Name
";



$sql4 = "SELECT experiment_id, CONCAT(experiment.name, ' elem_num: ' , average_deviation.element_num)  AS name, antibody_antibody_id AS antibody_id, cell_lines_cellline_id
FROM experiment
LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id
WHERE average_deviation.consensus_motif_motif_id = $motifName
&& average_deviation.element_num >= $minElem
";
$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

$sql7 = "SELECT distinct cell_lines_cellline_id, cell_lines.name AS cell_line , antibody.antibody_id as antibody
FROM average_deviation
LEFT JOIN experiment ON experiment.experiment_id = average_deviation.experiment_experiment_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
where consensus_motif.motif_id = $motifName
&& average_deviation.element_num >= $minElem
Group by cell_line
ORDER BY cell_line";

$sql8 = "SELECT DISTINCT antibody.name AS antibody, experiment.antibody_antibody_id AS antibody_id, GROUP_CONCAT(cell_lines.cellline_id SEPARATOR ' ') AS cellline_id
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
group by antibody_antibody_id, antibody

ORDER BY antibody";


//generating results

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result6 = $conn->query($sql6);
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);

$result1start = $conn->query($sql1start);
$result2start = $conn->query($sql2start);
$result3start = $conn->query($sql3start);


//genrating data into jsondata

while($r = mysqli_fetch_assoc($result1)) {
    $jsonData[] = $r;}

while($w = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $w;}

while($e = mysqli_fetch_assoc($result3)) {
    $jsonData3[] = $e;}

while($rs = mysqli_fetch_assoc($result1start)) {
    $jsonData1start[] = $rs;}

while($ws = mysqli_fetch_assoc($result2start)) {
    $jsonData2start[] = $ws;}

while($es = mysqli_fetch_assoc($result3start)) {
    $jsonData3start[] = $es;}


while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}

while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}

while($e7 = mysqli_fetch_assoc($result7)) {
    $jsonData7[] = $e7;}

while($e8 = mysqli_fetch_assoc($result8)) {
    $jsonData8[] = $e8;}

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

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121648705-1');
</script>

</head>

<body>

<div class="container_16">
<!--topdiv -->


  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/>

  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>

  <a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/>
  </a>
</div>

  <div class="foo">
    <ul class="navlink">
        <li><a href="main.html" title="Home" class="active">Home</a></li>
        <li onclick="glossToggle()"><a title="Help" class="active">Glossary</a></li>

    </ul>
        </div>




<h4 style="margin:auto;text-align:center;font-size:1.3em;padding-bottom:3em;padding-top:10em;">Venn diagramm view</h4>


<script>
// this will toggle the glossary iframe
function glossToggle() {
    var x = document.getElementById("glossary");
    var y = document.getElementById("chart_venn");
    if (x.style.display === "none") {
        x.style.display = "block";
	y.style.display = "none";
    } else {
	x.style.display = "none";
	y.style.display = "block";
    }
}
</script>


<div id="glossary" style="width:99% ;background-color: white;border:1px solid black;height:55em;display:none;z-index: 11;">
 <iframe id="ifrm" src="http://summit.med.unideb.hu/summitdb/glossary.html"  frameborder="0" scrolling="yes" style="width:100% ;background-color: white;height:100%;">
</iframe>
</div>



<div id="chart_venn" style="width:94% ;background-color: white;border:1px solid black;display:block;float:none;" >


<div id="circle" style="background-color:red;width:28% ;height:31em;opacity:0.5;border-radius: 50%;"></div>
<div id="circle2" style="background-color:blue;width:28% ;height:31em;opacity:0.5;border-radius: 50%;"></div>
<div id="circle3" style="background-color:green;width:28% ;height:31em;opacity:0.5;border-radius: 50%;"></div>

<p id="data">placeholder</p>
<p id="data2">placeholder</p>
<p id="data3">placeholder</p>
<p id="data1i2">placeholder</p>
<p id="data1i3">placeholder</p>
<p id="data2i3">placeholder</p>
<p id="data1i2i3">placeholder</p>

 <table style="width:71%;top:99em;">
<tr style="color:red;">
    <td>experiment name:</td>
    <td id="texpName1">not selected</td>
    <td>antibody:</td>
    <td id="tantibody1">not selected</td>
    <td>cell line:</td>
    <td id="tcelline1">not selected</td>
    <td>consensus motif binding sites:</td>
    <td id="tcons1">not selected</td>
  </tr>
<tr style="color:blue;">
    <td>experiment name:</td>
    <td id="texpName2">not selected</td>
    <td>antibody:</td>
    <td id="tantibody2">not selected</td>
    <td>cell line:</td>
    <td id="tcelline2">not selected</td>
    <td>consensus motif binding sites:</td>
    <td id="tcons2">not selected</td>
  </tr>
<tr style="color:green;">
    <td>experiment name:</td>
    <td id="texpName3">not selected</td>
    <td>antibody:</td>
    <td id="tantibody3">not selected</td>
    <td>cell line:</td>
    <td id="tcelline3">not selected</td>
    <td>consensus motif binding sites:</td>
    <td id="tcons3">not selected</td>
  </tr>
</table>
</div>

<?php
$size1 = sizeof($jsonData, JSON_NUMERIC_CHECK);
$size2 = sizeof($jsonData2, JSON_NUMERIC_CHECK);
$size3 = sizeof($jsonData3, JSON_NUMERIC_CHECK);


?>




<script>
//making the colorful table work

var data1start = <?php echo json_encode($jsonData1start);?>;

var data2start = <?php echo json_encode($jsonData2start);?>;

var data3start = <?php echo json_encode($jsonData3start);?>;

var texpName1 = data1start[0].name;
document.getElementById('texpName1').innerHTML = texpName1;
var tanti1 = data1start[0].antibody;
document.getElementById('tantibody1').innerHTML = tanti1;
var tcell1 = data1start[0].cell_line
document.getElementById('tcelline1').innerHTML = tcell1;
document.getElementById('tcons1').innerHTML = <?php echo $size1; ?>;


var texpName2 = data2start[0].name;
document.getElementById('texpName2').innerHTML = texpName2;
var tanti2 = data2start[0].antibody;
document.getElementById('tantibody2').innerHTML = tanti2;
var tcell2 = data2start[0].cell_line
document.getElementById('tcelline2').innerHTML = tcell2;
document.getElementById('tcons2').innerHTML = <?php echo $size2; ?>;



var texpName3 = data3start[0].name;
document.getElementById('texpName3').innerHTML = texpName3;
var tanti3 = data3start[0].antibody;
document.getElementById('tantibody3').innerHTML = tanti3;
var tcell3 = data3start[0].cell_line
document.getElementById('tcelline3').innerHTML = tcell3;
document.getElementById('tcons3').innerHTML = <?php echo $size3; ?>;




var lol1 = data1start[0].antid;
document.getElementById("antiformexp1").value = lol1;
var lol2 = data2start[0].antid;
document.getElementById("antiformexp2").value = lol2;
var lol3 = data3start[0].antid;
document.getElementById("antiformexp3").value = lol3;

document.getElementById("antiformexp1v2").value = lol1;
document.getElementById("antiformexp2v2").value = lol2;
document.getElementById("antiformexp3v2").value = lol3;




</script>


  <div name="chart4"  id="chart4" style="width:15%; background-color: white;height: 11em;border:1px solid black; ">
<p style="margin-left:5px;margin-top:3px;margin-bottom:0px;">Position weight matrix for selected motif.</p>
 <?php echo "<img src=\"./logos/" . $motifText . ".jpg\" style=\"width:95%;height:61%;opacity=30%;margin-left: 1em;margin-right: 1px;margin-top: 1px;\"  alt=\"No picture available!\" > " ?>
</div>

<div style="height:5em;padding:0.5em;">
<a target="_blank" href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=<?php echo $motifText;?>">
<button class="paired_button" onclick="">Go to selected motif's view</button>
</a>

<a target="_blank" href="http://summit.med.unideb.hu/jbrowse/index.html?tracks=DNA,ucsc-known-genes,mot-<?php echo $motifPart ;?>,example_track1,example_track2,example_track3& addStores={        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp1; ?>.bed%22}        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp2; ?>.bed%22} %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp3; ?>.bed%22} }& addTracks=[   {%22label%22:%22example_track1%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track1%22} {%22label%22:%22example_track2%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track2%22} {%22label%22:%22example_track3%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track3%22}]%22">
<button class="paired_button" onclick="">View in jbrowse</button>
</a>
</div>

<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;

var data = <?php 
echo $size1;
?>;

var data2 = <?php 
echo $size2;
?>;

var data3 = <?php 
echo $size3;
?>;

var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;

var data7 = <?php echo json_encode($jsonData7, JSON_NUMERIC_CHECK);?>;

var data8 = <?php echo json_encode($jsonData8, JSON_NUMERIC_CHECK);?>;

<?php
$inter1i2 = sizeof(array_merge($jsonData,$jsonData2)) - sizeof(array_unique(array_merge($jsonData,$jsonData2), SORT_REGULAR));
$inter1i3 = sizeof(array_merge($jsonData,$jsonData3)) - sizeof(array_unique(array_merge($jsonData,$jsonData3), SORT_REGULAR));
$inter2i3 = sizeof(array_merge($jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData2,$jsonData3), SORT_REGULAR));

?>







var intersect1_2_3 = <?php 
if ($size1 === 0 || $size2 === 0 || $size3 === 0){
 echo "0";

} else {
echo -(sizeof(array_merge($jsonData,$jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData,$jsonData2,$jsonData3), SORT_REGULAR)) -
$inter1i2 - 
$inter1i3 - 
$inter2i3);
};
?>;


var intersect1_2 = <?php echo $inter1i2; ?>;

var intersect1_3 = <?php echo $inter1i3; ?>;

var intersect2_3 = <?php echo $inter2i3; ?>;





var motive = <?php echo "\"" . $motifPart . "\""; ?>;
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


<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>


<div style="width:100%;height:95em;">
<br>
<p style="grid-column:1;">Set a motif:</p>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option value=". $item['motif_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>
<p>Minimum overlap number between motifs and peaks of experiment</p>

<form action="#" id="min_field"> <input type="text" id="textboxmnelem" value="100"> 
</form>



<p>Select the experiments in the rows of boxes below. Set from left to right: cell type > name of antibody > experiment. Then click on “Resend data” button to refresh the page. 
</p><br>
<button class="paired_button" onclick="doSearchpreShift()">View data in paired shift view</button>
<button class="paired_button" style="width:18em;"  onclick="vennBed()">Download bed file for genome view</button>

<!-- these id-s and values are here to give the function its standard values, because the venn view does not have upper and lower limits, and the paired shift view does -->
<br id="limit" value=25><br id="low_limit" value=-25>

<script>//this one works for the venn diagramm bed download


function vennBed() {

    var motive = '';
    var skillsSelect = document.getElementById("formmotive");
    var motive = skillsSelect.options[skillsSelect.selectedIndex].text;
    var motifid = '';
    var motifid = parseInt(document.getElementById("formmotive").value);
    var firstexp1 = '';
    var firstexp1 = parseInt(document.getElementById("formexp1").value) || "undefined";
    var secondexp2 = '';
    var secondexp2 = parseInt(document.getElementById("formexp2").value) || "undefined";
    var thirdexp3 = '';
    var thirdexp3 = parseInt(document.getElementById("formexp3").value) || "undefined";
    var limit = '';
    var limit = parseInt(document.getElementById("limit").value) || 25;
    var low_limit = '';
    var low_limit = parseInt(document.getElementById("low_limit").value) || -25;
//making the input a bit more idiot proof remember to update this link when it goes to a new place

    window.location = "http://summit.med.unideb.hu/summitdb/venn_downloads_BE.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive);

    return false; // not entirely necessary, but just in case

};









</script>




<br>

<div style="height:35em;">
<div class="wrapper">

<select id="cellformexp1" class="one" type="text" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id']  . " class=\"formexp1\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select disabled id="antiformexp1" type="text" class="two" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp1" type="text" value="" class="three" placeholder="Type to filter"  style="background:#ff6666;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"disabled\" >" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
<button class="threeAH2" onclick="jumptoexp1()"> experiment view </button>
<br>
<select id="cellformexp2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>



<select disabled id="antiformexp2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>



 <select id="formexp2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"disabled\" >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="sixAH2" onclick="jumptoexp2()"> experiment view </button>
<br>

<select id="cellformexp3" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select disabled id="antiformexp3" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . "  >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp3" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
<?php

foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"disabled\" >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="nineAH2" onclick="jumptoexp3()"> experiment view </button>

<br>
<br>
<br>



<script>

//makes the three jump to experiment view buttons work
function jumptoexp1() {
   var firstexp1 = '';
    var firstexp1 = parseInt(document.getElementById("formexp1").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp1);

window.open(adresshift, '_blank');
}

function jumptoexp2() {
   var firstexp2 = '';
    var firstexp2 = parseInt(document.getElementById("formexp2").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp2);

window.open(adresshift, '_blank');
}

function jumptoexp3() {
   var firstexp3 = '';
    var firstexp3 = parseInt(document.getElementById("formexp3").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp3);

window.open(adresshift, '_blank');
}



//this thing will help the preselect trim the experiment selection

 $( document ).ready(function() {
$('select#antiformexp1').change(function(){
$("select#formexp1 option").attr('disabled', false);

$(  "select#formexp1 " +  "option:not([data-antibody='" +  $("#antiformexp1").val() + "'])" )
	.attr( "disabled", "disabled" )

  });
}); 

 $( document ).ready(function() {
$('select#antiformexp2').change(function(){
$("select#formexp2 option").attr('disabled', false);

$(  "select#formexp2 " +  "option:not([data-antibody='" +  $("#antiformexp2").val() + "'])" )
        .attr( "disabled", "disabled" )

  });
}); 

 $( document ).ready(function() {
$('select#antiformexp3').change(function(){
$("select#formexp3 option").attr('disabled', false);


$(  "select#formexp3 " +  "option:not([data-antibody='" +  $("#antiformexp3").val() + "'])" )
        .attr( "disabled", "disabled" )

  });
}); 

 $( document ).ready(function() {
$('#min_field').change(function(){

$.minimal =  document.getElementById('min_field')[0].value;
alert($.minimal);
$("select#formexp1 option").removeClass("toolittle");
$("select#formexp1 " + "option([data-celline > '" + $.minimal + "'])" ).addClass("toolittle");

  });
});



 $( document ).ready(function() {
$('select#cellformexp1').click(function(){

$("select#antiformexp1").attr('disabled', false);
$("select#formexp1 option").removeClass("cell_unselected");
$("select#formexp1 " + "option:not([data-celline='" + $("#cellformexp1").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp1 option").attr('disabled', 'disabled');
$(  "select#antiformexp1 " +  "option[data-celline~=\"" +  $("#cellformexp1").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp2').click(function(){

$("select#antiformexp2").attr('disabled', false);
$("select#formexp2 option").removeClass("cell_unselected");
$("select#formexp2 " + "option:not([data-celline='" + $("#cellformexp2").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp2 option").attr('disabled', 'disabled');
$(  "select#antiformexp2 " +  "option[data-celline~=\"" +  $("#cellformexp2").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp3').click(function(){

$("select#antiformexp3").attr('disabled', false);
$("select#formexp3 option").removeClass("cell_unselected");
$("select#formexp3 " + "option:not([data-celline='" + $("#cellformexp3").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp3 option").attr('disabled', 'disabled');
$(  "select#antiformexp3 " +  "option[data-celline~=\"" +  $("#cellformexp3").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 
//make the buttons work

 $( document ).ready(function() {
$('button#exp1').click(function(){
	$("select#formexp1 option").removeClass("cell_unselected");
	$("select#antiformexp1 option").attr('disabled', false);
	$("select#formexp1 option").attr('disabled', false);
  });
}); 

 $( document ).ready(function() {
$('button#exp2').click(function(){
	$("select#formexp2 option").removeClass("cell_unselected");
        $("select#antiformexp2 option").attr('disabled', false);
	$("select#formexp2 option").attr('disabled', false);
  });
}); 

 $( document ).ready(function() {
$('button#exp3').click(function(){
	$("select#formexp3 option").removeClass("cell_unselected");
        $("select#antiformexp3 option").attr('disabled', false);
	$("select#formexp3 option").attr('disabled', false);
  });
}); 


</script>
<button id="exp1" class="threeAH" >clear selection </button>
<button id="exp2" class="sixAH" >clear selection </button>
<button id="exp3" class="nineAH" >clear selection</button>


</div>

<br>



<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend" onclick="doSearchVenn()" style="width: 14em;"><p>Refresh Page</p></button>

</div>


<br>



<div>
<div class="wrapper">

<select disabled id="cellformexp1v2" class="two" type="text" value="" placeholder="Type to filter" style="background:#ff6666;">


<?php
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp1v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp1v2" type="text" class="one" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp1v2" type="text" value="" class="three" placeholder="Type to filter"  style="background:#ff6666;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
<button class="threeAH2" onclick="jumptoexp1v2()"> experiment view </button>
<br>
<select disabled id="cellformexp2v2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">


<?php
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp2v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>



</select>



<select id="antiformexp2v2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>



 <select id="formexp2v2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="sixAH2" onclick="jumptoexp2v2()"> experiment view </button>
<br>

<select disabled id="cellformexp3v2" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp3v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp3v2" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . "  >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp3v2" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
<?php

foreach($jsonData4 as $item){
    echo "<option value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="nineAH2" onclick="jumptoexp3v2()"> experiment view </button>

<br>
<br>
<br>



<script>

//makes the three jump to experiment view buttons work
function jumptoexp1v2() {
   var firstexp1v2 = '';
    var firstexp1v2 = parseInt(document.getElementById("formexp1v2").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp1v2);

window.open(adresshift, '_blank');
}

function jumptoexp2v2() {
   var firstexp2v2 = '';
    var firstexp2v2 = parseInt(document.getElementById("formexp2v2").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp2v2);

window.open(adresshift, '_blank');
}

function jumptoexp3v2() {
   var firstexp3v2 = '';
    var firstexp3v2 = parseInt(document.getElementById("formexp3v2").value) || "undefined";
var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(firstexp3v2);

window.open(adresshift, '_blank');
}



//this thing will help the preselect trim the experiment selection
 $( document ).ready(function() {
$('select#antiformexp1v2').change(function(){

$("select#cellformexp1v2").attr('disabled', false);
$("select#formexp1v2 option").attr('disabled', false);

$(  "select#formexp1v2 " +  "option:not([data-antibody='" +  $("#antiformexp1v2").val() + "'])" )
    .attr( "disabled", "disabled" )

$("select#cellformexp1v2 option").attr('disabled', 'disabled');
$(  "select#cellformexp1v2 " +  "option[data-antibody~=\"" +  $("#antiformexp1v2").val() + "\"]" )
        .attr( 'disabled', false );


  });
}); 

 $( document ).ready(function() {
$('select#antiformexp2v2').click(function(){

$("select#cellformexp2v2").attr('disabled', false);
$("select#formexp2v2 option").attr('disabled', false);

$(  "select#formexp2v2 " +  "option:not([data-antibody='" +  $("#antiformexp2v2").val() + "'])" )
        .attr( "disabled", "disabled" )

$("select#cellformexp2v2 option").attr('disabled', 'disabled');
$(  "select#cellformexp2v2 " +  "option[data-antibody~=\"" +  $("#antiformexp2v2").val() + "\"]" )
        .attr( 'disabled', false );



  });
}); 

 $( document ).ready(function() {
$('select#antiformexp3v2').click(function(){

$("select#formexp3v2 option").attr('disabled', false);
$("select#cellformexp3v2").attr('disabled', false);




$(  "select#formexp3v2 " +  "option:not([data-antibody='" +  $("#antiformexp3v2").val() + "'])" )
        .attr( "disabled", "disabled" );

$("select#cellformexp3v2 option").attr('disabled', 'disabled');
$(  "select#cellformexp3v2 " +  "option[data-antibody~=\"" +  $("#antiformexp3v2").val() + "\"]" )
        .attr( 'disabled', false );



  });
}); 

 $( document ).ready(function() {
$('select#cellformexp1v2').click(function(){

$("select#formexp1v2 option").removeClass("cell_unselected");
$("select#formexp1v2 " + "option:not([data-celline='" + $("#cellformexp1v2").val() + "'])" ).addClass("cell_unselected");

//$("select#antiformexp1v2 option").attr('disabled', 'disabled');
//$(  "select#antiformexp1v2 " +  "option[data-celline~=\"" +  $("#cellformexp1v2").val() + "\"]" )
//        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp2v2').change(function(){

$("select#formexp2v2 option").removeClass("cell_unselected");
$("select#formexp2v2 " + "option:not([data-celline='" + $("#cellformexp2v2").val() + "'])" ).addClass("cell_unselected");

//$("select#antiformexp2v2 option").attr('disabled', 'disabled');
//$(  "select#antiformexp2v2 " +  "option[data-celline~=\"" +  $("#cellformexp2v2").val() + "\"]" )
//        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp3v2').change(function(){

$("select#formexp3v2 option").removeClass("cell_unselected");
$("select#formexp3v2 " + "option:not([data-celline='" + $("#cellformexp3v2").val() + "'])" ).addClass("cell_unselected");

//$("select#antiformexp3v2 option").attr('disabled', 'disabled');
//$(  "select#antiformexp3v2 " +  "option[data-celline~=\"" +  $("#cellformexp3v2").val() + "\"]" )
//        .attr( 'disabled', false )

  });
}); 
//make the buttons work

 $( document ).ready(function() {
$('button#exp1v2').click(function(){
    $("select#formexp1v2 option").removeClass("cell_unselected");
    $("select#antiformexp1v2 option").attr('disabled', false);
    $("select#formexp1v2 option").attr('disabled', false);
  });
}); 

 $( document ).ready(function() {
$('button#exp2v2').click(function(){
    $("select#formexp2v2 option").removeClass("cell_unselected");
        $("select#antiformexp2v2 option").attr('disabled', false);
    $("select#formexp2v2 option").attr('disabled', false);
  });
}); 

 $( document ).ready(function() {
$('button#exp3v2').click(function(){
    $("select#formexp3v2 option").removeClass("cell_unselected");
        $("select#antiformexp3v2 option").attr('disabled', false);
    $("select#formexp3v2 option").attr('disabled', false);
  });
}); 


</script>
<button id="exp1v2" class="threeAH" >clear selection </button>
<button id="exp2v2" class="sixAH" >clear selection </button>
<button id="exp3v2" class="nineAH" >clear selection</button>


</div>


<br>



<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend2" onclick="doSearchVenn2()" style="width: 14em;"><p>Refresh Page</p></button>

</div>
</div>



<script>

$(document).ready(function(){
$(".deletefirst").click(function(event){
 $('.'+  $(this).data('targets')).toggle();
});
});

// this function will bind the enter to the resend button
$(document).keypress(function(e){
    if (e.which == 13){
        $("#resend").click();
    }
});

//here we will set the form boxes to be by default what they were in the url originally
function arata_formularcell(y,x) {
        var el = y.querySelectorAll("[data-celline= \'" + x + "\' ]");
	for(var i = 0; i < el.length; i++) {
    el[i].classList.remove("cell_unselected");
}
}

function arata_formularcell2(y,x) {
        var el = y.querySelectorAll("[data-celline= \'" + x + "\' ]");
        for(var i = 0; i < el.length; i++) {
    el[i].disabled = false;
}
}

function arata_formularanti(y,x) {
        var el = y.querySelectorAll("[data-antibody= \'" + x + "\' ]");
        for(var i = 0; i < el.length; i++) {
    el[i].disabled = false;
}
} 

var formexp1value = <?php echo  $exp1Name ; ?>;
document.getElementById("formexp1").value = formexp1value;
document.getElementById("formexp1v2").value = formexp1value;


var formexp2value = <?php echo  $exp2Name ; ?>;
document.getElementById("formexp2").value = formexp2value;
document.getElementById("formexp2v2").value = formexp2value;


var formexp3value = <?php echo  $exp3Name ; ?>;
document.getElementById("formexp3").value = formexp3value;
document.getElementById("formexp3v2").value = formexp3value;




var formmotive = <?php echo '"'. $motifPart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var lol1 = data1start[0].antid;
document.getElementById("antiformexp1").value = lol1;
var lol2 = data2start[0].antid;
document.getElementById("antiformexp2").value = lol2;
var lol3 = data3start[0].antid;
document.getElementById("antiformexp3").value = lol3;

var lolz1 = data1start[0].cellid;
document.getElementById("cellformexp1").value = lolz1;
var lolz2 = data2start[0].cellid;
document.getElementById("cellformexp2").value = lolz2;
var lolz3 = data3start[0].cellid;
document.getElementById("cellformexp3").value = lolz3;


document.getElementById("antiformexp1v2").value = lol1;

document.getElementById("antiformexp2v2").value = lol2;

document.getElementById("antiformexp3v2").value = lol3;


document.getElementById("cellformexp1v2").value = lolz1;

document.getElementById("cellformexp2v2").value = lolz2;

document.getElementById("cellformexp3v2").value = lolz3;


var formminelem = getAllUrlParams().mnelem;
document.getElementById("textboxmnelem").value = formminelem;



//arata_formularcell(formexp1,fexp1cell);
//arata_formularcell(formexp2,fexp2cell);
//arata_formularcell(formexp3,fexp3cell);
//arata_formularanti(formexp1,fexp1anti);
//arata_formularanti(formexp2,fexp2anti);
//arata_formularanti(formexp3,fexp3anti);

//arata_formularcell2(antiformexp1,fexp1cell);
//arata_formularcell2(antiformexp2,fexp2cell);
//arata_formularcell2(antiformexp3,fexp3cell);

</script>


<script>
//this will generate the venn diagram for us

document.getElementById("data").innerHTML = data - intersect1_2 - intersect1_3 + intersect1_2_3; 
document.getElementById("data2").innerHTML = data2 - intersect1_2 - intersect2_3 + intersect1_2_3; 
document.getElementById("data3").innerHTML = data3 - intersect1_3 - intersect2_3 + intersect1_2_3; 
document.getElementById("data1i2").innerHTML = intersect1_2 - intersect1_2_3; 
document.getElementById("data1i3").innerHTML = intersect1_3 - intersect1_2_3; 
document.getElementById("data2i3").innerHTML = intersect2_3 - intersect1_2_3; 
document.getElementById("data1i2i3").innerHTML = intersect1_2_3; 


</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js">
</script>

<script>
//this script here will generate us the intersections for the venn diagramm bed file downloads


   function intersectionObjects2(a, b, areEqualFunction) {
        var results = [];
        
        for(var i = 0; i < a.length; i++) {
            var aElement = a[i];
            var existsInB = _.any(b, function(bElement) { return areEqualFunction(bElement, aElement); });

            if(existsInB) {
                results.push(aElement);
            }
        }
        
        return results;
    }



function intersectionObjects() {
        var results = arguments[0];
        var lastArgument = arguments[arguments.length - 1];
        var arrayCount = arguments.length;
        var areEqualFunction = _.isEqual;
        
        if(typeof lastArgument === "function") {
            areEqualFunction = lastArgument;
            arrayCount--;
        }
        
        for(var i = 1; i < arrayCount ; i++) {
            var array = arguments[i];
            results = intersectionObjects2(results, array, areEqualFunction);
            if(results.length === 0) break;
        }

        return results;
    }


   function differenceObjects2(a, b, areEqualFunction) {
        var results = [];
        
        for(var i = 0; i < a.length; i++) {
            var aElement = a[i];
            var existsInB = _.any(b, function(bElement) { return areEqualFunction(bElement, aElement); });

            if(!existsInB) {
		var pololo = "#11111";
		var aElementfinal = aElement.concat(pololo);
                results.push(aElementfinal);
            }
        }
        
        return results;
    }



function differenceObjects() {
        var results = arguments[0];
        var lastArgument = arguments[arguments.length - 1];
        var arrayCount = arguments.length;
        var areEqualFunction = _.isEqual;

        if(typeof lastArgument === "function") {
            areEqualFunction = lastArgument;
            arrayCount--;
        }

        for(var i = 1; i < arrayCount ; i++) {
            var array = arguments[i];
            results = differenceObjects2(results, array, areEqualFunction);
            if(results.length === 0) break;
        }

        return results;
    }




    var resulti1v2v3 = intersectionObjects(data1list, data2list, data3list, function(item1, item2) {
        return item1.motifpos_id === item2.motifpos_id;
    });

    var result1v2 = intersectionObjects(data1list, data2list,  function(item1i, item2i) {
        return item1i.motifpos_id === item2i.motifpos_id;
    });

   var result1v2i = differenceObjects(result1v2, resulti1v2v3,  function(item1e, item2e) {
        return item1e.motifpos_id === item2e.motifpos_id;
    });

var result1i = differenceObjects(data1list, data2list, data3list, function(item1e, item2e) {
        return item1e.motifpos_id === item2e.motifpos_id;
    });

</script>


<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="dosearchvenn.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="buttons.js">//this will make the buttons work
</script>


<div style="width:100%;height:7em;">

<p>
Antibody oriented search<br><br>
In this mode, two or three experiments can be compared as above. Here the seach starts with designating the antibody and the cell type afterwards. 
</p>
</div>


<div style="width:100%">

<p>
VennView<br><br>
In this mode, two or three experiments can be compared. The values in the sections of the diagram indicates the number of common and specific peaks at a consensus motif binding site. In this view, the con$
</p>
<br>
<br>
<br>



<p>
Copyright © 2018    Mátyás Schiller,  Erik Czipa, Levente Kontra, Tibor Nagy, Júlia Koller,
Orsolya Pálné Szén, Csaba Papp, László Steiner, Ferenc Marincs and Endre Barta
</p>
</div>

</body>

</html>
