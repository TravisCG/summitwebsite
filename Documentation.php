<?php
  include("templates/header.php");
  include("templates/footer.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>SummitDB Documentation</title>
	<meta name="generator" content="LibreOffice 6.0.7.3 (Linux)"/>
	<meta name="author" content="Czipa Erik"/>
	<meta name="created" content="2019-05-08T08:35:00"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2019-05-08T12:12:00"/>
	<meta name="AppVersion" content="16.0000"/>
	<meta name="Company" content="University of Debrecen"/>
	<meta name="DocSecurity" content="0"/>
	<meta name="HyperlinksChanged" content="false"/>
	<meta name="LinksUpToDate" content="false"/>
	<meta name="Mendeley Citation Style_1" content="http://www.zotero.org/styles/genome-biology"/>
	<meta name="Mendeley Document_1" content="True"/>
	<meta name="Mendeley Recent Style Id 0_1" content="http://www.zotero.org/styles/american-medical-association"/>
	<meta name="Mendeley Recent Style Id 1_1" content="http://www.zotero.org/styles/apa"/>
	<meta name="Mendeley Recent Style Id 2_1" content="http://www.zotero.org/styles/american-sociological-association"/>
	<meta name="Mendeley Recent Style Id 3_1" content="http://www.zotero.org/styles/chicago-author-date"/>
	<meta name="Mendeley Recent Style Id 4_1" content="http://www.zotero.org/styles/genome-biology"/>
	<meta name="Mendeley Recent Style Id 5_1" content="http://www.zotero.org/styles/genomebiology"/>
	<meta name="Mendeley Recent Style Id 6_1" content="http://www.zotero.org/styles/harvard1"/>
	<meta name="Mendeley Recent Style Id 7_1" content="http://www.zotero.org/styles/ieee"/>
	<meta name="Mendeley Recent Style Id 8_1" content="http://www.zotero.org/styles/modern-humanities-research-association"/>
	<meta name="Mendeley Recent Style Id 9_1" content="http://www.zotero.org/styles/modern-language-association"/>
	<meta name="Mendeley Recent Style Name 0_1" content="American Medical Association"/>
	<meta name="Mendeley Recent Style Name 1_1" content="American Psychological Association 6th edition"/>
	<meta name="Mendeley Recent Style Name 2_1" content="American Sociological Association"/>
	<meta name="Mendeley Recent Style Name 3_1" content="Chicago Manual of Style 17th edition (author-date)"/>
	<meta name="Mendeley Recent Style Name 4_1" content="Genome Biology"/>
	<meta name="Mendeley Recent Style Name 5_1" content="Genome Biology Journal"/>
	<meta name="Mendeley Recent Style Name 6_1" content="Harvard reference format 1 (deprecated)"/>
	<meta name="Mendeley Recent Style Name 7_1" content="IEEE"/>
	<meta name="Mendeley Recent Style Name 8_1" content="Modern Humanities Research Association 3rd edition (note with bibliography)"/>
	<meta name="Mendeley Recent Style Name 9_1" content="Modern Language Association 8th edition"/>
	<meta name="Mendeley Unique User Id_1" content="a8af13b7-4fd2-3ef7-9985-414d1cb0ba31"/>
	<meta name="ScaleCrop" content="false"/>
	<meta name="ShareDoc" content="false"/>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="master.css" />
	<script>
		function dochange(target) { window.open(target,"_self");};
	</script>
</head>
<body lang="hu-HU" text="#00000a" link="#0000ff" dir="ltr" style="background-color:white;">
<?php show_full_navigation();?>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%"><a name="_GoBack"></a>
<font color="#000000"><font face="Arial, serif"><font size="5" style="font-size: 20pt"><span lang="en-US"><b>Documentation</b></span></font></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font size="4" style="font-size: 14pt"><span lang="en-US"><i>ChIPSummitDB
is a collection of processed ChIP-seq data. It provides information
about the possible direct or indirect interactions between
transcription regulatory proteins and their positions in the genome.</i></span></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Data
processing steps:</span></font></font></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
1: ChIP-seq data collection from public databases.</span></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
2: Processing of collected ChIP-seq data using a custom analysis
pipeline. The pipeline includes read mapping, motif enrichment
analysis, peak prediction, and making coverage track files (bedgraphs
and bigwig). The peak region BED files and coverage file (bedgraph)
are essential for the next steps. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
3: Splitting peak region and summit prediction. The peak region files
and coverage files (bedgraph) from the previous step were used to
subdivide ChIP-seq regions into discrete signals and find summit
regions. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
4: Peak filtering. A custom script was created to filter peak
regions, depending on their symmetry and shape. The script utilizes
the split peak regions and coverage bedgraph files and results in
filtered peak region sets in the BED format. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
5: JASPAR CORE motif and ChIP-seq data pairing. We paired the JASPAR
motif to their corresponding ChIP-seq experiments. The results were
stored in a table. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
6:  </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">Motif
optimization. A motif optimization of JASPAR CORE motifs was
conducted. To do this, a merged peak region set was created using the
filtered peak regions of the corresponding ChIP-seq experiments
(determined in the previous step). All JASPAR motifs were optimized
using these merged genomic regions, resulting in optimized motifs. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
7: Determining motif locations. We used 3 different programs to find
the instances of optimized motifs in the genome. As a result, the
genomic locations are in BED format. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Step
8: Summit distance calculation. The centers of identified motifs
(step 7) served as reference points in the calculation of
motif-protein and protein-protein distance calculations. The results
are stored in a MySQL data table, which is available on the
ChIPSummitDB website.  </span></font></font>
</p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>About
ChIPSummitDB:</b></span></font></font></font></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">The</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">main</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">goal</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">analyzing</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">ChIP</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">-</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">seq</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">experiments</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
is </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">to</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">identify</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">regions</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">in</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">the</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">genome</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">where</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">we</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">find</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">more</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">sequencing</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">reads</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
(</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">tags</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">)
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">than</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">we</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">would</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">expect</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">to</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">see</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">by</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">chance</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.&nbsp;</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">These</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">regions</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">are</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
called </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">peak</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">regions</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">due</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">to</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
the </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">appearance</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
the </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">visualized</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">distribution</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">mapped</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">tags
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[1]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">peak</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">’</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">s</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">summit</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
(</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">maxima</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">)
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">shows</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">the</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">highest</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">coverage</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">the</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">region</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">and</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
is </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">known</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">to</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">more</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">-</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">or</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">-</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">less</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">coincide</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">with</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">the</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">center</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">corresponding</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">DNA</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">elements</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">in</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">the</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">case</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">of</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">transcription</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">factors
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[2]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
These summits correlate with the accurate contact positions of the
proteins on the DNA and can be used to determine the topological
arrangements of the binding proteins relative to the strand-specific
transcription factor binding sites (transcription factor binding
motifs (TFBMs)). Earlier we showed </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[3]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
that the exact positions of DNA binding proteins on the DNA can be
extracted from the ChIP-seq data by identifying the peak summit
positions.</span></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Our
goal was to create a global database which was based on combining the
location of identified </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">transcriptional</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">regulatory</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">elements</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
(</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">TREs)
with the positional information of the co-bound regulatory proteins
(using publicly available ChIP-seq data, targeting as many proteins
as we could). By investigating a global picture of different
transcription factors and cofactors, we can identify previously
unknown transcriptional regulatory networks. Using the database, we
can browse co-bound proteins on TREs and acquire information about
their positioning relative to each other and the bound transcription
factor motif.</span></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><font size="5" style="font-size: 20pt"><span lang="en-US"><b>Processing
the data</b></span></font></font></font></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Data
from 4058 ChIP-seq experiments, covering a wide range of proteins and
cell types, were collected from the NCBI SRA and ENCODE databases
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[4,5]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
The naming and automatic download of experiments were performed using
a custom script. Processing of the downloaded raw data was carried
out using a second in-house developed ChIP-seq analysis pipeline
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[6]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
involving</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
mapping </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[7]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">,
peak calling </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[2,8]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">,
tagdirectory creation,</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
and data visualization </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[8]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
The workflow of the procedure is visualized in Figure S1. Following
this analysis, the semi-processed data</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
were further analyzed. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
 <img src="images/documentation1.jpg" name="Kép 27" width="50%" height="50%"/>

</p>
<p style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Figure S1:
Schematic representation of the initial data processing.</b></span></span><span lang="en-US"><span style="font-style: normal">
Processing starts with data collection and proper naming. After
processing and filtering steps, we get the transcription factor
binding sites in bed and bedgraph formats.    </span></span>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-before: always">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>Peak
splitting and summit prediction</b></span></font></font></font></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">We
used PeakSplitter, </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="background: #ffffff">which
was developed to split sub&#8209;peaks when overlapping peaks are
present, </span></span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">for
summit predictions</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="background: #ffffff">.
Thus, a more accurate local maxima could be obtained (Figure S2). </span></span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
peaks for transcription factor binding sequences are usually
concentrated to a narrow area, showing a </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">Gaussian
distribution</span></font></font><em><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font></em><em><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="font-style: normal">due
to random fragmentation and their narrow binding surface. This was
especially observable after</span></span></font></font></em><font color="#000000"><font face="Arial, serif"><span lang="en-US"><i><span style="font-weight: normal">
</span></i></span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="font-weight: normal">the
extension of reads to the expected fragment length</span></span></font></font><b><font color="#000000"><font face="Arial, serif"><span lang="en-US">
</span></font></font></b><font color="#000000"><font face="Arial, serif"><span lang="en-US">[2]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
H</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">igh
signal and weak enrichment can indicate insufficient discarding of
read duplicates or </span></font></font><em><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="font-style: normal">library
preparation artifacts </span></span></font></font></em><font color="#000000"><font face="Arial, serif"><span lang="en-US">(Star
et al., 2014; Steven R. Head et al. 2014). </span></font></font>
</p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-after: avoid">
<img src="images/documentation2.jpg" name="Kép 8" hspace="1" vspace="1" width="50%" height="50%" border="0"/>
</p>
<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Fig</b></span></span><span lang="en-US"><span style="font-style: normal"><b>ure</b></span></span><span lang="en-US"><span style="font-style: normal"><b>
S2:</b></span></span><font color="#000000"><span lang="en-US"><span style="font-style: normal"><b>
Summit prediction.</b></span></span></font><font color="#000000"><span lang="en-US"><span style="font-style: normal">
Identification of local maxima within peak regions. </span></span></font>
</p>
<p lang="en-US" align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<br/>
<br/>

</p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>Peak
filtering</b></span></font></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Identifying
peaks with </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">a
well-defined maxima</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
was crucial at the early stage of data processing because false
positive peaks could result in false prediction of a protein’s
position. </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
peak summits (maxima) show the highest coverage for the peak region
and coincide reasonably with the center of the corresponding DNA
elements bound by transcription factors. Therefore, the
identification of regions suitable for clear determination of the
summit position(s) was required.</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
Current software packages use different strategies, such as the
evaluation of peak prediction reproducibility or the use of false
discovery rates (FDR), for peak prediction (</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[9]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">,
which dramatically decrease the false positive rates. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Unfortunately,
by using these methods, the filtering algorithms needed to be
configured differently for each experiment, which makes the
automatization of the processing of large datasets more difficult.
For better filtering, we have developed a pipeline, which reduces the
false positive discovery rate even further. </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">To
avoid false positive results, we filtered out duplicated reads by
using </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">a
step in the ChIP-seq analysis pipeline and </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="background: #ffffff">developed
a Perl script, which classified and filtered the sub&#8209;peaks
based on their size and shape. </span></span></font></font>
</p>
<img src="images/documentation3.jpg" name="Kép 9" hspace="11" width="50%" height="50%"/>
<p class="western" align="justify" style="line-height: 100%">
<span id="Frame2" dir="ltr" style="float: left; width: 3.95in; border: none; padding: 0in; background: #ffffff">
	<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
	<span lang="en-GB"><span style="font-style: normal"><b>Figure S3:
	</b></span></span><span lang="en-GB"><span style="font-style: normal"><b>Peak
	filtering according to shape.</b></span></span><span lang="en-GB"><span style="font-style: normal">
	We filtered peaks depending on the symmetry of their two side
	(summit positions serves as a symmetry axis) (B), the positions of
	the </span></span><font color="#000000"><span lang="en-GB"><span style="font-style: normal">2</span></span></font><font color="#000000"><sup><span lang="en-GB"><span style="font-style: normal">nd</span></span></sup></font><font color="#000000"><span lang="en-GB"><span style="font-style: normal">
	and 3</span></span></font><font color="#000000"><sup><span lang="en-GB"><span style="font-style: normal">rd</span></span></sup></font><font color="#000000"><span lang="en-GB"><span style="font-style: normal">
	quartiles (C), and the symmetry between the read coverage of the two
	strands (D). </span></span></font>
	</p>
</span><font color="#000000"><font face="Arial, serif"><span lang="en-US">In
these analyses, the peaks are considered </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">coverage
histograms and the positions of the median and first and third
quartile values were used. </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
“ideal” transcription factor peak has three attributes: i) the
read distribution on both strands have symmetrically curved
shoulders</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">,
if the median value is the symmetry axis; ii) the peak’s shape
displays a bell-like curve; iii) the maxima of the ChIP-seq signal is
approximately equal between the Watson and the Crick strands (Figure
S3a). The first two steps of the filtering analysis are required for
filtering out peak positions that have large gaps in their ChIP-seq
signal intensity even after the read extension by the peak caller
software. The formula in Figure S3b calculates how symmetrical the
two sides of the peak are. For this calculation, the maxima were used
as the axis of symmetry. The second formula (Figure S3c) quantifies
the shape of the peak based on the distances between the minimum,
maximum, and 2</span></font></font><font color="#000000"><sup><font face="Arial, serif"><span lang="en-US">nd</span></font></sup></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
and 3</span></font></font><font color="#000000"><sup><font face="Arial, serif"><span lang="en-US">rd</span></font></sup></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
quartile values of ChIP-seq signal intensities within the peaks. The
resulting value varies between 0 and 1. If we connect the four
above-mentioned values with a straight line (where the x axis
represents the position of the signal and y axis represents the
signal intensity), the peaks which have a “0” shape value would
be shaped like a triangle. In contrast, if the value converges to
0.5, the shape of the peak would resemble a square (Figure S3c).
Optimally, the forward and reverse tag counts (in a peak) have,
approximately, the same size due to the ChIP-seq method. The third
formula calculates the symmetry between the reverse and the direct
strand tag counts (Figure S3d). </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Due
to the ChIP-Seq technology, at each protein-DNA binding site, the
tags from the forward strands are located on the left-hand side of
the binding site and the tags observed from the reverse strand are
located on the right-hand side. This is an aspect which is considered
and used by several peak-calling (e.g.: macs2) software to extend
reads by an average value during peak identification. We used this
parameter to filter data. We calculated forward-reverse maxima
distances and values which could be found in the 90th percentile
passed this filtering step. </span></font></font>
</p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>JASPAR
CORE motif and ChIP-seq data pairing</b></span></font></font></font></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-after: avoid">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Identification
of the exact positions</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
of </span></font></font><em><font color="#000000"><font face="Arial, serif"><span lang="en-US"><span style="font-style: normal">TF</span></span></font></font></em><font color="#000000"><font face="Arial, serif"><span lang="en-US"><i>
</i></span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">binding
sites is the basis of ChIPSummitDB.  These motif positions are not
only a collection of regulatory regions, but the motif centers were
also used as reference points for summit position analysis. Our
primary goal was to create consensus binding site sets for as many
transcription factors as possible. To do this, we used the JASPAR
CORE database, which is a “</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">curated,
non-redundant set of profiles, derived from published collections of
experimentally defined transcription factor binding sites for
eukaryotes” </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[10]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
and incorporates 579 non-redundant motifs. We attempted to collect
all motifs with ChIP-seq experiments from our collection. Several
motifs were lacking NGS data for historical reasons, thus the JASPAR
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">CORE
was built to create families of binding profiles for as many
structural transcription factor classes as possible. Despite this, </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">we
could allocate only 338 motifs to at least one ChIP-seq experiment,
because in the available human data, no sequence and NGS data were
available for the rest of motifs (Figure S4).  </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<img src="images/documentation4.jpg"/>
</p>
<p lang="en-US" align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; font-style: normal; line-height: 100%">
<br/>
<br/>

</p>
<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Figure S4:
Pairing position weight matrices (PWMs) for processed ChIP-seq
experiments.</b></span></span><span lang="en-US"><span style="font-style: normal">
(A)  2820 experiments could be paired to a proper JASPAR motif from
the downloaded 3782 ChIP-seq experiments (B). This resulted in 338
JASPAR CORE motifs from the 579 (C). The result was a table where the
PWMs are paired to their corresponding ChIP-seq experiments (D).  </span></span>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-before: always">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>Motif
optimization and determining their locations</b></span></font></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">To
optimize the allocated motifs, the peak regions of the corresponding
ChIP-seq experiments were scanned for similar motif enrichments
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[8]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
The optimized motifs were manually curated and the most identical
ones were paired with the corresponding antibodies (Figure S4). This
step maximized the number of specific motif instances, which were
identified in the next step (Figure S5). </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<img src="images/documentation5.jpg"/>
</p>
<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Fig</b></span></span><span lang="en-US"><span style="font-style: normal"><b>ure</b></span></span><span lang="en-US"><span style="font-style: normal"><b>
S5: </b></span></span><span lang="en-US"><span style="font-style: normal"><b>Motif
optimization. </b></span></span><span lang="en-US"><span style="font-style: normal">JASPAR
CORE motifs were optimized with the findMotifsGenome program, which
used the original PWMs and the merged peak region set of
corresponding ChIP-seq experiments (determined in the Motif- ChIP-seq
experiment pairing step).</span></span></p>
<p lang="en-US" class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">Numerous
tools can be used to find the </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">occurrences
of individual motifs. </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">Instead
of choosing one single tool, we combined 3 popular methods: HOMER,
FIMO, and MAST </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[11–13]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
positions which were identified as motifs by at least two programs
were filtered in the first step (Figure S6a). Using the default motif
scores obtained by the above-mentioned three programs and the
distance of the closest summit obtained from the list of paired
motif-ChIP-seq experiments, a weighted motif value was calculated.
All identified ChIP-seq peaks were coupled with the closest motif
possessing the highest weighted motif value. </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
distance cutoff was +/- 50 base pairs. Following this step, sets of
non-redundant motifs were created by filtering out the motifs with
identical position and direction (Figure 6A). Even in the case of
palindromic sequences, identifying motif directions was possible due
to the flanking regions and the positional preferences of the peak
summits. </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">In
the previously mentioned step and in the subsequent analysis,
closestBed, a tool of bedtools, was used to measure the distance
between the center of the motifs and the summits </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">[14]</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
If the length of an N bp long motif was even, then the (N/2)+1 bp
from the 5’ end of the sequence was considered as the center of the
motif.  </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
We created individual summit position pools for all motifs from their
respective ChIP-seq experiments. Then, the identified motifs and
summits were combined using the closestBed program. This step
resulted in a table where all of the summit positions from the proper
set are </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">shown
together with one or more nearest</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
motif instances. Distances between the centers of the motifs and the
summits were calculated this way. Both this distance and the score of
the motif were taken into account during the coupling of the most
probable motifs with each of the summits. We combined these scores
into a formula, and the motif with the calculated highest score was
picked for each summit position (one summit could have more than one
motif in its vicinity, but only the strongest motif was selected for
the following steps). The formula for this calculation can be found
in Figure S6b (WMs). The same motif was frequently coupled to summits
from different experiments. To avoid redundancy, we removed the
duplicates.  </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">Thus,
we get non-redundant global consensus motif sets for 338 JASPAR CORE
matrices.  </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-after: avoid">
<img src="images/documentation6.jpg"/>
</p>
<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Fig</b></span></span><span lang="en-US"><span style="font-style: normal"><b>ure</b></span></span><span lang="en-US"><span style="font-style: normal"><b>
S6:</b></span></span><span lang="en-US"><span style="font-style: normal"><b>
Determining motif locations. </b></span></span><span lang="en-US"><span style="font-style: normal">To
identify the location of motif instances, we combined three different
motif finding methods. The merged peak region set of corresponding
ChIP-seq experiments was used in the identification (Figure S6a).  To
filter the identified motifs, we used the presented formula in Figure
S6b. In the case of overlapping motifs, the motif with the highest
Weighted Motif score was selected. </span></span>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>Summit
distance calculation</b></span></font></font></font></p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%">
<font color="#000000"><font face="Arial, serif"><span lang="en-US">The
identified consensus sequence locations not only show the genome-wide
distribution of transcription binding sites but can be also used as
reference points for landscaping of possible co&#8209;bindings and
the measurement of motif-protein or protein-protein distances. All
motif occurrences obtained from every set were screened to identify
ChIP-seq experiments containing peak summits in the +/- 50 bp
vicinity to the motif center and the distances between motif centers
and summit positions were calculated. The resulting distance tables
can be examined for either genome-wide or local data. The genome-wide
analysis can highlight large-scale information about protein
positioning, for example, co-location frequency, location preferences
between proteins, possible members of complexes, and patterns</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">
in the protein composition of different regulatory regions. In
addition to the frequency and the median/average values, both
calculated from the measured distances, the standard deviation can
also be informative. The preferred position of a particular factor
has a larger standard deviation (in relation to the positions of the
motif centers) if it is physically far from the reference point
(Figure S7). </span></font></font>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%; page-break-after: avoid">
<img src="images/documentation7.jpg" name="Kép 51" width="528" height="503" border="0"/>
</p>
<p align="justify" style="margin-top: 0.08in; margin-bottom: 0.08in; line-height: 100%">
<span lang="en-US"><span style="font-style: normal"><b>Figure S7:
Measuring the distances between motif centers and the surrounding
summits.</b></span></span><span lang="en-US"><span style="font-style: normal">
We calculated the concrete distance between motifs and the
neighboring summits (measured in base pairs). We took into account
all of the possible summits from every experiment.   </span></span>
</p>
<p class="western" align="justify" style="margin-bottom: 0in; line-height: 100%"><a name="_GoBack1"></a>
<font color="#000000"><font face="Arial, serif"><span lang="en-US">In
ChIPSummitDB, the examination of a specific region of the genome is
also possible. Examining the summit positions at a specific motif can
provide detailed information about the composition of regulatory
complexes and their topology, and a comparison of different cell
lines is also possible. </span></font></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><font size="5" style="font-size: 20pt"><span lang="en-US"><b>References
</b></span></font></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">1. Albert I, Wachi S, Jiang C, Pugh BF.
GeneTrack--a genomic data processing and visualization framework.
Bioinformatics. England; 2008;24:1305–6. </font></p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">2. Zhang Y, Liu T, Meyer CA, Eeckhoute J,
Johnson DS, Bernstein BE, et al. Model-based Analysis of ChIP-Seq
(MACS). Genome Biol. 2008;9. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">3. Nagy G, Czipa E, Steiner L, Nagy T,
Pongor S, Nagy L, et al. Motif oriented high-resolution analysis of
ChIP-seq data reveals the topological order of CTCF and cohesin
proteins on DNA. BMC Genomics. 2016;17:637. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">4. Leinonen R, Sugawara H, Shumway M,
Collaboration  on behalf of the INSD. The Sequence Read Archive.
Nucleic Acids Res. Oxford University Press; 2011;39:D19–21. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">5. An integrated encyclopedia of DNA
elements in the human genome. Nature. 2012;489. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">6. Barta E. Command line analysis of
ChIP-seq results. Embnet Journal. 2011;17(1):13--17. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">7. Li H, Durbin R. Fast and accurate
long-read alignment with Burrows--Wheeler transform. Bioinformatics.
2010;26. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">8. Heinz S, Benner C, Spann N, Bertolino E,
Lin YC, Laslo P, et al. Simple combinations of lineage-determining
transcription factors prime cis-regulatory elements required for
macrophage and B cell identities. Mol Cell. United States;
2010;38:576–89. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">9. Taslim C, Huang K, Huang T, Lin S.
Analyzing ChIP-seq data: preprocessing, normalization, differential
identification, and binding pattern characterization. Methods Mol
Biol. United States; 2012;802:275–91. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">10. Khan A, Fornes O, Stigliani A, Gheorghe
M, Castro-Mondragon JA, van&nbsp;der&nbsp;Lee R, et al. JASPAR 2018:
update of the open-access database of transcription factor binding
profiles and its web framework. Nucleic Acids Res. 2018;46:D260–6. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">11. Grant CE, Bailey TL, Noble WS. FIMO:
scanning for occurrences of a given motif. Bioinformatics. Oxford
University Press; 2011;27:1017–8. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">12. Finak G, McDavid A, Yajima M, Deng J,
Gersuk V, Shalek AK, et al. MAST: a flexible statistical framework
for assessing transcriptional changes and characterizing
heterogeneity in single-cell RNA sequencing data. Genome Biol.
London: BioMed Central; 2015;16:278. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">13. Lee MT, Bonneau AR, Takacs CM, Bazzini
AA, DiVito KR, Fleming ES, et al. Nanog, Pou5f1 and SoxB1 activate
zygotic gene expression during the maternal-to-zygotic transition.
Nature. England; 2013;503:360–4. </font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<font face="Arial, serif">14. Quinlan AR, Hall IM. BEDTools: a
flexible suite of utilities for comparing genomic features.
Bioinformatics. 2010;26. </font>
</p>
<p class="western" style="margin-left: 0.33in; text-indent: -0.33in; margin-bottom: 0in; line-height: 100%; orphans: 0; widows: 0">
<br/>

</p>
<?php show_footer();?>
</body>
</html>
