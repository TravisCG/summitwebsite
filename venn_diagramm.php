<?php
include("config.php");
include("threeexpbox.php");
include("templates/header.php");
include("templates/footer.php");

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

$link_base = "<a href=\"intersect_dist.php?exp1=" . $exp1Name . "&exp2=" . $exp2Name . "&exp3=" . $exp3Name . "&motive=" . $motifText . "&motifid=" . $motifPart . "&limit=25&low_limit=-25&slice=";

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>NAIK Genome Database</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<meta name="Description" content="A database containing genomic data that was analysed and meta analysed by the Bioinformatics Research Group of the NAIK MBK.">

<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="master.css" />
<link rel="stylesheet" type="text/css" href="venn_diagramm.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js"></script>
<script src="threeexpbox.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-121648705-1');


    $( document ).ready(function() {
        <?php expJS($allExperiment, $jsonData1start, $jsonData2start, $jsonData3start);?>

        document.getElementById("formmotive").value = <?php echo '"'. $motifPart . '"'; ?>; 
    }); 

  function dochange(target) { window.open(target,"_blank");};

</script>
</head>
<body>
<div class="bootstraptooltip" id="vennpaneltooltip">
In this panel, you can see some basic information about the selected ChIP-seq experiments: name; antibody; cell line and consensus motif binding sites (The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set). The background colours indicate the cluster colours of the experiments on the venn diagram.
</div>
<div class="bootstraptooltip" id="venntooltip">
The Venn diagram represents the number of overlaps between the adjusted motif and the peaks of selected ChIP-seq experiments. The sections of sets indicates the number of simultaneous occupancies of peaks on binding sites. The colors of sets are congruent with the information panel above and the dropdown boxes below.
</div>
<div class="bootstraptooltip" id="mvtooltip">
Find the average/median protein positional and occupancy frequency information on a set of given transcription factor binding sites in MotifView.
</div>
<div class="bootstraptooltip" id="gbtooltip">
Browse genomic data of selected experiment in genome browser.
</div>
<div class="bootstraptooltip" id="psvtooltip">
Check the distance distribution of selected experiment as frequency histograms  in PairShiftView.
</div>
<div class="bootstraptooltip" id="dtooltip">
Download genomic data of last selected experiment in BED format.
</div>
<?php show_full_navigation();?>
<h4>VennView</h4>
<div id="chart_venn" >

<div id="circle" class="venn_circle"></div>
<div id="circle2" class="venn_circle"></div>
<div id="circle3" class="venn_circle"></div>

<p id="data">placeholder</p>
<p id="data2">placeholder</p>
<p id="data3">placeholder</p>
<p id="data1i2">placeholder</p>
<p id="data1i3">placeholder</p>
<p id="data2i3">placeholder</p>
<p id="data1i2i3">placeholder</p>

<table class="venntable">
  <thead>
    <tr>
      <td>Experiment name</td>
      <td>Antibody</td>
      <td>Cell line</td>
      <td>Consensus motif binding sites</td>
    </tr>
  </thead>
  <tbody>
    <tr class="exp1">
      <td id="texpName1"><?php echo $jsonData1start[0]["name"];?></td>
      <td id="tantibody1"><?php echo $jsonData1start[0]["antibody"];?></td>
      <td id="tcelline1"><?php echo $jsonData1start[0]["cell_line"];?></td>
      <td id="tcons1"><?php echo $size1;?></td>
    </tr>
    <tr class="exp2">
      <td id="texpName2"><?php echo $jsonData2start[0]["name"];?></td>
      <td id="tantibody2"><?php echo $jsonData2start[0]["antibody"];?></td>
      <td id="tcelline2"><?php echo $jsonData2start[0]["cell_line"];?></td>
      <td id="tcons2"><?php echo $size2;?></td>
    </tr>
    <tr class="exp3">
      <td id="texpName3"><?php echo $jsonData3start[0]["name"];?></td>
      <td id="tantibody3"><?php echo $jsonData3start[0]["antibody"];?></td>
      <td id="tcelline3"><?php echo $jsonData3start[0]["cell_line"];?></td>
      <td id="tcons3"><?php echo $size3;?> </td>
    </tr>
  </tbody>
</table>
<img src="images/info.png" class="infobutton" id="vennhelp" />
</div>

<div id="motifbuttons" >
  <div name="chart4"  id="chart4">
    <p>Position weight matrix for selected motif.</p>
    <?php echo "<img src=\"./logos/" . $motifText . ".jpg\" alt=\"No picture available!\" > " ?>
  </div>
  The following buttons will navigate you to different views of currently plotted data.<br />
  <a target="_blank" href="https://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=100&mxelem=120000&motive=<?php echo $motifText;?>">
  <button class="paired_button" onclick="">MotifView</button>
  </a>

  <a target="_blank" href="https://summit.med.unideb.hu/jbrowse/index.html?loc=chr10%3A46391892..47806389&tracks=DNA%2Cucsc-known-genes%2Cmot-<?php echo $motifPart;?>%2Cexp-<?php echo $exp1Name;?>%2Cexp-<?php echo $exp2Name;?>%2Cexp-<?php echo $exp3Name;?>&highlight=">
  <button class="paired_button" onclick="">GenomeView</button>
  </a>
  <button class="paired_button" onclick="doSearchShift('_blank', '')">View data in PairedShiftView</button>
  <button class="paired_button" onclick="vennBed()" title="Download genomic position of motifs which overlap with the selected ChIP-seq experiments in a single BED file. The motifs are labeled with the overlapping experiment's name and color code.">Download BED file</button>
  <img src="images/info.png" class="infobutton" id="buttonhelp" />
</div>

<script src="urlgetter.js">//this one gets the options out of the url and make them an object
</script>

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


<div id="maincontent">
<br>
<p>Set a motif:</p>
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
</p>
<br id="limit" value=25>
<br id="low_limit" value=-25>

<script>//this one works for the venn diagram bed download

function vennBed() {

    var skillsSelect = document.getElementById("formmotive");
    var motive       = skillsSelect.options[skillsSelect.selectedIndex].text;
    var firstexp1    = parseInt(document.getElementById("formexp1").value) || "undefined";
    var secondexp2   = parseInt(document.getElementById("formexp2").value) || "undefined";
    var thirdexp3    = parseInt(document.getElementById("formexp3").value) || "undefined";

    window.location = "https://summit.med.unideb.hu/summitdb/venn_downloads.php?exp1=" + encodeURIComponent(firstexp1) + "&exp2=" + encodeURIComponent(secondexp2) + "&exp3=" + encodeURIComponent(thirdexp3)  + "&motive=" + encodeURIComponent(motive);
};

</script>

<div>
<?php expBoxes(); ?>
<br>

<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend" onclick="doSearchVenn()"><p>Refresh Page</p></button>

</div>
<br>
<div>
  <p>
  Antibody oriented search<br><br>
  In this mode, two or three experiments can be compared as above. Here the seach starts with designating the antibody and the cell type afterwards. 
  </p>
</div>
<?php expBoxesCell(); ?>
<br>
<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend2" onclick="doSearchVenn2()" ><p>Refresh Page</p></button>
<script>

var formminelem = getAllUrlParams().mnelem;
document.getElementById("textboxmnelem").value = formminelem;

//this will generate the venn diagram for us
var link  = '<?php echo $link_base; ?>';
document.getElementById("data").innerHTML = link + 'A">' + (data - intersect1_2 - intersect1_3 + intersect1_2_3) + "</a>"; 
document.getElementById("data2").innerHTML = link + 'B">' + (data2 - intersect1_2 - intersect2_3 + intersect1_2_3) + "</a>";
document.getElementById("data3").innerHTML = link + 'C">' + (data3 - intersect1_3 - intersect2_3 + intersect1_2_3) + "</a>";
document.getElementById("data1i2").innerHTML = link + 'AB">' + (intersect1_2 - intersect1_2_3) + "</a>";
document.getElementById("data1i3").innerHTML = link + 'AC">' + (intersect1_3 - intersect1_2_3) + "</a>"; 
document.getElementById("data2i3").innerHTML = link + 'BC">' + (intersect2_3 - intersect1_2_3) + "</a>";
document.getElementById("data1i2i3").innerHTML = link + 'ABC">' + (intersect1_2_3) + "</a>"; 

$("#vennhelp").click(function(event){
  $("#vennpaneltooltip").toggle();
  $("#venntooltip").toggle();
});

$("#buttonhelp").click(function(event){
  $("#mvtooltip").toggle();
  $("#gbtooltip").toggle();
  $("#psvtooltip").toggle();
  $("#dtooltip").toggle();
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js">
</script>


<script src="dosearch.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>

<script src="dosearchvenn.js">//this searches the brackets and makes the new url THE NEW URL IS HERE? IF IT HAS TO BE MODIFIED!!!! 
</script>
<div>
<p>VennView</p>
<p>In this mode, two or three experiments can be compared. The values in the sections of the diagram indicates the number of common and specific peaks at a consensus motif binding site.</p>
</div>
</div>
<?php show_footer();?>
</body>
</html>
