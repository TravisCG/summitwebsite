
function DrawAllShizCubes(howtosort,isitnew,motiveOrCelline){
	var chart2height = $('#motifchart2 .legend').length;

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
	} else if (motiveOrCelline == "cell"){
		if (howtosort == "data") {
		        var sorteddata = antiagentCount2.sort(function(x, y){
        		        return d3.descending(x.values[0].values, y.values[0].values);
	        	});
        	} else {
		        var sorteddata = antiagentCount2.sort(function(x, y){
        		        return d3.ascending(x.key, y.key);
	        	});
        	}
	} else {
		if (howtosort == "data") {
			var sorteddata = consensusCount.sort(function(x,y){
				return d3.descending(x.values[0].values, y.values[0].values);
			});
		} else {
			var sorteddata = consensusCount.sort(function(x,y){
				return d3.ascending(x.key, y.key);
			});
		}
	}

	// add the graph canvas to the body of the webpage
	  var svg = d3.select("#motifchart2").append("svg")
	    .attr("width", 200 )
	    .attr("height", 2500 )
	    .attr("class","cubechart" )
	    .attr("float","right" )
	  .append("g");

	// draw legend
	if (motiveOrCelline == "motive"){
	  var legend = svg.selectAll(".legend")
       		.data(antiagentCount)

	    .enter().append("g")
	      .attr("class", function(d) { return "legend " + isitnew;})
	      .attr("data-targets", function(d) { return d.key;})
	      .attr("transform", function(d, i) { return "translate( 40," + i * 25 + ")"; });
	}
	else if(motiveOrCelline == "cell"){
	  var legend = svg.selectAll(".legend")
	       .data(antiagentCount2)

	    .enter().append("g")
	      .attr("class", function(d) { return "legend " + isitnew;})
	      .attr("data-targets", function(d) { return d.key;})
	      .attr("transform", function(d, i) { return "translate( 40," + i * 25 + ")"; });
	} else {
	  var legend = svg.selectAll(".legend")
                       .data(consensusCount)
                       .enter().append("g")
                       .attr("class", function(d) { return "legend " + isitnew;})
                       .attr("data-targets", function(d) { return d.key;})
                       .attr("transform", function(d, i) { return "translate( 40," + i * 25 + ")"; });
	}

	  //add cube
	legend.append("rect")
		.attr("x", 0 /*width - 1300*/)
		.attr("width", 8 + "em")
		.attr("height", 1.6 + "em").style("fill", "white");
	legend.append("rect")
	        .attr("x", 105 /*width - 1135*/)
		.attr("width", 1.6 + "em")
		.attr("height", 1.6 + "em")
		.style("fill", function(d) { return d.values[0].key;})
		.style("opacity", 0.8);
	// draw legend text
	legend.append("text")
	      .attr("x", 95 /*width - 1145*/)
	      .attr("y", 9)
	      .attr("dy", ".35em")
	      .style("text-anchor", "end")
	      .text(function(d) { return d.values[0].values+ " " + d.key;})
	      .style("pointer-events", "none");
};

