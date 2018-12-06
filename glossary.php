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
<b>Average distance:</b>
The average of distances between every  summit and motif center pair at a given ChIP-seq experiment and consensus motif pair. <br><br><b>
Consensus binding site:</b> One of the motifs from the Consensus motif binding site set
<br><br><b>Consensus motif binding site set:</b> The most probable genome-wide binding site set of the transcription factors with common JASPAR Core motif. It contains the mapped TFBS matrix genomic positions which are overlapping with a corresponding peak region (i.e. the ones with the assigned antibodies). These sets intend to represent all possible experimentally validated binding sites of a given transcription factor.  
<br><br><b>ChIP-seq:</b> A functional genomics technique involving Chromatin immunoprecipitation of protein-nucleic acid complex followed by next-generation sequencing of the bound nucleic acid. It is used to determine genome-wide the binding position of proteins on chromosomal DNA at genome‑wide scale.
<br><br><b>ChIP-seq experiment:</b> An experiment using the ChIP-seq technique with the following important parameters: the type of the cell and/or tissue, the antibody used for the IP, make/model of the sequencing instrument, type of the sequencing (single‑end or paired-end), sequenced read length and sequencing depth
<br><br><b>Co-factor:</b> Here we collect under this name all of the ChIP-seq experiments where the antibody used for the IP is not against a TF
<br><br><b>Denovo motif:</b> The matrix of an enriched motif determined by the HOMER software. We provide the HOMER determined denovo motifs for every ChIP-seq experiments, but they are not used in our pipeline
<br><br><b>Element (number):</b> The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set.
<br><br><b>IP:</b> Immunoprecipitation. An experimental procedure utilizing a specific antibody. It is used for the enrichment of DNA fragments bound by a specific protein.
<br><br><b>JASPAR Core motif set:</b> JASPAR is a collection of transcription factor DNA-binding preferences, stored as position weight matrices (PWMs). The database contains a non-redundant set of profiles, which are collected from literature data (published and experimentally defined). 
<br><br><b>Merged peak set:</b> Peak regions from different ChIP-seq experiments are merged using bedtools to give every genomic region where there is an experimentally verified binding of the given TF(s).
<br><br><b>Peak:</b> The pileup of ChIP-seq reads on the reference genome. We filter out peaks with non-correct characteristics. We often use the word “peak” in the meaning of “peak region”
<br><br><b>Peak region:</b> A genomic region, assigned to a chromosome and labelled by the start and end positions, as determined by the peak calling HOMER software, which contains the peak. Ideally, the peak is at the middle of the peak region.
<br><br><b>Peak summit:</b> The genomic (absolute) or the TFBS-related (as the distance or shift value to the middle of a TFBS) position of the highest (maxima) point of a peak. One peak region can have more than one peak summit. We use PeakSplitter to determine them.
<br><br><b>Shift value (distance):</b> The value of the distance between a summit and a TFBS mapped consensus motif center in basepairs. It can be either a negative, or a positive number or zero.
<br><br><b>Standard deviation (of shift values):</b> Here, it is calculated from the shift values between peak summits and the centers of the consensus motif binding sites, which are closer than 50 bp.
<br><br><b>TF:</b> Transcription Factor. In this database, TF is used for any protein which can be immune‑precipitated together with its bound DNA, and if a specific binding site from the literature could be assigned to it.
<br><br><b>TFBS:</b> Transcription Factor Binding Site. A specific sequence in the genome, which matches to one or more TFBS matrix
<br><br><b>TFBS matrix:</b> A position weight matrix describing the consensus binding site for a  TF. It was determined using the given JASPAR core matrix for the TF by applying the HOMER motif optimization algorithm on the merged peak region obtained from the corresponding ChIP-seq experiments.
</div>
<?php show_footer(); ?>
</body>
</html>

