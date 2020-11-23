<?php
  include("templates/header.php");
  include("templates/footer.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121648705-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121648705-1');
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ChipSEQsummitdb, chipseq, summitdb, ChIP-seq peak summit, ChIP-seq database, transcription factor, consensus motif, motif database, transcription factor complex">
<title>Welcome to SummitDB</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="master.css" rel="stylesheet" type="text/css" />
<link href="emphasize.css" rel="stylesheet" type="text/css" />
<link href="slideshow.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
  show_full_navigation();
?>
<div id="introduction">

<div class="slideshow-container">

  <div class="mySlides fade">
    <div class="numbertext">1 / 4</div>
	<a target="_blank" href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=1000&mxelem=120000&motive=CTCF">
	    <img src="images/slide1.png" class="slideimg" >
	</a>
    <div class="text">Motif view</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 4</div>
 	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=1666&exp2=2734&exp3=2750&motive=CTCF&motifid=32&limit=40&low_limit=-40&formminid=1&formmaxid=10000&formminelem=1000&formmaxelem=120000">
	   <img src="images/slide2.png" class="slideimg">
	</a>
    <div class="text">Paired shift view</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 4</div>
	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=1666&exp2=2734&exp3=2750&motive=CTCF&motifid=32">
	    <img src="images/slide3.png" class="slideimg">
	</a>
    <div class="text">Venn diagram view</div>
  </div>

 <div class="mySlides fade">
    <div class="numbertext">4 / 4</div>
	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=2734">
	    <img src="images/exp_view.png" class="slideimg">
	</a>
    <div class="text">Experiment view</div>
  </div>
</div>

<script>
var slideIndex = 0;
showSlides(slideIndex);

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < 4; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > 4) {slideIndex = 1}
    slides[slideIndex-1].style.display = "block";
    setTimeout(showSlides, 5000); // Change image every 5 seconds
} 

</script>

<div>
<h3><u>Citing ChIPSummitDB</u></h3>
<p><u>The manuscript describing this database can be found by following these links:</u></p>
<p> <a class="bright" target="_blank" href="https://bmcgenomics.biomedcentral.com/articles/10.1186/s12864-016-2940-7">Motif oriented high-resolution analysis of ChIP-seq data reveals the topological order of CTCF and cohesin proteins on DNA</a>
G Nagy, E Czipa, L Steiner, T Nagy, S Pongor, L Nagy… - BMC genomics, 2016</p>
<p><a target="_blank" class="bright"  href="https://academic.oup.com/database/article/doi/10.1093/database/baz141/5700342">ChIPSummitDB: A ChIP-seq-based database of human transcription factor binding sites and the topological arrangements of the proteins bound to them.</a> E Czipa, M Schiller, T Nagy, L Kontra, L Steiner, J Koller, O Palne-Szen, E Barta - Database, 2020</p>


<h3>About ChIPSummitDB</h3>
<p>
ChIPSummitDB is a comprehensive database of transcription factor binding sites verified by human ChIP-seq experiments and the distances (positions) of the binding sites relative to the peak summits defined by the ChIP-seq reads.
The database is a collection of the genomic positions of the consensus binding sites of each analyzed TF (group). Furthermore, the database displays the overlapping peaks for these consensus binding site motifs.
The database can predict the topological relationships of different proteins at a given consensus binding site by measuring the motif center – peak summit distances.
</p>

<h3>Data views in ChIPSummitDB</h3>
<p>Data can be displayed using the following views:</p>
<p><span class="boldtxt">ExperimentView</span> shows detailed data for each ChIP-seq experiment downloaded from the SRA database.</p>
<p><span class="boldtxt">MotifView</span>shows the average ChIP-seq peak summit vs. motif center distances between each consensus motif binding site set and the ChIP-seq experiments using a scatterplot graph. The displayed values can be filtered by different parameters.</p>
<p><span class="boldtxt">PairShiftView</span> shows a distribution graph of the distance between the peak summit and the center of the motif for a maximum of three selected ChIP-seq experiments.</p>
<p><span class="boldtxt">VennDiagramView</span> shows the numbers of common peaks at a given consensus binding site set for a maximum of three ChIP-seq experiments using a Venn diagram.</p>
<p><span class="boldtxt">GenomeView</span> visualizes the consensus binding site sets and the whole or overlapping peak sets in the JBrowse genome browser.</p>
<p><span class="boldtxt">dbSNPView</span>This view helps you to see variations and overlapping regulatory motifs.</p>

<h3>Data download</h3>
<p>Different peak sets can be downloaded in “bedfile” format.</p>


<h3>Details about the views in ChIPSummitDB</h3>

<h5>MotifView</h5>
<p>In this mode, the average distances between the peak of the reads obtained in a ChIP-seq experiment and a given consensus motif on a scatterplot graph are visualized. Each scatter represents an experiment. Circles represent transcription factors with defined binding sites, while triangles represent co-factors and other indirectly bound proteins. Different colors indicate the antibody used in the immunoprecipitation. The X-axis shows the average distances between peak summits and the center of the binding sites for all overlapping peaks. The Y-axis shows either the number of overlapping peaks (elements) or, in default mode, the standard deviation of the shift values (distances) between the peak summits and motif centers. This scatterplot representation is available for all consensus binding motif sets.</p>
<p>The displayed data can be filtered by the number of overlapping peaks (element number) or by the standard deviation. Data can also be displayed based on the antibody or cell type. Averages of experiments obtained by the same antibody in different experiments can also be calculated and displayed.</p>
<p>After selecting a maximum of three experiments, links are available to switch to other views.</p>

<h5>PairShiftView</h5>
<p>In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph, a 5 bp rolling bin was used. No more than three different experiments can be compared. The maximum value of the curves shows the most frequent distance, which is the same as the value shown on the X-axis in the MotifView.</p>
<p>In the PairShiftView mode, the data range and the consensus motif binding site set can be changed. There is also a possibility to select an experiment and see it in the ExperimentView.</p>

<h5>VennDiagramView</h5>
<p>In this mode, two or three experiments can be compared. The values in the sections of the diagram indicate the number of overlapping peaks at the consensus motif binding sites for a given motif. One TFBS in a genome (among the thousands defined in the Consensus motif binding site set) can overlap (between 50bp at both sides) any of the two or all three experiments examined in this view. In the Venn diagram, we count these occurrences. In this view, the consensus motif and the experiment can be selected.</p>

<h5>ExperimentView</h5>
<p>In this mode, the details of any ChIP-seq experiment can be seen. The displayed information includes the SRA links, the number of reads, the antibody used, the mapped reads, and the number of peaks. The result of the HOMER de novo motif prediction can also be seen. Experiments incorporated into ChIPSummitDB can be searched for display.</p>

<h5>dbSNPView</h5>
<p>This view helps you to see variations and overlapping regulatory motifs based on dbSNP.</p>

</div>

</div>                                          

<script>
function dochange(target) { window.open(target,"_self");};
</script>
<?php
show_footer();
?>
</body>
</html>
