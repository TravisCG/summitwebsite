<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
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
$complex_id1 = '"' . $motiveplus . $exp1 . '"';
$complex_id2 = '"' . $motiveplus . $exp2 .  '"';
$complex_id3 = '"' . $motiveplus . $exp3 .  '"';
$minelem = $_GET['mnelem'];
$minName = '\''.$minelem.'\'';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql ="SELECT distance, count 
FROM new_paired_shift_view
where paired_shift_id = $complex_id1
&& distance <= $limit +2
&& distance >=  $low_limit -2
ORDER BY distance"; 

$sql2 = "SELECT distance, count 
FROM new_paired_shift_view
where paired_shift_id = $complex_id2
&& distance <= $limit + 2
&& distance >=  $low_limit - 2
ORDER BY distance";

$sql3 = "SELECT distance, count 
FROM new_paired_shift_view
where paired_shift_id = $complex_id3
&& distance <= $limit + 2
&& distance >=  $low_limit - 2
ORDER BY distance";

$sql1start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody, antibody.antibody_id as antid, cell_lines.cellline_id as cellid, element_num
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
LEFT JOIN average_deviation ON experiment.experiment_id = average_deviation.experiment_experiment_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
WHERE experiment.experiment_id = $exp1Name
&& consensus_motif.motif_id = $motifid
";

$sql2start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody , antibody.antibody_id as antid, cell_lines.cellline_id as cellid, element_num
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
LEFT JOIN average_deviation ON experiment.experiment_id = average_deviation.experiment_experiment_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
WHERE experiment.experiment_id = $exp2Name
&& consensus_motif.motif_id = $motifid
";

$sql3start = "SELECT experiment.name, cell_lines.name as cell_line, antibody.name as antibody, antibody.antibody_id as antid, cell_lines.cellline_id as cellid,	element_num
FROM
experiment
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
LEFT JOIN average_deviation ON experiment.experiment_id = average_deviation.experiment_experiment_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
WHERE experiment.experiment_id = $exp3Name
&& consensus_motif.motif_id = $motifid
";


$sql4 = "SELECT experiment.experiment_id, experiment.name AS name, experiment.antibody_antibody_id AS antibody_id, experiment.cell_lines_cellline_id
FROM experiment
LEFT JOIN average_deviation on average_deviation.experiment_experiment_id = experiment.experiment_id
WHERE average_deviation.element_num > $minName
&& average_deviation.consensus_motif_motif_id = $motifid;";

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

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result5 = $conn->query($sql5);
$result6 = $conn->query($sql6);
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);
$result1start = $conn->query($sql1start);
$result2start = $conn->query($sql2start);
$result3start = $conn->query($sql3start);



//genrating data into jsondata

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

while($w = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $w;}


while($e = mysqli_fetch_assoc($result3)) {
    $jsonData3[] = $e;}


while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}

while($ews = mysqli_fetch_assoc($result5)) {
    $jsonData5[] = $ews;}


while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}
$conn->close();

while($ew7 = mysqli_fetch_assoc($result7)) {
    $jsonData7[] = $ew7;}
$conn->close();

while($ew8 = mysqli_fetch_assoc($result8)) {
    $jsonData8[] = $ew8;}
$conn->close();

while($rs = mysqli_fetch_assoc($result1start)) {
    $jsonData1start[] = $rs;}

while($ws = mysqli_fetch_assoc($result2start)) {
    $jsonData2start[] = $ws;}

while($es = mysqli_fetch_assoc($result3start)) {
    $jsonData3start[] = $es;}
 

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">

<link rel="stylesheet" type="text/css" href="style.css">
<script src="jquery.js"></script>
<script src="d3.js"></script>

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

  <a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>
  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/>

  </a>
</div>

  <div class="foo">
    <ul class="navlink">
        <li><a href="main.html" title="Home" class="active">Home</a></li>
      <li onclick="glossToggle()"><a title="Venn diagramm>
Display the overlap information between selected experiments as a Venn diagram. 

To jbrowser>
Browse the genomic data of selected experiments in genome browser.

 Experiment view>
 Read the details of selected ChIP-seq experiment in Experiment view. 
" class="active">Glossary</a></li>
    </ul>
        </div>

 
	<?php echo " <h4 style='margin:auto;text-align:center;font-size:1.3em;padding-bottom:2em;padding-top:9em;'>	Shift values are shown using the ". $motiveName . " motif's center as point zero.</h4><br>" ?>

<script>
// this	will toggle the	glossary iframe
function glossToggle() {
    var x = document.getElementById("glossary");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
	x.style.display = "none";
    }
}
</script>


<div id="glossary" style="width:99% ;background-color: white;border:1px solid black;height:55em;display:none;">
 <iframe id="ifrm" src="http://summit.med.unideb.hu/summitdb/glossary.html"  frameborder="0" scrolling="yes" style="width:100% ;background-color: white;height:100%;">
</iframe>
</div>

<div id="chart" style="width:94% ;background-color: white;border:1px solid black;display:block;float:none;height:60em;" >

 <table style="width:75%;top:99em;">
<tr style="color:red;">
    <td>experiment name:</td>
    <td id="texpName1">not selected</td>
    <td>antibody:</td>
    <td id="tantibody1">not selected</td>
    <td>cell line:</td>
    <td id="tcelline1">not selected</td>
    <td>element number:</td>
    <td id="telementnum1">not selected</td>

  </tr>
<tr style="color:blue;">
    <td>experiment name:</td>
    <td id="texpName2">not selected</td>
    <td>antibody:</td>
    <td id="tantibody2">not selected</td>
    <td>cell line:</td>
    <td id="tcelline2">not selected</td>
    <td>element number:</td>
    <td id="telementnum2">not selected</td>

  </tr>
<tr style="color:green;">
    <td>experiment name:</td>
    <td id="texpName3">not selected</td>
    <td>antibody:</td>
    <td id="tantibody3">not selected</td>
    <td>cell line:</td>
    <td id="tcelline3">not selected</td>
    <td>element number:</td>
    <td id="telementnum3">not selected</td>
  </tr>
</table>



</div>

<div name="logo_chart"  id="logo_chart" style="width:94%; background-color: white;height: 8em;border:1px solid black; ">
	<?php echo "<img src=\"./logos/" . $motivePart . ".jpg\" style=\"width:15%;height:95%;opacity=30%;margin-left: 1em;margin-right: 1px;margin-top: 1px;float:left;\"> " ?>
<p style="float:left">Position weight matrix of selected motif.</p>
</div>


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
var telement1 = data1start[0].element_num
document.getElementById('telementnum1').innerHTML = telement1;


var texpName2 = data2start[0].name;
document.getElementById('texpName2').innerHTML = texpName2;
var tanti2 = data2start[0].antibody;
document.getElementById('tantibody2').innerHTML = tanti2;
var tcell2 = data2start[0].cell_line
document.getElementById('tcelline2').innerHTML = tcell2;
var telement2 = data2start[0].element_num
document.getElementById('telementnum2').innerHTML = telement2;


var texpName3 = data3start[0].name;
document.getElementById('texpName3').innerHTML = texpName3;
var tanti3 = data3start[0].antibody;
document.getElementById('tantibody3').innerHTML = tanti3;
var tcell3 = data3start[0].cell_line
document.getElementById('tcelline3').innerHTML = tcell3;
var telement3 = data3start[0].element_num
document.getElementById('telementnum3').innerHTML = telement3;

var lol1 = data1start[0].antid;
document.getElementById("antiformexp1").value = lol1;
var lol2 = data2start[0].antid;
document.getElementById("antiformexp2").value = lol2;
var lol3 = data3start[0].antid;
document.getElementById("antiformexp3").value = lol3;



</script>




<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
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

var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;
var data5 = <?php echo json_encode($jsonData5, JSON_NUMERIC_CHECK);?>;
var ujtomb = <?php echo json_encode($ujtomb);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;
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
<script>
//var formmaxid = getAllUrlParams().formmaxid;
//document.getElementById("textboxmax").value = formmaxid;

//var formminid = getAllUrlParams().formminid;
//document.getElementById("textboxmin").value = formminid;

//var formminelem = getAllUrlParams().formminelem;
//document.getElementById("textboxamnelem").value = formminelem;

//var formmaxelem = getAllUrlParams().formmaxelem;
//document.getElementById("textboxminelem").value = formmaxelem;

</script>

<script>//this one gets the options out of the url and make them an object

//this will get the parameters from the url and put them in an object to be used later

function getAllUrlParams(url) {

  // get query string from url (optional) or window
  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

  // we'll store the parameters here
  var obj = {};

  // if query string exists
  if (queryString) {

    // stuff after # is not part of query string, so get rid of it
    queryString = queryString.split('#')[0];

    // split our query string into its component parts
    var arr = queryString.split('&');

    for (var i=0; i<arr.length; i++) {
      // separate the keys and the values
      var a = arr[i].split('=');

      // in case params look like: list[]=thing1&list[]=thing2
      var paramNum = undefined;
      var paramName = a[0].replace(/\[\d*\]/, function(v) {
        paramNum = v.slice(1,-1);
        return '';
      });

      // set parameter value (use 'true' if empty)
      var paramValue = typeof(a[1])==='undefined' ? true : a[1];

      // if parameter name already exists
      if (obj[paramName]) {
        // convert value to array (if still string)
        if (typeof obj[paramName] === 'string') {
          obj[paramName] = [obj[paramName]];
        }
        // if no array index number specified...
        if (typeof paramNum === 'undefined') {
          // put the value on the end of the array
          obj[paramName].push(paramValue);        }
        // if array index number specified...
        else {
          // put the value at that index number
          obj[paramName][paramNum] = paramValue;
        }
      }
      // if param name doesn't exist yet, set it
      else {
        obj[paramName] = paramValue;
      }
    }
  }

  return obj;
}




</script>



<br>
<div style="height:105em;">
<br>
<br>
<p>Minimum overlap number between motifs and peaks of experiment</p>

<form action="#" id="min_field"> <input type="text" id="textboxmnelem" value="100">
</form>
<br>
<script>
var formminelem = getAllUrlParams().mnelem;
document.getElementById("textboxmnelem").value = formminelem;
</script>



<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option value=". $item['motif_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>






<p>Select the experiments in the rows of boxes below. Set from left to right: cell type > name of antibody > experiment. Then click on “Resend data” button to refresh the page. 
 </p>

<button class="paired_button" onclick="doSearchpreVenn()">View data in venn diagramm</button>

<a target="_blank" href="http://summit.med.unideb.hu/jbrowse/index.html?tracks=DNA,ucsc-known-genes,mot-<?php echo $motifid; ?>,example_track1&example_track2&example_track3 addStores={        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp1; ?>.bed%22}        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp2; ?>.bed%22} %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp3; ?>.bed%22} }& addTracks=[   {%22label%22:%22example_track1%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track1%22} {%22label%22:%22example_track2%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track2%22} {%22label%22:%22example_track3%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track3%22}]%22">
<button class="paired_button" onclick="">View data in jbrowse</button>
</a>


<br>
<div style="height:67em;">

<div class="wrapper1" style="height:4em;">
<p class="one">cell type</p>
<p class="two">antibody</p>
<p class="three">experiment name</p>

</div>



<div class="wrapper">

<select id="cellformexp1" class="one" type="text" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id']  . " class=\"formexp1\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp1" type="text" class="two" value="" placeholder="Type to filter" style="background:#ff6666;">

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
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . "  >" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
<br>
<button class="threeAH" onclick="jumptoexp1()"> experiment view </button>


<select id="cellformexp2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>



<select id="antiformexp2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . "  >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>



 <select id="formexp2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . "  >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="sixAH" onclick="jumptoexp2()"> experiment view </button>

<br>

<select id="cellformexp3" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp3" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

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
    echo "<option value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . "  >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="nineAH" onclick="jumptoexp3()"> experiment view </button>

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
$('select#cellformexp1').change(function(){

$("select#formexp1 option").removeClass("cell_unselected");
$("select#formexp1 " + "option:not([data-celline='" + $("#cellformexp1").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp1 option").attr('disabled', 'disabled');
$(  "select#antiformexp1 " +  "option[data-celline~=\"" +  $("#cellformexp1").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp2').change(function(){

$("select#formexp2 option").removeClass("cell_unselected");
$("select#formexp2 " + "option:not([data-celline='" + $("#cellformexp2").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp2 option").attr('disabled', 'disabled');
$(  "select#antiformexp2 " +  "option[data-celline~=\"" +  $("#cellformexp2").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 

 $( document ).ready(function() {
$('select#cellformexp3').change(function(){

$("select#formexp3 option").removeClass("cell_unselected");
$("select#formexp3 " + "option:not([data-celline='" + $("#cellformexp3").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp3 option").attr('disabled', 'disabled');
$(  "select#antiformexp3 " +  "option[data-celline~=\"" +  $("#cellformexp3").val() + "\"]" )
        .attr( 'disabled', false )

  });
}); 



</script>


</div>

<p>In the boxes below set the minimum and maximum distances from the centre of the motif. This is the value of x axis. </p>

<br>
<p>distance from motif center maximum</p>
<input id="limit" type="number" min="20" max="35" step="5">
<br>
<p>distance from motif center minimum</p>
<input id="low_limit" type="number" min="-35" max="-20" step="5">

<br>

<!--
<p>Minimum standard deviation</p>
<form action="#"> <input type="text" id="textboxmin" value="integer please">
</form>

<p>Maximum standard deviation</p>

<form action="#"> <input type="text" id="textboxmax" value="integer please">
</form>

<p>Minimum overlap number between motifs and peaks of experiment</p>

<form action="#"> <input type="text" id="textboxmnelem" value="integer please">
</form>

<p>Maximum overlap number between motifs and peaks of experiment</p>

<form action="#"> <input type="text" id="textboxmxelem" value="integer please">
</form>
-->

<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchShift()" style="width: 14em;"><p>Refresh Page</p></button>


</div>


<br>
<br>





<script>

$(document).ready(function(){
$(".deletefirst").click(function(event){
 $('.'+  $(this).data('targets')).toggle();
});
});

//this thing will help the preselect trim the experiment selection
/*
$( document ).ready(function() {
$('select#antiformexp1').change(function(){
$( "option:not('.'+  $(this).data('targets')) + select#formexp1" ).attr( "disabled", "disabled" )
.siblings().removeAttr('disabled');
  });
});
*/



// this function will bind the enter to the resend button
$(document).keypress(function(e){
    if (e.which == 13){
        $("#resend").click();
    }
});

//here we will set the form boxes to be by default what they were in the url originally

var formexp1value = <?php echo  $exp1Name ; ?>;
document.getElementById("formexp1").value = formexp1value;

var formexp2value = <?php echo  $exp2Name ; ?>;
document.getElementById("formexp2").value = formexp2value;

var formexp3value = <?php echo  $exp3Name ; ?>;
document.getElementById("formexp3").value = formexp3value;


var fexp1anti = "0";
var fexp1anti = $('#formexp1').find(":selected").attr("data-antibody");
document.getElementById("antiformexp1").value = fexp1anti;

var fexp2anti = "0";
var fexp2anti = $('#formexp2').find(":selected").attr("data-antibody");
document.getElementById("antiformexp2").value = fexp2anti;

var fexp3anti = "0";
var fexp3anti = $('#formexp3').find(":selected").attr("data-antibody");
document.getElementById("antiformexp3").value = fexp3anti;

var fexp1cell = "0";
var fexp1cell = $('#formexp1').find(":selected").attr("data-celline");
document.getElementById("cellformexp1").value = fexp1cell;

var fexp2cell = "0";
var fexp2cell = $('#formexp2').find(":selected").attr("data-celline");
document.getElementById("cellformexp2").value = fexp2cell;

var fexp3cell = "0";
var fexp3cell = $('#formexp3').find(":selected").attr("data-celline");
document.getElementById("cellformexp3").value = fexp3cell;

var formmotiveval = <?php echo '"'. $motifid . '"' ;  ?>;
document.getElementById("formmotive").value = formmotiveval;

var limit = <?php echo  $limit ; ?>;
document.getElementById("limit").value = limit;

var low_limit = <?php echo  $low_limit ; ?>;
document.getElementById("low_limit").value = low_limit;

//var formmaxid = getAllUrlParams().formmaxid;
//document.getElementById("textboxmax").value = formmaxid;

//var formminid = getAllUrlParams().formminid;
//document.getElementById("textboxmin").value = formminid;

//var formminelem = getAllUrlParams().formminelem;
//document.getElementById("textboxmnelem").value = formminelem;

//var formmaxelem = getAllUrlParams().formmaxelem;
//document.getElementById("textboxmxelem").value = formmaxelem;



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

var formexp2value = <?php echo  $exp2Name ; ?>;
document.getElementById("formexp2").value = formexp2value;

var formexp3value = <?php echo  $exp3Name ; ?>;
document.getElementById("formexp3").value = formexp3value;

var fexp1anti = "0";
var fexp1anti = $('#formexp1').find(":selected").attr("data-antibody");
document.getElementById("antiformexp1").value = fexp1anti;

var fexp2anti = "0";
var fexp2anti = $('#formexp2').find(":selected").attr("data-antibody");
document.getElementById("antiformexp2").value = fexp2anti;

var fexp3anti = "0";
var fexp3anti = $('#formexp3').find(":selected").attr("data-antibody");
document.getElementById("antiformexp3").value = fexp3anti;

var fexp1cell = "0";
var fexp1cell = $('#formexp1').find(":selected").attr("data-celline");
document.getElementById("cellformexp1").value = fexp1cell;

var fexp2cell = "0";
var fexp2cell = $('#formexp2').find(":selected").attr("data-celline");
document.getElementById("cellformexp2").value = fexp2cell;

var fexp3cell = "0";
var fexp3cell = $('#formexp3').find(":selected").attr("data-celline");
document.getElementById("cellformexp3").value = fexp3cell;

var formmotive = <?php echo '"'. $motifPart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

arata_formularcell(formexp1,fexp1cell);
arata_formularcell(formexp2,fexp2cell);
arata_formularcell(formexp3,fexp3cell);
arata_formularanti(formexp1,fexp1anti);
arata_formularanti(formexp2,fexp2anti);
arata_formularanti(formexp3,fexp3anti);

arata_formularcell2(antiformexp1,fexp1cell);
arata_formularcell2(antiformexp2,fexp2cell);
arata_formularcell2(antiformexp3,fexp3cell);


document.getElementById("formmotive").value = formmotiveval;

</script>
<div style="width:100%;">

<br><br><br><br>
<p>
PairShiftView
<br><br>
In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The height of the curves shows the most frequent distance. In the PairShiftView mode, the data range and the consensus motif binding site can be set. An experiment can be also selected  and displayed in the ExperimentView. 




</p>
<div style="width=100%">

<p>
Copyright © 2018   Mátyás Schiller, Erik Czipa, Levente Kontra, Tibor Nagy, Júlia Koller,
Orsolya Pálné Szén, Csaba Papp, László Steiner, Ferenc Marincs and Endre Barta

</p>
</div>

</div>



</body>

</html>
