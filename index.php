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
	<a target="_blank" href="http://summit.med.unideb.hu/summitdb/motif_view.php?maxid=10000&minid=1&mnelem=5000&mxelem=120000&motive=CTCF">
	    <img src="slide1.png" class="slideimg" >
	</a>
    <div class="text">Motif view</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 4</div>
 	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=1666&exp2=2734&exp3=2750&motive=CTCF&motifid=32&limit=25&low_limit=-25&formminid=1&formmaxid=10000&formminelem=5000&formmaxelem=120000">
	   <img src="slide2.png" class="slideimg">
	</a>
    <div class="text">Paired shift view</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 4</div>
	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=1666&exp2=2734&exp3=2750&motive=CTCF&motifid=32">
	    <img src="slide3.png" class="slideimg">
	</a>
    <div class="text">Venn diagram view</div>
  </div>

 <div class="mySlides fade">
    <div class="numbertext">4 / 4</div>
	<a  target="_blank" href="http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=2734">
	    <img src="exp_view.png" class="slideimg">
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
<h3>About ChIPSummitDB</h3>
<p>ChIPSummitDB is a comprehensive database of transcription factor binding sites verified by human 
<a href="#" title="An experiment using the ChIP-seq technique with the following important parameters: 
the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument,
 type of the sequencing (single‑end or paired-end), sequenced read length and sequencing depth" class="emphasize">ChIP-seq experiments</a>
 and their distances (positions) relative to the peak summits defined by the ChIP-seq reads.
The database is a collection of the genomic positions of the consensus binding sites of each analyzed <a href="#" title="TF: Transcription Factor. In this database, TF is used for any protein which can be immune‑precipitated together with its bound DNA, and if a specific binding site from the literature could be assigned to it." class="emphasize"><span>TF</span></a> (group). Furthermore, the database displays the overlapping peaks for these <a href="#" title="One of the motifs from the Consensus motif binding site set" class="emphasize">consensus binding site</a> motifs.
The database can predict the topological relations of different proteins at a given <a href="#" title=" Consensus binding site: One of the motifs from the Consensus motif binding site set." class="emphasize"><span>consensus binding site</span></a> by measuring the motif center – <a href="#" title="Peak summit: The genomic (absolute) or the TFBS-related (as the distance or shift value to the middle of a TFBS) position of the highest (maxima) point of a peak. One peak region can have more than one peak summit. We use PeakSplitter to determine them.
" class="emphasize">peak summit</a> distances.</p>

<h3>Data views in ChIPSummitDB</h3>
<p>ExperimentView shows detailed data for each <a href="#" title="ChIP-seq experiment: An experiment using the ChIP-seq technique with the following important parameters: the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument, type of the sequencing (single‑end or paired-end), sequenced read length and sequencing depth 
" class="emphasize"><span>ChIP-seq experiment</span></a> downloaded from the <a href="https://www.ncbi.nlm.nih.gov/sra"  title="SRA Database">SRA database</a>.</p>
<p>MotifView shows the average ChIP-seq <a href="#" title="Peak summit: The genomic (absolute) or the TFBS-related (as the distance or shift value to the middle of a TFBS) position of the highest (maxima) point of a peak. One peak region can have more than one peak summit. We use PeakSplitter to determine them.
" class="emphasize">peak summit</a> vs. motif center distances between each consensus motif binding site set and the ChIP-seq experiments by a scatterplot graph. The displayed values can be filtered by different parameters</p>
<p>PairShiftView shows a distribution graph of the distance between the <a href="#" title="The genomic (absolute) or the TFBS-related (as the distance or shift value to the middle of a TFBS) position of the highest (maxima) point of a peak. One peak region can have more than one peak summit. We use PeakSplitter to determine them." class="emphasize">  peak summit</a> and the center of the motif  for maximum three selected <a href="#" title="An experiment using the ChIP-seq technique with the following important parameters: 
the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument, 
 type of the sequencing (single‑end or paired-end), sequenced read length and sequencing depth" class="emphasize">ChIP-seq experiments</a>.</p>
<p>VennView shows the numbers of the common  peaks at a given <a href="#" title="One of the motifs from the Consensus motif binding site set" class="emphasize">consensus binding site set</a> for maximum three <a href="#" title="ChIP-seq experiment: An experiment using the ChIP-seq technique with the following important parameters: the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument, type of the sequencing (single‑end or paired-end), sequenced read length and sequencing depth 
" class="emphasize"><span>ChIP-seq experiment</span></a> by a Venn diagram.</p>
<p>GenomeView visualizes the consensus binding site sets and the whole or overlapping peak sets in the <a href="https://jbrowse.org/" title="JBrowse Genome Browser">JBrowse genome browser</a>.</p>

<h3>Data download</h3>
<p>Different peak sets can be downloaded in “bedfile” format.</p>

<h3>Citing ChIPSummitDB</h3>
<p>The manuscript describing this database will be submitted soon. Until acceptance, Please cite the following  paper firstly describing the idea and the underlying methods behind ChIPSummitDB.
 <a href="https://scholar.google.hu/scholar?oi=bibs&cluster=8378628083884756002&btnI=1&hl=en">Motif oriented high-resolution analysis of ChIP-seq data reveals the topological order of CTCF and cohesin proteins on DNA</a>
G Nagy, E Czipa, L Steiner, T Nagy, S Pongor, L Nagy… - <a href="https://bmcgenomics.biomedcentral.com/articles/10.1186/s12864-016-2940-7">BMC genomics </a>, 2016</p>

<h3>Details about the views in ChIPSummitDB</h3>

<h5>MotifView</h5>
<p>In this mode, the average distances between the peak of the reads obtained in a ChIP-seq experiment and a given consensus motif on a scatterplot graph is visualized. Each scatter represents an experiment. Circles represent transcription factors with defined binding sites, while triangles represent co-factors and other indirectly bound proteins. Different colors indicate the antibody used in the immune precipitation. The X-axis shows the average distances of peak summits and the center of the binding sites for all overlapping peaks. The Y-axis shows either the number of overlapping peaks (elements) or, in default mode, the standard deviation of the shift values (distances) between the peak summits and motif centers. This scatterplot representation is available for all consensus binding motif sets.</p>
<p>The displayed data can be filtered by the number of overlapping peaks (element number) or by the standard deviation. Data can be also displayed based on the used antibody or cell type. Averages of experiments obtained by the same antibody in different experiments can be also calculated and shown.</p>
<p>After selecting maximum three experiments, links are available to switch to other views.</p>

<h5>PairShiftView</h5>
<p>In this mode, the frequencies of the different distance values between the motif and peak summit pairs for a given consensus binding site set are displayed in a histogram. To smooth the graph a 5 bp rolling bin was used. No more than three different experiments can be compared. The maximum value of the curves shows the most frequent distance, which is supposed to be the same what is shown on the X-axis at the MotifView.
In the PairShiftView mode, the data range and the consensus motif binding site set can be changed. There is also a possibility to select an experiment and see it in the ExperimentView.</p>

<h5>VennView</h5>
<p>In this mode, two or three experiment can be compared. The values in the sections of the diagram indicates the number  of overlapping peaks at the consensus motif binding sites of a given motif. Considering one TFBS in a genome (among the thousands defined in the Consensus motif binding site set) it can overlap (between 50bp at both sides) one, any of the two or all three experiments examined in this view. In the Venn diagram, we count these occurrences. In this view, the consensus motif and the experiment can be selected.</p>

<h5>ExperimentView</h5>
<p>In this mode, the details of any  ChIP-seq experiment can be seen.. The displayed information includes the SRA links, the number of reads, the antibody used, the mapped reads and the number of peaks. The result of the <a href="http://homer.ucsd.edu/homer/" title="HOMER">HOMER</a> denovo motif prediction can be also seen. Experiments incorporated into ChIPSummitDB can be searched for display.</p>


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
