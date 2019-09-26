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
	<meta name="author" content="Endre Barta"/>
	<meta name="created" content="2019-05-08T10:34:00"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2019-05-17T12:16:00"/>
	<meta name="AppVersion" content="16.0000"/>
	<meta name="Company" content="University of Debrecen"/>
	<meta name="DocSecurity" content="0"/>
	<meta name="HyperlinksChanged" content="false"/>
	<meta name="LinksUpToDate" content="false"/>
	<meta name="ScaleCrop" content="false"/>
	<meta name="ShareDoc" content="false"/>
	<style type="text/css">
		@page { size: 8.27in 11.69in; margin-left: 1.25in; margin-right: 1.25in; margin-top: 1in; margin-bottom: 1in }
		p { margin-bottom: 0.1in; direction: ltr; line-height: 115%; text-align: left; orphans: 2; widows: 2; margin-left: 10px; margin-right: 10px; }
		p.western { font-size: 12pt }
		p.cjk { font-size: 12pt; so-language: hu-HU }
		p.ctl { font-size: 12pt }
		a:link { color: #0000ff }
	</style>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="master.css" rel="stylesheet" type="text/css" />
	<script>
		function dochange(target) { window.open(target,"_self");}
	</script>
</head>
<body lang="hu-HU" link="#0000ff" dir="ltr">
<?php show_full_navigation();?>
<div id="helpcontent">
<h4>Tutorial</h4>
<div id="quickmenu">
<ul>
<li><a href="#motif">MotifView</a></li>
<li><a href="#pairshift">PairShiftView</a></li>
<li><a href="#dbsnp">dbSNPView</a></li>
<li><a href="#experiment">ExperimentView</a></li>
<li><a href="#genome">GenomeView</a></li>
</ul>
</div>
<a name="motif"><p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US"><b>MotifView</b></span></font></p></a>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">To
	guide the user through the different steps of using ChiPSummitDB,
	the POU2F2 motif is used as an example because it has a relatively
	small set of overlapping factors. </span></font></font></font>
	</p>
</ol>
<p style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
on the “Search views” menu and then click the “MotifView”
button. </span></font></font></font>
</p>
<img src="images/tutorial1.jpg" name="Kép 1" hspace="12" vspace="1" border="0"/>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">In
	the “Set a motif” dropdown box, select POU2F2. </span></font></font></font>

	</p>
</ol>
<img src="images/tutorial2.jpg" name="Kép 7" hspace="12" border="0"/>
<ol start="3">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
	on the “Go to MotifView” button to update the page.</span></font></font></font></p>
</ol>
<img src="images/tutorial3.jpg" name="Kép 8" hspace="12" vspace="1" border="0"/>
<ol start="4">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a">
	<font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">After
	updating the page, a scatterplot for the POU2F2 motif can be seen.
	Filter out the experiments, which overlap with POU2F2 less than </span></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">500
	times. To do this, change the default value (100) to 500 in the
	“Minimum overlap number between motifs and peaks of experiment”
	box. Click on the “Refresh page” button to update the
	scatterplot. Only 28 scatter should now be visible.</span></font></font><font face="Arial, serif"><span lang="en-US">
	This means that the identified POU2F2 binding sites overlap with
	peaks from 28 ChIP-seq experiments. However, on the right-hand side
	of the page, only 20 TFs are displayed and labeled with different
	colors. This indicates that the 28 scatters on the plot are from 28
	ChIP-seq experiments (but some experiments have the same protein
	target &gt; 20 different protein). Thus, certain TFs are presented
	in multiple experiments as indicated by the number in the front of
	the TF’s name (for example “5 P300”).</span></font> 
</font></font></p>
</ol>
<img src="images/tutorial3b.jpg" />
<ol start="5">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">For
	simplicity, investigate the TFs individually. To hide all scatters
	click on the “Hide all scatters” button, which results in an
	empty graph. To undo click on the “Show all scatters” button.
	The user can also display individual data points by selecting the
	TF’s name.</span></font></font></font></p>
</ol>
<img src="images/tutorial4.jpg" name="Kép 10"  hspace="12" vspace="1" border="0"/>
<ol start="6">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">The
	legend in the right-hand side window shows that data from two POU2F2
	ChIP-seq experiments are available. After hiding all scatters, click
	on the purple square next to POU2F2 and two scatters will appear in
	the graph area. </span></font></font></font>
	</p>
</ol>
<img src="images/tutorial5.jpg" name="Kép 11"  hspace="12" vspace="1" border="0"/>
<ol start="7">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">By
	moving the cursor over any of the two scatters, detailed information
	about the experiment will be displayed at the tool tip. The
	description indicates, that the data is from ChIP-seq experiments in
	which the lymphoblastoid cell lines, GM10847 and GM12878, were used.
	The number of elements is 4179 for cell line GM12878, indicating
	4179 POU2F2-binding motifs in the genome and peaks of the sequenced
	reads (tags) of TF POU2F2 overlap. The tooltip also shows the
	average distance between the peak summits, i.e. the maxima position
	of protein covered regions, and the motif centers, i.e. the central
	base pair of the protein binding DNA motifs, which are fixed
	reference points in the genome. The standard deviation value for the
	average distance is shown also. By comparing the average distances
	from tooltips for different scatters, the position preferences of
	the protein can be elucidated. Regarding the position values of 1.07
	and 1.47 (for the two POU2F2 experiments) in the example, we can
	conclude that POU2F2 covers the DNA downstream of the motif to which
	it binds, and also binds to its own regulatory region. The summit
	positions have relatively low standard deviations (&lt; 20). We
	postulate that direct protein-DNA binding is more stable and less
	mobile than indirect contact, and this leads to the relatively low
	standard deviation values for these binding sites. Here are two more
	examples for the above postulate. When the two POU2F2 scatters are
	displayed, click on the colored square next to P300. Five triangles
	will appear on the plot. It shows that P300 binding preferences are
	located on either side of the zero reference point and their SD is
	higher than POU2F2’s. This suggests that P300 binds indirectly to
	the DNA via POU2F2. Next click on the colored square next to EB1,
	which will bring up two more scatters. Although the binding position
	of EB1 overlaps with that of POU2F2, EB1 has a different binding
	motif. Thus, we hypothesize that both P300 and EB1 bind POU2F2 and
	the complex binds to the binding site of POU2F2.</span></font> </font></font>

	</p>
</ol>
<img src="images/tutorial6.jpg" name="Kép 12"  hspace="12" vspace="1" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US"><b>Interoperability
between the different views</b></span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
MotifView provides a complex picture of the transcription factor
binding sites and the overlapping ChIP-seq read peaks in an
interactive graph. Scatter on the diagram, represents one particular
ChIP-seq experiment and can be selected by clicking on it.  A maximum
of three scatters can be selected.</span></font><font face="Arial, serif">
</font>
</p>
<img src="images/tutorial7.jpg" name="Kép 13" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">After
selecting scatters, certain information (cell line, antibody, and
element number) about the corresponding experiment will appear in the
three boxes under each other below the graph. To view detailed
information there are the following options:</span></font></p>
<ul>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Clicking
	on the “to paired shifts” button, will open a new window with
	the distance distribution chart of the summit positions of the
	selected experiments, compared to that motif, which was selected in
	the previous step. </span></font></font></font>
	</p>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">To
	browse the genomic locations of the peak-motif co-occurrences in the
	genome browser, click on the “to the GenomeView” button.</span></font></font></font></p>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">To
	see the number of common and specific peak-motif pairs between the
	selected experiments, click on the “to venn diagram” button. </span></font></font></font>
	</p>
</ul>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<img src="images/tutorial9.jpg" name="Kép 14" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">Furthermore,
you can download the intersection of the corresponding motif and the
last selected experiment by clicking on the “download last selected
button”. The selected experiment list can be modified by using the
“Clear all selected” button. This will remove all of the
selections. </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US"><b>Changing
the display of data</b></span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
middle and the right-hand side panel of options stand for the
modification of the data display. </span></font>
</p>
<img src="images/tutorial10.jpg" name="Kép 16" align="bottom" vspace="1" border="0"/>

<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">In
the middle, the first two buttons allows the user to the Y value,
which will toggle between two states: standard deviation and element
number. For further information please check the Help menu. The
default setting is the standard deviation. </span></font>
</p>
<img src="images/tutorial11.jpg" name="Kép 17" align="bottom" border="0"/>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
	on the “element number” to display the motif- experiment peak
	overlap number as a Y value. </span></font>
</font></font></p>
</ol>
<img src="images/tutorial12.jpg" name="Kép 18" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
page will update and reorder the scatters of experiments depending on
the overlap number between ChIP-seq peaks and POU2F2 motifs. Two
POU2F2 ChIP-seq data have the highest overlap number of ~4000 POU2F2
binding sites. To find detailed information hover over one of the
scatter, which will show the accurate element number and other
information. The POU2F2 ChIP-seq derived from GM10847 cell line has
3851 peaks, which co-located with POU2F2 motifs. </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
unification step averages the average summit positions, the average
standard deviations, and the element numbers obtained from different
experiments. To display the unification calculations, the user can
choose between “average standard deviation vs. average of average
positions” or “average element numbers vs. average of average
positions” buttons.</span></font><font face="Arial, serif"> </font>
</p>
<img src="images/tutorial13.jpg" name="Kép 20" align="bottom" border="0"/>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
	on the “average standard deviation vs average of average
	positions” button. </span></font></font></font>
	</p>
</ol>
<img src="images/tutorial14.jpg" name="Kép 21" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">This
step will combine the values of ChIP-seq experiments (with similar
antibodies) and create a new plot, where the y value is the average
standard deviations.</span></font><font face="Arial, serif"><font size="4" style="font-size: 14pt"><b>
 </b></font></font>
</p>
<img src="images/tutorial15.jpg" name="Kép 22" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">Only
one dot corresponds to each antibody, which shows the average values
of its corresponding experiments. </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
buttons on the right-hand side modify the order and the content of
labels. </span></font>
</p>
<img src="images/tutorial16.jpg" name="Kép 23" align="bottom" vspace="1" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
first two buttons sort the antibodies according to their names
(alphabetically) or the number of experiments. </span></font>
</p>
<img src="images/tutorial17.jpg" name="Kép 25" align="bottom" border="0"/>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">Choosing
the last two buttons will modify the labels. The antibody names will
be replaced with cell type names. Following the logic of the previous
buttons, the experiment can be sorted by name of the cell line or the
number of their occurrences.</span></font></p>
<img src="images/tutorial18.jpg" name="Kép 26" align="bottom" vspace="1" border="0"/>
<p lang="en-US" class="western" align="center" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<img src="images/tutorial19.jpg" name="Kép 27" align="bottom" hspace="1" border="0"/>
<a name="pairshift"><p class="western" style="margin-bottom: 0in; line-height: 100%; page-break-before: always">
<font face="Arial, serif"><span lang="en-US"><b>PairShiftView</b></span></font></p></a>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">To
introduce this tool, the relation between the CTCF motif and its
corresponding summits from two experiments from the MCF7 cell line
will be shown as an example.  </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Move
	the cursor over the “Search views” menu and click on the
	“PairShiftView “button. </span></font></font></font>
	</p>
</ol>
<img src="images/tutorial20.jpg" name="Kép 28"  hspace="12" border="0"/>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Select
	the CTCF motif under “Set a motif”. </span></font></font></font>
	</p>
</ol>
<img src="images/tutorial21.jpg" name="Kép 29" hspace="11" vspace="1" border="0"/>
<ol start="3">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
	on the first upper left (red) dropdown box and select the “MCF7”
	cell type from the list. Click on the second box from the left in
	the row, and select CTCF from the list. In the third red box, select
	the name of the following experiment: "hs_BreastAdenocarcinoma_MCF7_cancer_CTCF_SRX1091824”.</span></font>
	</font></font>
	</p>
</ol>
<img src="images/tutorial22.jpg" name="Kép 30"  hspace="11" border="0"/>
<ol start="4">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a">
	<font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">In
	the next (blue) row of boxes, repeat the previous steps, but select
	RAD21 as the antibody and
	“hs_BreastAdenocarcinoma_MCF7_cancer_RAD21_ERX004452” as the
	experiment name.</span></font></font></font></p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="5">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">After
	setting the parameters, click on the “Refresh Page” button.</span></font>
	</font></font><span class="sd-abs-pos" style="top: 0.19in; left: 0in; width: 554px">
</span>
	</p>
</ol>
<img src="images/tutorial22b.jpg" name="Kép 71" border="0"/>
<ol start="6">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a">
	<font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">The
	page will refresh in a new window and a diagram will be displayed.
	The color of the curves corresponds to the colors of the boxes used
	for settings. If the curves do not fit inside the diagram, then
	adjust the minimum and maximum values of the axes below the graph.</span></font></font></font></p>
</ol>
<img src="images/tutorial23.jpg" name="Kép 31" align="bottom" hspace="1" border="0"/>
<p class="western" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<font face="Arial, serif"><span lang="en-US">The page will be updated
and the modified diagram will be displayed. </span></font>
</p>
<p lang="en-US" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">On
the plot, the red curve (CTCF) is shifted towards the left-hand side
of the center of the CTCF motif, with a peak around position -5. In
contrast, the RAD21 peak is shifted to the 3’ direction of the
motif and has a local maxima around position 15. Based on these
observations, it can be assumed that the fine positional shifts that
may exist between the contact points of cohesin proteins (CTCF,
RAD21, SMC1/3, and STAG1/2) might reflect the 3D position of the
components within the complex. </span></font></font></font>
</p>
<p style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Explanation:
</span></font><font face="Arial, serif"><span lang="en-US">Since</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">CTCF</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">is</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">only</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">known</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">specific</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">DNA</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">binder</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">among</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">components</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">of</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">CTCF</span></font><font face="Arial, serif"><span lang="en-US">/</span></font><font face="Arial, serif"><span lang="en-US">cohesin</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">complex</span></font><font face="Arial, serif"><span lang="en-US">,
</span></font><font face="Arial, serif"><span lang="en-US">we</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">expected</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">that</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">corresponding</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">ChIP</span></font><font face="Arial, serif"><span lang="en-US">-</span></font><font face="Arial, serif"><span lang="en-US">seq</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">peaks</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">will</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">point</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">to</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">same</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">position</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">with</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">respect</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">to</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">CTCF
motif</span></font><font face="Arial, serif"><span lang="en-US">. </span></font><font face="Arial, serif"><span lang="en-US">In</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">contrast</span></font><font face="Arial, serif"><span lang="en-US">,
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">fact</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">that</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">we</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">can
observe a </span></font><font face="Arial, serif"><span lang="en-US">positional
</span></font><font face="Arial, serif"><span lang="en-US">shift</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">suggests</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">that</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">RAD21</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">proteins</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">occupy</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">conserved</span></font><font face="Arial, serif"><span lang="en-US">
– </span></font><font face="Arial, serif"><span lang="en-US">relatively</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">fixed</span></font><font face="Arial, serif"><span lang="en-US">
– </span></font><font face="Arial, serif"><span lang="en-US">positions</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">that</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">are</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">close</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">enough</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">to</span></font><font face="Arial, serif"><span lang="en-US">
the </span></font><font face="Arial, serif"><span lang="en-US">DNA</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">so</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">as</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">to</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">allow</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">DNA</span></font><font face="Arial, serif"><span lang="en-US">-</span></font><font face="Arial, serif"><span lang="en-US">protein</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">crosslinks</span></font><font face="Arial, serif"><span lang="en-US">
to form </span></font><font face="Arial, serif"><span lang="en-US">during</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">the</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">ChIP</span></font><font face="Arial, serif"><span lang="en-US">-</span></font><font face="Arial, serif"><span lang="en-US">seq</span></font><font face="Arial, serif"><span lang="en-US">
</span></font><font face="Arial, serif"><span lang="en-US">procedure</span></font><font face="Arial, serif"><span lang="en-US">.
</span></font></font></font>
</p>
<p style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font color="#000000"><font face="Arial, serif"><span lang="en-US">The
JARID1B is known as a histone demethylase enzyme. A high fraction of
JARID1B peaks overlap with CTCF binding sites in basal breast cancer
cells </span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">(Yamamoto
et al., 2014)</span></font></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">.
The relationship between these two factors has been investigated, as
well as their relative effects on each other. According to the
knock-down experiments, they found clear evidence for CTCF-JARID1B
interactions, which suggests that the two proteins are present in the
same complex.</span></font></font> </font></font>
</p>
<img src="images/tutorial24.jpg" name="Kép 32" align="bottom" vspace="1" border="0"/>
<ol start="7">
	<li/>
<p style="margin-top: 0.19in; margin-bottom: 0in; line-height: 100%">
	<font color="#00000a"><font color="#000000"><font face="Arial, serif"><span lang="en-US">When
	JARID1B and “hs_BreastAdenocarcinoma_MCF7_cancer_JARID1B_SRX265412”
	are selected in the third row of green boxes, a flat and broad green
	curve for the third experiment appears in “PairShiftView”,
	indicating frequent CTCF-JARID1B co-appearance. Consequently, the
	standard deviation of the positions for the JARID1B curve is higher
	(20.55), than that of the other two curves. This indicates that the
	interaction between the CTCF&#8209;binding motif and the JARID1B
	protein is very likely not direct, the protein occupies the binding
	sites via several other proteins.</span></font></font></font></p>
	<li/>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
	<font color="#00000a"><font face="Arial, serif"><span lang="en-US">Use
	the second panel, if you want to start the experiment selection with
	the name of the antibody. This panel is similar to the previous with
	a slight difference, the “cell type “ and “antibody” columns
	are switched. </span></font></font>
	</p>
</ol>
<img src="images/tutorial25.jpg" name="Kép 35" align="bottom" border="0"/>
<a name="dbsnp"><p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US"><b>dbSNPView</b></span></font></p></a>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Users
	can find motifs which overlap with known nucleotide variations. The
	database contains dbSNP entries. This tutorial will demonstrate how
	to perform this action.</span></font></font></font></p>
</ol>
<p style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Click
on the “Search views” menu and then click the “dbSNPView”
button. </span></font></font></font>
</p>
<img src="images/tutorial26.jpg" name="Image1" align="bottom" border="0"/>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">There
	are two ways to find overlapping SNPs. The first one is to specify
	the dbSNP ID itself. Write “</span></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">rs1193185173”
	in the dbSNP search box, then click “Send”.</span></font></font><font face="Arial, serif"><span lang="en-US">
	</span></font>
</font></font></p>
</ol>
<img src="images/tutorial27.jpg" name="Image2" align="bottom" border="0"/>
<ol start="3">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Now
	a chromosomic view is displayed with all the SNPs and motifs. You
	can click on the motif logo and the browser immediately goes to the
	MotifView. You can also click on the SNPs to see details of the
	selected variation in a new window. You can also switch off SNPs not
	overlapping with any motifs.</span></font> </font></font>
	</p>
</ol>
<img src="images/tutorial28.jpg" name="Image3" border="0"/>
<ol start="4">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">This
	view is limited to 100 bp only. The user may want to see a larger
	genomic landscape. To perform this action, set the chromosome to 10,
	Start position to 711630, and End position to 711888. Remove the
	text from the dbSNP box. If dbSNP is set, the website will not set
	the other fields. Remark: the genomic region cannot be larger than
	1000 bp. If every setting is correct, click “Send”.</span></font>
	</font></font>
	</p>
</ol>
<img src="images/tutorial29.jpg" name="Image4" align="bottom" border="0"/>
<ol start="5">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">The
	user can now see all the motifs and variations in the region.
	Clicking on the motifs will switch to the MotifView. The overlapping
	SNPs are red. Clicking on them has a similar effect as if the user
	specified the SNP id in the website. The non-overlapping SNPs are
	blue and clicking on them will display details about the SNP.</span></font>
</font></font></p>
</ol>
<img src="images/tutorial30.jpg" name="Image5" align="bottom" border="0"/>
<a name="experiment"><p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US"><b>ExperimentView</b></span></font></p></a>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">The
processed ChIP-seq experiment’s attributes can be browsed in this
view. </span></font>
</p>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Move
	the cursor over the “Search views” menu and click on the
	“ExperimentView“ button.</span></font></font></font></p>
</ol>
<p lang="en-US" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">You
	can select a given experiment from the list using the dropdown
	boxes, which are similar to the PairShiftView panels. Click on the
	left dropdown box and select the “MCF7” cell type from the list.
	Click on the second box from the left in the row, and select CTCF
	from the list. In the third box click on the
	“hs_BreastAdenocarcinoma_MCF7_cancer_CTCF_SRX1091824”
	experiment.</span></font></font></font></p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="3">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a">
	<font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">After
	the page refreshes, you can read the attributes of each experiment.
	The following attributes can be found:</span></font></font></font></p>
	<ol type="a">
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Experiment
		name: Name of ChIP-seq data according to our nomenclature:
		“Organism (hs- Homo sapiens) _ “Tissue name” _ “Cell type”
		_ “Cell line type” _ “Antibody name” _ “SRA ID”</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Antibody:
		name of ChIP-seq target protein.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Cell
		line: Name or code of cell type</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Sra
		ftp link: Link to directly download raw SRA file in .sra format. </span></font></font></font>
		</p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Homer
		de novo motif: The htp report of the homer de novo motif scan under
		corresponding peak regions.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">GenomeView:
		link to browse the peak region in Jbrowse genome viewer.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Number
		of peaks: Number of peaks from the HOMER peak calling analysis.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Link
		to motif view if antibody and consensus motif is the same: This
		link can be used for transcription factors, which have identified
		JASPAR CORE consensus motif set. This link navigates to the
		corresponding motif’s MotifView.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Number
		of reads: Raw sequence data reads</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">SRX
		search: link to the SRA report about the experiment.</span></font></font></font></p>
		<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Overlapping
		motifs: List of motifs which are occupied by peaks for a given
		ChIP-seq. The second column represents the number of
		co-occurrences. The motif names are hyperlinks which direct the
		user to the MotifView. </span></font></font></font>
		</p>
	</ol>
</ol>
<p lang="en-US" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<a name="genome"><font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 12pt; font-weight:bold;">GenomeView</font></font></font></p></a>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">There
are two ways to use the GenomeView. After finding some interesting
experiment in MotifView you can export them into GenomeView to
visualize your finds or you can open it directly and use an “</font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><i>à
la carte</i></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">”
system to select what you would like to see. If you chose to get to
GenomeView from MotifView you can get more specific information and
also use the “</font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><i>à
la carte</i></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">”
mode, however if you do not need the experiment:consensus motif
specific peak data you can head straight to GenomeView from the
Search views menu.</font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<br/>
<br/>

</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">For
this tutorial we are going to start with, how to use GenomeView via
Motif View first. If you would like you can skip to the description
of the “</font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><i>à
la carte</i></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">”
system, as that is sufficient if you want to use GenomeView directly.
To do so please go to step II/1.</font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">I.
Importing tracks from MotifView </font></font></font>
</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">To
guide through the different steps of using ChIPSummitDB the POU2F2
motif was used as example because it has a relatively small set of
overlapping factors. We will start just like in the MotifView
tutorial.</font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">I.
/ 1. Click on the “Search views” menu and then click the
“MotifView” button.</font></font></font></p>
<p lang="en" style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<br/>
<br/>

</p>
<img src="images/tutorial32.png"  hspace="11" />
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">I.
/ 2. In the “Set a motif” dropdown box select POU2F2 and sat
“</span></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">Minimum
overlap number between motifs and peaks of experiment</font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">”
to 500.</span></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">
Than click on “Go to MotifView”</font></font></font></p>
<img src="images/tutorial33.png"  hspace="11" vspace="1" />
<p class="western" style="margin-bottom: 0in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><span lang="en">I.
/ 3</span></font></font><font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">.
After updating the page, a scatterplot for the POU2F2 motif can be
seen. For further description on what the scatterplot shows please
refer the MotifView tutorial. Please select the same experiments as
seen at the “</span></font></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en-US">Interoperability
between the different views</span></font></font><font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">”
and export them in to the genomeView.</span></font></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">
</font></font><font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">This
is the point where we diverge from the MotifView tutorial.</span></font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">For
now, please click on the 3 peak-sets shown with red arrows (I.). You
can notice that after you have clicked on a peak-set it becomes
highlighted and under the plot, some details, from the experiment
that you clicked on, will appear. Please click on “to the
GenomeView”, shown with black arrow.</span></font></font></font></p>
<img src="images/tutorial34.png"  hspace="11" vspace="1" />
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">I.
/ 6.</span></font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">You
should see something like the next screenshot. Welcome to GenomeView!
This is powered by jbrowse v16.3. If you have any familiarity with it
or any other genome visualizer (gbrowse, IGV or IGB, etc..) you will
probably navigate it easily. If this is your first time with a genome
browser the next paragraph will describe how to navigate.</span></font></font></font></p>
<img src="images/tutorial35.jpg"  hspace="11" vspace="1" />
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">The
genome is represented as the X-axis: 5’ to the left and 3’ to the
right (if you zoom in enough the sequences are shown). Data tracks
are presented under it, one beneath the other. The name of the tracks
are on the top right corner of each track. Tracks are showing
information based on genomic position. For a description how to move
around and zoom click on “Help” (red arrow) and then on
“?General”.</span></font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">I.
/ 7.</span></font></font></font></p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">If
you look around you will see the first track under the genome is the
gene map from the UCSC (</span></font></font><font color="#0000ff"><u><a href="https://genome.ucsc.edu/"><font face="Arial, serif"><font size="2" style="font-size: 11pt">https://genome.ucsc.edu/</font></font></a></u></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">).
Under it is the map of the transcription factor bindig sites, in our
case that will be for POU2F2. Under this, you will have 3 track for
the 3 selected experiments (the order you see them may vary).For a
good example please go to “chr1:157696368..157697135” (You can
simply enter it at the top).</span></font></font></font></p>
<img src="images/tutorial36.png" name="Kép 62" align="bottom" hspace="1" vspace="1" border="0"/>

<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">Here
you can see a transcription factor biding site where all 3 peak-sets
are present. The peak is represented as a line, the motif is shown as
an orange rectangle, and the orange vertical line shows the summit.
The number shows the score of the peak calling. This shows that the
summit in the p300 track is a bit to the 5’ compared to the other
two. </span></font></font></font>
</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">II.
Adding tracks </span></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en"><i>à
la carte</i></span></font></font></font></p>
<img src="images/tutorial37.png" hspace="11" />
<p>
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">II.
/ 1. Tracks can be added to GenomeView from the “select tracks”
menu (red arrow). </span></font></font></font>
</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<br/>
<br/>

</p>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
<font color="#00000a"><font face="Arial, serif"><font size="2" style="font-size: 11pt">II.
/ 2. </font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">After
clicking on it, a panel with 2 parts shows up from the left. The main
part is the table (red rectangle) which shows all the tracks
available in the database. </span></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">Here
you will find motif tracks (consensus motifs of ChIPSummitDB),
experiment (all peaks from an experiment) and miscellaneous tracks.</font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt"><span lang="en">
Other parts are to filter these. On the top (black arrow) you can
enter any text you are looking for in the database. On the left you
can use filters to show only the type of tracks you need (Green
arrows).</span></font></font><font face="Arial, serif"><font size="2" style="font-size: 11pt">
As there is an overwhelming amount of experiment tracks you can
filter these more precisely. At the yellow rectangle you can filter
expreiments based on the antibody and/or cell line that was used.</font></font></font></p>
<img src="images/tutorial38.png"  hspace="12" vspace="1" />
<p lang="en-US" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%; page-break-before: always">
<font face="Arial, serif"><span lang="en-US"><b>VennDiagramView</b></span></font></p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<p class="western" style="margin-bottom: 0in; line-height: 100%"><font face="Arial, serif"><span lang="en-US">You
can display the frequency of common and specific peaks for selected
experiments at a consensus motif binding site in the VennDiagramView.
 </span></font>
</p>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol>
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Move
	the cursor over the “Search views” menu and click on the
	“VennDiagramView” button.</span></font></font></font></p>
</ol>
<p lang="en-US" style="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="2">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">We
	will use the CTCF motif as an example. Under “Set a motif”,
	click on the drop down box and select “CTCF” from the list. </span></font></font></font>
	</p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="3">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">Below
	the motif selection, click on the first upper left (red) dropdown
	box and select the “MCF7” cell type from the list. Click on the
	second box from the left in the row, and select CTCF from the list.
	In the third red box select the name of the experiment to
	“hs_BreastAdenocarcinoma_MCF7_cancer_CTCF_SRX1091824”.</span></font></font></font></p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="4">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">In
	the next (blue) row of boxes, repeat the previous steps, but select
	RAD21 as the antibody and
	“hs_BreastAdenocarcinoma_MCF7_cancer_RAD21_ERX004452” as the
	experiment name.</span></font></font></font></p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="5">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">In
	the third (green) row, select MC7 as the cell type and JARID1B as
	the antibody. In the third box, choose
	</span></font><font color="#000000"><font face="Arial, serif"><span lang="en-US">“hs_BreastAdenocarcinoma_MCF7_cancer_JARID1B_SRX265412”
	</span></font></font><font face="Arial, serif"><span lang="en-US">from
	the list. </span></font></font></font>
	</p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="6">
	<li/>
<p style="margin-bottom: 0in; line-height: 100%"><font color="#00000a"><font face="Cambria, serif"><font face="Arial, serif"><span lang="en-US">After
	you set all the parameters, click on the “Refresh Page” button
	to display the data. The sets represent the overlap between the
	chosen motif and ChIP-seq experiments. The colors of the sets
	correspond to the colors of the dropdown boxes. The segments show
	the number of co-occurences between two or three ChIP-seq
	experiments at the motif. All segment sizes are revealed on the Venn
	diagram. </span></font></font></font>
	</p>
</ol>
<p lang="en-US" class="western" style="margin-bottom: 0in; line-height: 100%">
<br/>

</p>
<ol start="7">
	<li/>
<p style="margin-top: 0.19in; margin-bottom: 0.19in; line-height: 100%">
	<font color="#00000a"><font face="Arial, serif"><span lang="en-US">Use
	the second panel, if you want to start the experiment selection with
	the name of the antibody. This panel is similar to the previous with
	a slight difference, the “cell type“ and “antibody” columns
	are switched. </span></font></font>
	</p>
</ol>
</div>
<?php show_footer();?>
</body>
</html>
