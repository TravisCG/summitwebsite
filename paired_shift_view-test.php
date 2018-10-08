<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$motivePart = $_GET['motive'];
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
echo date('l jS \of F Y h:i:s A');
/*$sql = "SELECT
distinct distance FROM summit 
left join peak on peak.peak_id = summit.peak_peak_id
left join experiment on experiment.experiment_id = peak.experiment_experiment_id
left join motif_pos on motif_pos.motifpos_id = summit.motif_pos_motifpos_id
left join consensus_motif on consensus_motif.motif_id = motif_pos.consensus_motif_motif_id
where experiment.experiment_id = 23
order by distance asc";
*/

$sql ="SELECT distance, count(distance) as count 
FROM paired_shift_view
where exp_id = $exp1 
&& motive_name LIKE $motiveName
&& distance <= $limit +2
&& distance >=  $low_limit -2
group by distance"; 
//order by distance asc";

echo date('l jS \of F Y h:i:s A');

$sql2 = "SELECT distance, count(distance) as count 
FROM paired_shift_view
where exp_id = $exp2
&& motive_name LIKE $motiveName
&& distance <= $limit + 2
&& distance >=  $low_limit - 2
group by distance";


echo date('l jS \of F Y h:i:s A');

/*summit left join peak on peak.peak_id = summit.peak_peak_id 
left join experiment on experiment.experiment_id = peak.experiment_experiment_id 
left join motif_pos on motif_pos.motifpos_id = summit.motif_pos_motifpos_id 
left join consensus_motif on consensus_motif.motif_id = motif_pos.consensus_motif_motif_id 
where experiment.experiment_id = $exp2 
&& consensus_motif.name LIKE $motiveName
group by distance"; 
*/
//order by distance asc";


$sql3 = "SELECT distance, count(distance) as count 
FROM paired_shift_view
where exp_id = $exp3
&& motive_name LIKE $motiveName
&& distance <= $limit + 2 
&& distance >=  $low_limit - 2
group by distance";

echo date('l jS \of F Y h:i:s A');

/*
summit left join peak on peak.peak_id = summit.peak_peak_id 
left join experiment on experiment.experiment_id = peak.experiment_experiment_id 
left join motif_pos on motif_pos.motifpos_id = summit.motif_pos_motifpos_id 
left join consensus_motif on consensus_motif.motif_id = motif_pos.consensus_motif_motif_id 
where experiment.experiment_id = $exp3 
&& consensus_motif.name LIKE $motiveName
group by distance"; 
*/
//order by distance asc";


$sql4 = "SELECT experiment_id, name
FROM experiment";


echo date('l jS \of F Y h:i:s A');

$result = $conn->query($sql);
echo date('l jS \of F Y h:i:s A');
$result2 = $conn->query($sql2);
echo date('l jS \of F Y h:i:s A');
$result3 = $conn->query($sql3);
echo date('l jS \of F Y h:i:s A');
$result4 = $conn->query($sql4);
echo date('l jS \of F Y h:i:s A');


//      genrating data into thisrow

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}
echo date('l jS \of F Y h:i:s A');

//$conn->close();

while($w = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $w;}

echo date('l jS \of F Y h:i:s A');
//$conn->close();

echo date('l jS \of F Y h:i:s A');
while($e = mysqli_fetch_assoc($result3)) {
    $jsonData3[] = $e;}

echo date('l jS \of F Y h:i:s A');

while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}

echo date('l jS \of F Y h:i:s A');

$conn->close();



//these will get the anti agent that was used in the experiment
function split2($string){
$max = strlen($string);
$n = 0;
for($i=0;$i<$max;$i++){
    if($string[$i]=="_"){
        $n++;
        if($n>= 4){
            break;
        }
    }
}

$m = 0;
for($j=0;$j<$max;$j++){
    if($string[$j]=="_"){
            $m++;
        if($m>= 5){

break;
}
    }
}

$arr = substr($string,$i+1,$j-$i-1);

return $arr;
}

//here we add one more column to the results

$ujtomb = array_map("split2", $column);


echo date('l jS \of F Y h:i:s A');
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
 <?php echo " <h2 style='text-align: center;margin-left: 12em;'>	The experiments shown here are the ". $motivePart . " consensus motive.</h1><br>" ?>
 <img src="logo.jpg" alt="NAIK-MBK"  style="position:absolute; top:3px; right:17px; border-radius:50%;"> 
</div>

  <div id="chart" style="width:94% ;background-color: white;border:1px solid black;display:block;float:none;" ></div>

 <div name="logo_chart"  id="logo_chart" style="width:94%; background-color: white;height: 8em;border:1px solid black; ">
 <?php echo "<img src=\"./logos/" . $motivePart . ".jpg\" style=\"width:15%;height:95%;opacity=30%;margin-left: 1em;margin-right: 1px;margin-top: 1px;\"> " ?>
</div>


<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;
var data = <?php echo json_encode($jsonData, JSON_NUMERIC_CHECK);?>;
var data2 = <?php echo json_encode($jsonData2, JSON_NUMERIC_CHECK);?>;
var data3 = <?php echo json_encode($jsonData3, JSON_NUMERIC_CHECK);?>;
var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;

var ujtomb = <?php echo json_encode($ujtomb);?>;
var motive = <?php echo "\"" . $motivePart . "\""; ?>;
var nestedbyantiagent = d3.nest()
  .key(function(d) { return d.antiagent; })
  .entries(data);

var antiagentCount = d3.nest()
  .key(function(d) { return d.antiagent; })
 .key(function(d) { return d.colour_hex; })
  .rollup(function(v) { return v.length; })
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


<script src="drawallshift.js">//this draws the canvas itself
</script>

<script src="drawcubes.js">//this draws the cubes next to the canvas
</script>



<script>
// lets draw the things we need when the page loads
//DrawAllShizStand_dev("std_dev", "average");
//DrawAllShizCubes("data", "notnew");


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
<br>
<div id="buttons" style="text-align: left;width: 40%;display:inline-block;float:none;">

<p>Set the three experiments:</p><br>


  <select id="formexp1" type="text" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
     echo "<option value=". $item['experiment_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }


?>

</select>
 <select id="formexp2" type="text" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
     echo "<option value=". $item['experiment_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
 <select id="formexp3" type="text" value="" placeholder="Type to filter" style="background:#66ff66;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
     echo "<option value=". $item['experiment_id'] .">" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>

<br>
<p>Here you will be able to set the upper and bottom limit of the distance shown. (the parameter set here is the max x and the negative of the minimum x value) </p>

<br>
<p>upper limit</p>
<input id="limit" type="number" min="20" max="35" step="5">
<br>
<p>lower limit</p>
<input id="low_limit" type="number" min="-35" max="-20" step="5">

<br>


<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">

<?php 
//this one puts ALL the options in the select area
$handle = fopen("avg_dev_w_expID.csv", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
     echo "<option>" .$line . "</option>";    // process the line read.
    }

    fclose($handle);
} else {
    // error opening the file.
}
?>

</select>


<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="doSearchShift()" style="width: 14em;"><p>Resend Data</p></button>

<br>
<br>
</div>


<script>
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

var formmotive = <?php echo '"'. $motivePart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var limit = <?php echo  $limit ; ?>;
document.getElementById("limit").value = limit;

var low_limit = <?php echo  $low_limit ; ?>;
document.getElementById("low_limit").value = low_limit;

</script>

</body>

</html>
