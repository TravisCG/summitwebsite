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
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);



//genrating data into jsondata

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

</head>

<body>

<script>


var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;
var data5 = <?php echo json_encode($jsonData5, JSON_NUMERIC_CHECK);?>;
var ujtomb = <?php echo json_encode($ujtomb);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;
</script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
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
<script>
var formmaxid = getAllUrlParams().formmaxid;
document.getElementById("textboxmax").value = formmaxid;

var formminid = getAllUrlParams().formminid;
document.getElementById("textboxmin").value = formminid;

var formminelem = getAllUrlParams().formminelem;
document.getElementById("textboxamnelem").value = formminelem;

var formmaxelem = getAllUrlParams().formmaxelem;
document.getElementById("textboxminelem").value = formmaxelem;

</script>
<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>




<br>
<div>
<br>
<br>
<br>


<p>Set the three experiments. You can narrow down the experiment by choosing the cell line and the antibody for it:</p><br>

<div>

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

<select id="formexp1" type="text" value="" class="three" placeholder="Type to filter" style="background:#ff6666;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<option value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . ">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>


<br>
<select id="cellformexp2" class="four" type="text" value="" placeholder="Type to filter" style="background:#8282ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id']  . " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="antiformexp2" type="text" class="five" value="" placeholder="Type to filter" style="background:#8282ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>

</select>

<select id="formexp2" type="text" class="six" value="" placeholder="Type to filter" style="background:#8282ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
     echo "<option value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . ">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>


<br>
<select id="cellformexp3" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] . " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp3" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>



</select>

<select id="formexp3" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
     echo "<option value=". $item['experiment_id'] .  " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . ">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>

<script>
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

<button id="resend" onclick="doSearchpreShift()" style="width: 14em;"><p>Open paired shift view</p></button>


<!-- <button class="deletefirst" data-targets="johndoe" style="width: 14em;"><p>Remove first options</p></button> -->

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



var formmotive = <?php echo '"'. $motifid . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var limit = <?php echo  $limit ; ?>;
document.getElementById("limit").value = limit;

var low_limit = <?php echo  $low_limit ; ?>;
document.getElementById("low_limit").value = low_limit;

var formmaxid = getAllUrlParams().formmaxid;
document.getElementById("textboxmax").value = formmaxid;

var formminid = getAllUrlParams().formminid;
document.getElementById("textboxmin").value = formminid;

var formminelem = getAllUrlParams().formminelem;
document.getElementById("textboxmnelem").value = formminelem;

var formmaxelem = getAllUrlParams().formmaxelem;
document.getElementById("textboxmxelem").value = formmaxelem;

</script>

<p>
PairShiftView

In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The maximum value of the curves shows the most frequent distance, which is supposed to be the same what is shown on the X-axis at the MotifView.
In the PairShiftView mode, the data range and the consensus motif binding site set can be changed. There is also a possibility to select an experiment and see it in the ExperimentView.
</p>


</body>

</html>
