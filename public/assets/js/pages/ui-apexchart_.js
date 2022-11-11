 
var barOptions = {
  series: [
    {
      name: "Compras",
      data: [],
    },
    {
      name: "Ventas",
      data: [],
    },
    {
      name: "Ingresos",
      data: [],
    },
    {
      name: "Egresos",
      data: [],
    },
  ],
  chart: {
    type: "bar",
    height: 400,
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      endingShape: "rounded",
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: ["Ene","Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct","Nov","Dic"],
  },
  yaxis: {
    title: {
      text: "$ ",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " ";
      },
    },
  },
};

 
var bar = new ApexCharts(document.querySelector("#bar"), barOptions);
 
bar.render();
 