var maxValue = d3.max([  // Find the max value of a list of 3 elements
    d3.max(data, function(d) { return d.count; }), // Find the max value in `set1`
    d3.max(data2, function(d) { return d.count; }),  // Find the max value in `set2`
    d3.max(data3, function(d) { return d.count; })  // Find the max value in `set3`
]) * 1.1;


var width2 = "95%";
var w = $('#chart').width() *0.65;
    h = $('#chart').height() *0.85;

var xax = d3.scale.linear().domain([xlowlimit,xhilimit]).range([70,1442]);
var yax = d3.scale.linear().domain([0, maxValue]).range([h, 0]);

var chartlength = Math.max(data.length, data2.length, data3.length);

var chart = d3.select("#chart").append("svg")
    .attr("class", "chart")
    .attr("width", width2)
    .attr("height", h + 200);

movingAvg = function(n) {
    return function (points) {
        points = points.map(function(each, index, array) {
            var to = index + n - 1;
            var subSeq, sum;
            if (to < points.length) {
                subSeq = array.slice(index, to + 1);
                sum = subSeq.reduce(function(a,b) { return [a[0] + b[0], a[1] + b[1]]; });
                return sum.map(function(each) { return each / n; });
            }
            return undefined;
        });

 points = points.filter(function(each) { return typeof each !== 'undefined' });
        // Transform the points into a base line
        pathDesc = d3.svg.line().interpolate("basis")(points)
        //                 // Remove the extra "M"
        return pathDesc.slice(1, pathDesc.length);
        }
}

var movingAverageLine = d3.svg.line()
    .x(function(d) {return xax(d.distance); })
    .y(function(d) {return yax(d.count);})
    .interpolate(movingAvg(5));

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#bb0000")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(data))
 .on('mouseover', function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
    chart.append("line")
       .attr("id", "actualpos")
       .attr("x1", d3.mouse(this)[0] + 1) //this little shift prevents the mouseout event
       .attr("y1", d3.mouse(this)[1] + 1) //fire too early
       .attr("x2", d3.mouse(this)[0])
       .attr("y2", yax(0))
       .attr("stroke-width", "2")
       .attr("stroke", "black");
    chart.append("text")
         .attr("id", "posxy")
         .attr("x", d3.mouse(this)[0] - 10)
         .attr("y", d3.mouse(this)[1] - 10)
         .text( xax.invert(d3.mouse(this)[0]).toFixed(2));
  })
 .on('mouseout', function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
  });

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#0000cc")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(data2))
 .on('mouseover', function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
    chart.append("line")
         .attr("id", "actualpos")
         .attr("x1", d3.mouse(this)[0] + 1) //this little shift prevents the mouseout event
         .attr("y1", d3.mouse(this)[1] + 1) //fire too early
         .attr("x2", d3.mouse(this)[0])
         .attr("y2", yax(0))
         .attr("stroke-width", "2")
         .attr("stroke", "black");
    chart.append("text")
         .attr("id", "posxy")
         .attr("x", d3.mouse(this)[0] - 10)
         .attr("y", d3.mouse(this)[1] - 10)
         .text( xax.invert(d3.mouse(this)[0]).toFixed(2) );
  })
 .on('mouseout', function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
  });

chart.append('svg:path')
 .attr('class', 'avg')
 .style("stroke", "#00cc00")
 .style("stroke-width", "5")
 .style("fill", "none")
 .attr("d", movingAverageLine(data3))
 .on("mouseover", function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
    chart.append("line")
         .attr("id", "actualpos")
         .attr("x1", d3.mouse(this)[0] + 1) //this little shift prevents the mouseout event
         .attr("y1", d3.mouse(this)[1] + 1) //fire too early
         .attr("x2", d3.mouse(this)[0])
         .attr("y2", yax(0))
         .attr("stroke-width", "2")
         .attr("stroke", "black");
    chart.append("text")
         .attr("id", "posxy")
         .attr("x", d3.mouse(this)[0] - 10)
         .attr("y", d3.mouse(this)[1] - 10)
         .text( xax.invert(d3.mouse(this)[0]).toFixed(2) );
  })
 .on("mouseout", function(){
    chart.select("#actualpos").remove();
    chart.select("#posxy").remove();
  });

// setting up the x and the y axis
chart.append("line")
    .attr("x1", 50)
    .attr("y1", yax(0))
    .attr("x2", xax(xhilimit))
    .attr("y2", yax(0))
    .attr("stroke-width", 2)
    .attr("stroke", "black");

chart.append("line")
    .attr("x1", 70)
    .attr("y1", yax(0)+15)
    .attr("x2", 70)
    .attr("y2", yax(maxValue))
    .attr("stroke-width", 2)
    .attr("stroke", "black");

// the numbers to the chart are added here
for(xpos = xlowlimit; xpos < xhilimit; xpos += 5){
  chart.append("text")
      .attr("class", "label")
      .attr("x", xax(xpos) - 9)
      .attr("y", yax(0)+25)
      .text(xpos);

  chart.append("line")
      .attr("x1", xax(xpos))
      .attr("x2", xax(xpos))
      .attr("y1", yax(0) - 5)
      .attr("y2", yax(0) + 5)
      .attr("stroke-width", 2)
      .attr("stroke", "black");
}

step = maxValue / 10;
if(step < 2){
  step = 1;
}
else if(step < 8){
  step = 5;
}
else if(step < 30){
  step = 10;
}
else if(step < 100){
  step = 50;
}
else if(step < 300){
  step = 500;
}
else{
  step = 1000;
}

for(ypos = 0; ypos < maxValue; ypos += step){
  var markpos = Math.round(ypos);
  chart.append("text")
      .attr("class", "label")
      .attr("x", 14)
      .attr("y", yax(markpos) + 5)
      .text(markpos);

  chart.append("line")
      .attr("x1", 65)
      .attr("x2", 75)
      .attr("y1", yax(markpos))
      .attr("y2", yax(markpos))
      .attr("stroke-width", 2)
      .attr("stroke", "black");
}
