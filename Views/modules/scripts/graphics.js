"use strict";
function init() {
  compras_grafica();
  ventas_grafica();
  resumen_compras();
  resumen_ventas();
}

function compras_grafica() {
  $.post(
    "Controllers/Graphics.php?op=compras_grafica",
    function (data, status) {
      data = JSON.parse(data);
      //console.log(data.fechas);

      var ctx = document.getElementById("compras_grafica");
      if (ctx) {
        ctx.height = 150;
        var myChart = new Chart(ctx, {
          type: "line",
          data: {
            labels: data.fechas,
            type: "line",
            defaultFontFamily: "Poppins",
            datasets: [
              {
                label: "Compras",
                data: data.totales,
                backgroundColor: "transparent",
                borderColor: "#f96332",
                borderWidth: 2,
                pointStyle: "circle",
                pointRadius: 3,
                pointBorderColor: "transparent",
                pointBackgroundColor: "#f96332",
              },
            ],
          },
          options: {
            responsive: true,
            tooltips: {
              mode: "index",
              titleFontSize: 12,
              titleFontColor: "#000",
              bodyFontColor: "#000",
              backgroundColor: "#fff",
              titleFontFamily: "Poppins",
              bodyFontFamily: "Poppins",
              cornerRadius: 3,
              intersect: false,
            },
            legend: {
              display: false,
              labels: {
                usePointStyle: true,
                fontFamily: "Poppins",
              },
            },
            scales: {
              xAxes: [
                {
                  display: true,
                  gridLines: {
                    display: false,
                    drawBorder: false,
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Fecha",
                  },
                  ticks: {
                    fontFamily: "Poppins",
                    fontColor: "#9aa0ac", // Font Color
                  },
                },
              ],
              yAxes: [
                {
                  display: true,
                  gridLines: {
                    display: true,
                    drawBorder: false,
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Total",
                    fontFamily: "Poppins",
                  },
                  ticks: {
                    fontFamily: "Poppins",
                    fontColor: "#9aa0ac", // Font Color
                  },
                },
              ],
            },
            title: {
              display: false,
              text: "Normal Legend",
            },
          },
        });
      }
    }
  );
}

function ventas_grafica() {
  $.post("Controllers/Graphics.php?op=ventas_grafica", function (data, status) {
    data = JSON.parse(data);
    // console.log(data.fechas);

    var ctx = document.getElementById("ventas_grafica");
    if (ctx) {
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: data.fechas,
          type: "line",
          defaultFontFamily: "Poppins",
          datasets: [
            {
              label: "Ventas",
              data: data.totales,
              backgroundColor: "transparent",
              borderColor: "#2ECC71",
              borderWidth: 2,
              pointStyle: "circle",
              pointRadius: 3,
              pointBorderColor: "transparent",
              pointBackgroundColor: "#2ECC71",
            },
          ],
        },
        options: {
          responsive: true,
          tooltips: {
            mode: "index",
            titleFontSize: 12,
            titleFontColor: "#000",
            bodyFontColor: "#000",
            backgroundColor: "#fff",
            titleFontFamily: "Poppins",
            bodyFontFamily: "Poppins",
            cornerRadius: 3,
            intersect: false,
          },
          legend: {
            display: false,
            labels: {
              usePointStyle: true,
              fontFamily: "Poppins",
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: false,
                  drawBorder: false,
                },
                scaleLabel: {
                  display: true,
                  labelString: "Fecha",
                },
                ticks: {
                  fontFamily: "Poppins",
                  fontColor: "#9aa0ac", // Font Color
                },
              },
            ],
            yAxes: [
              {
                display: true,
                gridLines: {
                  display: true,
                  drawBorder: false,
                },
                scaleLabel: {
                  display: true,
                  labelString: "Total",
                  fontFamily: "Poppins",
                },
                ticks: {
                  fontFamily: "Poppins",
                  fontColor: "#9aa0ac", // Font Color
                },
              },
            ],
          },
          title: {
            display: false,
            text: "Normal Legend",
          },
        },
      });
    }
  });
}

function resumen_compras() {
  $.post(
    "Controllers/Graphics.php?op=resumen_compras",
    function (data, status) {
      data = JSON.parse(data);
      //console.log(data);
      var ctx = document.getElementById("resumen_compras").getContext("2d");
      var myChart = new Chart(ctx, {
        type: "pie",
        data: {
          datasets: [
            {
              data: data.totales,
              backgroundColor: [
                "#191d21",
                "#63ed7a",
                "#ffa426",
                "#fc544b",
                "#6777ef",
              ],
              label: "Dataset 1",
            },
          ],
          labels: data.fechas,
        },
        options: {
          responsive: true,
          legend: {
            position: "bottom",
          },
        },
      });
    }
  );
}

function resumen_ventas() {
  $.post("Controllers/Graphics.php?op=resumen_ventas", function (data, status) {
    data = JSON.parse(data);
    //console.log(data);
    var options = {
      tooltips: {
        enabled: true,
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let sum = ctx.dataset._meta[0].total;
            let percentage = ((value * 100) / sum).toFixed(2) + "%";
            return percentage;
          },
          color: "#fff",
        },
      },
    };
    var ctx = document.getElementById("resumen_ventas").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "pie",
      data: {
        datasets: [
          {
            data: data.totales,
            backgroundColor: [
              "#191d21",
              "#63ed7a",
              "#ffa426",
              "#fc544b",
              "#6777ef",
            ],
            label: "Dataset 1",
          },
        ],
        labels: data.fechas,
      },
      options: {
        responsive: true,
        legend: {
          position: "bottom",
        },
      },
    });
  });
}

init();
