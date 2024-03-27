
// Donut Chart
var user_count =document.getElementById("user_count").value;
var admin_count =document.getElementById("admin_count").value;
var super_admin_count =document.getElementById("super_admin_count").value;

var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
var pieData = {
labels: [
    'User',
    'Admin',
    'Super Admin'
],
datasets: [
    {
    data: [user_count, admin_count, super_admin_count],
    backgroundColor: ['#f56954', '#00a65a', '#f39c12']
    }
]
}
var pieOptions = {
legend: {
    display: false
},
maintainAspectRatio: false,
responsive: true
}
// You can switch between pie and douhnut using the method below.
var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
type: 'doughnut',
data: pieData,
options: pieOptions
})


// The Calender
$('#calendar').datetimepicker({
format: 'L',
inline: true
})



/* jQueryKnob */
$('.knob').knob()