<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$maxID = $_GET['maxid'];
$minID = $_GET['minid'];
$minElem = $_GET['mnelem'];
$maxElem = $_GET['mxelem'];
$expPart = $_GET['exp'];
$expName = '\'%' . $expPart . '%\'';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT anti2cons.antibody_antibody_id, anti2cons.consensus_motif_motif_id AS motifid, antibody.antibody_id AS antiid, antibody.name AS antibody, average_deviation.element_num AS element_num, average_deviation.average AS average, average_deviation.median AS median, average_deviation.experiment_experiment_id AS exp_ID, average_deviation.consensus_motif_motif_id, average_deviation.std_dev AS std_dev, consensus_motif.motif_id, consensus_motif.name AS motive_name, experiment.experiment_id, experiment.name AS exp_name FROM anti2cons LEFT JOIN antibody ON anti2cons.antibody_antibody_id = antibody.antibody_id LEFT JOIN average_deviation ON anti2cons.consensus_motif_motif_id = average_deviation.consensus_motif_motif_id LEFT JOIN consensus_motif ON anti2cons.consensus_motif_motif_id = consensus_motif.motif_id LEFT JOIN experiment ON experiment.experiment_id = average_deviation.experiment_experiment_id  INNER JOIN (SELECT count(name) AS nameCount,name FROM antibody GROUP BY name) s2 ON s2.name = antibody.name WHERE average_deviation.std_dev <= $maxID && average_deviation.std_dev >= $minID && average_deviation.element_num >= $minElem && average_deviation.element_num <= $maxElem && consensus_motif.name LIKE $expName";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data 
        $jsonData = array();
//      genrating data into thisrow

while($r = mysqli_fetch_assoc($result)) {
    $jsonData[] = $r;
}

} else {
    echo "0 results found, go back and try an other motive please.";
}

$conn->close();


$column = array_column($jsonData, 'exp_name');

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



foreach ($jsonData as $i => $value) {
	$jsonData[$i]['antiagent'] = $ujtomb[$i];
}



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
<div id="header">
 <img src="logo.jpg" alt="NAIK-MBK"  style="float: left;border-radius:50%;"> 
 <?php echo " <h2 style='float: left;'>	The experiments shown here are the ones that used the ". $expPart . " as antiagent.</h1><br>" ?>
</div>
  <div id="chart" style="width:84% ;background-color: white;border:1px solid black;" ></div>
  <div id="chart2" style="width:15%;overflow-y: scroll; background-color: white;border:1px solid black;"></div>

<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;
var data = <?php echo json_encode($jsonData, JSON_NUMERIC_CHECK);?>;
var ujtomb = <?php echo json_encode($ujtomb);?>;


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

<script src="drawcubes_exp.js">//this draws the cubes next to the canvas
</script>

<script>
// lets draw the things we need when the page loads
DrawAllShizStand_dev("std_dev", "average");
DrawAllShizCubes("data");
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


//this funky php script will give us the interactive legends
<?php
foreach ( array_unique($ujtomb) as $value) {
echo '$(document).ready(function(){' . "\n" . '$(".' . $value . 'leg").click(function(){' . "\n" . '$(".' . $value . '").fadeToggle("slow");' . "\n" . '});' . "\n" . '});' . "\n \n"   ;
}
echo '$(document).ready(function(){' . "\n" . '$(".' . $value . 'leg").removeClass("new")});' . "\n";

//
echo '$("#refresh").children().click(function(){ console.log("cubefiddling")});' . "\n";

?>
//' . "\n" . '$(".' . $value . 'leg").click(function(){' . "\n" . '$(".' . $value . '").fadeToggle("slow");' . "\n" . '});' . "\n" . '});' . "\n \n"   ;
//}
//?> 
</script>
<div style="text-align: left;width: 40%;">
<p>This form will change the maximum and minimum average deviation value of the dots shown. Try using integers please. </p> <br> <p>Smallest average deviation goes here.</p>
<form action="#" id="form_field"> <input type="text" id="textboxmin" value="integer please"> 
</form>

<p>Max average deviation</p>

<form action="#" id="form_field"> <input type="text" id="textboxmax" value="integer please"> 
</form>

<p>Minimum number of elements in the experiment.</p>

<form action="#" id="form_field"> <input type="text" id="textboxmnelem" value="integer please"> 
</form>

<p>Maximum number of elements in the experiment.</p>

<form action="#" id="form_field"> <input type="text" id="textboxmxelem" value="integer please"> 
</form>


<p>Select a motive:</p><br>
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
<p>Using this button will resend information from our database, so it may take be time consuming.</p>

<button onclick="doSearch()" style="width: 14em;"><p>Resend Data</p></button>
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
<div style="text-align: left;width: 40%;">
  <div style="float: left;width: 23%;height:100%;">
  </div>
  <p>Using these buttons will help you change the way the information is shown by changing the Y (vertical) column value.</p>
  <button onclick="updatestand_dev()"> <p>stand dev vs average</p></button><br><br>
  <button onclick="updateelem_num()"> <p>element number vs average</p></button><br><br>
  <button onclick="update_avg_med()"> <p>average vs median</p></button><br><br><br>
</div>
<div id="refresh" style="float: right; width:15%;">
  <div style="float: left;width: 55%;">
<br><br>
 <button id="nodotz" onclick="" style="width: 12em;"> <p>Toggle all dots out.</p></button><br><br>
  <button id="yesdotz" onclick="" style="width: 12em;"> <p>Toggle all dots in.</p></button><br><br><br><br>
 
    <button onclick="update_alphabet()" class="cubefiddler"> <p>cubes arranged alphabetically</p></button><br><br>
    <button onclick="update_nonalphabet()" class="cubefiddler"> <p>cubes arranged nonalphabetically</p></button><br><br>

</div>
</div>

<script>
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

<?php

foreach ( array_unique($ujtomb) as $value) {
echo '$("#refresh").children().click(function(){' . "\n" . '$(".' . $value . 'leg.new").click(function(){' . "\n" . '$(".' . $value . '").fadeToggle("slow");' . "\n" . '});' . "\n" . '});' . "\n \n"   ;
echo '$("#refresh").children().click(function(){' . "\n" . '$(".' . $value . 'leg").removeClass("new")});' . "\n";
echo '$("#refresh").children().click(function(){ console.log("cubefiddling")});' . "\n";
}
?>;

</script>

</body>

</html>
