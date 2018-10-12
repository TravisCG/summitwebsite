<?php
include("config.php");

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

function fetchAssoc($res) {
  while( $r = mysqli_fetch_assoc($res)){
    $assoc[] = $r;
  }
  return($assoc);
}

function getMotifPos($conn, $motifName, $expName){
  $sql = "SELECT motifpos_id FROM venn_view WHERE motif_id = $motifName AND experiment_id = $expName";
  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

function getExpCellAntiBody($conn, $expName){
  $sql = "SELECT experiment.name, cell_lines.name AS cell_line, antibody.name AS antibody, antibody.antibody_id AS antid, cell_lines.cellline_id AS cellid
          FROM
          experiment
          LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
          LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
          WHERE experiment.experiment_id = $expName";
  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

//TODO: May I need to add motif name and minimum overlap?
function getAntiBodyFromCell($conn, $cellline){
  $sql = "SELECT distinct(antibody.name) AS antibody, antibody_id, cellline_id FROM experiment LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id WHERE cell_lines.name = '$cellline';";
  $res = $conn->query($sql);
  $assoc = fetchAssoc($res);
  return($assoc);
}

$sql4 = "SELECT experiment_id, CONCAT(experiment.name, ' elem_num: ' , average_deviation.element_num)  AS name, antibody_antibody_id AS antibody_id, cell_lines_cellline_id
FROM experiment
LEFT JOIN average_deviation ON average_deviation.experiment_experiment_id = experiment.experiment_id
WHERE average_deviation.consensus_motif_motif_id = $motifName
&& average_deviation.element_num >= $minElem
";

$sql6 = "SELECT name, motif_id 
FROM consensus_motif";

$sql7 = "SELECT distinct cell_lines_cellline_id, cell_lines.name AS cell_line , antibody.antibody_id as antibody
FROM average_deviation
LEFT JOIN experiment ON experiment.experiment_id = average_deviation.experiment_experiment_id
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
LEFT JOIN consensus_motif ON consensus_motif.motif_id = average_deviation.consensus_motif_motif_id
where consensus_motif.motif_id = $motifName
&& average_deviation.element_num >= $minElem
Group by cell_line
ORDER BY cell_line";

$sql8 = "SELECT DISTINCT antibody.name AS antibody, experiment.antibody_antibody_id AS antibody_id, GROUP_CONCAT(cell_lines.cellline_id SEPARATOR ' ') AS cellline_id
FROM experiment 
LEFT JOIN antibody ON antibody.antibody_id = experiment.antibody_antibody_id 
LEFT JOIN cell_lines ON cell_lines.cellline_id = experiment.cell_lines_cellline_id
group by antibody_antibody_id, antibody

ORDER BY antibody";


//generating results

$jsonData1 = getMotifPos($conn, $motifName, $exp1Name);
$jsonData2 = getMotifPos($conn, $motifName, $exp2Name);
$jsonData3 = getMotifPos($conn, $motifName, $exp3Name);
$result4 = $conn->query($sql4);
$result6 = $conn->query($sql6);
$result7 = $conn->query($sql7);
$result8 = $conn->query($sql8);

$jsonData1start = getExpCellAntiBody($conn, $exp1Name);
$jsonData2start = getExpCellAntiBody($conn, $exp2Name);
$jsonData3start = getExpCellAntiBody($conn, $exp3Name);


//genrating data into jsondata
$jsonData4 = fetchAssoc($result4);
$jsonData6 = fetchAssoc($result6);
$jsonData7 = fetchAssoc($result7);
$jsonData8 = fetchAssoc($result8);

$antibody1 = getAntiBodyFromCell($conn, $jsonData1start[0]['cell_line']);
$antibody2 = getAntiBodyFromCell($conn, $jsonData2start[0]['cell_line']);
$antibody3 = getAntiBodyFromCell($conn, $jsonData3start[0]['cell_line']);

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

    //makes the three jump to experiment view buttons work
    function jumptoexp(expelement) {
        var expID = parseInt(document.getElementById(expelement).value) || "undefined";
        var adresshift = "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + encodeURIComponent(expID);
        window.open(adresshift, '_blank');
    }

    $( document ).ready(function() {
        $('select#antiformexp1').change(function(){
            $("select#formexp1 option").attr('disabled', false);
            $(  "select#formexp1 " +  "option:not([data-antibody='" +  $("#antiformexp1").val() + "'])" ).attr( "disabled", "disabled" )
        });
    
        $('select#antiformexp2').change(function(){
            $("select#formexp2 option").attr('disabled', false);
            $(  "select#formexp2 " +  "option:not([data-antibody='" +  $("#antiformexp2").val() + "'])" ).attr( "disabled", "disabled" )
        });
    
        $('select#antiformexp3').change(function(){
            $("select#formexp3 option").attr('disabled', false);
            $(  "select#formexp3 " +  "option:not([data-antibody='" +  $("#antiformexp3").val() + "'])" ).attr( "disabled", "disabled" )
        });
    
        $('#min_field').change(function(){
            $.minimal =  document.getElementById('min_field')[0].value;
            $("select#formexp1 option").removeClass("toolittle");
            $("select#formexp1 " + "option([data-celline > '" + $.minimal + "'])" ).addClass("toolittle");
        });
    
        $('select#cellformexp1').click(function(){
            $("select#antiformexp1").attr('disabled', false);
            $("select#formexp1 option").removeClass("cell_unselected");
            $("select#formexp1 " + "option:not([data-celline='" + $("#cellformexp1").val() + "'])" ).addClass("cell_unselected");
            $("select#antiformexp1 option").attr('disabled', 'disabled');
            $(  "select#antiformexp1 " +  "option[data-celline~=\"" +  $("#cellformexp1").val() + "\"]" ).attr( 'disabled', false )
        });
    
        $('select#cellformexp2').click(function(){
            $("select#antiformexp2").attr('disabled', false);
            $("select#formexp2 option").removeClass("cell_unselected");
            $("select#formexp2 " + "option:not([data-celline='" + $("#cellformexp2").val() + "'])" ).addClass("cell_unselected");
            $("select#antiformexp2 option").attr('disabled', 'disabled');
            $(  "select#antiformexp2 " +  "option[data-celline~=\"" +  $("#cellformexp2").val() + "\"]" ).attr( 'disabled', false )
        });
    
        $('select#cellformexp3').click(function(){
            $("select#antiformexp3").attr('disabled', false);
            $("select#formexp3 option").removeClass("cell_unselected");
            $("select#formexp3 " + "option:not([data-celline='" + $("#cellformexp3").val() + "'])" ).addClass("cell_unselected");
            $("select#antiformexp3 option").attr('disabled', 'disabled');
            $(  "select#antiformexp3 " +  "option[data-celline~=\"" +  $("#cellformexp3").val() + "\"]" ).attr( 'disabled', false )
        });
    
        $('button#exp1').click(function(){
    	    $("select#formexp1 option").removeClass("cell_unselected");
            $("select#antiformexp1 option").attr('disabled', false);
            $("select#formexp1 option").attr('disabled', false);
        });
    
        $('button#exp2').click(function(){
            $("select#formexp2 option").removeClass("cell_unselected");
            $("select#antiformexp2 option").attr('disabled', false);
            $("select#formexp2 option").attr('disabled', false);
        });
    
        $('button#exp3').click(function(){
            $("select#formexp3 option").removeClass("cell_unselected");
            $("select#antiformexp3 option").attr('disabled', false);
            $("select#formexp3 option").attr('disabled', false);
        });

        //this thing will help the preselect trim the experiment selection
        $('select#antiformexp1v2').change(function(){
            $("select#cellformexp1v2").attr('disabled', false);
            $("select#formexp1v2 option").attr('disabled', false);
            $(  "select#formexp1v2 " +  "option:not([data-antibody='" +  $("#antiformexp1v2").val() + "'])" ).attr( "disabled", "disabled" );
            $("select#cellformexp1v2 option").attr('disabled', 'disabled');
            $(  "select#cellformexp1v2 " +  "option[data-antibody~=\"" +  $("#antiformexp1v2").val() + "\"]" ).attr( 'disabled', false );
        });
    
        $('select#antiformexp2v2').click(function(){
            $("select#cellformexp2v2").attr('disabled', false);
            $("select#formexp2v2 option").attr('disabled', false);
            $(  "select#formexp2v2 " +  "option:not([data-antibody='" +  $("#antiformexp2v2").val() + "'])" ).attr( "disabled", "disabled" );
            $("select#cellformexp2v2 option").attr('disabled', 'disabled');
            $(  "select#cellformexp2v2 " +  "option[data-antibody~=\"" +  $("#antiformexp2v2").val() + "\"]" ).attr( 'disabled', false );
        });
    
        $('select#antiformexp3v2').click(function(){
            $("select#formexp3v2 option").attr('disabled', false);
            $("select#cellformexp3v2").attr('disabled', false);
            $(  "select#formexp3v2 " +  "option:not([data-antibody='" +  $("#antiformexp3v2").val() + "'])" ).attr( "disabled", "disabled" );
            $("select#cellformexp3v2 option").attr('disabled', 'disabled');
            $(  "select#cellformexp3v2 " +  "option[data-antibody~=\"" +  $("#antiformexp3v2").val() + "\"]" ).attr( 'disabled', false );
        });
    
        $('select#cellformexp1v2').click(function(){
            $("select#formexp1v2 option").removeClass("cell_unselected");
            $("select#formexp1v2 " + "option:not([data-celline='" + $("#cellformexp1v2").val() + "'])" ).addClass("cell_unselected");
        });
    
        $('select#cellformexp2v2').change(function(){
            $("select#formexp2v2 option").removeClass("cell_unselected");
            $("select#formexp2v2 " + "option:not([data-celline='" + $("#cellformexp2v2").val() + "'])" ).addClass("cell_unselected");
        });
    
        $('select#cellformexp3v2').change(function(){
            $("select#formexp3v2 option").removeClass("cell_unselected");
            $("select#formexp3v2 " + "option:not([data-celline='" + $("#cellformexp3v2").val() + "'])" ).addClass("cell_unselected");
        });
    
        $('button#exp1v2').click(function(){
            $("select#formexp1v2 option").removeClass("cell_unselected");
            $("select#antiformexp1v2 option").attr('disabled', false);
            $("select#formexp1v2 option").attr('disabled', false);
        });
    
        $('button#exp2v2').click(function(){
            $("select#formexp2v2 option").removeClass("cell_unselected");
            $("select#antiformexp2v2 option").attr('disabled', false);
            $("select#formexp2v2 option").attr('disabled', false);
        });
    
        $('button#exp3v2').click(function(){
            $("select#formexp3v2 option").removeClass("cell_unselected");
            $("select#antiformexp3v2 option").attr('disabled', false);
            $("select#formexp3v2 option").attr('disabled', false);
        });
    
    }); 

</script>
</head>
<body>
<div class="container_16">
<!--topdiv -->


  <a href="http://www.naik.hu/en/"><img src="naik-logo.png" alt="SummitDB"  title="SummitDB" class="logo2"/></a>
  <img src="logo.gif" alt="SummitDB"  title="SummitDB" class="logomid"/>
  <a href="https://www.edu.unideb.hu/"><img src="University_logo.png" alt="SummitDB"  title="SummitDB" class="logo"/></a>
</div>

  <div class="foo">
    <ul class="navlink">
        <li><a href="main.html" title="Home" class="active">Home</a></li>
        <li onclick="glossToggle()"><a title="Help" class="active">Glossary</a></li>

    </ul>
        </div>




<h4 style="margin:auto;text-align:center;font-size:1.3em;padding-bottom:3em;padding-top:10em;">Venn diagramm view</h4>
<div id="glossary" style="width:99% ;background-color: white;border:1px solid black;height:55em;display:none;z-index: 11;">
 <iframe id="ifrm" src="http://summit.med.unideb.hu/summitdb/glossary.html"  frameborder="0" scrolling="yes" style="width:100% ;background-color: white;height:100%;">
</iframe>
</div>



<div id="chart_venn" style="width:94% ;background-color: white;border:1px solid black;display:block;float:none;" >


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

 <table style="width:71%;top:99em;">
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

<script>
var data1start = <?php echo json_encode($jsonData1start);?>;
var data2start = <?php echo json_encode($jsonData2start);?>;
var data3start = <?php echo json_encode($jsonData3start);?>;
</script>


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
var data4 = <?php echo json_encode($jsonData4, JSON_NUMERIC_CHECK);?>;
var data7 = <?php echo json_encode($jsonData7, JSON_NUMERIC_CHECK);?>;
var data8 = <?php echo json_encode($jsonData8, JSON_NUMERIC_CHECK);?>;

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
<button class="paired_button" onclick="doSearchpreShift()">View data in paired shift view</button>
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
// Set antibody names by the cell lines (first select box) 
foreach($antibody1 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp1" type="text" value="" class="three" placeholder="Type to filter"  style="background:#ff6666;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"false\" >" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
<button class="threeAH2" onclick="jumptoexp('formexp1')"> experiment view </button>
<br>
<select id="cellformexp2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area
foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="antiformexp2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">
<?php 
// Set antibody names by the cell lines (select left hand side from this box)
foreach($antibody2 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"false\" >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="sixAH2" onclick="jumptoexp('formexp2')"> experiment view </button>
<br>

<select id="cellformexp3" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " class=\"formexp2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="antiformexp3" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">
<?php 
// Set antibody names by the cell lines (select left hand side from this box)
foreach($antibody3 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . "  >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp3" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
<?php

foreach($jsonData4 as $item){
    echo "<option class=\"cell_unselected\" value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " disabled=\"false\" >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="nineAH2" onclick="jumptoexp('formexp3')"> experiment view </button>

<br>
<br>
<br>
<button id="exp1" class="threeAH" >clear selection </button>
<button id="exp2" class="sixAH" >clear selection </button>
<button id="exp3" class="nineAH" >clear selection</button>

</div>
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


<?php
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp1v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp1v2" type="text" class="one" value="" placeholder="Type to filter" style="background:#ff6666;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] . " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp1v2" type="text" value="" class="three" placeholder="Type to filter"  style="background:#ff6666;">
<?php 
//this one puts ALL the options in the select area

foreach($jsonData4 as $item){
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }
?>

</select>
<button class="threeAH2" onclick="jumptoexp('formexp1v2')"> experiment view </button>
<br>
<select id="cellformexp2v2" type="text" class="five" value="" placeholder="Type to filter" style="background:#6666ff;">


<?php
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp2v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>



</select>



<select id="antiformexp2v2" type="text" class="four" value="" placeholder="Type to filter" style="background:#6666ff;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . " >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>



 <select id="formexp2v2" type="text" class="six" value=""  placeholder="Type to filter" style="background:#6666ff;">

<?php
//this one puts ALL the options in the select area
foreach($jsonData4 as $item){
    echo "<option  value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="sixAH2" onclick="jumptoexp('formexp2v2')"> experiment view </button>
<br>

<select disabled id="cellformexp3v2" type="text" value="" class="eight" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData7 as $item){
    echo "<option value=".  $item['cell_lines_cellline_id'] .  " data-antibody=" . "\"" .  $item['antibody'] . "\" class=\"formexp3v2\">" . $item['cell_line'] . "</option>" ;    // process the line read.
    }
?>
</select>


<select id="antiformexp3v2" type="text" value="" class="seven" placeholder="Type to filter" style="background:#66ff66;">

<?php 
//this one puts ALL the options in the select area

foreach($jsonData8 as $item){
    echo "<option value=".  $item['antibody_id'] .  " data-celline=" . "\"" .  $item['cellline_id'] . "\"" . "  >" . $item['antibody'] . "</option>" ;    // process the line read.
    }
?>
</select>

<select id="formexp3v2" type="text" value="" class="nine" placeholder="Type to filter" style="background:#66ff66;">
<?php

foreach($jsonData4 as $item){
    echo "<option value=". $item['experiment_id'] . " data-celline=". $item['cell_lines_cellline_id']. " data-antibody=" 
    . $item['antibody_id'] . " >" . $item['name'] . "</option>" ;    // process the line read.
    }

?>
</select>
<button class="nineAH2" onclick="jumptoexp('formexp3v2')"> experiment view </button>

<br>
<br>
<br>
<button id="exp1v2" class="threeAH" >clear selection </button>
<button id="exp2v2" class="sixAH" >clear selection </button>
<button id="exp3v2" class="nineAH" >clear selection</button>


</div>
<br>
<p>After setting the parameters, click the button below to refresh the page.</p>

<button id="resend2" onclick="doSearchVenn2()" style="width: 14em;"><p>Refresh Page</p></button>

</div>
</div>

<script>
var formexp1value = <?php echo  $exp1Name ; ?>;
document.getElementById("formexp1").value = formexp1value;
document.getElementById("formexp1v2").value = formexp1value;

var formexp2value = <?php echo  $exp2Name ; ?>;
document.getElementById("formexp2").value = formexp2value;
document.getElementById("formexp2v2").value = formexp2value;

var formexp3value = <?php echo  $exp3Name ; ?>;
document.getElementById("formexp3").value = formexp3value;
document.getElementById("formexp3v2").value = formexp3value;

var formmotive = <?php echo '"'. $motifPart . '"'; ?>;
document.getElementById("formmotive").value = formmotive;

var lol1 = data1start[0].antid;
document.getElementById("antiformexp1").value = lol1;
var lol2 = data2start[0].antid;
document.getElementById("antiformexp2").value = lol2;
var lol3 = data3start[0].antid;
document.getElementById("antiformexp3").value = lol3;

var lolz1 = data1start[0].cellid;
document.getElementById("cellformexp1").value = lolz1;
var lolz2 = data2start[0].cellid;
document.getElementById("cellformexp2").value = lolz2;
var lolz3 = data3start[0].cellid;
document.getElementById("cellformexp3").value = lolz3;
document.getElementById("antiformexp1v2").value = lol1;
document.getElementById("antiformexp2v2").value = lol2;
document.getElementById("antiformexp3v2").value = lol3;
document.getElementById("cellformexp1v2").value = lolz1;
document.getElementById("cellformexp2v2").value = lolz2;
document.getElementById("cellformexp3v2").value = lolz3;


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
In this mode, two or three experiments can be compared. The values in the sections of the diagram indicates the number of common and specific peaks at a consensus motif binding site. In this view, the con$
</p>
<br>
<p>
Copyright © 2018    Mátyás Schiller,  Erik Czipa, Levente Kontra, Tibor Nagy, Júlia Koller,
Orsolya Pálné Szén, Csaba Papp, László Steiner, Ferenc Marincs and Endre Barta
</p>
</div>

</body>
</html>
