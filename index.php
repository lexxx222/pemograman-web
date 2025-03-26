<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Mahasiswa & Export PDF</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <style>
        #chart-container {
            width: 100%;
            max-width: 800px;
            height: 400px;
            margin: auto;
            text-align: center;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        button, select {
            display: block;
            margin: 10px auto;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div id="chart-container">
        <canvas id="myChart"></canvas>
    </div>
    <select id="sortOption" onchange="renderChart()">
        <option value="default">Default</option>
        <option value="desc">Paling Banyak</option>
        <option value="asc">Paling Sedikit</option>
    </select>
    <button onclick="downloadPDF()">Download PDF</button>

    <script>
        async function fetchData(sortOption = "default") {
            try {
                const response = await fetch('get_data.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                let data = await response.json();
                
                // Sorting data berdasarkan pilihan pengguna
                let combined = data.labels.map((label, index) => ({ label, value: data.values[index] }));
                if (sortOption === "asc") {
                    combined.sort((a, b) => a.value - b.value);
                } else if (sortOption === "desc") {
                    combined.sort((a, b) => b.value - a.value);
                }
                
                return {
                    labels: combined.map(item => item.label),
                    values: combined.map(item => item.value)
                };
            } catch (error) {
                console.error("Error fetching data:", error);
                return { labels: [], values: [] };
            }
        }

        async function renderChart() {
            const sortOption = document.getElementById("sortOption").value;
            const data = await fetchData(sortOption);
            const ctx = document.getElementById('myChart').getContext('2d');
            if (window.myChart instanceof Chart) {
                window.myChart.destroy(); // Hapus chart sebelumnya jika ada
            }
            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: data.values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `Jumlah: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        }
        renderChart();

        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text("Grafik Mahasiswa", 10, 10);
            const canvas = document.getElementById('myChart');
            const imgData = canvas.toDataURL('image/png');
            doc.addImage(imgData, 'PNG', 10, 20, 180, 100);
            doc.save("grafik_mahasiswa.pdf");
        }
    </script>
</body>
</html>