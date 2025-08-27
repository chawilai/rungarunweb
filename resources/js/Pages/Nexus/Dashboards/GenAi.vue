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
    initModalOverviewChart()
    initResourceUtilizationChart()
  })

  function initModalOverviewChart() {
    const el = document.getElementById('modal-overview-chart')
    if (!el) return
    const chartOptions = {
      chart: { height: 305, type: 'line', background: 'transparent', toolbar: { show: false } },
      stroke: { curve: 'smooth', width: 2 },
      dataLabels: { enabled: false },
      colors: ['#ff8b4b', '#4caf50', '#6c74f8'],
      legend: { show: true, horizontalAlign: 'center', offsetY: 6 },
      series: [
        { name: 'NeuraText', data: [320,330,345,310,295,340,360,345,355,370,385,400,380,360,370,390,410,420,415] },
        { name: 'VisioGen', data: [300,315,295,320,335,320,290,270,300,330,340,335,290,280,310,325,310,295,285] },
        { name: 'EchoWave', data: [280,295,270,260,275,300,275,280,280,300,315,305,285,290,295,310,320,310,295] },
      ],
      xaxis: { categories: ['Feb 19','Feb 20','Feb 21','Feb 22','Feb 23','Feb 24','Feb 25','Feb 26','Feb 27','Feb 28','Feb 29','Mar 1','Mar 2','Mar 3','Mar 4','Mar 5','Mar 6','Mar 7','Mar 8'], axisBorder: { show: false }, axisTicks: { show: false } },
      yaxis: { labels: { show: true }, axisBorder: { show: false }, axisTicks: { show: false } },
      tooltip: { enabled: true, shared: true, intersect: false },
      grid: { show: true, borderColor: 'rgba(150,150,150,0.2)' },
      responsive: [{ breakpoint: 450, options: { stroke: { width: 1.5 }, xaxis: { tickAmount: 5 } } }],
    }
    new window.ApexCharts(el, chartOptions).render()
  }

  function initResourceUtilizationChart() {
    const el = document.getElementById('resource-utilization-chart')
    if (!el) return
    const chartOptions = {
      chart: { type: 'treemap', height: 275, background: 'transparent', toolbar: { show: false } },
      plotOptions: { treemap: { distributed: true, enableShades: false, borderRadius: 8 } },
      dataLabels: { style: { colors: ['var(--color-base-content)'] } },
      stroke: { width: 4, colors: ['var(--color-base-100)'] },
      series: [{ name: 'AI Model Usage', data: [
        { x: 'NeuraText', y: 48 }, { x: 'EchoWave', y: 44 }, { x: 'DeepScribe', y: 42 }, { x: 'SynthVoice', y: 40 }, { x: 'VisioGen', y: 34 }, { x: 'Cortex', y: 30 }, { x: 'Crunch', y: 28 },
      ] }],
      colors: ['#1b7efda0','#fd731ea0','#a153ffa0','#28ff87a0','#ff29aaa0','#ffb01da0','#A0B5C6a0'],
      tooltip: { y: { formatter: (val) => `${val}% Usage` } },
    }
    new window.ApexCharts(el, chartOptions).render()
  }
})
</script>

<template>
  <Head title="Gen AI Dashboard" />
  <NexusLayout>
    <div id="layout-content">
        <!--  Start: Title -->
        <div class="flex flex-wrap items-end gap-3 sm:gap-6 xl:gap-12">
            <div
                class="from-base-content to-secondary inline-block bg-gradient-to-tr from-40% bg-clip-text text-xl font-semibold tracking-tight text-transparent sm:text-3xl">
                <p>Welcome Back, Denish</p>
                <p class="mt-1">Here’s an overview of insights</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button
                        class="btn text-primary-content from-primary to-secondary relative z-1 gap-2 border-none bg-gradient-to-r">
                        <span class="iconify lucide--sparkles size-4.5"></span>
                        <span class="text-base">Ask AI</span>
                    </button>
                    <div
                        class="from-primary to-secondary rounded-box absolute inset-x-0 top-3 h-8 bg-gradient-to-r opacity-40 blur-md dark:opacity-20"></div>
                </div>
                <div
                    class="rounded-[calc(var(--radius-box)+1px)] bg-gradient-to-r from-green-600 via-emerald-500 to-teal-500 p-px">
                    <button class="btn btn-sm bg-base-100 text-[15px]">
                        Analyze Data
                    </button>
                </div>
                <div
                    class="rounded-[calc(var(--radius-box)+1px)] bg-gradient-to-r from-cyan-600 via-blue-500 to-indigo-500 p-px max-sm:hidden">
                    <button class="btn btn-sm bg-base-100 text-[15px]">
                        Get Insights
                    </button>
                </div>
            </div>
        </div>
        <!--  End: Title -->

        <!--  Start: Stats -->
        <div class="mt-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6">
                <div
                    class="card bg-base-100 h-full cursor-pointer p-4 shadow transition-all hover:shadow-md sm:col-span-2">
                    <div class="flex justify-between">
                        <p class="leading-none font-medium">Quick Insights</p>
                        <button class="btn btn-xs btn-ghost btn-circle -m-1">
                            <span
                                class="iconify lucide--pin size-4 text-orange-400"></span>
                        </button>
                    </div>
                    <div class="mt-3.5 flex h-full items-stretch gap-4 sm:gap-8">
                        <div>
                            <p class="text-2xl font-semibold">
                                <sup class="text-base-content/40 me-0.5 text-lg">
                                    $
                                </sup>
                                1245
                                <span class="text-base-content/60 text-xl"></span>
                            </p>
                            <p
                                class="text-base-content/50 mt-auto pt-1 text-center text-sm/none">
                                Today
                            </p>
                        </div>
                        <div
                            class="border-base-300 h-full border-s border-dashed"></div>
                        <div>
                            <p class="text-2xl font-semibold">
                                <sup class="text-base-content/40 me-0.5 text-lg">
                                    $
                                </sup>
                                12.
                                <span class="text-base-content/60 text-xl">74</span>
                                K
                            </p>
                            <p
                                class="text-base-content/50 mt-auto pt-1 text-center text-sm/none">
                                This Month
                            </p>
                        </div>
                        <div
                            class="border-base-300 h-full border-s border-dashed max-sm:hidden"></div>
                        <div class="max-sm:hidden">
                            <p class="text-2xl font-semibold">
                                +18.4%
                                <span class="text-base-content/60 text-xl"></span>
                            </p>
                            <p
                                class="text-base-content/50 mt-auto pt-1 text-center text-sm/none">
                                Growth
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-base-100 cursor-pointer p-4 shadow transition-all hover:shadow-md">
                    <div class="flex justify-between">
                        <p class="text-sm/none">Token Consumption</p>
                        <button class="btn btn-xs btn-ghost btn-circle -m-1">
                            <span
                                class="iconify lucide--flame text-base-content/80 size-4"></span>
                        </button>
                    </div>
                    <p class="mt-2 text-2xl font-medium">18.47 M</p>
                    <div class="flex items-end justify-between gap-2">
                        <p class="text-base-content/50 text-sm/none">
                            Higher than usual
                        </p>
                        <div class="bg-base-200 rounded-box p-1">
                            <span
                                class="iconify lucide--chevron-right text-base-content/80 block"></span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-base-100 cursor-pointer p-4 shadow transition-all hover:shadow-md">
                    <div class="flex justify-between">
                        <p class="text-sm/none">AI Model Accuracy</p>
                        <button class="btn btn-xs btn-ghost btn-circle -m-1">
                            <span
                                class="iconify lucide--target text-base-content/80 size-4"></span>
                        </button>
                    </div>
                    <p class="mt-2 text-2xl font-medium">97.2%</p>
                    <div class="flex items-end justify-between gap-2">
                        <p class="text-base-content/50 text-sm/none">
                            Stable performance
                        </p>
                        <div class="bg-base-200 rounded-box p-1">
                            <span
                                class="iconify lucide--chevron-right text-base-content/80 block"></span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-base-100 cursor-pointer p-4 shadow transition-all hover:shadow-md">
                    <div class="flex justify-between">
                        <p class="text-sm/none">Processing Power</p>
                        <button class="btn btn-xs btn-ghost btn-circle -m-1">
                            <span
                                class="iconify lucide--cpu text-base-content/80 size-4"></span>
                        </button>
                    </div>
                    <p class="mt-2 text-2xl font-medium">
                        96
                        <span class="text-base">TFLOPS</span>
                    </p>
                    <div class="flex items-end justify-between gap-2">
                        <p class="text-base-content/50 text-sm/none">
                            Performance at peak
                        </p>
                        <div class="bg-base-200 rounded-box p-1">
                            <span
                                class="iconify lucide--chevron-right text-base-content/80 block"></span>
                        </div>
                    </div>
                </div>
                <div class="bg-neutral text-neutral-content card h-full p-3 shadow">
                    <p class="text-lg/5.5 font-medium">
                        Supercharge Your AI Capabilities
                    </p>
                    <div class="mt-auto flex items-end justify-between gap-3 pt-2">
                        <div>
                            <p class="text-sm/none italic opacity-80">
                                Enhanced AI
                            </p>
                        </div>
                        <button class="btn btn-sm rounded-full">Upgrade</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  End: Stats -->

        <div class="mt-6 grid grid-cols-12 gap-6">
            <!--  Start: Modal Overview -->

            <div class="col-span-12 xl:col-span-6 2xl:col-span-7">
                <div class="card bg-base-100 shadow">
                    <div class="card-body px-0 pb-0">
                        <div class="px-6">
                            <div class="flex items-start justify-between">
                                <span class="text-lg/none font-medium">
                                    Modals Overview
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <button
                                        class="btn btn-circle btn-sm border-base-300 btn-outline">
                                        <span
                                            class="iconify lucide--arrow-up-down size-4"></span>
                                    </button>
                                    <button
                                        class="btn btn-circle btn-sm border-base-300 btn-outline">
                                        <span
                                            class="iconify lucide--layout-grid size-4"></span>
                                    </button>
                                    <button
                                        class="btn btn-circle btn-sm border-base-300 btn-outline max-sm:hidden">
                                        <span
                                            class="iconify lucide--refresh-cw size-4"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-1 flex justify-between">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-4xl font-semibold">
                                            627K
                                        </span>
                                        <span class="text-primary font-medium">
                                            +2.14%
                                        </span>
                                    </div>
                                    <span class="text-base-content/60 text-sm">
                                        Tokens processed today
                                    </span>
                                </div>
                                <div class="dropdown dropdown-end mt-1">
                                    <div
                                        tabindex="0"
                                        role="button"
                                        class="text-base-content/60 hover:text-base-content flex cursor-pointer items-center gap-1 text-sm transition-all">
                                        This Month
                                        <span
                                            class="iconify lucide--chevron-down size-3"></span>
                                    </div>
                                    <ul
                                        tabindex="0"
                                        class="dropdown-content menu bg-base-100 rounded-box z-1 mt-1 w-36 p-1 shadow transition-all hover:shadow-md">
                                        <li><a>Today</a></li>
                                        <li><a>This Week</a></li>
                                        <li><a>This Month</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id="modal-overview-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  End: Modal Overview -->

            <div class="col-span-12 xl:col-span-6 2xl:col-span-5">
                <div class="space-y-6">
                    <!--  Start: System Status -->

                    <div class="card bg-base-100 shadow">
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <span
                                    class="iconify lucide--heart-pulse size-4"></span>
                                <p class="grow font-medium">System Status</p>
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-base-content/60 text-sm italic max-sm:hidden">
                                        Fully operational
                                    </span>
                                    <div class="inline-grid *:[grid-area:1/1]">
                                        <div
                                            class="status status-success animate-ping"></div>
                                        <div class="status status-success"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div
                                    class="border-base-200 hover:bg-base-200/50 rounded-box cursor-pointer border p-3 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="iconify lucide--badge-check text-success size-4.5"></span>
                                        <p class="text-sm">API Success Rate</p>
                                    </div>
                                    <div
                                        class="mt-2.5 flex items-end justify-between gap-2">
                                        <p class="text-lg/none font-medium">98%</p>
                                        <p class="text-success text-sm/none">
                                            Stable
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="border-base-200 hover:bg-base-200/50 rounded-box cursor-pointer border p-3 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="iconify lucide--clock text-primary size-4.5"></span>
                                        <p class="text-sm">Response Time</p>
                                    </div>
                                    <div
                                        class="mt-2.5 flex items-end justify-between gap-2">
                                        <p class="text-lg/none font-medium">
                                            200ms
                                        </p>
                                        <p class="text-primary text-sm/none">
                                            Acceptable
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="border-base-200 hover:bg-base-200/50 rounded-box cursor-pointer border p-3 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="iconify lucide--zap text-secondary size-4.5"></span>
                                        <p class="text-sm">AI Performance</p>
                                    </div>
                                    <div
                                        class="mt-2.5 flex items-end justify-between gap-2">
                                        <p class="text-lg/none font-medium">
                                            350 tokens/req
                                        </p>
                                        <p class="text-secondary text-sm/none">
                                            Efficient
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="border-base-200 hover:bg-base-200/50 rounded-box cursor-pointer border p-3 transition-all">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="iconify lucide--server text-error size-4.5"></span>
                                        <p class="text-sm">Server Load</p>
                                    </div>
                                    <div
                                        class="mt-2.5 flex items-end justify-between gap-2">
                                        <p class="text-lg/none font-medium">75%</p>
                                        <p class="text-error text-sm/none">
                                            High Load
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  End: System Status -->

                    <!--  Start: Modals List -->

                    <div class="card bg-base-100 shadow">
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <span
                                    class="iconify lucide--brain-circuit text-base-content/80 size-4.5"></span>
                                <p class="grow font-medium">Modals</p>
                                <button class="btn btn-ghost btn-xs btn-circle">
                                    <span
                                        class="iconify lucide--settings-2 size-4"></span>
                                </button>
                            </div>
                            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                                <div
                                    class="group flex cursor-pointer items-center gap-3">
                                    <div
                                        class="border-base-300 group-hover:bg-base-200 flex size-9 items-center justify-center rounded-lg border border-dashed transition-all">
                                        <span class="iconify lucide--plus"></span>
                                    </div>
                                    <p class="leading-none font-medium">
                                        Add Modal
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="bg-primary/10 grid size-9 place-items-center rounded-lg">
                                        <div
                                            class="mask mask-hexagon-2 bg-primary/30 size-5"></div>
                                    </div>
                                    <div>
                                        <p class="leading-none font-medium">
                                            NeuraX-7
                                        </p>
                                        <p class="text-base-content/60 text-sm">
                                            99k users
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="bg-secondary/10 grid size-9 place-items-center rounded-lg">
                                        <div
                                            class="mask mask-diamond bg-secondary/30 size-5"></div>
                                    </div>
                                    <div>
                                        <p class="leading-none font-medium">
                                            SynthaMind-5
                                        </p>
                                        <p class="text-base-content/60 text-sm">
                                            120k users
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="bg-success/10 grid size-9 place-items-center rounded-lg">
                                        <div
                                            class="mask mask-pentagon bg-success/30 size-5"></div>
                                    </div>
                                    <div>
                                        <p class="leading-none font-medium">
                                            QuantumVision-X
                                        </p>
                                        <p class="text-base-content/60 text-sm">
                                            85k users
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  End: Modals List -->
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2 2xl:grid-cols-12">
            <div class="2xl:col-span-3">
                <!--  Start: Global AI Trends -->

                <div aria-label="Card" class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="flex items-center gap-3 px-5 pt-5">
                            <span class="iconify lucide--globe size-4.5"></span>
                            <span class="font-medium">Global AI Trends</span>
                            <button
                                class="btn btn-outline border-base-300 max-sm:btn-square btn-sm ms-auto">
                                <span
                                    class="iconify lucide--download size-3.5"></span>
                                <span class="max-sm:hidden">Download</span>
                            </button>
                        </div>
                        <div class="space-y-2.5 p-5">
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-primary/30 flex h-8 w-[67%] items-center rounded-full ps-5 text-sm">
                                    India
                                </div>
                                <span class="me-4 text-sm">67%</span>
                            </div>
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-secondary/30 flex h-8 w-[78%] items-center rounded-full ps-5 text-sm">
                                    United States
                                </div>
                                <span class="me-4 text-sm">78%</span>
                            </div>
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-success/30 flex h-8 w-[52%] items-center rounded-full ps-5 text-sm">
                                    Japan
                                </div>
                                <span class="me-4 text-sm">52%</span>
                            </div>
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-warning/30 flex h-8 w-[80%] items-center rounded-full ps-5 text-sm">
                                    Germany
                                </div>
                                <span class="me-4 text-sm">80%</span>
                            </div>
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-info/30 flex h-8 w-[45%] items-center rounded-full ps-5 text-sm">
                                    Canada
                                </div>
                                <span class="me-4 text-sm">45%</span>
                            </div>
                            <div
                                class="bg-base-200/80 flex h-8 w-full items-center justify-between rounded-full">
                                <div
                                    class="bg-error/30 flex h-8 w-[30%] items-center rounded-full ps-5 text-sm">
                                    Brazil
                                </div>
                                <span class="me-4 text-sm">30%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  End: Global AI Trends -->
            </div>
            <div class="max-2xl:order-2 lg:col-span-2 2xl:col-span-5">
                <!--  Start: Recent task table -->

                <div aria-label="Card" class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="flex items-center gap-3 px-5 pt-5">
                            <span
                                class="iconify lucide--list-check size-4.5"></span>
                            <span class="font-medium">Recent Generations</span>
                            <button
                                class="btn btn-outline border-base-300 max-sm:btn-square btn-sm ms-auto">
                                <span
                                    class="iconify lucide--file-text size-3.5"></span>
                                <span class="max-sm:hidden">Export</span>
                            </button>
                        </div>
                        <div class="mt-2 overflow-auto">
                            <table class="table *:text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            class="flex items-center space-x-3 truncate">
                                            <div
                                                class="bg-base-200 rounded-box p-2">
                                                <span
                                                    class="iconify lucide--settings block size-4"></span>
                                            </div>
                                            <p>Model Fine-Tuning</p>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="status status-info"></div>
                                                In Progress
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-base-content/80 inline-flex items-center gap-1 text-sm">
                                                <span
                                                    class="iconify lucide--clock size-3.5"></span>
                                                2h 30m
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                aria-label="Show product"
                                                class="btn btn-circle btn-ghost btn-sm">
                                                <span
                                                    class="iconify lucide--eye text-base-content/80 size-4"></span>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="flex items-center space-x-3 truncate">
                                            <div
                                                class="bg-base-200 rounded-box p-2">
                                                <span
                                                    class="iconify lucide--upload-cloud block size-4"></span>
                                            </div>
                                            <p>Dataset Processing</p>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="status status-warning"></div>
                                                On Hold
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-base-content/80 inline-flex items-center gap-1 text-sm">
                                                <span
                                                    class="iconify lucide--clock size-3.5"></span>
                                                1h 15m
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                aria-label="Show product"
                                                class="btn btn-circle btn-ghost btn-sm">
                                                <span
                                                    class="iconify lucide--eye text-base-content/80 size-4"></span>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="flex items-center space-x-3 truncate">
                                            <div
                                                class="bg-base-200 rounded-box p-2">
                                                <span
                                                    class="iconify lucide--wand block size-4"></span>
                                            </div>
                                            <p>Generating AI Art</p>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="status status-success"></div>
                                                Done
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-base-content/80 inline-flex items-center gap-1 text-sm">
                                                <span
                                                    class="iconify lucide--clock size-3.5"></span>
                                                45m
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                aria-label="Show product"
                                                class="btn btn-circle btn-ghost btn-sm">
                                                <span
                                                    class="iconify lucide--eye text-base-content/80 size-4"></span>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="flex items-center space-x-3 truncate">
                                            <div
                                                class="bg-base-200 rounded-box p-2">
                                                <span
                                                    class="iconify lucide--cpu block size-4"></span>
                                            </div>
                                            <p>Running Inference</p>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="status status-info"></div>
                                                In Progress
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="text-base-content/80 inline-flex items-center gap-1 text-sm">
                                                <span
                                                    class="iconify lucide--clock size-3.5"></span>
                                                3h 10m
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                aria-label="Show product"
                                                class="btn btn-circle btn-ghost btn-sm">
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

                <!--  End: Recent task table -->
            </div>
            <div class="max-2xl:order-1 2xl:col-span-4">
                <!--  Start: Resource utilization -->

                <div aria-label="Card" class="card bg-base-100 shadow">
                    <div class="card-body p-0">
                        <div class="flex items-center gap-3 px-5 pt-5">
                            <span class="iconify lucide--cpu size-4.5"></span>
                            <span class="font-medium">Resource Utilization</span>
                            <button
                                class="btn btn-outline border-base-300 max-sm:btn-square btn-sm ms-auto">
                                <span
                                    class="iconify lucide--bar-chart size-3.5"></span>
                                <span class="max-sm:hidden">View Report</span>
                            </button>
                        </div>
                    </div>
                    <div class="mx-4 -mt-2">
                        <div id="resource-utilization-chart"></div>
                    </div>
                </div>

                <!--  End: Resource utilization -->
            </div>
        </div>
    </div>
  </NexusLayout>
</template>

