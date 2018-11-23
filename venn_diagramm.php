<?php
include("config.php");
include("threeexpbox.php");
include("templates/header.php");

$exp1Name = $_GET['exp1'];
$exp2Name = $_GET['exp2'];
$exp3Name = $_GET['exp3'];
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

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

//generating results

$jsonData1 = getMotifPos($conn, $motifName, $exp1Name);
$jsonData2 = getMotifPos($conn, $motifName, $exp2Name);
$jsonData3 = getMotifPos($conn, $motifName, $exp3Name);
$result6 = $conn->query($sql6);

$jsonData1start = getExpCellAntiBody($conn, $exp1Name);
$jsonData2start = getExpCellAntiBody($conn, $exp2Name);
$jsonData3start = getExpCellAntiBody($conn, $exp3Name);

$allExperiment = getAllExpCellAnti($conn, $motifPart, $minElem);

//genrating data into jsondata
$jsonData6 = fetchAssoc($result6);

$conn->close();

$size1 = sizeof($jsonData1, JSON_NUMERIC_CHECK);
$size2 = sizeof($jsonData2, JSON_NUMERIC_CHECK);
$size3 = sizeof($jsonData3, JSON_NUMERIC_CHECK);

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
<script src="threeexpbox.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-121648705-1');

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

    $( document ).ready(function() {
        <?php expJS($allExperiment, $jsonData1start, $jsonData2start, $jsonData3start);?>

        $('#antiformexp1v2').prepend('<?php echo fillCells($allExperiment, $jsonData1start[0]["antibody"], "antibody");?>');
        $('#antiformexp2v2').prepend('<?php echo fillCells($allExperiment, $jsonData2start[0]["antibody"], "antibody");?>');
        $('#antiformexp3v2').prepend('<?php echo fillCells($allExperiment, $jsonData3start[0]["antibody"], "antibody");?>');

        fillSelect("#cellformexp1v2", data1start[0].antibody, allExperiment, data1start[0].cell_line, "antibody", "cell_line");
        fillSelect("#cellformexp2v2", data2start[0].antibody, allExperiment, data2start[0].cell_line, "antibody", "cell_line");
        fillSelect("#cellformexp3v2", data3start[0].antibody, allExperiment, data3start[0].cell_line, "antibody", "cell_line");
 
        fillExpByAntiCell('#formexp1v2', data1start[0].antibody, data1start[0].cell_line, allExperiment, data1start[0].name);
        fillExpByAntiCell('#formexp2v2', data2start[0].antibody, data2start[0].cell_line, allExperiment, data2start[0].name);
        fillExpByAntiCell('#formexp3v2', data3start[0].antibody, data3start[0].cell_line, allExperiment, data3start[0].name);

        $('#antiformexp1v2').change(function(){
            fillSelect('#cellformexp1v2', $('#antiformexp1v2').val(), allExperiment, "", "antibody", "cell_line");
            fillExpByAntiCell('#formexp1v2', $('#antiformexp1v2').val(), $('#cellformexp1v2').val(), allExperiment);
        });

        $('#antiformexp2v2').change(function(){
            fillSelect('#cellformexp2v2', $('#antiformexp2v2').val(), allExperiment, "", "antibody", "cell_line");
            fillExpByAntiCell('#formexp2v2', $('#antiformexp2v2').val(), $('#cellformexp2v2').val(), allExperiment);
        });

        $('#antiformexp3v2').change(function(){
            fillSelect('#cellformexp3v2', $('#antiformexp3v2').val(), allExperiment, "", "antibody", "cell_line");
            fillExpByAntiCell('#formexp3v2', $('#antiformexp3v2').val(), $('#cellformexp3v2').val(), allExperiment);
        });

        $('#cellformexp1v2').change(function(){
            fillExpByAntiCell('#formexp1v2', $('#antiformexp1v2').val(), $('#cellformexp1v2').val(), allExperiment);
        });

        $('#cellformexp2v2').change(function(){
            fillExpByAntiCell('#formexp2v2', $('#antiformexp2v2').val(), $('#cellformexp2v2').val(), allExperiment);
        });

        $('#cellformexp3v2').change(function(){
            fillExpByAntiCell('#formexp3v2', $('#antiformexp3v2').val(), $('#cellformexp3v2').val(), allExperiment);
        });

        document.getElementById("formmotive").value = <?php echo '"'. $motifPart . '"'; ?>; 
    }); 

</script>
</head>
<body>
<?php show_small_navigation("Help");?>
<h4 style="margin:auto;text-align:center;font-size:1.3em;padding-bottom:3em;padding-top:10em;">Venn diagramm view</h4>
<div id="glossary" style="width:99% ;background-color: white;border:1px solid black;height:55em;display:none;z-index: 11;">
 <iframe id="ifrm" src="http://summit.med.unideb.hu/summitdb/glossary.html"  frameborder="0" scrolling="yes" style="width:100% ;background-color: white;height:100%;">
</iframe>
</div>

<div id="chart_venn" >

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

 <table style="width:90%;top:99em;">
<tr style="color:red;">
    <td>experiment name:</td>
    <td id="texpName1"><?php echo $jsonData1start[0]["name"];?></td>
    <td>antibody:</td>
    <td id="tantibody1"><?php echo $jsonData1start[0]["antibody"];?></td>
    <td>cell line:</td>
    <td id="tcelline1"><?php echo $jsonData1start[0]["cell_line"];?></td>
    <td>consensus motif binding sites:</td>
    <td id="tcons1"><?php echo $size1;?></td>
  </tr>
<tr style="color:blue;">
    <td>experiment name:</td>
    <td id="texpName2"><?php echo $jsonData2start[0]["name"];?></td>
    <td>antibody:</td>
    <td id="tantibody2"><?php echo $jsonData2start[0]["antibody"];?></td>
    <td>cell line:</td>
    <td id="tcelline2"><?php echo $jsonData2start[0]["cell_line"];?></td>
    <td>consensus motif binding sites:</td>
    <td id="tcons2"><?php echo $size2;?></td>
  </tr>
<tr style="color:green;">
    <td>experiment name:</td>
    <td id="texpName3"><?php echo $jsonData3start[0]["name"];?></td>
    <td>antibody:</td>
    <td id="tantibody3"><?php echo $jsonData3start[0]["antibody"];?></td>
    <td>cell line:</td>
    <td id="tcelline3"><?php echo $jsonData3start[0]["cell_line"];?></td>
    <td>consensus motif binding sites:</td>
    <td id="tcons3"><?php echo $size3;?> </td>
  </tr>
</table>
</div>

  <div name="chart4"  id="chart4" style="width:15%; background-color: white;height: 11em;border:1px solid black; ">
<p style="margin-left:5px;margin-top:3px;margin-bottom:0px;">Position weight matrix for selected motif.</p>
 <?php echo "<img src=\"./logos/" . $motifText . ".jpg\" style=\"width:95%;height:61%;opacity=30%;margin-left: 1em;margin-right: 1px;margin-top: 1px;\"  alt=\"No picture available!\" > " ?>
</div>

<div style="height:5em;padding:0.5em;">
<a target="_blank" href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=<?php echo $motifText;?>">
<button class="paired_button" onclick="">Go to selected motif's view</button>
</a>

<a target="_blank" href="http://summit.med.unideb.hu/jbrowse/index.html?tracks=DNA,ucsc-known-genes,mot-<?php echo $motifPart ;?>,example_track1,example_track2,example_track3& addStores={        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp1Name; ?>.bed%22}        %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp2Name; ?>.bed%22} %22example_track1%22:{%22type%22:%22JBrowse/Store/SeqFeature/BED%22,%22baseUrl%22:%22.%22,%22urlTemplate%22:%22{dataRoot}/summits/summit-<?php echo $exp3Name; ?>.bed%22} }& addTracks=[   {%22label%22:%22example_track1%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track1%22} {%22label%22:%22example_track2%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track2%22} {%22label%22:%22example_track3%22,%22type%22:%22JBrowse/View/Track/CanvasFeatures%22,%22store%22:%22example_track3%22}]%22">
<button class="paired_button" onclick="">View in jbrowse</button>
</a>
</div>

<script>
var data = <?php echo $size1;?>;
var data2 = <?php echo $size2;?>;
var data3 = <?php echo $size3;?>;

<?php
$inter1i2 = sizeof(array_merge($jsonData1,$jsonData2)) - sizeof(array_unique(array_merge($jsonData1,$jsonData2), SORT_REGULAR));
$inter1i3 = sizeof(array_merge($jsonData1,$jsonData3)) - sizeof(array_unique(array_merge($jsonData1,$jsonData3), SORT_REGULAR));
$inter2i3 = sizeof(array_merge($jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData2,$jsonData3), SORT_REGULAR));
?>

var intersect1_2_3 = <?php 
if ($size1 === 0 || $size2 === 0 || $size3 === 0){
 echo "0";

} else {
echo -(sizeof(array_merge($jsonData1,$jsonData2,$jsonData3)) - sizeof(array_unique(array_merge($jsonData1,$jsonData2,$jsonData3), SORT_REGULAR)) -
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
<button class="paired_button" onclick="doSearchShift('_blank')">View data in paired shift view</button>
<button class="paired_button" onclick="vennBed()">Download bed file for genome view</button>

<br id="limit" value=25><br id="low_limit" value=-25>

<script>//this one works for the venn diagramm bed download

function vennBed() {

    var skillsSelect = document.getElementById("formmotive");
    var motive       = skillsSelect.options[skillsSelect.selectedIndex].text;
    var firstexp1    = parseInt(document.getElementById("formexp1").value) || "undefined";
    var secondexp2   = parseInt(document.getElementById("formexp2").value) || "undefined";
    var thirdexp3    = parseInt(document.getElementById("formexp3").value) || "undefined";

    window.location = "http://summit.med.unideb.hu/summitdb/venn_downloads.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive);
};

</script>

<br>

<div style="height:35em;">
<?php expBoxes(); ?>
<br>

<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend" onclick="doSearchVenn()" style="width: 14em;"><p>Refresh Page</p></button>

</div>
<br>
<div>
<div style="width:100%;height:7em;">

<p>
Antibody oriented search<br><br>
In this mode, two or three experiments can be compared as above. Here the seach starts with designating the antibody and the cell type afterwards. 
</p>
</div>

<div class="wrapper">

<select id="cellformexp1v2" class="two" type="text" value="" placeholder="Type to filter" style="background:#ff6666;">
</select>


<select id="antiformexp1v2" type="text" class="one" value="" placeholder="Type to filter" style="background:#ff6666;">
</select>

<select id="formexp1v2" type="text" value="" class="three" placeholder="Type to filter"  style="background:#ff6666;">
</select>
<button class="threeAH" onclick="jumptoexp('formexp1v2')"> experiment view </button>
<br>
<select id="cellformexp2v2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">
</select>

<select id="antiformexp2v2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">
</select>

<select id="formexp2v2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">
</select>
<button class="sixAH" onclick="jumptoexp('formexp2v2')"> experiment view </button>
<br>

<select id="cellformexp3v2" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">
</select>

<select id="antiformexp3v2" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">
</select>

<select id="formexp3v2" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
</select>
<button class="nineAH" onclick="jumptoexp('formexp3v2')"> experiment view </button>

<br>
<br>
<br>

</div>
<br>
<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend2" onclick="doSearchVenn2()" style="width: 14em;"><p>Refresh Page</p></button>

</div>
</div>

<script>

var formminelem = getAllUrlParams().mnelem;
document.getElementById("textboxmnelem").value = formminelem;

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
<div style="width:100%">

<p>
VennView<br><br>
In this mode, two or three experiments can be compared. The values in the sections of the diagram indicates the number of common and specific peaks at a consensus motif binding site.
</p>
<br>
<p>
Copyright © 2018    Mátyás Schiller,  Erik Czipa, Levente Kontra, Tibor Nagy, Júlia Koller,
Orsolya Pálné Szén, Csaba Papp, László Steiner, Ferenc Marincs and Endre Barta
</p>
</div>

</body>
</html>
