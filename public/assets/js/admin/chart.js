document.addEventListener('DOMContentLoaded', () => {
  // REMOVE THE VARIABLE DECLARATION - this is the root cause of the issue
  // var dashboardData <- REMOVE THIS LINE

  console.log('Initializing dashboard charts...')

  // Check if dashboardData exists and log its contents
  if (typeof dashboardData === 'undefined') {
    console.error(
      'dashboardData is not defined. Please ensure it is passed from the server-side.'
    )
    return
  }

  console.log('Dashboard data available:', dashboardData)

  // Specifically log the news views data to verify it exists
  console.log('News Views Data:', {
    labels: dashboardData.newsViewsLabels,
    values: dashboardData.newsViewsValues
  })

  // Booking Status Chart
  const bookingStatusCtx = document.getElementById('bookingStatusChart')
  if (bookingStatusCtx) {
    console.log('Booking Status Chart element found:', bookingStatusCtx)
    const bookingStatusChart = new Chart(bookingStatusCtx.getContext('2d'), {
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
              font: { size: 12 }
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
    console.log('Booking Status Chart initialized successfully')
  } else {
    console.warn('Booking Status Chart element not found')
  }

  // Revenue Chart
  const revenueCtx = document.getElementById('revenueChart')
  if (revenueCtx) {
    console.log('Revenue Chart element found:', revenueCtx)
    const revenueChart = new Chart(revenueCtx.getContext('2d'), {
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
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => formatCurrency(context.raw)
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => {
                if (value >= 1000000) return value / 1000000 + 'M'
                return value
              }
            }
          }
        }
      }
    })
    console.log('Revenue Chart initialized successfully')
  } else {
    console.warn('Revenue Chart element not found')
  }

  // News Views Chart
  const newsViewsCtx = document.getElementById('newsViewsChart')
  if (newsViewsCtx) {
    console.log('News Views Chart element found:', newsViewsCtx)
    console.log('News Views Chart context:', newsViewsCtx.getContext('2d'))

    // Check if the data is valid
    if (!dashboardData.newsViewsLabels || !dashboardData.newsViewsValues) {
      console.error('News Views data is missing or invalid:', {
        labels: dashboardData.newsViewsLabels,
        values: dashboardData.newsViewsValues
      })
    } else {
      try {
        const newsViewsChart = new Chart(newsViewsCtx.getContext('2d'), {
          type: 'line',
          data: {
            labels: dashboardData.newsViewsLabels,
            datasets: [
              {
                label: 'Lượt xem tin tức',
                data: dashboardData.newsViewsValues,
                backgroundColor: 'rgba(20, 184, 166, 0.2)',
                borderColor: 'rgba(20, 184, 166, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(20, 184, 166, 1)',
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: (context) => `Lượt xem: ${formatNumber(context.raw)}`
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: (value) => {
                    if (value >= 1000) return value / 1000 + 'K'
                    return value
                  }
                }
              },
              x: {
                grid: { display: false }
              }
            }
          }
        })
        console.log(
          'News Views Chart initialized successfully:',
          newsViewsChart
        )
      } catch (error) {
        console.error('Error initializing News Views Chart:', error)
      }
    }
  } else {
    console.error(
      'News Views Chart element not found. Check if the element with ID "newsViewsChart" exists in the DOM'
    )
  }

  // Hiển thị số lượng tin tức - Sử dụng newsCount
  const newsCountElement = document.getElementById('news-count')
  if (newsCountElement && typeof dashboardData.newsCount !== 'undefined') {
    newsCountElement.textContent = formatNumber(dashboardData.newsCount)
    console.log('News count updated:', dashboardData.newsCount)
  } else {
    console.warn('News count element not found or newsCount data is undefined')
  }
})

/**
 * Định dạng số tiền theo định dạng tiền tệ VND
 */
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount)
}

/**
 * Định dạng số nguyên với dấu phân cách hàng nghìn
 */
function formatNumber(number) {
  return new Intl.NumberFormat('vi-VN').format(number)
}

/**
 * Định dạng ngày tháng theo định dạng tiếng Việt
 */
function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString('vi-VN')
}
