google.charts.load("current", { packages: ["gantt"] });
google.charts.setOnLoadCallback(drawChart);

function daysToMilliseconds(days) {
  return days * 24 * 60 * 60 * 1000;
}

function drawChart() {
  // do nothing
}

function updateChart(data) {
  if (data.length === 0) {
    $("#chart_div").empty();
    return;
  }
  var newdata = new google.visualization.DataTable();
  newdata.addColumn("string", "Task ID");
  newdata.addColumn("string", "Task Name");
  newdata.addColumn("date", "Start Date");
  newdata.addColumn("date", "End Date");
  newdata.addColumn("number", "Duration");
  newdata.addColumn("number", "Percent Complete");
  newdata.addColumn("string", "Dependencies");
  newdata.addRows(data);

  var options = {
    height: data.length * 50 + 50,
    width: 1300,
    gantt: {
      trackHeight: 50
    }
  };

  var chart = new google.visualization.Gantt(
    document.getElementById("chart_div")
  );

  chart.draw(newdata, options);
}
