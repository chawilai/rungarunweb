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
    <div id="layout-content">
        <div class="flex items-center justify-between">
            <p class="text-lg font-medium">CRM Overview</p>
            <div class="breadcrumbs hidden p-0 text-sm sm:inline">
                <ul>
                    <li><a href="./dashboards-ecommerce.html">Nexus</a></li>
                    <li>Dashboards</li>
                    <li class="opacity-80">CRM</li>
                </ul>
            </div>
        </div>
        <div class="mt-6">
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 md:col-span-4 xl:col-span-3 2xl:col-span-2">
                    <!--  Start: Dashboard Stats -->

                    <div
                        class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-1">
                        <div class="cursor-pointer">
                            <div class="card bg-base-100 false shadow">
                                <div class="card-body gap-2 p-4 2xl:p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-base-200 rounded-box false flex items-center p-1.5">
                                            <span
                                                class="iconify lucide--users size-4.5"></span>
                                        </div>
                                        <p
                                            class="line-clamp-1 font-medium max-2xl:text-sm">
                                            Customers
                                        </p>
                                    </div>
                                    <div
                                        class="mt-5 mb-0.5 flex items-center gap-2 text-sm 2xl:gap-3">
                                        <p
                                            class="text-lg leading-0 font-medium 2xl:text-2xl">
                                            4,235
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm false gap-0.5 px-1.5">
                                            <span
                                                class="iconify lucide--arrow-up size-3"></span>
                                            8.04%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer">
                            <div
                                class="card bg-base-100 from-primary shadow-primary/10 to-primary/85 text-primary-content bg-linear-to-tr shadow shadow-md">
                                <div class="card-body gap-2 p-4 2xl:p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-base-200 rounded-box bg-primary-content/15 flex items-center p-1.5">
                                            <span
                                                class="iconify lucide--dollar-sign size-4.5"></span>
                                        </div>
                                        <p
                                            class="line-clamp-1 font-medium max-2xl:text-sm">
                                            Revenue
                                        </p>
                                    </div>
                                    <div
                                        class="mt-5 mb-0.5 flex items-center gap-2 text-sm 2xl:gap-3">
                                        <p
                                            class="text-lg leading-0 font-medium 2xl:text-2xl">
                                            $75,400
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm !bg-primary-content/15 !text-primary-content gap-0.5 !border-transparent px-1.5">
                                            <span
                                                class="iconify lucide--arrow-up size-3"></span>
                                            15.3%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer">
                            <div class="card bg-base-100 false shadow">
                                <div class="card-body gap-2 p-4 2xl:p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-base-200 rounded-box false flex items-center p-1.5">
                                            <span
                                                class="iconify lucide--handshake size-4.5"></span>
                                        </div>
                                        <p
                                            class="line-clamp-1 font-medium max-2xl:text-sm">
                                            Closed Deals
                                        </p>
                                    </div>
                                    <div
                                        class="mt-5 mb-0.5 flex items-center gap-2 text-sm 2xl:gap-3">
                                        <p
                                            class="text-lg leading-0 font-medium 2xl:text-2xl">
                                            574
                                        </p>
                                        <div
                                            class="badge badge-soft badge-error badge-sm false gap-0.5 px-1.5">
                                            <span
                                                class="iconify lucide--arrow-down size-3"></span>
                                            -2.4%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer">
                            <div class="card bg-base-100 false shadow">
                                <div class="card-body gap-2 p-4 2xl:p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-base-200 rounded-box false flex items-center p-1.5">
                                            <span
                                                class="iconify lucide--smile size-4.5"></span>
                                        </div>
                                        <p
                                            class="line-clamp-1 font-medium max-2xl:text-sm">
                                            Satisfaction
                                        </p>
                                    </div>
                                    <div
                                        class="mt-5 mb-0.5 flex items-center gap-2 text-sm 2xl:gap-3">
                                        <p
                                            class="text-lg leading-0 font-medium 2xl:text-2xl">
                                            93%
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm false gap-0.5 px-1.5">
                                            <span
                                                class="iconify lucide--arrow-up size-3"></span>
                                            2.3%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  End: Dashboard Stats -->
                </div>
                <div class="col-span-12 md:col-span-8 xl:col-span-6 2xl:col-span-7">
                    <!--  Start: Sale Metrics -->

                    <div class="card bg-base-100 shadow">
                        <div class="card-body px-0 pb-0">
                            <div class="px-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-medium">
                                        Sale Metrics
                                    </span>
                                    <span class="text-base-content/60 text-xs">
                                        2024 vs. 2025
                                    </span>
                                </div>
                                <div
                                    class="mt-5 grid h-full grid-cols-2 justify-between gap-6 2xl:grid-cols-3">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="status status-success"></span>
                                            <span
                                                class="text-base-content/80 text-sm">
                                                Realtime Sales
                                            </span>
                                        </div>
                                        <span class="mt-2 text-2xl font-semibold">
                                            541
                                        </span>
                                        <span class="text-base-content/60 text-xs">
                                            494 last hour
                                        </span>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="status status-secondary"></span>
                                            <span
                                                class="text-base-content/80 text-sm">
                                                Revenue
                                            </span>
                                        </div>
                                        <span class="mt-2 text-2xl font-semibold">
                                            $51,474
                                        </span>
                                        <span class="text-base-content/60 text-xs">
                                            $49,162 last month
                                        </span>
                                    </div>

                                    <div
                                        class="hidden flex-col items-center 2xl:flex">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="status status-error"></span>
                                            <span
                                                class="text-base-content/80 text-sm">
                                                Customer Retention
                                            </span>
                                        </div>
                                        <span class="mt-2 text-2xl font-semibold">
                                            3.14%
                                        </span>
                                        <span class="text-base-content/60 text-xs">
                                            2.16% last week
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3.5 overflow-hidden rounded-xl ps-5">
                                <div id="sale-metrics-chart"></div>
                            </div>
                        </div>
                    </div>

                    <!--  End: Sale Metrics -->
                </div>
                <div class="col-span-12 xl:col-span-3">
                    <div
                        class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-1">
                        <!--  Start: Premium Widget -->

                        <div class="col-span-1">
                            <div class="card bg-base-100 shadow">
                                <div class="card-body">
                                    <p class="text-base-content/60 text-xs italic">
                                        Upgrade to premium
                                    </p>
                                    <p class="mt-1 leading-tight">
                                        Make the better business analytics with
                                        Premium Dashboard
                                    </p>
                                    <div
                                        class="mt-2 flex items-end justify-between">
                                        <div class="avatar-group -space-x-3.5">
                                            <div class="avatar">
                                                <div
                                                    class="bg-base-200 w-7 rounded-full">
                                                    <img
                                                        alt="Avatar"
                                                        src="/nexus/images/avatars/4.png" />
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <div
                                                    class="bg-base-200 w-7 rounded-full">
                                                    <img
                                                        alt="Avatar"
                                                        src="/nexus/images/avatars/5.png" />
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <div
                                                    class="bg-base-200 w-7 rounded-full">
                                                    <img
                                                        alt="Avatar"
                                                        src="/nexus/images/avatars/7.png" />
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <div
                                                    class="bg-base-200 w-7 rounded-full">
                                                    <img
                                                        alt="Avatar"
                                                        src="/nexus/images/avatars/8.png" />
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-sm btn-outline btn-neutral">
                                            Pay Monthly $29
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  End: Premium Widget -->

                        <!--  Start: Goal Status -->

                        <div class="col-span-1">
                            <div class="card bg-base-100 shadow">
                                <div class="card-body pb-3">
                                    <div>
                                        <p class="font-medium">
                                            Goal Status
                                            <span class="text-success text-sm">
                                                (Nearly Finished)
                                            </span>
                                        </p>
                                        <p class="mt-1 text-sm">
                                            You're completed 80% of yearly goal
                                        </p>
                                        <div class="mt-1">
                                            <div id="goal-status-chart"></div>
                                        </div>
                                        <div class="mt-3 flex justify-between">
                                            <p class="text-sm font-medium">
                                                Budget Spent
                                            </p>
                                            <div>
                                                <span class="text-sm font-medium">
                                                    $22500
                                                </span>
                                                <span
                                                    class="text-base-content/60 ms-1 text-xs">
                                                    /$30000
                                                </span>
                                            </div>
                                        </div>
                                        <progress
                                            class="progress progress-primary h-1.5"
                                            value="0.75"></progress>
                                    </div>
                                </div>
                                <hr class="border-base-300 mt-1" />
                                <div class="flex justify-between gap-3 p-2.5 px-3">
                                    <button class="btn btn-primary btn-soft btn-sm">
                                        <span
                                            class="iconify lucide--pencil size-3.5"></span>
                                        Change Goal
                                    </button>
                                    <div class="inline-flex items-center gap-1">
                                        <div
                                            class="tooltip"
                                            data-tip="Download Report">
                                            <button
                                                class="btn btn-sm btn-ghost btn-square"
                                                aria-label="download">
                                                <span
                                                    class="iconify lucide--arrow-down-to-line size-4"></span>
                                            </button>
                                        </div>
                                        <div
                                            class="tooltip"
                                            data-tip="Refresh Data">
                                            <button
                                                class="btn btn-sm btn-ghost btn-square"
                                                aria-label="refresh">
                                                <span
                                                    class="iconify lucide--refresh-ccw size-4"></span>
                                            </button>
                                        </div>
                                        <div class="tooltip" data-tip="Support">
                                            <button
                                                class="btn btn-sm btn-ghost btn-square"
                                                aria-label="help">
                                                <span
                                                    class="iconify lucide--circle-help size-4"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  End: Goal Status -->
                    </div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-2 2xl:grid-cols-3">
                <div class="col-span-1">
                    <!--  Start: Social Acquisition -->

                    <div class="card bg-base-100 shadow">
                        <div class="card-body px-0 pb-0">
                            <div class="flex items-center gap-2 px-5">
                                <span
                                    class="iconify lucide--megaphone text-base-content/80 size-4.5"></span>
                                <span class="grow font-medium">
                                    Social Acquisition
                                </span>
                                <div
                                    class="hidden items-center gap-1 sm:inline-flex">
                                    <span class="me-1 text-sm">0</span>
                                    <div
                                        class="bg-primary/20 rounded-box size-2.5"></div>
                                    <div
                                        class="bg-primary/40 rounded-box size-2.5"></div>
                                    <div
                                        class="bg-primary/60 rounded-box size-2.5"></div>
                                    <div
                                        class="bg-primary/80 rounded-box size-2.5"></div>
                                    <div
                                        class="bg-primary rounded-box size-2.5"></div>
                                    <span class="ms-1 text-sm">100</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div id="social-acquisition-chart"></div>
                            </div>
                        </div>
                    </div>

                    <!--  End: Social Acquisition -->
                </div>
                <div class="col-span-1">
                    <!--  Start: Customer Deals -->

                    <div aria-label="Card" class="card bg-base-100 shadow">
                        <div class="card-body p-0">
                            <div
                                class="flex items-center justify-between gap-2 px-5 pt-5">
                                <span
                                    class="iconify lucide--handshake text-base-content/80 size-4.5"></span>
                                <span class="grow font-medium">Customer Deals</span>
                                <button
                                    class="btn btn-outline border-base-300 btn-sm">
                                    <span
                                        class="iconify lucide--plus size-3.5"></span>
                                    Make a Deal
                                </button>
                            </div>
                            <div class="mt-1 overflow-auto">
                                <table class="table *:text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Value</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="flex items-center space-x-3 truncate">
                                                <img
                                                    alt="Order"
                                                    class="mask mask-squircle bg-base-200 size-7"
                                                    src="/nexus/images/avatars/1.png" />
                                                <p>John Doe</p>
                                            </td>
                                            <td class="font-medium">$50,000</td>
                                            <td>
                                                <div
                                                    class="badge badge-success badge-sm badge-soft">
                                                    Completed
                                                </div>
                                            </td>
                                            <td
                                                class="text-base-content/80 text-sm">
                                                16 Dec
                                            </td>
                                            <td>
                                                <button
                                                    aria-label="Show product"
                                                    class="btn btn-square btn-ghost btn-xs">
                                                    <span
                                                        class="iconify lucide--eye text-base-content/80 size-4"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="flex items-center space-x-3 truncate">
                                                <img
                                                    alt="Order"
                                                    class="mask mask-squircle bg-base-200 size-7"
                                                    src="/nexus/images/avatars/2.png" />
                                                <p>Jane Smith</p>
                                            </td>
                                            <td class="font-medium">$12,240</td>
                                            <td>
                                                <div
                                                    class="badge badge-secondary badge-sm badge-soft">
                                                    Pending
                                                </div>
                                            </td>
                                            <td
                                                class="text-base-content/80 text-sm">
                                                21 June
                                            </td>
                                            <td>
                                                <button
                                                    aria-label="Show product"
                                                    class="btn btn-square btn-ghost btn-xs">
                                                    <span
                                                        class="iconify lucide--eye text-base-content/80 size-4"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="flex items-center space-x-3 truncate">
                                                <img
                                                    alt="Order"
                                                    class="mask mask-squircle bg-base-200 size-7"
                                                    src="/nexus/images/avatars/3.png" />
                                                <p>Rahul Kumar</p>
                                            </td>
                                            <td class="font-medium">$87,452</td>
                                            <td>
                                                <div
                                                    class="badge badge-success badge-sm badge-soft">
                                                    Completed
                                                </div>
                                            </td>
                                            <td
                                                class="text-base-content/80 text-sm">
                                                15 Aug
                                            </td>
                                            <td>
                                                <button
                                                    aria-label="Show product"
                                                    class="btn btn-square btn-ghost btn-xs">
                                                    <span
                                                        class="iconify lucide--eye text-base-content/80 size-4"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="flex items-center space-x-3 truncate">
                                                <img
                                                    alt="Order"
                                                    class="mask mask-squircle bg-base-200 size-7"
                                                    src="/nexus/images/avatars/4.png" />
                                                <p>Emily Davis</p>
                                            </td>
                                            <td class="font-medium">$65,357</td>
                                            <td>
                                                <div
                                                    class="badge badge-success badge-sm badge-soft">
                                                    Completed
                                                </div>
                                            </td>
                                            <td
                                                class="text-base-content/80 text-sm">
                                                17 Nov
                                            </td>
                                            <td>
                                                <button
                                                    aria-label="Show product"
                                                    class="btn btn-square btn-ghost btn-xs">
                                                    <span
                                                        class="iconify lucide--eye text-base-content/80 size-4"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="flex items-center space-x-3 truncate">
                                                <img
                                                    alt="Order"
                                                    class="mask mask-squircle bg-base-200 size-7"
                                                    src="/nexus/images/avatars/5.png" />
                                                <p>Akash Singh</p>
                                            </td>
                                            <td class="font-medium">$35,769</td>
                                            <td>
                                                <div
                                                    class="badge badge-error badge-sm badge-soft">
                                                    Canceled
                                                </div>
                                            </td>
                                            <td
                                                class="text-base-content/80 text-sm">
                                                30 Jan
                                            </td>
                                            <td>
                                                <button
                                                    aria-label="Show product"
                                                    class="btn btn-square btn-ghost btn-xs">
                                                    <span
                                                        class="iconify lucide--eye text-base-content/80 size-4"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!--  End: Customer Deals -->
                </div>
                <div class="col-span-1">
                    <!--  Start: Quick Integrations -->

                    <div class="card bg-base-100 shadow">
                        <div class="card-body">
                            <div class="flex items-center gap-2">
                                <span
                                    class="iconify lucide--unplug text-base-content/80 size-4.5"></span>
                                <p class="grow font-medium">Quick Integration</p>
                                <button
                                    class="btn btn-ghost btn-sm border-base-300">
                                    <span
                                        class="iconify lucide--settings-2 size-3.5"></span>
                                    Manage
                                </button>
                            </div>
                            <div class="mt-4 space-y-3.5">
                                <div class="flex items-center gap-3">
                                    <img
                                        alt="chat"
                                        class="bg-base-200 mask mask-squircle size-11 p-2"
                                        src="/nexus/images/brand-logo/salesforce.svg" />
                                    <div class="grow">
                                        <p class="leading-none font-medium">
                                            Salesforce
                                        </p>
                                        <p
                                            class="text-base-content/80 line-clamp-1 text-sm">
                                            Salesforce provides customer
                                            relationship management software and
                                            application focused on sales
                                        </p>
                                    </div>
                                    <button class="btn btn-xs btn-soft btn-error">
                                        Connect
                                    </button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img
                                        alt="chat"
                                        class="bg-base-200 mask mask-squircle size-11 p-2"
                                        src="/nexus/images/brand-logo/asana.svg" />
                                    <div class="grow">
                                        <p class="leading-none font-medium">
                                            Asana
                                        </p>
                                        <p
                                            class="text-base-content/80 line-clamp-1 text-sm">
                                            Track, manage and connect your project
                                            across any team.
                                        </p>
                                    </div>
                                    <button class="btn btn-xs btn-soft btn-primary">
                                        Disconnect
                                    </button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img
                                        alt="chat"
                                        class="bg-base-200 mask mask-squircle size-11 p-2"
                                        src="/nexus/images/brand-logo/slack.svg" />
                                    <div class="grow">
                                        <p class="leading-none font-medium">
                                            Slack
                                        </p>
                                        <p
                                            class="text-base-content/80 line-clamp-1 text-sm">
                                            Slack is a new way to communicate with
                                            your team.
                                        </p>
                                    </div>
                                    <button class="btn btn-xs btn-soft btn-error">
                                        Connect
                                    </button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img
                                        alt="chat"
                                        class="bg-base-200 mask mask-squircle size-11 p-2"
                                        src="/nexus/images/brand-logo/notion.svg" />
                                    <div class="grow">
                                        <p class="leading-none font-medium">
                                            Notion
                                        </p>
                                        <p
                                            class="text-base-content/80 line-clamp-1 text-sm">
                                            Notion is a freemium productivity and
                                            note-taking web application developed by
                                            Notion Lab Inc.
                                        </p>
                                    </div>
                                    <button class="btn btn-xs btn-soft btn-primary">
                                        Disconnect
                                    </button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <img
                                        alt="chat"
                                        class="bg-base-200 mask mask-squircle size-11 p-2"
                                        src="/nexus/images/brand-logo/hubspot.svg" />
                                    <div class="grow">
                                        <p class="leading-none font-medium">
                                            Hubspot
                                        </p>
                                        <p
                                            class="text-base-content/80 line-clamp-1 text-sm">
                                            Hubspot is a CRM platform with all the
                                            software, integrations and resources you
                                            need to connect
                                        </p>
                                    </div>
                                    <button class="btn btn-xs btn-soft btn-primary">
                                        Disconnect
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  End: Quick Integrations -->
                </div>
            </div>
        </div>
    </div>

    <div class="-mt-2 flex items-center justify-between px-6 pb-4">
        <p>
            Built and designed with care by
            <a target="_blank" class="text-primary" href="https://withden.dev/">
                Denish
            </a>
        </p>
        <a
            aria-label="Buy now"
            target="_blank"
            class="bg-primary text-primary-content group flex size-9 items-center gap-2 overflow-hidden rounded-full px-2.5 py-0.5 font-medium transition-all hover:w-26"
            href="https://daisyui.com/store/244268">
            <span class="iconify lucide--shopping-cart block size-4.5"></span>
            <span class="hidden text-sm text-nowrap group-hover:block">
                Buy Now
            </span>
        </a>
    </div>
  </NexusLayout>
</template>

