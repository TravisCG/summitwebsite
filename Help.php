<?php
include("templates/header.php");
include("templates/footer.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 6.0.7.3 (Linux)"/>
	<meta name="author" content="Czipa Erik"/>
	<meta name="created" content="2019-05-08T10:22:00"/>
	<meta name="changedby" content="Tibor Nagy"/>
	<meta name="changed" content="2019-05-20T09:41:52.718351309"/>
	<meta name="AppVersion" content="16.0000"/>
	<meta name="Company" content="HP"/>
	<meta name="DocSecurity" content="0"/>
	<meta name="HyperlinksChanged" content="false"/>
	<meta name="LinksUpToDate" content="false"/>
	<meta name="ScaleCrop" content="false"/>
	<meta name="ShareDoc" content="false"/>
	<style type="text/css">
		@page { size: 8.27in 11.69in; margin: 0.98in }
		p { margin-bottom: 0.1in; direction: ltr; color: #000000; line-height: 115%; text-align: left; orphans: 2; widows: 2 }
		p.western { font-family: "Liberation Serif", serif; so-language: en-US }
		p.cjk { font-family: "Noto Sans CJK SC Regular"; so-language: zh-CN }
		p.ctl { font-family: "Lohit Devanagari"; so-language: hi-IN }
	</style>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="master.css" rel="stylesheet" type="text/css" />
	<script>
		function dochange(target) { window.open(target,"_self");};
	</script>
</head>
<body lang="hu-HU" text="#00000a" dir="ltr">
<?php show_full_navigation();?>
<div id="helpcontent">
<h4>Help page</h4>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>MotifView</b></span></font></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">Short
description: Find the average/median protein positional and occupancy
frequency information on a set of given transcription factor binding
sites. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">The</span><span lang="en-US">
</span><span lang="en-US">motif</span><span lang="en-US"> </span><span lang="en-US">view</span><span lang="en-US">
</span><span lang="en-US">shows</span><span lang="en-US"> </span><span lang="en-US">the</span><span lang="en-US">
</span><span lang="en-US">average</span><span lang="en-US">/</span><span lang="en-US">median</span><span lang="en-US">
</span><span lang="en-US">positions</span><span lang="en-US"> </span><span lang="en-US">of</span><span lang="en-US">
</span><span lang="en-US">occupying</span><span lang="en-US">
</span><span lang="en-US">proteins</span><span lang="en-US"> </span><span lang="en-US">on</span><span lang="en-US">
</span><span lang="en-US">the</span><span lang="en-US"> </span><span lang="en-US">instances</span><span lang="en-US">
</span><span lang="en-US">of</span><span lang="en-US"> </span><span lang="en-US">a</span><span lang="en-US">
</span><span lang="en-US">given</span><span lang="en-US">
</span><span lang="en-US">transcription</span><span lang="en-US">
</span><span lang="en-US">factor</span><span lang="en-US"> </span><span lang="en-US">motif
(</span><span lang="en-US">on the whole or a portion of the consensus
motif set</span><span lang="en-US">)</span><span lang="en-US">. The
reference point is marked </span><span lang="en-US">as</span><span lang="en-US">
</span><span lang="en-US">zero</span><span lang="en-US"> </span><span lang="en-US">and</span><span lang="en-US">
</span><span lang="en-US">it</span><span lang="en-US"> </span><span lang="en-US">represents</span><span lang="en-US">
</span><span lang="en-US">the</span><span lang="en-US"> </span><span lang="en-US">center</span><span lang="en-US">
</span><span lang="en-US">of</span><span lang="en-US"> the </span><span lang="en-US">motif</span><span lang="en-US">.
</span><span lang="en-US">The</span><span lang="en-US"> </span><span lang="en-US">scatter</span><span lang="en-US">
</span><span lang="en-US">plots</span><span lang="en-US"> </span><span lang="en-US">provide</span><span lang="en-US">
</span><span lang="en-US">information</span><span lang="en-US"> </span><span lang="en-US">about</span><span lang="en-US">
</span><span lang="en-US">the</span><span lang="en-US"> </span><span lang="en-US">frequency</span><span lang="en-US">
</span><span lang="en-US">of</span><span lang="en-US"> </span><span lang="en-US">co</span><span lang="en-US">-</span><span lang="en-US">occupancies</span><span lang="en-US">
</span><span lang="en-US">and</span><span lang="en-US"> </span><span lang="en-US">the</span><span lang="en-US">
</span><span lang="en-US">distance</span><span lang="en-US">
</span><span lang="en-US">distribution</span><span lang="en-US">
</span><span lang="en-US">standard</span><span lang="en-US">
</span><span lang="en-US">deviations</span><span lang="en-US"> </span><span lang="en-US">of</span><span lang="en-US">
</span><span lang="en-US">distinct</span><span lang="en-US">
</span><span lang="en-US">proteins</span><span lang="en-US">. </span><span lang="en-US">The</span><span lang="en-US">
</span><span lang="en-US">latter</span><span lang="en-US"> </span><span lang="en-US">can</span><span lang="en-US">
</span><span lang="en-US">correlate</span><span lang="en-US"> </span><span lang="en-US">with</span><span lang="en-US">
</span><span lang="en-US">the</span><span lang="en-US"> </span><span lang="en-US">physical</span><span lang="en-US">
</span><span lang="en-US">distance</span><span lang="en-US"> </span><span lang="en-US">between</span><span lang="en-US">
</span><span lang="en-US">the</span><span lang="en-US"> </span><span lang="en-US">protein</span><span lang="en-US">
</span><span lang="en-US">and</span><span lang="en-US"> </span><span lang="en-US">the</span><span lang="en-US">
</span><span lang="en-US">DNA</span><span lang="en-US"> (</span><span lang="en-US">direct</span><span lang="en-US">
</span><span lang="en-US">or</span><span lang="en-US"> </span><span lang="en-US">indirect</span><span lang="en-US">
</span><span lang="en-US">binding</span><span lang="en-US">). </span><span lang="en-US">Every</span><span lang="en-US">
</span><span lang="en-US">dot</span><span lang="en-US"> </span><span lang="en-US">represents</span><span lang="en-US">
</span><span lang="en-US">a</span><span lang="en-US"> </span><span lang="en-US">ChIP</span><span lang="en-US">-</span><span lang="en-US">seq</span><span lang="en-US">
</span><span lang="en-US">experiment,</span><span lang="en-US"> </span><span lang="en-US">which</span><span lang="en-US">
is </span><span lang="en-US">colored</span><span lang="en-US">
according to the </span><span lang="en-US">type</span><span lang="en-US">
</span><span lang="en-US">of</span><span lang="en-US"> </span><span lang="en-US">target</span><span lang="en-US">
</span><span lang="en-US">protein</span><span lang="en-US">. </span><span lang="en-US">The</span><span lang="en-US">
displayed dots </span><span lang="en-US">can</span><span lang="en-US">
</span><span lang="en-US">be</span><span lang="en-US"> </span><span lang="en-US">filtered</span><span lang="en-US">
</span><span lang="en-US">based</span><span lang="en-US"> </span><span lang="en-US">on</span><span lang="en-US">
</span><span lang="en-US">cell</span><span lang="en-US"> </span><span lang="en-US">type</span><span lang="en-US">/</span><span lang="en-US">cell</span><span lang="en-US">
</span><span lang="en-US">line</span><span lang="en-US"> </span><span lang="en-US">or</span><span lang="en-US">
</span><span lang="en-US">target</span><span lang="en-US"> </span><span lang="en-US">proteins</span><span lang="en-US">.
</span></font>
</p>
<img src="images/help1.jpg" name="Kép 52" border="0" />
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">The
MotifView appears as an interactive scatterplot, which gives
information about the given JASPAR core motif instances in the genome
(global analysis of consensus motif set, see above), the overlap
frequency between motifs, and ChIP-seq peaks and the average/median
positioning of summits from different experiments. Every dot on the
chart belongs to a single ChIP-seq experiment. The dots are placed
depending on the relation between the positioning information and the
adjusted motif center. (The position weight matrix of the adjusted
motif is shown in the bottom-right corner. The center of the motif is
marked with “0” on the scale below.) The motif of interest can be
set in the “Set a motif” dropdown box. In the write boxes, you
can modify what data is displayed and the minimum and maximum values
of the y axis (standard deviation or element number, this will be
discussed later in this description). Important: All of the changes
will only be displayed after clicking on the “Resend Data” button
below. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">If
the user hovers the cursor on a given dot, a tool-tip will appear,
which gives information about the ChIP-seq experiment, including the
name of the experiment, cell type, target protein, and quantified
information about summit positions (average/median distance, standard
deviation of distances, and overlap number). The dots are </span><span lang="en-US">colored</span><span lang="en-US">
according to the </span><span lang="en-US">type</span><span lang="en-US">
</span><span lang="en-US">of</span><span lang="en-US"> </span><span lang="en-US">target</span><span lang="en-US">
</span><span lang="en-US">protein</span><span lang="en-US">. The
legend with color codes is visible on the right-hand side of the
chart, which is also interactive. Clicking on a specific target
protein name in the legend section can hide the respective dots from
the chart. The large amount of displayed dots can be overwhelming in
the data review, so we created a “Clear all dots out” button to
hide all of the points of the chart. The specific spots can be called
back one-by-one by clicking on the factor name in the legend. Using
this process, we can compare the positioning of proteins of interest.
 All of these steps are revocable by clicking on the “Show all
dots” button. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"> <font face="Times New Roman, serif"><span lang="en-US">The
X axis is constant and represents the distance from the center of the
adjusted JASPAR CORE motif (the distance is measured in base pairs).
The Y axis is adjustable, you can choose to display the number of
summit-motif overlaps or the standard deviation of summit positions. </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">As
was previously mentioned, we created consensus motif sets for the
JASPAR core motifs, which represent all of the possible binding sites
for different factors (documentation link). The power of the ChIP-seq
technique resides in its comparability, which means in our case, that
we can easily investigate the relationship between motif centers and
nearby summit positions. We define this in distances (measured in
base pairs) then visualize the average, frequency, and standard
deviation on scatterplots. Several motifs show a high density of
overlapping summits. Binding sites like CTCF or AR motifs are popular
among transcription factors/ co-factors in the case of genomic
co-localization. Genomic regions like super enhancers are
collectively bound by an array of factors. At the core of these
regions are transcription factor motif(s), which is/are covered with
a collection of different proteins. Since we investigate whole sets
of possible transcription factor binding sites and we visualize the
average values of all possible co-localizing factors (the summit
positions of these factors), we can run into some rather crowded
scatterplots. To resolve this problem, we can use the previously
mentioned “Clear all dots out” function or we can utilize the
factor unification solution. The latter is based on consolidating
different ChIP-seq experiments (even from different cell types),
which have a common antibody target. The unification step averages
the summit positions of the affected experiments (average of
averages), the standard deviations (average of standard deviations),
and the element numbers. To activate this display you can choose
between two buttons: “average standard deviation vs. average of
average positions” or “average element numbers vs. average of
average positions”. The two features differ in the values of the y
axis. The first one displays the average of standard deviations, the
second shows the average number of motif-summit overlaps per
experiment.  </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US"><b>Interoperability
between the different views</b></span></font></p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">The
MotifView provides a global picture about the transcription factor
binding sites and their occupying ChIP-seq signals. Thus, the
MotifView is a genomic bird’s-eye view, which is a useful tool for
identifying intriguing phenomena. However, in order to properly
understand what we are seeing, we need to be able to take a closer
look. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">As
mentioned in the Help section, the diagram was made to be
interactive. The dots on the diagram (which all represent a specific
ChIP-seq experiment) can be marked by clicking on them. The
attributes (cell line, antibody, SRA ID, element number) of the
selected experiments (a maximum of 3 experiments can be selected at
the same time) appear below the chart. If you want to investigate the
appointed highlighted data, you can choose from the following
options: </span></font>
</p>
<ul>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font face="Calibri, serif"><font face="Times New Roman, serif"><span lang="en-US">If
	you click on the “to PairShiftView” button, it will navigate you
	to the distance distribution chart of the summit positions (of the
	selected experiments) compared to the adjusted motif (the same
	motif, which was displayed in the MotifView). </span></font></font>
	</p>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font face="Calibri, serif"><font face="Times New Roman, serif"><span lang="en-US">To
	browse the genomic locations of peak-motif co-occurrences in the
	genome browser, click on the “to the GenomeView” button.</span></font></font></p>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font face="Calibri, serif"><font face="Times New Roman, serif"><span lang="en-US">You
	can check the frequency of co-occupancy between the selected factors
	by clicking on the “to Venn diagram” button. This will open a
	classical logic diagram display mode, where the motif related
	co-appearance of summits can be seen.</span></font></font></p>
</ul>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%"><a name="_GoBack"></a>
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%; page-break-before: always">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>PairShift
View</b></span></font></font></p>
<img src="images/help2.jpg" name="Kép 53" hspace="11" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">
The
MotifView displays the statistical data (occurrence frequency,
average/median distance related to the motif, and distance standard
deviation) of all the ChIP-seq experiments, which contain overlapping
peaks with any instances of an adjusted motif type (e.g.: all CTCF
motif). The positioning of the different factors related to the motif
has a central role in this view but this view’s resolution is too
low to see the details of position distribution. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">The
pair shift view shows the summit distance distributions of the
selected ChIP-seq data (a maximum of 3) related to a motif as a
histogram. The X axis represents the distance (measured in base
pairs) from the middle of the given motif, which is marked as the “0”
point. The numbering of the axis is consistent with the position
weight matrix below the diagram.  The Y axis shows the frequency of
summit occurrences at the relative position (at a given base pair)
relative to the motif center. In the case of well-defined protein
topology with high overlap frequency and close DNA localization, the
curve has a bell-like pattern (normal distribution-like). According
to our observations, the narrowness of the curve is inversely
proportional to the protein’s physical distance from the DNA
(direct or indirect binding). This relationship can be detected when
looking at the standard deviations as well (MotifView). Factors with
low overlap frequency and no position preference show plateau
distribution. </span></font>
</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><a name="__DdeLink__1528_1325945844"></a>
<font face="Times New Roman, serif"><span lang="en-US">To visualize
the data, we need to set the options. We recommend that you set the
motif first in the dropdown box below “Set a motif”. After you
choose a motif of interest, you can set which experiments you want to
investigate. (You can select them using the dropdown menus, or you
can navigate to pair shift view comparison from motif view after you
highlighted the dots (experimental data) that you are interested in.
You can read about this in ”Details”, found in the MotifView Help
section. To select the ChIP-seq data of interest, set the attributes
of the experiment in the dropdown boxes from right to left: in the
first box select the cell type, in the second you can pick the
antibody, and in the third box you can choose by the name of the
experiment. The experiment name is related to the experimental
attributes: the tissue type and the origin of the cell type, the
target protein name, and the SRA experiment ID. When you set all the
parameters, click on the “Resend Data” button. Following the page
refresh, the updated data will be displayed. The minimum and maximum
values of the axes are configurable as well in the text boxes below
the diagram. A rolling mean with a 5 bp frame was applied to smooth
the frequency curves.</span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>VennDiagramView</b></span></font></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">The
diagrams of the MotifView cumulatively represent the statistical data
of all occupying ChIP-seq experiments (occurrence frequency,
average/median distance related to the motif, and distance standard
deviation) on all instances (consensus motif set) of an adjusted
motif type. The co-occurrence frequency of distinct ChIP-seq summits
from different experiments is not taken into account here. To fill
this gap, we created a VennDiagram View. The Venn diagram displays
all possible logical relations between a collection of different
sets. In our case, the sets are the motifs that overlap with the
peaks of a chosen ChIP-seq experiment and the relation is the number
of common motifs that are simultaneously occupied by these
experiments.  </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>ExperimentView</b></span></font></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><span lang="en-US">At
the early stage of our work, we collected 4068 human ChIP-seq data
from public databases (NCBI SRA, ENCODE). 3727 experiments were
successfully processed and used in the following steps of the
analysis. The basic information of this data is at least as crucial
as the final results. As previously mentioned, we tried to use a wide
variety of ChIP-seq data considering both the origins (cell type,
tissue) and the target proteins. To track the source of the data, we
created an “ExperimentView”, which is a more manageable and
readable way to browse essential information about the distinct
experiments by putting all of the data into a simple table. The
search interface of this view is quite similar to the PairShiftView
and VennDiagramView.</span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><span lang="en-US"><b>GenomeView</b></span></font></font></p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Times New Roman, serif"><font color="#000000"><span lang="en-US"><br/>
</span></font><span lang="en-US">The
genome browser gives the user opportunity to look at each motif each
peak on the genome. The genome viewer can visualize all consensus
motifs one by one, peaks of each experiment and miscellaneous tracks
including: dbSNP track, known gene track from UCSC and </span><span lang="en-US">E</span><span lang="en-US">ensembl
and some regulatory regions tracks. To find information on basic
navigation please refer to the jbrowse help menu on the top left
corner, next to the “view” menu. To add additional tracks please
click on the “select tracks” button. This will bring in a table
to select tracks from. To narrow down the selection table the filters
on the left can be used. To remove the table of tracks please click
on the “select tracks” button again.</span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western"><font face="Times New Roman, serif"><font size="4" style="font-size: 14pt"><b>dbSNPView</b></font></font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">This
view helps you to see variations and overlapping regulatory motifs.</font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">If
you search by a dbSNP ID, you can see the reference variation, the
alternate nucleotides and (if present) the overlapping sequence
logos. Every SNP has an ID and a link to the original dbSNP page. The
motif logo is also clickable and you can reach the corresponding
motif page.</font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">The
other way to see the genomic landscape is to specify a region.
Because in this case the genomic region can be large, only a
schematic view will be seen. The variations marked as lines (red
colour indicates overlapping with motifs) and motifs drawn as
rectangles. Both the variations and the motifs clickable. The SNP ID
link is the same as described above, but the motif has two links! If
you click to the name, you will be navigated to the MotifView page,
but any other click inside the rectangle work like a zoom. You can
see the nucleotides and the motif logo after the page reloaded.</font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">In
this zoomed mode if you hoover the mouse overt the SNP, you can see
the reference nucleotides in green and the alternative allele in red.</font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">Please
specify the dbSNP ID or a genomic region. If both set, only dbSNP
will be used. If dbSNP ID is set the final image will be created
using 50bp flanking region. If you would like to see a larger
landscape, you can set the genomic region manually.</font></p>
<p lang="en-US" class="western"><font face="Times New Roman, serif">Caution:
The genomic region cannot be larger than 1000bp!</font></p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><br/>

</p>
</div>
<?php show_footer();?>
</body>
</html>
