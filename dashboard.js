document.addEventListener('DOMContentLoaded', function() {
    fetch('dashboardsales.php')
        .then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.success) {
                // Extracting data for Chart.js
                const productNames = jsonResponse.data.map(item => item.ProdName);
                const salesData = jsonResponse.data.map(item => item.sold);
                const revenueData = jsonResponse.data.map(item => item.revenue);
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueChart = new Chart(revenueCtx, {
                    type: 'line',  // Line chart for displaying revenue
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            } else {
                // Logging and displaying error messages if the fetch was unsuccessful
                console.error('Error fetching data: ', jsonResponse.error);
                alert('Failed to fetch data: ' + jsonResponse.error);
            }
        })
        .catch(error => {
            console.error('Error parsing JSON: ', error);
            alert('Error parsing JSON. Please check the console for more details.');
        });
});
