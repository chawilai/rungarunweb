<script setup>
import { Head } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import NexusLayout from '@/Layouts/NexusLayout.vue'

onMounted(() => {
  function ensureScript(src) {
    return new Promise((resolve) => {
      if (document.querySelector(`script[src="${src}"]`)) return resolve()
      const s = document.createElement('script')
      s.src = src
      s.onload = () => resolve()
      document.body.appendChild(s)
    })
  }

  ensureScript('https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js').then(() => {
    if (!window.ApexCharts) return
    initSaleMetricsChart()
    initGoalStatusChart()
    initSocialAcquisitionChart()
  })

  function initSaleMetricsChart() {
    const el = document.getElementById('sale-metrics-chart')
    if (!el) return
    const chartOptions = {
      chart: { height: 323, type: 'bar', background: 'transparent', toolbar: { show: false } },
      plotOptions: { bar: { borderRadius: 2, columnWidth: '50%', barHeight: '100%' } },
      stroke: { show: true, width: 2, colors: ['transparent'] },
      dataLabels: { enabled: false },
      colors: ['#ff8b4b', '#6c74f8'],
      legend: { show: true, horizontalAlign: 'center', offsetY: 6 },
      series: [
        { name: 'Customer', data: [1175, 1734, 2239, 2741, 1823, 2154, 1013, 2794, 1834, 3273] },
        { name: 'Acquisition', data: [1803, 2175, 2882, 2486, 3755, 1888, 3154, 4345, 2683, 2891] },
      ],
      xaxis: {
        categories: [
          new Date('1/1/2016'), new Date('1/1/2017'), new Date('1/1/2018'), new Date('1/1/2019'), new Date('1/1/2020'), new Date('1/1/2021'), new Date('1/1/2022'), new Date('1/1/2023'), new Date('1/1/2024'), new Date('1/1/2025'),
        ],
        axisBorder: { show: false }, axisTicks: { show: false }, labels: { formatter: (val) => new Date(val).getFullYear().toString() },
      },
      yaxis: {
        axisBorder: { show: false }, axisTicks: { show: false },
        labels: { formatter: (val, e) => (e && e.seriesIndex === 1 ? `$${val}K` : val.toString()) },
      },
      tooltip: { enabled: true, shared: true, intersect: false },
      grid: { show: false },
      responsive: [{ breakpoint: 450, options: { plotOptions: { bar: { borderRadius: 2 } }, xaxis: { tickAmount: 3 } } }],
    }
    new window.ApexCharts(el, chartOptions).render()
  }

  function initGoalStatusChart() {
    const el = document.getElementById('goal-status-chart')
    if (!el) return
    const chartOptions = {
      series: [76],
      chart: { height: 258, type: 'radialBar', offsetY: -20, background: 'transparent', sparkline: { enabled: true } },
      stroke: { lineCap: 'round' },
      colors: ['#167bff'],
      plotOptions: {
        radialBar: {
          startAngle: -90,
          endAngle: 90,
          track: { background: 'var(--color-base-200)', strokeWidth: '75%', margin: 8, dropShadow: { enabled: false, top: 0, left: 0, color: '#999', opacity: 1, blur: 4 } },
          dataLabels: { name: { show: false }, value: { offsetY: -2, fontSize: '22px' } },
        },
      },
      grid: { padding: { top: -10 } },
      fill: { type: 'gradient', gradient: { shade: 'light' } },
      labels: ['Average Results'],
    }
    new window.ApexCharts(el, chartOptions).render()
  }

  function initSocialAcquisitionChart() {
    const el = document.getElementById('social-acquisition-chart')
    if (!el) return
    const series = [
      { name: 'Twitter', data: [ { x: 'Mon', y: 39 }, { x: 'Tue', y: 14 }, { x: 'Wed', y: 22 }, { x: 'Thu', y: 45 }, { x: 'Fri', y: 10 }, { x: 'Sat', y: 27 }, { x: 'Sun', y: 66 } ] },
      { name: 'Youtube', data: [ { x: 'Mon', y: 13 }, { x: 'Tue', y: 19 }, { x: 'Wed', y: 11 }, { x: 'Thu', y: 40 }, { x: 'Fri', y: 17 }, { x: 'Sat', y: 58 }, { x: 'Sun', y: 27 } ] },
      { name: 'Instagram', data: [ { x: 'Mon', y: 48 }, { x: 'Tue', y: 41 }, { x: 'Wed', y: 24 }, { x: 'Thu', y: 14 }, { x: 'Fri', y: 40 }, { x: 'Sat', y: 41 }, { x: 'Sun', y: 33 } ] },
      { name: 'Whatsapp', data: [ { x: 'Mon', y: 37 }, { x: 'Tue', y: 30 }, { x: 'Wed', y: 48 }, { x: 'Thu', y: 49 }, { x: 'Fri', y: 40 }, { x: 'Sat', y: 46 }, { x: 'Sun', y: 27 } ] },
      { name: 'Facebook', data: [ { x: 'Mon', y: 36 }, { x: 'Tue', y: 10 }, { x: 'Wed', y: 48 }, { x: 'Thu', y: 49 }, { x: 'Fri', y: 45 }, { x: 'Sat', y: 56 }, { x: 'Sun', y: 20 } ] },
    ]

    const chartOptions = {
      series,
      chart: { height: 298, type: 'heatmap', background: 'transparent', toolbar: { show: false } },
      stroke: { width: 6, colors: ['var(--color-base-100)'] },
      plotOptions: { heatmap: { radius: 6 } },
      dataLabels: { enabled: false },
      grid: { show: false, padding: { top: -20, bottom: -6 } },
      xaxis: { type: 'category', axisTicks: { show: false }, axisBorder: { show: false } },
      colors: ['#5860ff'],
    }
    new window.ApexCharts(el, chartOptions).render()
  }
})
</script>

<template>
  <Head title="CRM Dashboard" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">CRM Overview</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Dashboards</li>
            <li class="opacity-80">CRM</li>
          </ul>
        </div>
      </div>
      <div class="grid gap-4 mt-6">
        <div class="grid md:grid-cols-2 gap-4">
          <div class="card bg-base-100"><div class="card-body"><h3 class="card-title">Sale Metrics</h3><div id="sale-metrics-chart"></div></div></div>
          <div class="card bg-base-100"><div class="card-body"><h3 class="card-title">Goal Status</h3><div id="goal-status-chart"></div></div></div>
        </div>
        <div class="card bg-base-100"><div class="card-body"><h3 class="card-title">Social Acquisition</h3><div id="social-acquisition-chart"></div></div></div>
      </div>
    </div>
  </NexusLayout>
</template>

