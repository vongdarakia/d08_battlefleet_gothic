function gridData() {
    var data = new Array();
    var xpos = 1;
    var ypos = 1;
    var width = 10;
    var height = 10;
    var click = 0;

    for (var row = 0; row < 100; row++) {
        data.push( new Array() );
        
        for (var column = 0; column < 150; column++) {
            data[row].push({
                x: xpos,
                y: ypos,
                width: width,
                height: height,
                click: click
            })
            xpos += width;
        }
        xpos = 1;
        ypos += height;    
    }
    return data;
}

var gridData = gridData();    
console.log(gridData);

var grid = d3.select(".grid")
    .append("svg")
    .attr("width","1502px")
    .attr("height","1002px");

var row = grid.selectAll(".row")
    .data(gridData)
    .enter().append("g")
    .attr("class", "row");

var column = row.selectAll(".square")
    .data(function(d) { return d; })
    .enter().append("rect")
    .attr("class","square")
    .attr("x", function(d) { return d.x; })
    .attr("y", function(d) { return d.y; })
    .attr("width", function(d) { return d.width; })
    .attr("height", function(d) { return d.height; })
    .style("fill", "#fff")
    .style("stroke", "gray")
    .style("stroke-width", "0.2")
    .on('click', function(d) {
        d.click ++;
        if ((d.click)%4 == 0 ) { d3.select(this).style("fill","#fff"); }
        if ((d.click)%4 == 1 ) { d3.select(this).style("fill","#2C93E8"); }
        if ((d.click)%4 == 2 ) { d3.select(this).style("fill","#F56C4E"); }
        if ((d.click)%4 == 3 ) { d3.select(this).style("fill","#838690"); }
    });

d3.selectAll(".row:nth-child(10n) .square").style("stroke-width", "0.5");
d3.selectAll(".row:first-child .square").style("stroke-width", "0.5");
d3.selectAll(".square:nth-child(10n)").style("stroke-width", "0.5");
d3.selectAll(".square:first-child").style("stroke-width", "0.5");

$(document).ready(function(){
    $("#post-data").click(function(e) {
        e.preventDefault();
        $.ajax({type: "POST",
            url: "/url",
            data: { id: $("#Shareitem").val(), access_token: $("#access_token").val() },
            success:function(result) {
          $("#sharelink").html(result);
        }});
    });
});
