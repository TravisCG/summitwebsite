function DrawAllShizStand_dev(argy, argx){
var width2 = $('#chart').width();

d3.select(window).on('resize', resize); 

function resize() {
    // update width
    width = parseInt(d3.select('#chart').style('width'), 10);

    // reset x range
 //   x.range([0, width]);

    // do the actual resize...
}



// setup x
var xValue = function(d) { return d[argx];}, // data -> value
    xScale = d3.scale.linear().range([0, width2 - 55]), // value -> display
    xMap = function(d) { return xScale(xValue(d));}, // data -> display
    xAxis = d3.svg.axis().scale(xScale).orient("center");

// setup y
var yValue = function(d) { return d[argy]; }, // data -> value (this is acsi magics if stand_dev is NA retun 0)
    yScale = d3.scale.linear().range([450, 0]), // value -> display
    yMap = function(d) { return yScale(yValue(d));}, // data -> display
    yAxis = d3.svg.axis().scale(yScale).orient("left");

// setup fill color
// a kockak itt vannak elnevezve
  var cValue = function(d) { return d.antiagent;},
    color = d3.scale.category20();
 //   .attr("transform", "translate(100px , 0 )");

// add the graph canvas to the body of the webpage
  var svg = d3.select("#chart").append("svg")
//    .attr("width", width + margin.left + margin.right + legendtitle)
    .attr("width", "95%")
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
// add the tooltip area to the webpage
  var tooltip = d3.select("#chart").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

// load data


  // don't want dots overlapping axis, so add in buffer to data domain
  xScale.domain([d3.min(data, xValue)-1, d3.max(data, xValue)+1]);
  yScale.domain([d3.min(data, yValue)-6, d3.max(data, yValue)+1]);
  //yScale.domain([-80, +80]);
  // x-axis
  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0, 450 )")
      .call(xAxis)
    .append("text")
      .attr("class", "label")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "end")
      .text(argx); // y-axis
  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("class", "label")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text(argy);





  // draw dots

  svg.selectAll(".dot")
.data(data)
.enter().append("circle")
.attr("class", function(d) { return "dot " + d.antiagent;})

      .attr("r", function(d) {
        if(d.factor_type == "CF"){
            return 2.5;
}
                else {
            return 3.5;
                        }
    }
)

      .attr("cx", xMap)
      .attr("cy", yMap)
      .style("fill", function(d) { return d.colour_hex;})
      .style("opacity", function(d) {
        if(d.factor_type == "CF"){
            return 0.3;
}
		else {
            return 1;
        		}
    }
)



.on("mouseover", function(d) {
          tooltip.transition()
               .duration(200)
               .style("opacity",  0.9);

 tooltip.html("<br/> (experiment name:" + d.exp_name 
		+ "<br/> cell line: " + d.cell_line 
                + "<br/> antibody: " + d.antibody 
		+ "<br/> average deviation: " + d.average 
		+ "<br/> element number: " + d.element_num 
		+ "<br/> standard deviation: " + d.std_dev 
		+ ")")
               .style("left", (d3.event.pageX + 5) + "px")
               .style("top", (d3.event.pageY - 28) + "px");
               //.style("transition: opacity 1s")




      })
      .on("mouseout", function(d) {
          tooltip.transition()
               .duration(500)
               .style("opacity", 0);
});





}; 
