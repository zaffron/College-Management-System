
// -- Bar Chart Students per department
var ctx = document.getElementById("myBarChart");

var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: deptNames,
        datasets: [{
            label: "Students Number",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: studCounts,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'Department'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 20
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 100,
                    maxTicksLimit: 6
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: true
        }
    }
});