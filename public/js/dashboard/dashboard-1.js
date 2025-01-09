var chartBar = function (ss = [], cats = []) {
  var options = {
    series: ss,
    chart: {
      type: "area",
      height: 350,
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    colors: ["#2f4cdd", "#c20808"],
    dataLabels: {
      enabled: true,
    },
    markers: {
      shape: "circle",
    },
    legend: {
      show: true,
      fontSize: "12px",

      labels: {
        colors: "#000000",
      },
      position: "top",
      horizontalAlign: "left",
      markers: {
        width: 19,
        height: 19,
        strokeWidth: 0,
        strokeColor: "#fff",
        fillColors: undefined,
        radius: 4,
        offsetX: -5,
        offsetY: -5,
      },
    },
    stroke: {
      show: true,
      width: 4,
      colors: ["#2f4cdd", "#b519ec"],
    },

    grid: {
      borderColor: "#eee",
    },
    xaxis: {
      categories: cats,
      labels: {
        style: {
          colors: "#3e4954",
          fontSize: "13px",
          fontFamily: "Poppins",
          fontWeight: 100,
          cssClass: "apexcharts-xaxis-label",
        },
      },
      crosshairs: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        style: {
          colors: "#3e4954",
          fontSize: "13px",
          fontFamily: "Poppins",
          fontWeight: 100,
          cssClass: "apexcharts-xaxis-label",
        },
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return " " + val + " ";
        },
      },
    },
  };
  var chartBar1 = new ApexCharts(document.querySelector("#chartBar"), options);
  chartBar1.render();
};
$(document).ready(() => {
  // chartBar(series, categories);
  //   console.log("document is ready");
});
