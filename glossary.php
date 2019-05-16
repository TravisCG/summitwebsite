<?php
  include("templates/header.php");
  include("templates/footer.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SummitDB</title>
<link href="favicon.png" rel="icon"  type="image/png" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="master.css" rel="stylesheet" type="text/css" />
<script>
  function dochange(target) { window.open(target,"_self");};
</script>
</head>
<body>
<?php show_full_navigation(); ?>
<div id="maincontent">
<h4>Glossary</h4>
<p><span class="boldtxt">Average distance</span>: The average of distances between each summit and motif center pair for a given ChIP-seq experiment and consensus motif pair.</p>
<p><span class="boldtxt">Consensus binding site</span>: One of the motifs from the Consensus motif binding site set</p>
<p><span class="boldtxt">Consensus motif binding site set</span>: The most probable genome-wide binding site set of the transcription factors with a common JASPAR Core motif. A set contains the mapped TFBS matrix genomic positions, which overlap with a corresponding peak region (i.e. the ones with the assigned antibodies). These sets represent all possible experimentally validated binding sites for a given transcription factor.</p>
<p><span class="boldtxt">ChIP-seq</span>: A functional genomics technique	involving Chromatin immunoprecipitation of a protein-nucleic acid complex followed by next-generation sequencing of the bound nucleic acid. It is used to determine, on a genome-wide basis, the binding position of proteins on chromosomal DNA.</p>
<p><span class="boldtxt">ChIP-seq experiment</span>: An experiment using the ChIP-seq technique with the following important parameters: the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument, type of sequencing (single‑end or paired-end), sequenced read length, and sequencing depth</p>
<p><span class="boldtxt">Co-factor</span>: Here we collect under this name all of the ChIP-seq experiments where the antibody used for the IP is not against a TF</p>
<p><span class="boldtxt">De novo motif</span>: The matrix of an enriched motif determined by the HOMER software. We provide the HOMER determined de novo motifs for every ChIP-seq experiment, but they are not used in our pipeline</p>
<p><span class="boldtxt">Element (number)</span>: The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set.</p>
<p><span class="boldtxt">IP</span>: Immunoprecipitation. An experimental procedure utilizing a specific antibody. It is used for the enrichment of DNA fragments bound by a specific protein.</p>
<p><span class="boldtxt">JASPAR Core motif set</span>: JASPAR is a collection of transcription factor DNA-binding preferences, stored as position weight matrices (PWMs). The database contains a non-redundant set of profiles, which are collected from literature data (published and experimentally defined).</p>
<p><span class="boldtxt">Merged peak set</span>: Peak regions from different ChIP-seq experiments are merged using bedtools to give every genomic region where there is an experimentally verified binding of a given TF(s).</p>
<p><span class="boldtxt">Peak</span>: The pileup of ChIP-seq reads on the reference genome. We filter out peaks with non-correct characteristics. We often use the word “peak” to mean  “peak region”.</p>
<p><span class="boldtxt">Peak region</span>: A genomic region, assigned to a chromosome and labeled by the start and end positions, as determined by the peak calling HOMER software, which contains the peak. Ideally, the peak is in the middle of the peak region.</p>
<p><span class="boldtxt">Peak summit</span>:	The genomic (absolute) or the TFBS-related (as the distance or shift value to the middle of a TFBS) position of the highest (maxima) point of a peak. One peak region can have more than one peak summit. We use PeakSplitter to determine these.</p>
<p><span class="boldtxt">Shift value (distance)</span>: The value of the distance between a summit and a TFBS mapped consensus motif center in base pairs. The number can be either negative, positive, or zero.</p>
<p><span class="boldtxt">Standard deviation (of shift values)</span>: Here, it is calculated from the shift values between peak summits and the centers of the consensus motif binding sites, which are closer than 50 bp.</p>
<p><span class="boldtxt">TF</span>: Transcription Factor. In this database, TF is used for any protein which can be immune‑precipitated together with its bound DNA, and if a specific binding site from the literature could be assigned.</p>
<p><span class="boldtxt">TFBS</span>: Transcription Factor Binding Site. A specific sequence in the genome, which matches with one or more TFBS matrix</p>
<p><span class="boldtxt">TFBS matrix</span>: A position weight matrix describing the consensus binding site for a TF. It is determined using the given JASPAR core matrix for the TF by applying the HOMER motif optimization algorithm on the merged peak region obtained from the corresponding ChIP-seq experiments.</p>
</div>
<?php show_footer(); ?>
</body>
</html>

