<?php
$servername = "localhost";
$username = "sciguest";
$password = "password";
$dbname = "summitdb";
$exp = $_GET['exp'];
$expName = '\''.$exp.'\'';
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
$motiveText = $_GET['motiftext'];
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
$result6 = $conn->query($sql6);
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);

//genrating data into jsondata

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

</head>

<body>


<script>
var margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = 1400 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
var legendtitle = 420;
var maxShift = 99;

var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;

var data7 = <?php echo json_encode($jsonData7, JSON_NUMERIC_CHECK);?>;

var data8 = <?php echo json_encode($jsonData8, JSON_NUMERIC_CHECK);?>;

var data9 = <?php echo json_encode($column1);?>;

var motive = <?php echo "\"" . $motifPart . "\""; ?>;
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


<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<br>
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
$(   "a.formexp1:not([data-antibody='" +  $("#antiformexp1").val() + "'])" ).addClass("disabled" );

  });
}); 


 $( document ).ready(function() {
$('select#cellformexp1').change(function(){

$("a.formexp1").removeClass("cell_unselected");
$("a.formexp1:not([data-celline='" + $("#cellformexp1").val() + "'])" ).addClass("cell_unselected");

$("select#antiformexp1 option").attr('disabled', 'disabled');
$(  "select#antiformexp1 " +  "option[data-celline~=\"" +  $("#cellformexp1").val() + "\"]" )
        .attr( 'disabled', false )

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




<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

<script src="dosearchvenn.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="buttons.js">//this will make the buttons work
</script>


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
