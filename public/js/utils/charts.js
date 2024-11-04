Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

export function chartArea(ctx, labels, data) {
  return new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
    options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
  });
}

export function chartBar(ctx, labels, data) {
    const colors = ["#4e73df", "#2e59d9", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b", "#858796", "#f8b500"];
    const backgroundColors = labels.map((_, index) => colors[index % colors.length]);
    return new Chart(ctx, {
        type: 'bar',
        data: {
        labels: labels,
        datasets: [{
            label: "Revenue",
            backgroundColor: backgroundColors, // Asignar colores dinámicos
            hoverBackgroundColor: backgroundColors.map(color => darkenColor(color, 20)), // Ajuste del color de hover (opcional)
            borderColor: "#4e73df",
            data: data,
        }],
        },
        options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
            }
        },
        scales: {
            xAxes: [{
            time: {
                unit: 'number'
            },
            gridLines: {
                display: false,
                drawBorder: false
            },
            ticks: {
                maxTicksLimit: 6
            },
            maxBarThickness: 25,
            }],
            yAxes: [{
            ticks: {
                stepSize: 1,
                min: 0,
            },
            gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
            }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        },
    });
}

function darkenColor(color, percent) {
    const num = parseInt(color.replace("#", ""), 16),
            amt = Math.round(2.55 * percent),
            R = (num >> 16) - amt,
            G = (num >> 8 & 0x00FF) - amt,
            B = (num & 0x0000FF) - amt;
    return "#" + (0x1000000 + (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 + (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 + (B < 255 ? (B < 1 ? 0 : B) : 255)).toString(16).slice(1);
}