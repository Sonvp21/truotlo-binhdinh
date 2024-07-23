<script>
    // Lấy dữ liệu từ controller
    const datasets = {!! $chartData !!};
    const datasetsB = {!! $chartDataB !!};
    const lineCount = {!! $lineCount !!};

    // Cập nhật số lượng đường
    document.getElementById('lineCount').textContent = lineCount;

    // Định nghĩa các màu cho từng đường
    const colors = [
        'rgba(75, 192, 192, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(201, 203, 207, 1)'
    ];

    // Áp dụng màu và style cho mỗi dataset
    datasets.forEach((dataset, index) => {
        dataset.borderColor = colors[index % colors.length];
        dataset.borderWidth = 2;
        dataset.fill = false;
        dataset.showLine = true;
        dataset.tension = 0.2;
    });
    datasetsB.forEach((dataset, index) => {
        dataset.borderColor = colors[index % colors.length];
        dataset.borderWidth = 2;
        dataset.fill = false;
        dataset.showLine = true;
        dataset.tension = 0.2;
    });

    function generateCustomLegend(chart, containerId) {
        const legendContainer = document.getElementById(containerId);
        legendContainer.innerHTML = '';

        const ul = document.createElement('ul');
        ul.style.listStyle = 'none';
        ul.style.padding = '0';

        chart.data.datasets.forEach((dataset, index) => {
            const li = document.createElement('li');
            li.style.display = 'flex';
            li.style.alignItems = 'center';
            li.style.marginBottom = '5px';
            li.style.cursor = 'pointer';

            const colorBox = document.createElement('span');
            colorBox.style.display = 'inline-block';
            colorBox.style.width = '20px';
            colorBox.style.height = '20px';
            colorBox.style.marginRight = '10px';
            colorBox.style.backgroundColor = dataset.borderColor;

            const text = document.createElement('span');
            text.textContent = dataset.label;

            li.appendChild(colorBox);
            li.appendChild(text);

            li.onclick = () => {
                const meta = chart.getDatasetMeta(index);
                meta.hidden = !meta.hidden;
                chart.update();
                li.style.opacity = meta.hidden ? '0.5' : '1';
            };

            ul.appendChild(li);
        });

        legendContainer.appendChild(ul);
    }

    const ctx = document.getElementById('landslideChart').getContext('2d');
    const landslideChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Chuyển vị ngang tích lũy (mm) từ ngày 19/11/2023'
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Độ cao (m)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Đo nghiêng, hướng Tây - Đông'    
                },
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.x !== null) {
                                label += `(${context.parsed.x.toFixed(3)}, ${context.parsed.y})`;
                            }
                            return label;
                        }
                    }
                },
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'xy'
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            }
        }
    });

    const chartB = document.getElementById('showChartB').getContext('2d');
    const showChartB = new Chart(chartB, {
        type: 'line',
        data: {
            datasets: datasetsB
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Chuyển vị ngang tích lũy (mm) từ ngày 19/11/2023'
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Độ cao (m)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Đo nghiêng, hướng Bắc - Nam'
                },
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.x !== null) {
                                label += `(${context.parsed.x.toFixed(3)}, ${context.parsed.y})`;
                            }
                            return label;
                        }
                    }
                },
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'xy'
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            }
        }
    });

    generateCustomLegend(landslideChart, 'legendContainerA');
    generateCustomLegend(showChartB, 'legendContainerB');

    // Thêm chức năng ẩn/hiện legend cho cả hai biểu đồ
    function setupToggleLegend(chartInstance, toggleId, legendContainerId) {
        const toggleLegend = document.getElementById(toggleId);
        const arrowIcon = toggleLegend.querySelector('.arrow-icon');
        const legendContainer = document.getElementById(legendContainerId);
    
        toggleLegend.addEventListener('click', () => {
            legendContainer.style.display = legendContainer.style.display === 'none' ? 'block' : 'none';
            arrowIcon.classList.toggle('up');
            
            // Thay đổi nội dung của icon
            if (arrowIcon.classList.contains('up')) {
                arrowIcon.innerHTML = '&#9650;'; // Mũi tên lên
            } else {
                arrowIcon.innerHTML = '&#9660;'; // Mũi tên xuống
            }
        });
    }

    setupToggleLegend(landslideChart, 'toggleLegendA', 'legendContainerA');
    setupToggleLegend(showChartB, 'toggleLegendB', 'legendContainerB');

    // Xử lý form chọn khoảng thời gian
document.getElementById('dateRangeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const startDate = document.getElementById('start_date').value;
    const startTime = document.getElementById('start_time').value;
    const endDate = document.getElementById('end_date').value;
    const endTime = document.getElementById('end_time').value;
    
    // Chuyển hướng với tham số mới
    window.location.href = `${window.location.pathname}?start_date=${startDate}&start_time=${startTime}&end_date=${endDate}&end_time=${endTime}`;
});

// Lọc dữ liệu theo thời gian
function filterDataByDateRange(datasets, startDate, startTime, endDate, endTime) {
    const start = new Date(`${startDate}T${startTime}`);
    const end = new Date(`${endDate}T${endTime}`);

    return datasets.map(dataset => {
        if (dataset.label === 'Điểm chuẩn') return dataset;
        
        const filteredData = dataset.data.filter(point => {
            const pointDate = new Date(dataset.label);
            return pointDate >= start && pointDate <= end;
        });
        
        return {...dataset, data: filteredData};
    }).filter(dataset => dataset.data.length > 0 || dataset.label === 'Điểm chuẩn');
}

// Áp dụng bộ lọc nếu có tham số thời gian
const urlParams = new URLSearchParams(window.location.search);
const startDate = urlParams.get('start_date');
const startTime = urlParams.get('start_time') || '00:00';
const endDate = urlParams.get('end_date');
const endTime = urlParams.get('end_time') || '23:59';

if (startDate && endDate) {
    datasets = filterDataByDateRange(datasets, startDate, startTime, endDate, endTime);
    datasetsB = filterDataByDateRange(datasetsB, startDate, startTime, endDate, endTime);
    
    // Cập nhật biểu đồ
    landslideChart.data.datasets = datasets;
    landslideChart.update();
    
    showChartB.data.datasets = datasetsB;
    showChartB.update();
    
    // Cập nhật số lượng đường
    document.getElementById('lineCount').textContent = datasets.length - 1; // Trừ 1 vì có điểm chuẩn
}

// Đặt giá trị ban đầu cho các trường input date và time
document.addEventListener('DOMContentLoaded', function() {
    const datasets = {!! $chartData !!};
    let minDate = null;
    let maxDate = null;

    datasets.forEach(dataset => {
        if (dataset.label !== 'Điểm chuẩn') {
            const date = new Date(dataset.label);
            if (!minDate || date < minDate) minDate = date;
            if (!maxDate || date > maxDate) maxDate = date;
        }
    });

    if (minDate && maxDate) {
        document.getElementById('start_date').value = minDate.toISOString().split('T')[0];
        document.getElementById('start_time').value = minDate.toTimeString().slice(0, 5);
        document.getElementById('end_date').value = maxDate.toISOString().split('T')[0];
        document.getElementById('end_time').value = maxDate.toTimeString().slice(0, 5);
    }
});

document.getElementById('exportExcel').addEventListener('click', function() {
    var startDate = document.getElementById('start_date').value;
    var startTime = document.getElementById('start_time').value;
    var endDate = document.getElementById('end_date').value;
    var endTime = document.getElementById('end_time').value;

    var url = '/export-excel?' + 
              'start_date=' + encodeURIComponent(startDate) + 
              '&start_time=' + encodeURIComponent(startTime) + 
              '&end_date=' + encodeURIComponent(endDate) + 
              '&end_time=' + encodeURIComponent(endTime);

    window.location.href = url;
});
</script>