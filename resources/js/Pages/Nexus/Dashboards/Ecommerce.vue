<script setup>
import { onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'

onMounted(() => {
  // Load ApexCharts and SimpleBar CDN if not present
  function ensureScript(src) {
    return new Promise((resolve) => {
      if (document.querySelector(`script[src="${src}"]`)) return resolve()
      const s = document.createElement('script')
      s.src = src
      s.onload = () => resolve()
      document.body.appendChild(s)
    })
  }
  function ensureCss(href) {
    if (document.querySelector(`link[href="${href}"]`)) return
    const l = document.createElement('link')
    l.rel = 'stylesheet'
    l.href = href
    document.head.appendChild(l)
  }

  ensureCss('https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.css')

  Promise.all([
    ensureScript('https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js'),
    ensureScript('https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.min.js'),
  ]).then(() => {
    initCharts()
  })

  function initCharts() {
    if (!window.ApexCharts) return
    initCustomerAcquisitionChart()
    initRevenueStatisticsChart()
    initGlobalSalesChart()
  }

  // Ported from nexus html js/pages/dashboards/ecommerce.js
  function initCustomerAcquisitionChart() {
    const el = document.getElementById('customer-acquisition-chart')
    if (!el) return
    const chartOptions = {
      chart: { height: 356, sparkline: { enabled: false }, toolbar: { show: false }, zoom: { enabled: false }, background: 'transparent' },
      forecastDataPoints: { count: 2, dashArray: [6, 4] },
      grid: { show: false },
      yaxis: { show: false, min: 125, max: 181 },
      xaxis: { categories: Array.from({ length: 15 }, (_, index) => index + 1) },
      tooltip: { y: { formatter: (val) => val.toString() } },
      stroke: { curve: 'stepline', width: [2, 1.5] },
      colors: ['#167bff', 'rgba(150,150,150,0.3)'],
      series: [
        { name: 'Customer', data: [144, 150, 146, 154, 150, 155, 160, 155, 140, 155, 160, 180, 170, 165, 165] },
        { name: 'Advertise', data: [140, 142, 142, 140, 146, 148, 150, 136, 130, 133, 145, 148, 158, 150, 150] },
      ],
    }
    new window.ApexCharts(el, chartOptions).render()
  }
  function initRevenueStatisticsChart() {
    const el = document.getElementById('revenue-statics-chart')
    if (!el) return
    const chartOptions = {
      chart: { height: 288, type: 'bar', stacked: true, background: 'transparent', toolbar: { show: false } },
      plotOptions: { bar: { borderRadius: 8, borderRadiusApplication: 'end', borderRadiusWhenStacked: 'last', colors: { backgroundBarColors: ['rgba(150,150,150,0.07)'], backgroundBarRadius: 8 }, columnWidth: '45%', barHeight: '100%' } },
      dataLabels: { enabled: false },
      colors: ['#ff8b4b', '#6c74f8'],
      legend: { show: true, horizontalAlign: 'center', offsetX: 0, offsetY: 6 },
      series: [ { name: 'Orders', data: [10, 12, 14, 16, 18, 20, 14, 16, 24, 12] }, { name: 'Revenue', data: [15, 24, 21, 28, 30, 40, 22, 32, 48, 20] } ],
      xaxis: { categories: [
        new Date('1/1/2016'), new Date('1/1/2017'), new Date('1/1/2018'), new Date('1/1/2019'), new Date('1/1/2020'), new Date('1/1/2021'), new Date('1/1/2022'), new Date('1/1/2023'), new Date('1/1/2024'), new Date('1/1/2025')
      ], axisBorder: { show: false }, axisTicks: { show: false }, labels: { formatter: (val) => new Date(val).getFullYear().toString() } },
      yaxis: { axisBorder: { show: false }, axisTicks: { show: false }, labels: { show: false } },
      tooltip: { enabled: true, shared: true, intersect: false },
      grid: { show: false },
      responsive: [{ breakpoint: 450, options: { plotOptions: { bar: { borderRadius: 4 } }, xaxis: { tickAmount: 3 } } }],
    }
    new window.ApexCharts(el, chartOptions).render()
  }
  function initGlobalSalesChart() {
    const el = document.getElementById('global-sales-chart')
    if (!el) return
    const data = [
      { name: 'Turkey', orders: 9 }, { name: 'India', orders: 12 }, { name: 'Canada', orders: 13 }, { name: 'US', orders: 16 }, { name: 'Netherlands', orders: 14 }, { name: 'Italy', orders: 17 }, { name: 'Other', orders: 19 }
    ]
    const chartOptions = {
      chart: { height: 344, type: 'bar', parentHeightOffset: 0, background: 'transparent', toolbar: { show: false } },
      plotOptions: { bar: { horizontal: true, borderRadius: 4, distributed: true, borderRadiusApplication: 'end' } },
      dataLabels: { enabled: true, textAnchor: 'start', style: { colors: ['#fff'] }, formatter: (val, opt) => opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val, offsetX: -10, dropShadow: { enabled: false } },
      series: [{ data: data.map((c) => c.orders) }],
      legend: { show: false },
      stroke: { width: 0, colors: ['#fff'] },
      xaxis: { categories: data.map((c) => c.name) },
      yaxis: { labels: { show: false } },
      grid: { show: false },
      tooltip: { theme: 'dark', x: { show: false }, y: { formatter: (val) => `${val}%` } },
      colors: ['#7179ff', '#4bcd89', '#ff6c88', '#5cb7ff', '#9071ff', '#ff5892', '#ff8b4b'],
    }
    new window.ApexCharts(el, chartOptions).render()
  }
})
</script>

<template>
  <Head title="E-commerce Dashboard" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Business Overview</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Dashboards</li>
            <li class="opacity-80">Ecommerce</li>
          </ul>
        </div>
      </div>

      <!-- Charts section: provide containers with same IDs -->
      <div class="grid gap-4 md:grid-cols-2 mt-4">
        <div class="card bg-base-100">
          <div class="card-body">
            <h3 class="card-title">Customer Acquisition</h3>
            <div id="customer-acquisition-chart"></div>
          </div>
        </div>
        <div class="card bg-base-100">
          <div class="card-body">
            <h3 class="card-title">Revenue Statistics</h3>
            <div id="revenue-statics-chart"></div>
          </div>
        </div>
      </div>

      <div class="grid gap-4 mt-4">
        <div class="card bg-base-100">
          <div class="card-body">
            <h3 class="card-title">Global Sales</h3>
            <div id="global-sales-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </NexusLayout>
</template>

