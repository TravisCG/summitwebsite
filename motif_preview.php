<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
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


$sql2 = "SELECT motif_id 
FROM consensus_motif WHERE name LIKE $motiveName";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

$result2 = $conn->query($sql2);
$result6 = $conn->query($sql6);


$jsonData2 = array();

while($r2 = mysqli_fetch_assoc($result2)) {
    $jsonData2[] = $r2;
}

while($ew6 = mysqli_fetch_assoc($result6)) {
    $jsonData6[] = $ew6;}
$conn->close();


$conn->close();

//$column1 = array_column($jsonData, 'cell_line');
//$column2 = array_column($jsonData, 'antibody');
//$column3 = array_unique ( array_merge ($column1 , $column2 ));


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
var legendtitle = 420;
var maxShift = 99;
var data = <?php echo json_encode($jsonData, JSON_NUMERIC_CHECK);?>;
var ujtomb = <?php echo json_encode($column3);?>;
var nestedbyantiagent = d3.nest()
  .key(function(d) { return d.antibody; })
  .entries(data);
var motifid = <?php echo json_encode($jsonData2, JSON_NUMERIC_CHECK);?>;



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

<div id="buttons" style="text-align: left;width: 40%;">
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


<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option>" . $item['name'] . "</option>" ;    // process the line read.
    }
?>


</select>
<p>When te parameters have been set, this button will refresh the page.</p>

<button id="resend" onclick="dopreSearch()" style="width: 14em;"><p>Go to motif view</p></button>

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

<script>


// this function will bind the enter to the resend button
$(document).keypress(function(e){
    if (e.which == 13){
        $("#resend").click();
    }
});



//here we will set the form boxes to be by default what they were in the url originally

var formmaxid = 10000;
document.getElementById("textboxmax").value = formmaxid;

var formminid = 1;
document.getElementById("textboxmin").value = formminid;

var formminelem = 100;
document.getElementById("textboxmnelem").value = formminelem;

var formmaxelem = 120000;
document.getElementById("textboxmxelem").value = formmaxelem;

var formmotive = "CTCF";
document.getElementById("formmotive").value = formmotive;

</script>

<div style="width:48%;float:right;">
<p>
MotifView <br>
In this mode, the average distances between the peak of the reads obtained in a ChIP-seq experiment and a given consensus motif on a scatterplot graph is visualized. Each scatter represents an experiment. Circles represent transcription factors with defined binding sites, while triangles represent co-factors and other indirectly bound proteins. Different colors indicate the antibody used in the immune precipitation. The X-axis shows the average distances of peak summits and the center of the binding sites for all overlapping peaks. The Y-axis shows either the number of overlapping peaks (elements) or, in default mode, the standard deviation of the shift values (distances) between the peak summits and motif centers. This scatterplot representation is available for all consensus binding motif sets.
The displayed data can be filtered by the number of overlapping peaks (element number) or by the standard deviation. Data can be also displayed based on the used antibody or cell type. Averages of experiments obtained by the same antibody in different experiments can be also calculated and shown.
After selecting maximum three experiments, links are available to switch to other views.  
</p>
</div>
</body>

</html>
