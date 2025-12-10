import { Chart } from "@/components/ui/chart"
// Main JavaScript file for Investment Casting ERP

// Import Bootstrap
const bootstrap = window.bootstrap

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  initializeApp()
  initializeSessionTimeout()
})

function initializeApp() {
  // Initialize tooltips
  initializeTooltips()

  // Initialize form validation
  initializeFormValidation()

  // Initialize data tables
  initializeDataTables()

  // Initialize charts
  initializeCharts()

  // Initialize auto-refresh
  initializeAutoRefresh()

  // Initialize keyboard shortcuts
  initializeKeyboardShortcuts()
}

// Tooltip initialization
function initializeTooltips() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))
}

// Form validation
function initializeFormValidation() {
  // Bootstrap form validation
  var forms = document.querySelectorAll(".needs-validation")
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add("was-validated")
      },
      false,
    )
  })

  // Custom validation rules
  addCustomValidationRules()
}

function addCustomValidationRules() {
  // Email validation
  const emailInputs = document.querySelectorAll('input[type="email"]')
  emailInputs.forEach((input) => {
    input.addEventListener("blur", function () {
      validateEmail(this)
    })
  })

  // Number validation
  const numberInputs = document.querySelectorAll('input[type="number"]')
  numberInputs.forEach((input) => {
    input.addEventListener("input", function () {
      validateNumber(this)
    })
  })
}

function validateEmail(input) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  const isValid = emailRegex.test(input.value)

  if (!isValid && input.value !== "") {
    input.setCustomValidity("Please enter a valid email address")
    input.classList.add("is-invalid")
  } else {
    input.setCustomValidity("")
    input.classList.remove("is-invalid")
    if (input.value !== "") {
      input.classList.add("is-valid")
    }
  }
}

function validateNumber(input) {
  const value = Number.parseFloat(input.value)
  const min = Number.parseFloat(input.getAttribute("min")) || 0
  const max = Number.parseFloat(input.getAttribute("max")) || Number.POSITIVE_INFINITY

  if (isNaN(value) || value < min || value > max) {
    input.setCustomValidity(`Please enter a number between ${min} and ${max}`)
    input.classList.add("is-invalid")
  } else {
    input.setCustomValidity("")
    input.classList.remove("is-invalid")
    input.classList.add("is-valid")
  }
}

// Data tables enhancement
function initializeDataTables() {
  // Add search functionality to tables
  const tables = document.querySelectorAll(".table")
  tables.forEach((table) => {
    addTableSearch(table)
    addTableSorting(table)
  })
}

function addTableSearch(table) {
  const tableContainer = table.closest(".card-body") || table.parentElement
  const searchContainer = document.createElement("div")
  searchContainer.className = "mb-3"
  searchContainer.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search table..." onkeyup="filterTable(this, '${table.id || "table"}')">
                </div>
            </div>
        </div>
    `

  tableContainer.insertBefore(searchContainer, table.parentElement)
}

function filterTable(input, tableId) {
  const filter = input.value.toLowerCase()
  const table = document.getElementById(tableId) || input.closest(".card-body").querySelector("table")
  const rows = table.querySelectorAll("tbody tr")

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase()
    row.style.display = text.includes(filter) ? "" : "none"
  })
}

function addTableSorting(table) {
  const headers = table.querySelectorAll("thead th")
  headers.forEach((header, index) => {
    if (!header.classList.contains("no-sort")) {
      header.style.cursor = "pointer"
      header.innerHTML += ' <i class="fas fa-sort text-muted"></i>'
      header.addEventListener("click", () => sortTable(table, index))
    }
  })
}

function sortTable(table, columnIndex) {
  const tbody = table.querySelector("tbody")
  const rows = Array.from(tbody.querySelectorAll("tr"))
  const header = table.querySelectorAll("thead th")[columnIndex]

  // Determine sort direction
  const isAscending = !header.classList.contains("sort-desc")

  // Remove existing sort classes
  table.querySelectorAll("thead th").forEach((th) => {
    th.classList.remove("sort-asc", "sort-desc")
    const icon = th.querySelector("i")
    if (icon) {
      icon.className = "fas fa-sort text-muted"
    }
  })

  // Add sort class to current header
  header.classList.add(isAscending ? "sort-asc" : "sort-desc")
  const icon = header.querySelector("i")
  if (icon) {
    icon.className = isAscending ? "fas fa-sort-up text-primary" : "fas fa-sort-down text-primary"
  }

  // Sort rows
  rows.sort((a, b) => {
    const aValue = a.cells[columnIndex].textContent.trim()
    const bValue = b.cells[columnIndex].textContent.trim()

    // Try to parse as numbers
    const aNum = Number.parseFloat(aValue)
    const bNum = Number.parseFloat(bValue)

    if (!isNaN(aNum) && !isNaN(bNum)) {
      return isAscending ? aNum - bNum : bNum - aNum
    }

    // String comparison
    return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue)
  })

  // Reorder rows in DOM
  rows.forEach((row) => tbody.appendChild(row))
}

// Charts initialization
function initializeCharts() {
  // Initialize any charts on the page
  const chartElements = document.querySelectorAll("[data-chart]")
  chartElements.forEach((element) => {
    const chartType = element.dataset.chart
    const chartData = JSON.parse(element.dataset.chartData || "{}")
    createChart(element, chartType, chartData)
  })
}

function createChart(element, type, data) {
  const ctx = element.getContext("2d")

  const config = {
    type: type,
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "top",
        },
        tooltip: {
          mode: "index",
          intersect: false,
        },
      },
      scales:
        type !== "pie" && type !== "doughnut"
          ? {
              x: {
                display: true,
                title: {
                  display: true,
                },
              },
              y: {
                display: true,
                title: {
                  display: true,
                },
              },
            }
          : {},
    },
  }

  new Chart(ctx, config)
}

// Auto-refresh functionality
function initializeAutoRefresh() {
  // Auto-refresh alerts and notifications every 30 seconds
  setInterval(() => {
    refreshAlerts()
    refreshNotifications()
  }, 30000)
}

function refreshAlerts() {
  // Check for low stock alerts
  fetch("ajax/get_alerts.php")
    .then((response) => response.json())
    .then((data) => {
      updateAlertsDisplay(data)
    })
    .catch((error) => console.error("Error refreshing alerts:", error))
}

function refreshNotifications() {
  // Check for new notifications
  fetch("ajax/get_notifications.php")
    .then((response) => response.json())
    .then((data) => {
      updateNotificationsDisplay(data)
    })
    .catch((error) => console.error("Error refreshing notifications:", error))
}

function updateAlertsDisplay(alerts) {
  const alertContainer = document.getElementById("alertContainer")
  if (alertContainer && alerts.length > 0) {
    // Update alerts display
    alertContainer.innerHTML = alerts
      .map(
        (alert) => `
            <div class="alert alert-${alert.type} alert-dismissible fade show" role="alert">
                ${alert.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `,
      )
      .join("")
  }
}

function updateNotificationsDisplay(notifications) {
  const notificationBadge = document.getElementById("notificationBadge")
  if (notificationBadge) {
    notificationBadge.textContent = notifications.length
    notificationBadge.style.display = notifications.length > 0 ? "inline" : "none"
  }
}

// Keyboard shortcuts
function initializeKeyboardShortcuts() {
  document.addEventListener("keydown", (event) => {
    // Ctrl/Cmd + S to save forms
    if ((event.ctrlKey || event.metaKey) && event.key === "s") {
      event.preventDefault()
      const activeForm = document.querySelector("form:focus-within")
      if (activeForm) {
        activeForm.submit()
      }
    }

    // Escape to close modals
    if (event.key === "Escape") {
      const openModal = document.querySelector(".modal.show")
      if (openModal) {
        const modal = bootstrap.Modal.getInstance(openModal)
        if (modal) {
          modal.hide()
        }
      }
    }

    // Ctrl/Cmd + N for new items
    if ((event.ctrlKey || event.metaKey) && event.key === "n") {
      event.preventDefault()
      const newButton = document.querySelector('[data-bs-toggle="modal"]')
      if (newButton) {
        newButton.click()
      }
    }
  })
}

// Utility functions
function showLoading(element) {
  const originalContent = element.innerHTML
  element.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...'
  element.disabled = true

  return function hideLoading() {
    element.innerHTML = originalContent
    element.disabled = false
  }
}

function showToast(message, type = "info") {
  const toastContainer = document.getElementById("toastContainer") || createToastContainer()

  const toast = document.createElement("div")
  toast.className = `toast align-items-center text-white bg-${type} border-0`
  toast.setAttribute("role", "alert")
  toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `

  toastContainer.appendChild(toast)

  const bsToast = new bootstrap.Toast(toast)
  bsToast.show()

  // Remove toast element after it's hidden
  toast.addEventListener("hidden.bs.toast", () => {
    toast.remove()
  })
}

function createToastContainer() {
  const container = document.createElement("div")
  container.id = "toastContainer"
  container.className = "toast-container position-fixed bottom-0 end-0 p-3"
  document.body.appendChild(container)
  return container
}

function formatCurrency(amount) {
  return new Intl.NumberFormat("en-IN", {
    style: "currency",
    currency: "INR",
  }).format(amount)
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString("en-IN", {
    year: "numeric",
    month: "short",
    day: "numeric",
  })
}

function formatDateTime(dateString) {
  return new Date(dateString).toLocaleString("en-IN", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  })
}

// Export functions for global use
window.ERPUtils = {
  showLoading,
  showToast,
  formatCurrency,
  formatDate,
  formatDateTime,
  filterTable,
  sortTable,
}

// AJAX helper functions
function makeAjaxRequest(url, options = {}) {
  const defaultOptions = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },
  }

  const finalOptions = { ...defaultOptions, ...options }

  return fetch(url, finalOptions)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      return response.json()
    })
    .catch((error) => {
      console.error("AJAX request failed:", error)
      showToast("Request failed. Please try again.", "danger")
      throw error
    })
}

// Form submission helper
function submitFormAjax(form, successCallback, errorCallback) {
  const formData = new FormData(form)
  const hideLoading = showLoading(form.querySelector('button[type="submit"]'))

  fetch(form.action || window.location.href, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      hideLoading()
      if (data.success) {
        if (successCallback) {
          successCallback(data)
        } else {
          showToast(data.message || "Operation completed successfully", "success")
          if (data.redirect) {
            window.location.href = data.redirect
          }
        }
      } else {
        if (errorCallback) {
          errorCallback(data)
        } else {
          showToast(data.message || "Operation failed", "danger")
        }
      }
    })
    .catch((error) => {
      hideLoading()
      console.error("Form submission error:", error)
      if (errorCallback) {
        errorCallback({ message: "Network error occurred" })
      } else {
        showToast("Network error occurred", "danger")
      }
    })
}

// Print functionality
function printElement(elementId) {
  const element = document.getElementById(elementId)
  if (!element) {
    showToast("Element not found for printing", "danger")
    return
  }

  const printWindow = window.open("", "_blank")
  printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @media print {
                    .no-print { display: none !important; }
                    body { font-size: 12px; }
                    .table { font-size: 11px; }
                }
            </style>
        </head>
        <body>
            ${element.outerHTML}
            <script>
                window.onload = function() {
                    window.print();
                    window.close();
                };
            </script>
        </body>
        </html>
    `)
  printWindow.document.close()
}

// Export functionality
function exportTableToCSV(tableId, filename = "export.csv") {
  const table = document.getElementById(tableId)
  if (!table) {
    showToast("Table not found for export", "danger")
    return
  }

  const rows = table.querySelectorAll("tr")
  const csvContent = Array.from(rows)
    .map((row) => {
      const cells = row.querySelectorAll("th, td")
      return Array.from(cells)
        .map((cell) => {
          const text = cell.textContent.trim()
          return `"${text.replace(/"/g, '""')}"`
        })
        .join(",")
    })
    .join("\n")

  const blob = new Blob([csvContent], { type: "text/csv" })
  const url = window.URL.createObjectURL(blob)
  const a = document.createElement("a")
  a.href = url
  a.download = filename
  a.click()
  window.URL.revokeObjectURL(url)
}

// Session timeout warning
let sessionTimeoutWarning
function initializeSessionTimeout() {
  const timeoutDuration = 30 * 60 * 1000 // 30 minutes
  const warningTime = 5 * 60 * 1000 // 5 minutes before timeout

  function resetTimeout() {
    clearTimeout(sessionTimeoutWarning)
    sessionTimeoutWarning = setTimeout(() => {
      showToast("Your session will expire in 5 minutes. Please save your work.", "warning")
    }, timeoutDuration - warningTime)
  }
  // Reset timeout on user activity
  ;["mousedown", "mousemove", "keypress", "scroll", "touchstart"].forEach((event) => {
    document.addEventListener(event, resetTimeout, true)
  })

  resetTimeout()
}
