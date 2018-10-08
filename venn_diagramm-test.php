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
$motifPart = $_GET['motif'];
$motifName = '\''.$motifPart.'\'';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries
$sql1 = "SELECT motifpos_id
FROM summitdb.motif_pos m
    RIGHT join summit on m.motifpos_id = summit.motif_pos_motifpos_id
    RIGHT join peak on peak.peak_id = summit.peak_peak_id
WHERE m.consensus_motif_motif_id= $motifName
AND peak.experiment_experiment_id = $exp1Name
";

$sql2 = "SELECT motifpos_id
FROM summitdb.motif_pos m
    RIGHT join summit on m.motifpos_id = summit.motif_pos_motifpos_id
    RIGHT join peak on peak.peak_id = summit.peak_peak_id
WHERE m.consensus_motif_motif_id= $motifName
AND peak.experiment_experiment_id = $exp2Name
";

$sql3 = "SELECT motifpos_id
FROM summitdb.motif_pos m
    RIGHT join summit on m.motifpos_id = summit.motif_pos_motifpos_id
    RIGHT join peak on peak.peak_id = summit.peak_peak_id
WHERE m.consensus_motif_motif_id= $motifName
AND peak.experiment_experiment_id = $exp3Name
"; 

$sql4 = "SELECT experiment_id, experiment.name AS name, antibody_antibody_id AS antibody_id, cell_lines_cellline_id
FROM experiment";

$sql7 = "SELECT DISTINCT cell_lines_cellline_id, cell_lines.name AS cell_line 
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id";

$sql8 = "SELECT DISTINCT  antibody.name AS antibody, experiment.antibody_antibody_id AS antibody_id, GROUP_CONCAT(cell_lines.cellline_id SEPARATOR ' ') AS cellline_id
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
group by antibody_antibody_id, antibody";


//generating results

echo date('l jS \of F Y h:i:s A');
$result1 = $conn->query($sql1);
echo date('l jS \of F Y h:i:s A');
$result2 = $conn->query($sql2);
echo date('l jS \of F Y h:i:s A');
$result3 = $conn->query($sql3);
echo date('l jS \of F Y h:i:s A');
$result4 = $conn->query($sql4);
echo date('l jS \of F Y h:i:s A');
$result7 = $conn->query($sql7);
echo date('l jS \of F Y h:i:s A');
$result8 = $conn->query($sql8);
echo date('l jS \of F Y h:i:s A');

//genrating data into jsondata

while($r = mysqli_fetch_assoc($result1)) {
    $jsonData[] = $r;}
echo date('l jS \of F Y h:i:s A');

while($w = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $w;}
echo date('l jS \of F Y h:i:s A');

while($e = mysqli_fetch_assoc($result3)) {
    $jsonData3[] = $e;}
echo date('l jS \of F Y h:i:s A');

while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}
echo date('l jS \of F Y h:i:s A');

while($e7 = mysqli_fetch_assoc($result7)) {
    $jsonData7[] = $e7;}
echo date('l jS \of F Y h:i:s A');

while($e8 = mysqli_fetch_assoc($result8)) {
    $jsonData8[] = $e8;}
echo date('l jS \of F Y h:i:s A');

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

<div id="header" style="width:94% ;display:block;float:none;">
	<img src="debrecen_logo.png" alt="NAIK-MBK"  style="position:absolute; top:3px; left:17px; border-radius:40%;"> 
	<?php echo " <h2 style='text-align: center;margin-left: 12em;'>	The venn diagramm here shows the peaks from the three selected experiments.</h1><br>" ?>
	<img src="logo.jpg" alt="NAIK-MBK"  style="position:absolute; top:3px; right:17px; border-radius:50%;"> 
</div>

<div id="chart_venn" style="width:94% ;background-color: white;border:1px solid black;display:block;float:none;" >


<div id="circle" style="background-color:red;width:28% ;height:28%;opacity:0.5;border-radius: 50%;"></div>
<div id="circle2" style="background-color:blue;width:28% ;height:28%;opacity:0.5;border-radius: 50%;"></div>
<div id="circle3" style="background-color:green;width:28% ;height:28%;opacity:0.5;border-radius: 50%;"></div>

<p id="data">placeholder</p>
<p id="data2">placeholder</p>
<p id="data3">placeholder</p>
<p id="data1i2">placeholder</p>
<p id="data1i3">placeholder</p>
<p id="data2i3">placeholder</p>
<p id="data1i2i3">placeholder</p>






</div>


<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;

var data = <?php 
if (json_encode($jsonData, JSON_NUMERIC_CHECK) == 'null'){ 
echo json_encode($jsonData, JSON_NUMERIC_CHECK); 
}else {
echo sizeof($jsonData, JSON_NUMERIC_CHECK);
};
?>;

var data2 = <?php 
echo sizeof($jsonData2, JSON_NUMERIC_CHECK);
?>;

var data3 = <?php 
echo sizeof($jsonData3, JSON_NUMERIC_CHECK);
?>;


var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;
var data7 = <?php echo json_encode($jsonData7, JSON_NUMERIC_CHECK);?>;

var data8 = <?php echo json_encode($jsonData8, JSON_NUMERIC_CHECK);?>;

var intersect1_2_3 = <?php 
if (sizeof($jsonData, JSON_NUMERIC_CHECK) === 0 || sizeof($jsonData2, JSON_NUMERIC_CHECK) === 0 || sizeof($jsonData3, JSON_NUMERIC_CHECK) === 0){
 echo "0";

} else {
echo -(sizeof(array_merge($jsonData,$jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData,$jsonData2,$jsonData3), SORT_REGULAR)) -
sizeof(array_merge($jsonData,$jsonData2)) + sizeof(array_unique(array_merge($jsonData,$jsonData2), SORT_REGULAR)) - 
sizeof(array_merge($jsonData,$jsonData3)) + sizeof(array_unique(array_merge($jsonData,$jsonData3), SORT_REGULAR)) - 
sizeof(array_merge($jsonData2,$jsonData3)) + sizeof(array_unique(array_merge($jsonData2,$jsonData3), SORT_REGULAR)));
};
?>;

//echo sizeof(array_merge($jsonData,$jsonData2)) - sizeof(array_unique(array_merge($jsonData,$jsonData2), SORT_REGULAR)) + 
//sizeof(array_merge($jsonData,$jsonData3)) - sizeof(array_unique(array_merge($jsonData,$jsonData3), SORT_REGULAR)) + 
//sizeof(array_merge($jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData2,$jsonData3), SORT_REGULAR)) -

var intersect1_2 = <?php echo sizeof(array_merge($jsonData,$jsonData2)) - sizeof(array_unique(array_merge($jsonData,$jsonData2), SORT_REGULAR)); ?>;

var intersect1_3 = <?php echo sizeof(array_merge($jsonData,$jsonData3)) - sizeof(array_unique(array_merge($jsonData,$jsonData3), SORT_REGULAR)); ?>;

var intersect2_3 = <?php echo sizeof(array_merge($jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData2,$jsonData3), SORT_REGULAR)); ?>;




var data1u2 = <?php echo  json_encode((array_merge($jsonData,$jsonData2)), JSON_NUMERIC_CHECK);?>;
var data1u2f = <?php echo  json_encode((array_unique(array_merge($jsonData,$jsonData2), SORT_REGULAR)),JSON_NUMERIC_CHECK);?>;


var motive = <?php echo "\"" . $motifPart . "\""; ?>;
</script>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="urlgenvenn.js">//this one makes the resend button work
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

</script>


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
<select id="cellformexp2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  ">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>



<select id="antiformexp2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  ">" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>



 <select id="formexp2" type="text" class="six" value="" placeholder="Type to filter" style="background:#6666ff;">

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
    echo "<option value=".  $item['cell_lines_cellline_id'] .  ">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp3" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  ">" . $item['antibody'] . "</option>" ;    // process the line read.
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


</div>



<br>



<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchVenn()" style="width: 14em;"><p>Resend Data</p></button>

<button class="deletefirst" data-targets="johndoe" style="width: 14em;"><p>Remove first options</p></button>

</div>


<br>
<br>
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

var formexp1value = <?php echo  $exp1Name ; ?>;
document.getElementById("formexp1").value = formexp1value;

var formexp2value = <?php echo  $exp2Name ; ?>;
document.getElementById("formexp2").value = formexp2value;

var formexp3value = <?php echo  $exp3Name ; ?>;
document.getElementById("formexp3").value = formexp3value;

var formmotive = <?php echo '"'. $motifid . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var motifNamev = <?php echo $motifName; ?>;


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

</body>

</html>
