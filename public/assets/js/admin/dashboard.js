document.addEventListener('DOMContentLoaded', () => {
  // Lấy dữ liệu từ biến toàn cục dashboardData được truyền từ PHP
  // Biến này được định nghĩa trong view dashboard.php

  // Check if dashboardData is available
  if (typeof dashboardData === 'undefined') {
    console.error(
      'dashboardData is not defined. Please ensure it is passed from the server-side.'
    )
    return // Exit the function if dashboardData is not available
  }

  // Booking Status Chart
  const bookingStatusCtx = document
    .getElementById('bookingStatusChart')
    .getContext('2d')
  const bookingStatusChart = new Chart(bookingStatusCtx, {
    type: 'doughnut',
    data: {
      labels: dashboardData.bookingStatusLabels,
      datasets: [
        {
          data: dashboardData.bookingStatusValues,
          backgroundColor: [
            'rgba(245, 158, 11, 0.8)', // pending - amber
            'rgba(59, 130, 246, 0.8)', // confirmed - blue
            'rgba(16, 185, 129, 0.8)', // paid - green
            'rgba(239, 68, 68, 0.8)', // cancelled - red
            'rgba(139, 92, 246, 0.8)' // completed - purple
          ],
          borderWidth: 0
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            usePointStyle: true,
            padding: 15,
            font: {
              size: 12
            }
          }
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              const label = context.label || ''
              const value = context.formattedValue
              const total = context.dataset.data.reduce((a, b) => a + b, 0)
              const percentage = Math.round((context.raw / total) * 100)
              return `${label}: ${value} (${percentage}%)`
            }
          }
        }
      },
      cutout: '70%'
    }
  })

  // Revenue Chart
  const revenueCtx = document.getElementById('revenueChart').getContext('2d')
  const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: dashboardData.monthlyRevenueLabels,
      datasets: [
        {
          label: 'Doanh thu (VND)',
          data: dashboardData.monthlyRevenueValues,
          backgroundColor: 'rgba(20, 184, 166, 0.8)',
          borderColor: 'rgba(20, 184, 166, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              const value = context.raw
              return formatCurrency(value)
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: (value) => {
              if (value >= 1000000) {
                return value / 1000000 + 'M'
              }
              return value
            }
          }
        }
      }
    }
  })
})

// Utility functions
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount)
}

function formatNumber(number) {
  return new Intl.NumberFormat('vi-VN').format(number)
}

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('vi-VN')
}
