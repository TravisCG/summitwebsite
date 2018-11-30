<?php
include("config.php");
include("templates/header.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

$result6 = $conn->query($sql6);

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
<script src="dosearch.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>
<script>
function dochange(target) { window.open(target,"_self");};
</script>
</head>
<body>
<?php show_full_navigation();?>

<div id="maincontent">
<div id="buttons" class="halfdiv" >
<p>This form will change the maximum and minimum average deviation value of the dots shown. Try using integers please. </p> <br> 
<p>Minimum standard deviation</p>
<form action="#" id="form_field">
<input type="text" id="textboxmin" value="1"> 
<p>Maximum standard deviation</p>
<input type="text" id="textboxmax" value="10000"> 
<p>Minimum overlap number between motifs and peaks of experiment</p>
<input type="text" id="textboxmnelem" value="100"> 
<p>Maximum overlap number between motifs and peaks of experiment</p>
<input type="text" id="textboxmxelem" value="120000">
</form>

<p>Set a motif:</p><br>
  <select id="formmotive" type="text" value="CTCF" placeholder="Type to filter">
<?php
//this one puts ALL the options in the select area
foreach($jsonData6 as $item){
     echo "<option>" . $item['name'] . "</option>" ;    // process the line read.
    }
?>
</select>
<p>When te parameters have been set, this button will refresh the page.</p>
<button id="resend" onclick="doSearch('_self')" ><p>Go to motif view</p></button>
</div>
<div id="motifdesc">
<p>
MotifView <br>
In this mode, the average distances between the peak of the reads obtained in a ChIP-seq experiment and a given consensus motif on a scatterplot graph is visualized. Each scatter represents an experiment. Circles represent transcription factors with defined binding sites, while triangles represent co-factors and other indirectly bound proteins. Different colors indicate the antibody used in the immune precipitation. The X-axis shows the average distances of peak summits and the center of the binding sites for all overlapping peaks. The Y-axis shows either the number of overlapping peaks (elements) or, in default mode, the standard deviation of the shift values (distances) between the peak summits and motif centers. This scatterplot representation is available for all consensus binding motif sets.
The displayed data can be filtered by the number of overlapping peaks (element number) or by the standard deviation. Data can be also displayed based on the used antibody or cell type. Averages of experiments obtained by the same antibody in different experiments can be also calculated and shown.
After selecting maximum three experiments, links are available to switch to other views.  
</p>
</div>
</div>
</body>
</html>
