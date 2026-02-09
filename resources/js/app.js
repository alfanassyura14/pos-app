import './bootstrap';
import Chart from 'chart.js/auto';

// Dashboard initialization
document.addEventListener('DOMContentLoaded', () => {
    initializeChart();
});

function initializeChart() {
    const ctx = document.getElementById('overviewChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [
                {
                    label: 'Sales',
                    data: [2800, 3200, 2500, 3800, 4200, 3500, 3900, 3300, 4100, 3700, 4500, 5000],
                    borderColor: 'rgb(236, 72, 153)',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                },
                {
                    label: 'Revenue',
                    data: [2000, 2300, 1800, 2800, 3200, 2500, 2900, 2400, 3100, 2700, 3500, 4000],
                    borderColor: 'rgb(156, 163, 175)',
                    backgroundColor: 'rgba(156, 163, 175, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'start',
                    labels: {
                        color: 'rgb(156, 163, 175)',
                        usePointStyle: true,
                        pointStyle: 'line',
                        padding: 20,
                        font: { size: 12 },
                    },
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(30, 41, 59, 0.95)',
                    titleColor: 'rgb(255, 255, 255)',
                    bodyColor: 'rgb(203, 213, 225)',
                    borderColor: 'rgba(71, 85, 105, 0.5)',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + 'k';
                            }
                            return label;
                        }
                    }
                },
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { color: 'rgb(100, 116, 139)', font: { size: 11 } },
                },
                y: {
                    border: { display: false },
                    grid: { color: 'rgba(71, 85, 105, 0.2)', drawBorder: false },
                    ticks: {
                        color: 'rgb(100, 116, 139)',
                        font: { size: 11 },
                        stepSize: 1000,
                        callback: function(value) {
                            return value / 1000 + 'k';
                        }
                    },
                },
            },
        },
    });
}

