// this script will add the three choices to chart3 and make a download button , a jbrowse link and an exp_view link

var firstChoice = "Not yet selected";
var secondChoice =  "Not yet selected";
var thirdChoice =  "Not yet selected";

var firstIndex = "not_yet_selected";
var secondIndex = "not_yet_selected";
var thirdIndex = "not_yet_selected";

var firstIndexjbrowse = "not_yet_selected";
var secondIndexjbrowse = "not_yet_selected";
var thirdIndexjbrowse = "not_yet_selected";


var firstAvgName = "not_yet_selected";
var secondAvgName = "not_yet_selected";
var thirdAvgName = "not_yet_selected";


var chosenexp = "";
var whichone = 3;
//so when it loads, it sets the third one and the user 
//starts with setting the first

function choosethree(x,y,z,w) {


if (whichone == 1) {
chosenexp = z;
firstChoice = x;
firstIndex = y;
firstIndexjbrowse = z;
firstAvgName = w;
whichone = 2;

}

else if (whichone == 2) { 
chosenexp = z;
secondChoice = x;
secondIndex = y;
secondIndexjbrowse = z;
secondAvgName = w;
whichone = 3;

}
else if (whichone == 3) { 
chosenexp = z;
thirdChoice = x;
thirdIndex = y;
thirdIndexjbrowse = z;
thirdAvgName = w;
whichone = 1;

}

d3.selectAll(".threechosen").remove();





var svgthree = d3.select("#motifchart3").append("text")
.html(function(d) { return "<div id=\"mfunchelp\" >You flagged the following experiments (cell line, antibody, <a title=\"The number of peak regions obtained in a ChIP-seq experiment, which overlap with a particular consensus motif binding site set. \">element number</a>): <br/> The blue buttons will help navigating to the other views.<br>Click on the buttons to open <br> the \'experiment view\' for more details <br>about the Chip-seq data. </div>"})
.attr("class", "threechosen");



var widththree = "15em";
var heightthree = "4em";
var word = "download last selected";
var wordshift = "to paired shifts";
var wordjbrowse = "to the genome view";
var wordvenn = "to venn diagram";




var holdertwo = d3.select("#motifchart3")
      .append("svg")
      .attr("width", "15em")
      .attr("height", "8em")
      .attr("class", "threechosen");
// draw a rectangle for the downloads
holdertwo.append("a")
    .attr("xlink:href", function(d) {
return "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + firstIndexjbrowse ;})
    .attr("target", "blank")
    .append("rect")
    .attr("x", "0.1em")
    .attr("y", "0em")
    .attr("height", "2.5em")
    .attr("width", "15em")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")

holdertwo.append("a")
    .attr("xlink:href", function(d) {
return "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" + secondIndexjbrowse ;})
    .attr("target", "blank")
    .append("rect")
    .attr("x", "0.1em")
    .attr("y", "2.7em")
    .attr("height", "2.5em")
    .attr("width", "15em")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.6em")

holdertwo.append("a")
    .attr("xlink:href", function(d) {
return "http://summit.med.unideb.hu/summitdb/experiment_view.php?exp=" +  thirdIndexjbrowse;})
    .attr("target", "blank")
    .append("rect")
    .attr("x", "0.1em")
    .attr("y", "5.4em")
    .attr("height", "2.5em")
    .attr("width", "15em")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")


// draw text on the screen
holdertwo.append("text")
    .attr("x", "7.55em")
    .attr("y", "0em")
    .style("fill", "black")
    .style("font-size", "1em")
    .attr("dy", "1.6em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text( firstChoice )

// draw text on the screen
holdertwo.append("text")
    .attr("x", "7.55em")
    .attr("y", "2.7em")
    .style("fill", "black")
    .style("font-size", "1em")
    .attr("dy", "1.6em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text( secondChoice )

// draw text on the screen
holdertwo.append("text")
    .attr("x", "7.55em")
    .attr("y", "5.4em")
    .style("fill", "black")
    .style("font-size", "1.0em")
    .attr("dy", "1.6em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text( thirdChoice );


var holderthree = d3.select("#motifchart3")
      .append("svg")
      .attr("width", "17em")    
      .attr("height", "8em")
      .attr("class", "threechosen");
// draw a rectangle for the downloads
holderthree.append("a")
    .attr("xlink:href", function(d) { return "http://summit.med.unideb.hu/summitdb/downloads_BE.php?exp=" +  chosenexp  + "&motive=" + motive;})
    .append("rect")  
    .attr("x", "3.1em")
    .attr("y", "2.9em")
    .attr("height", "2.5em")
    .attr("width", "13.4em")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")
    .append("title")
    .text("Download genomic data of the last selected experiemnt in BED format");

// draw text on the screen
holderthree.append("text")
    .attr("x", "9.8em")
    .attr("y", "1em")
    .style("fill", "black")
    .style("font-size", "1em")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text("More views to browse.");

holderthree.append("rect")
    .attr("id", "clearExp")
    .attr("x", "3.1em")
    .attr("y", "5.5em")
    .attr("height", "2.5em")
    .attr("width", "13.4em")
    .attr("fill", "tomato")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")
    .on("click", function(){
       whichone = 1;
       for(i = 1; i < 4; i++){
         choosethree("Not yet selected");
         var point = document.querySelector(".red" + i);
         if(point != null){
           point.style.stroke = "grey";
           point.style.strokeWidth = 1;
           point.classList.remove("red" + i);
         }
       }
    });

holderthree.append("text")
    .attr("x", "9.8em")
    .attr("y", "5.5em")
    .attr("text-anchor", "middle")
    .attr("dy", "1.7em")
    .style("font-size", "1em")
    .style("pointer-events", "none")
    .text("Clear all selected");

holderthree.append("text")
    .attr("x", "9.8em")
    .attr("y", "4.4em")
    .style("fill", "black")
    .style("font-size", "1em")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text(word);
// paired shift view part

var holdershift = d3.select("#motifchart3")
      .append("svg")
      .attr("width", "15em")
      .attr("height", "8.5em")
      .attr("class", "threechosen");
// draw a button for the shift views
holdershift.append("a")
    .attr("xlink:href", function(d) { 
return "http://summit.med.unideb.hu/summitdb/paired_shift_view.php?exp1=" +  firstIndexjbrowse + "&exp2=" + secondIndexjbrowse  + "&exp3=" + thirdIndexjbrowse + "&motive=" + motive + "&motifid=" + motifid[0].motif_id +"&limit=25&low_limit=-25&formminid=" + formminid + "&formmaxid=" + formmaxid + "&mnelem=" + formminelem + "&formmaxelem=" + formmaxelem;})
    .attr("target", "blank")
    .append("rect")  
    .attr("x", "0.1em")
    .attr("y", "0.2em")
    .attr("height", "2.5em")
    .attr("width", "11.8em")
    .style("stroke", "blue")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")

// draw text on the screen
holdershift.append("text")
    .attr("x", "5.4em")
    .attr("y", "1.3em")
    .style("fill", "black")
    //.style("font-size", "1.1em")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text(wordshift)

holdershift.append("svg:title")
     .text("Check the distance distribution of selected experiments in frequency histogram. \n \nBrowse the genomic data of selected experiments in genome browser. \n \nDisplay the overlap information between selected experiments as a Venn diagram. Download genomic data of the last selected experiment in BED format.")
//jbrowse part

var holderjb = d3.select("#motifchart3")
      .append("svg")
      .attr("width", "11em")    
      .attr("height", "8em")
      .attr("class", "threechosen");
// draw a button for the jbrowse
holdershift.append("a")
    .attr("xlink:href", function(d) {
if(secondAvgName == "not_yet_selected"){
  secondAvgName = firstAvgName;
  secondIndex = firstIndex;
}
if(typeof thirdAvgName === "undefined"){
  thirdAvgName = secondAvgName;
  thirdIndex = secondIndex;
}

return "http://summit.med.unideb.hu/jbrowse/index.html?tracks=DNA,ucsc-known-genes,mot-" + motifid[0].motif_id + "," + firstAvgName + "," + secondAvgName + "," + thirdAvgName +"&addStores={\"" + firstAvgName + "\":{\"type\":\"JBrowse/Store/SeqFeature/GFF3\",\"baseUrl\":\".\",\"urlTemplate\":\"{dataRoot}/gff3/" + firstIndex + ".gff3\"},\"" + secondAvgName + "\":{\"type\":\"JBrowse/Store/SeqFeature/GFF3\",\"baseUrl\":\".\",\"urlTemplate\":\"{dataRoot}/gff3/" + secondIndex + ".gff3\"},\"" + thirdAvgName + "\":{\"type\":\"JBrowse/Store/SeqFeature/GFF3\",\"baseUrl\":\".\",\"urlTemplate\":\"{dataRoot}/gff3/" + thirdIndex + ".gff3\"}}&addTracks=[{\"label\":\"" + firstAvgName + "\",\"type\":\"JBrowse/View/Track/CanvasFeatures\",\"store\":\"" + firstAvgName + "\"},{\"label\":\"" + secondAvgName + "\",\"type\":\"JBrowse/View/Track/CanvasFeatures\",\"store\":\"" + secondAvgName + "\"},{\"label\":\"" + thirdAvgName + "\",\"type\":\"JBrowse/View/Track/CanvasFeatures\",\"store\":\"" + thirdAvgName + "\"}]";})
    .attr("target", "_blank")
    .append("rect")  
    .attr("x", "0.1em")
    .attr("y", "2.9em")
    .attr("height", "2.5em")
    .attr("width", "11.8em")
    .style("stroke", "blue")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em")

// draw text on the screen
holdershift.append("text")
    .attr("x", "5.4em")
    .attr("y", "3.8em")
    .style("fill", "black")
    //.style("font-size", "1.1em")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text(wordjbrowse)
//holderthree.append("svg:title")
//     .text("Browse the genomic data of selected experiments in genome browser.")


//venn diagramm part

var holdervenn = d3.select("#motifchart3")
      .append("svg")
      .attr("width", "13em")
      .attr("height", "8em")
      .attr("class", "threechosen");
// draw a button for the shift views
holdershift.append("a")
    .attr("xlink:href", function(d) { 
return "http://summit.med.unideb.hu/summitdb/venn_diagramm.php?exp1=" +  firstIndexjbrowse + "&exp2=" + secondIndexjbrowse  + "&exp3=" + thirdIndexjbrowse + "&motive=" + motive + "&motifid=" + motifid[0].motif_id + "&mnelem=" + getAllUrlParams().mnelem ;})
    .attr("target", "blank")
    .append("rect")  
    .attr("x", "0.1em")
    .attr("y", "5.6em")
    .attr("height", "2.5em")
    .attr("width", "11.8em")
    .style("stroke", "blue")
    .style("fill", "lightblue")
    .attr("rx", "0.3em")
    .attr("ry", "0.3em");

// draw text on the screen
holdershift.append("text")
    .attr("x", "5.4em")
    .attr("y", "6.3em")
    .style("fill", "black")
    //.style("font-size", "1.1em")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle")
    .style("pointer-events", "none")
    .text(wordvenn)
//holdershift.append("svg:title")
//     .text("Display the overlap information between selected experiments as a Venn diagram. Download genomic data of the last selected experiment in BED format.")




};

