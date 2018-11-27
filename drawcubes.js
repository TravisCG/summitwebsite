
function DrawAllShizCubes(howtosort,isitnew,motiveOrCelline){
var chart2height = $('#motifchart2 .legend').length;
// setup fill color
// a kockak nem itt vannak elnevezve, hanem a motive_viewnél
  var cValue = function(d) { return d.tokmindegy;},
    color = d3.scale.category20();

if (motiveOrCelline == "motive"){

	if (howtosort == "data") {
	var sorteddata = antiagentCount.sort(function(x, y){
		return d3.descending(x.values[0].values, y.values[0].values);
	});
	} else {
	var sorteddata = antiagentCount.sort(function(x, y){
		return d3.ascending(x.key, y.key);
	});
	}
} else {
	if (howtosort == "data") {
        var sorteddata = antiagentCount2.sort(function(x, y){
                return d3.descending(x.values[0].values, y.values[0].values);
        });
        } else {
        var sorteddata = antiagentCount2.sort(function(x, y){
                return d3.ascending(x.key, y.key);
        });
        }

}




// add the graph canvas to the body of the webpage
  var svg = d3.select("#motifchart2").append("svg")
    .attr("width", 250 )
    .attr("height", 2500 )
    .attr("class","cubechart" )
    .attr("float","right" )
  .append("g");

//load data
  // x-axis
  svg.append("g")
      .attr("class", "axisRed")

  // y-axis
  svg.append("g")
      .attr("class", "axisRed")

  // draw dots
  svg.selectAll(".dot")
    .data(sorteddata)
    .enter().append("circle")
    .style("fill", function(d) { return color(cValue(d));})




// draw legend
if (motiveOrCelline == "motive"){
  var legend = svg.selectAll(".legend")
       .data(antiagentCount)

    .enter().append("g")
      .attr("class", function(d) { return d.key + "leg legend " + isitnew;})
      .attr("data-targets", function(d) { return d.key;})
      .attr("transform", function(d, i) { return "translate( 40," + i * 25 + ")"; });
}

else {
  var legend = svg.selectAll(".legend")
       .data(antiagentCount2)

    .enter().append("g")
      .attr("class", function(d) { return d.key + "leg legend " + isitnew;})
      .attr("data-targets", function(d) { return d.key;})
      .attr("transform", function(d, i) { return "translate( 40," + i * 25 + ")"; });
}

  //add cube
  legend.append("g")
        .append("rect")
        .attr("x", width - 1135)
      .attr("width", 1.6 + "em")
      .attr("height", 1.6 + "em")
        .style("fill", function(d) { return d.values[0].key;})
	.style("opacity", 0.8);
// draw legend text
  legend.append("text")
      .attr("x", width - 1145)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .text(function(d) { return d.values[0].values+ " " + d.key;})
      .style("pointer-events", "none");
;


};

