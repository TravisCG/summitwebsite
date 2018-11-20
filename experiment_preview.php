<?php
include("config.php");
include("templates/header.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//queries

$sql4 = "SELECT experiment_id, experiment.name  AS name, antibody_antibody_id AS antibody_id, cell_lines_cellline_id
FROM experiment
";

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
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);

//genrating data into jsondata

while($es = mysqli_fetch_assoc($result4)) {
    $jsonData4[] = $es;}

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

<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="master.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>
function dochange(target) { window.open(target,"_self");};
</script>
</head>

<body>
<?php show_header();?>
<div>
<br>
<br>
<br>
<br>

<p>After selecting the cell line and the antibody, the corresponding experiments appears in a separate box and can be selected for displaying in the Experiment view.</p>

<div>
<div class="wrapper">

<select id="cellformexp1" class="one" type="text" value="" placeholder="Type to filter" style="background:#cccccc;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id']  . " class=\"formexp1\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp1" type="text" class="two" value="" placeholder="Type to filter" style="background:#cccccc;">

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
        $("a.formexp1").removeClass("disabled");
        $("a.formexp1:not([data-antibody='" +  $("#antiformexp1").val() + "'])" ).addClass("disabled");
    });

    $('select#cellformexp1').change(function(){
        $("a.formexp1").removeClass("cell_unselected");
        $("a.formexp1:not([data-celline='" + $("#cellformexp1").val() + "'])" ).addClass("cell_unselected");

        $("select#antiformexp1 option").attr('disabled', 'disabled');
        $("select#antiformexp1 " +  "option[data-celline~=\"" +  $("#cellformexp1").val() + "\"]" ).attr( 'disabled', false )
    });

});
</script>


<div class="three" style="overflow-y: scroll;background:#cccccc;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<a class=\"formexp1 visible\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " href=\"experiment_view.php?exp=" .$item['experiment_id'] . "\" target=\"_blank\" " . ">" . $item['name'] . "</a>" ;    // process the line read.
    }
?>
</div>

<br>
<br>
</div>
<br>
<br>
</div>
<p>
ExperimentView<br><br>
In this mode, the details of any  ChIP-seq experiment can be seen. 
<br>The displayed information includes the SRA links, the number of reads, 
<br>the antibody used, the mapped reads and the number of peaks. 
<br>The result of the HOMER denovo motif prediction can be also seen. 
<br>Experiments incorporated into ChIPSummitDB can be searched for display. 
</p>

</body>

</html>
