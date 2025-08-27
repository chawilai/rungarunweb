<script setup>
import { onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import NexusLayout from "@/Layouts/NexusLayout.vue";

onMounted(() => {
    // Load ApexCharts and SimpleBar CDN if not present
    function ensureScript(src) {
        return new Promise((resolve) => {
            if (document.querySelector(`script[src="${src}"]`))
                return resolve();
            const s = document.createElement("script");
            s.src = src;
            s.onload = () => resolve();
            document.body.appendChild(s);
        });
    }
    function ensureCss(href) {
        if (document.querySelector(`link[href="${href}"]`)) return;
        const l = document.createElement("link");
        l.rel = "stylesheet";
        l.href = href;
        document.head.appendChild(l);
    }

    ensureCss(
        "https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.css",
    );

    Promise.all([
        ensureScript(
            "https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js",
        ),
        ensureScript(
            "https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.min.js",
        ),
    ]).then(() => {
        initCharts();
    });

    function initCharts() {
        if (!window.ApexCharts) return;
        initCustomerAcquisitionChart();
        initRevenueStatisticsChart();
        initGlobalSalesChart();
    }

    // Ported from nexus html js/pages/dashboards/ecommerce.js
    function initCustomerAcquisitionChart() {
        const el = document.getElementById("customer-acquisition-chart");
        if (!el) return;
        const chartOptions = {
            chart: {
                height: 356,
                sparkline: { enabled: false },
                toolbar: { show: false },
                zoom: { enabled: false },
                background: "transparent",
            },
            forecastDataPoints: { count: 2, dashArray: [6, 4] },
            grid: { show: false },
            yaxis: { show: false, min: 125, max: 181 },
            xaxis: {
                categories: Array.from({ length: 15 }, (_, index) => index + 1),
            },
            tooltip: { y: { formatter: (val) => val.toString() } },
            stroke: { curve: "stepline", width: [2, 1.5] },
            colors: ["#167bff", "rgba(150,150,150,0.3)"],
            series: [
                {
                    name: "Customer",
                    data: [
                        144, 150, 146, 154, 150, 155, 160, 155, 140, 155, 160,
                        180, 170, 165, 165,
                    ],
                },
                {
                    name: "Advertise",
                    data: [
                        140, 142, 142, 140, 146, 148, 150, 136, 130, 133, 145,
                        148, 158, 150, 150,
                    ],
                },
            ],
        };
        new window.ApexCharts(el, chartOptions).render();
    }
    function initRevenueStatisticsChart() {
        const el = document.getElementById("revenue-statics-chart");
        if (!el) return;
        const chartOptions = {
            chart: {
                height: 288,
                type: "bar",
                stacked: true,
                background: "transparent",
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    borderRadiusApplication: "end",
                    borderRadiusWhenStacked: "last",
                    colors: {
                        backgroundBarColors: ["rgba(150,150,150,0.07)"],
                        backgroundBarRadius: 8,
                    },
                    columnWidth: "45%",
                    barHeight: "100%",
                },
            },
            dataLabels: { enabled: false },
            colors: ["#ff8b4b", "#6c74f8"],
            legend: {
                show: true,
                horizontalAlign: "center",
                offsetX: 0,
                offsetY: 6,
            },
            series: [
                {
                    name: "Orders",
                    data: [10, 12, 14, 16, 18, 20, 14, 16, 24, 12],
                },
                {
                    name: "Revenue",
                    data: [15, 24, 21, 28, 30, 40, 22, 32, 48, 20],
                },
            ],
            xaxis: {
                categories: [
                    new Date("1/1/2016"),
                    new Date("1/1/2017"),
                    new Date("1/1/2018"),
                    new Date("1/1/2019"),
                    new Date("1/1/2020"),
                    new Date("1/1/2021"),
                    new Date("1/1/2022"),
                    new Date("1/1/2023"),
                    new Date("1/1/2024"),
                    new Date("1/1/2025"),
                ],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    formatter: (val) => new Date(val).getFullYear().toString(),
                },
            },
            yaxis: {
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { show: false },
            },
            tooltip: { enabled: true, shared: true, intersect: false },
            grid: { show: false },
            responsive: [
                {
                    breakpoint: 450,
                    options: {
                        plotOptions: { bar: { borderRadius: 4 } },
                        xaxis: { tickAmount: 3 },
                    },
                },
            ],
        };
        new window.ApexCharts(el, chartOptions).render();
    }
    function initGlobalSalesChart() {
        const el = document.getElementById("global-sales-chart");
        if (!el) return;
        const data = [
            { name: "Turkey", orders: 9 },
            { name: "India", orders: 12 },
            { name: "Canada", orders: 13 },
            { name: "US", orders: 16 },
            { name: "Netherlands", orders: 14 },
            { name: "Italy", orders: 17 },
            { name: "Other", orders: 19 },
        ];
        const chartOptions = {
            chart: {
                height: 344,
                type: "bar",
                parentHeightOffset: 0,
                background: "transparent",
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                    distributed: true,
                    borderRadiusApplication: "end",
                },
            },
            dataLabels: {
                enabled: true,
                textAnchor: "start",
                style: { colors: ["#fff"] },
                formatter: (val, opt) =>
                    opt.w.globals.labels[opt.dataPointIndex] + ":  " + val,
                offsetX: -10,
                dropShadow: { enabled: false },
            },
            series: [{ data: data.map((c) => c.orders) }],
            legend: { show: false },
            stroke: { width: 0, colors: ["#fff"] },
            xaxis: { categories: data.map((c) => c.name) },
            yaxis: { labels: { show: false } },
            grid: { show: false },
            tooltip: {
                theme: "dark",
                x: { show: false },
                y: { formatter: (val) => `${val}%` },
            },
            colors: [
                "#7179ff",
                "#4bcd89",
                "#ff6c88",
                "#5cb7ff",
                "#9071ff",
                "#ff5892",
                "#ff8b4b",
            ],
        };
        new window.ApexCharts(el, chartOptions).render();
    }
});
</script>

<template>
    <Head title="E-commerce Dashboard" />
    <NexusLayout>
        <div id="layout-content">
            <div class="flex items-center justify-between">
                <p class="text-lg font-medium">Business Overview</p>
                <div class="breadcrumbs hidden p-0 text-sm sm:inline">
                    <ul>
                        <li><a href="./dashboards-ecommerce.html">Nexus</a></li>
                        <li>Dashboards</li>
                        <li class="opacity-80">Ecommerce</li>
                    </ul>
                </div>
            </div>
            <div class="mt-6">
                <!--  Start: Dashboard Stats Widget -->

                <div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="card bg-base-100 shadow">
                        <div class="card-body gap-2">
                            <div
                                class="flex items-start justify-between gap-2 text-sm"
                            >
                                <div>
                                    <p class="text-base-content/80 font-medium">
                                        Revenue
                                    </p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <p class="inline text-2xl font-semibold">
                                            $587.54
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm gap-0.5 px-1 font-medium"
                                        >
                                            <span
                                                class="iconify lucide--arrow-up size-3.5"
                                            ></span>
                                            10.8%
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-base-200 rounded-box flex items-center p-2"
                                >
                                    <span
                                        class="iconify lucide--circle-dollar-sign size-5"
                                    ></span>
                                </div>
                            </div>
                            <p class="text-base-content/60 text-sm">
                                vs.
                                <span class="mx-1">$494.16</span>
                                last period
                            </p>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow">
                        <div class="card-body gap-2">
                            <div
                                class="flex items-start justify-between gap-2 text-sm"
                            >
                                <div>
                                    <p class="text-base-content/80 font-medium">
                                        Sales
                                    </p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <p class="inline text-2xl font-semibold">
                                            4500
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm gap-0.5 px-1 font-medium"
                                        >
                                            <span
                                                class="iconify lucide--arrow-up size-3.5"
                                            ></span>
                                            21.2%
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-base-200 rounded-box flex items-center p-2"
                                >
                                    <span
                                        class="iconify lucide--package size-5"
                                    ></span>
                                </div>
                            </div>
                            <p class="text-base-content/60 text-sm">
                                vs.
                                <span class="mx-1">3845</span>
                                last period
                            </p>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow">
                        <div class="card-body gap-2">
                            <div
                                class="flex items-start justify-between gap-2 text-sm"
                            >
                                <div>
                                    <p class="text-base-content/80 font-medium">
                                        Customers
                                    </p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <p class="inline text-2xl font-semibold">
                                            2242
                                        </p>
                                        <div
                                            class="badge badge-soft badge-error badge-sm gap-0.5 px-1 font-medium"
                                        >
                                            <span
                                                class="iconify lucide--arrow-down size-3.5"
                                            ></span>
                                            -6.8%
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-base-200 rounded-box flex items-center p-2"
                                >
                                    <span
                                        class="iconify lucide--users size-5"
                                    ></span>
                                </div>
                            </div>
                            <p class="text-base-content/60 text-sm">
                                vs.
                                <span class="mx-1">2448</span>
                                last period
                            </p>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow">
                        <div class="card-body gap-2">
                            <div
                                class="flex items-start justify-between gap-2 text-sm"
                            >
                                <div>
                                    <p class="text-base-content/80 font-medium">
                                        Spending
                                    </p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <p class="inline text-2xl font-semibold">
                                            $112.54
                                        </p>
                                        <div
                                            class="badge badge-soft badge-success badge-sm gap-0.5 px-1 font-medium"
                                        >
                                            <span
                                                class="iconify lucide--arrow-up size-3.5"
                                            ></span>
                                            8.5%
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-base-200 rounded-box flex items-center p-2"
                                >
                                    <span
                                        class="iconify lucide--eraser size-5"
                                    ></span>
                                </div>
                            </div>
                            <p class="text-base-content/60 text-sm">
                                vs.
                                <span class="mx-1">$98.14</span>
                                last period
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12">
                    <div class="xl:col-span-7">
                        <!--  Start: Revenue Statistic -->

                        <div class="card bg-base-100 shadow">
                            <div class="card-body px-0 pb-0">
                                <div class="px-6">
                                    <div class="flex items-start justify-between">
                                        <span class="font-medium">
                                            Revenue Statistics
                                        </span>
                                        <div
                                            class="tabs tabs-box tabs-xs hidden sm:block"
                                        >
                                            <div class="tab false px-3">Day</div>
                                            <div class="tab false px-3">Month</div>
                                            <div class="tab tab-active px-3">
                                                Year
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-4xl font-semibold">
                                                $184.78K
                                            </span>
                                            <span class="text-success font-medium">
                                                +3.24%
                                            </span>
                                        </div>
                                        <span class="text-base-content/60 text-sm">
                                            Total income in this year
                                        </span>
                                    </div>
                                </div>
                                <div id="revenue-statics-chart"></div>
                            </div>
                        </div>

                        <!--  End: Revenue Statistic -->
                    </div>
                    <div class="xl:col-span-5">
                        <!--  Start: Customer Acquisition -->

                        <div class="card bg-base-100 shadow">
                            <div class="card-body p-0">
                                <div
                                    class="flex items-center justify-between px-5 pt-5"
                                >
                                    <span class="font-medium">
                                        Customer Acquisition
                                    </span>
                                    <div class="inline-flex items-center gap-2">
                                        <div
                                            class="text-base-content/60 w-6 border border-dashed"
                                        ></div>
                                        <span class="text-base-content/80 text-xs">
                                            Prediction
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-4 py-3">
                                    <div
                                        class="divide-base-300 grid grid-cols-2 gap-5 px-5 sm:grid-cols-3 sm:divide-x"
                                    >
                                        <div class="text-center">
                                            <p>Advertise</p>
                                            <p class="mt-0.5 text-xl font-medium">
                                                $148
                                            </p>
                                            <div
                                                class="text-success mt-0.5 inline-flex items-center gap-1"
                                            >
                                                <span
                                                    class="iconify lucide--arrow-up size-3"
                                                ></span>
                                                <p class="text-xs">4.78%</p>
                                            </div>
                                        </div>
                                        <div class="hidden text-center sm:block">
                                            <p>Customers</p>
                                            <p class="mt-0.5 text-xl font-medium">
                                                427
                                            </p>
                                            <div
                                                class="text-success mt-0.5 inline-flex items-center gap-1"
                                            >
                                                <span
                                                    class="iconify lucide--arrow-up size-3"
                                                ></span>
                                                <p class="text-xs">3.15%</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="-mt-25 sm:mx-5">
                                    <div id="customer-acquisition-chart"></div>
                                </div>
                            </div>
                        </div>

                        <!--  End: Customer Acquisition -->
                    </div>
                </div>
                <div
                    class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-5 2xl:grid-cols-12"
                >
                    <div class="xl:col-span-3 2xl:col-span-5">
                        <!--  Start: Recent Orders -->

                        <div aria-label="Card" class="card bg-base-100 shadow">
                            <div class="card-body p-0">
                                <div class="flex items-center gap-3 px-5 pt-5">
                                    <span
                                        class="iconify lucide--shopping-bag size-4.5"
                                    ></span>
                                    <span class="font-medium">Recent Orders</span>
                                    <button
                                        class="btn btn-outline border-base-300 btn-sm ms-auto"
                                    >
                                        <span
                                            class="iconify lucide--download size-3.5"
                                        ></span>
                                        Report
                                    </button>
                                </div>
                                <div class="mt-2 overflow-auto">
                                    <table class="table *:text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-all-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <td
                                                    class="flex items-center space-x-3 truncate"
                                                >
                                                    <img
                                                        alt="order image"
                                                        class="mask mask-squircle bg-base-200 size-7.5"
                                                        src="/nexus/images/apps/ecommerce/products/1.jpg"
                                                    />
                                                    <p>Men's tracking shoes</p>
                                                </td>
                                                <td class="font-medium">$99</td>
                                                <td class="text-xs">25 Jun 2024</td>
                                                <td>
                                                    <div
                                                        class="badge badge-success badge-sm badge-soft"
                                                    >
                                                        Delivered
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-ghost btn-xs"
                                                        >
                                                            <span
                                                                class="iconify lucide--eye text-base-content/60 size-4"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-error btn-outline btn-xs border-transparent"
                                                        >
                                                            <span
                                                                class="iconify lucide--trash size-4"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <td
                                                    class="flex items-center space-x-3 truncate"
                                                >
                                                    <img
                                                        alt="order image"
                                                        class="mask mask-squircle bg-base-200 size-7.5"
                                                        src="/nexus/images/apps/ecommerce/products/2.jpg"
                                                    />
                                                    <p>Cocooil body oil</p>
                                                </td>
                                                <td class="font-medium">$75</td>
                                                <td class="text-xs">22 Jun 2024</td>
                                                <td>
                                                    <div
                                                        class="badge badge-info badge-sm badge-soft"
                                                    >
                                                        On Going
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-ghost btn-xs"
                                                        >
                                                            <span
                                                                class="iconify lucide--eye text-base-content/60 size-4"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-error btn-outline btn-xs border-transparent"
                                                        >
                                                            <span
                                                                class="iconify lucide--trash size-4"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <td
                                                    class="flex items-center space-x-3 truncate"
                                                >
                                                    <img
                                                        alt="order image"
                                                        class="mask mask-squircle bg-base-200 size-7.5"
                                                        src="/nexus/images/apps/ecommerce/products/3.jpg"
                                                    />
                                                    <p>Freeze Air</p>
                                                </td>
                                                <td class="font-medium">$47</td>
                                                <td class="text-xs">17 Jun 2024</td>
                                                <td>
                                                    <div
                                                        class="badge badge-primary badge-sm badge-soft"
                                                    >
                                                        Confirmed
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-ghost btn-xs"
                                                        >
                                                            <span
                                                                class="iconify lucide--eye text-base-content/60 size-4"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-error btn-outline btn-xs border-transparent"
                                                        >
                                                            <span
                                                                class="iconify lucide--trash size-4"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <td
                                                    class="flex items-center space-x-3 truncate"
                                                >
                                                    <img
                                                        alt="order image"
                                                        class="mask mask-squircle bg-base-200 size-7.5"
                                                        src="/nexus/images/apps/ecommerce/products/4.jpg"
                                                    />
                                                    <p>Ladies's shoes</p>
                                                </td>
                                                <td class="font-medium">$52</td>
                                                <td class="text-xs">23 Jun 2024</td>
                                                <td>
                                                    <div
                                                        class="badge badge-error badge-sm badge-soft"
                                                    >
                                                        Canceled
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-ghost btn-xs"
                                                        >
                                                            <span
                                                                class="iconify lucide--eye text-base-content/60 size-4"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-error btn-outline btn-xs border-transparent"
                                                        >
                                                            <span
                                                                class="iconify lucide--trash size-4"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <input
                                                        aria-label="checked-order"
                                                        class="checkbox checkbox-sm"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <td
                                                    class="flex items-center space-x-3 truncate"
                                                >
                                                    <img
                                                        alt="order image"
                                                        class="mask mask-squircle bg-base-200 size-7.5"
                                                        src="/nexus/images/apps/ecommerce/products/10.jpg"
                                                    />
                                                    <p>Choco's cookie</p>
                                                </td>
                                                <td class="font-medium">$24</td>
                                                <td class="text-xs">21 Jun 2024</td>
                                                <td>
                                                    <div
                                                        class="badge badge-secondary badge-sm badge-soft"
                                                    >
                                                        Waiting
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-ghost btn-xs"
                                                        >
                                                            <span
                                                                class="iconify lucide--eye text-base-content/60 size-4"
                                                            ></span>
                                                        </button>
                                                        <button
                                                            aria-label="Show product"
                                                            class="btn btn-square btn-error btn-outline btn-xs border-transparent"
                                                        >
                                                            <span
                                                                class="iconify lucide--trash size-4"
                                                            ></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--  End: Recent Orders -->
                    </div>
                    <div class="xl:col-span-2 2xl:col-span-3">
                        <!--  Start: Quick Chat -->

                        <div class="card bg-base-100 shadow">
                            <div class="card-body pb-3">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="iconify lucide--messages-square size-4.5"
                                    ></span>
                                    <span class="font-medium">Quick Chat</span>
                                    <a
                                        href="./apps/chat"
                                        class="btn btn-outline btn-sm border-base-300 ms-auto"
                                    >
                                        Go To Chat
                                    </a>
                                </div>
                                <div class="-mx-2 mt-2 space-y-0.5">
                                    <div
                                        class="rounded-box hover:bg-base-200 flex cursor-pointer items-center gap-3 px-2 py-2 transition-all active:scale-[.98]"
                                    >
                                        <img
                                            alt="chat"
                                            class="bg-base-200 mask mask-squircle size-11"
                                            src="/nexus/images/avatars/1.png"
                                        />
                                        <div class="grow">
                                            <div class="flex gap-1">
                                                <p class="grow">Mia Johnson</p>
                                                <span
                                                    class="text-base-content/60 text-xs"
                                                >
                                                    11:35 AM
                                                </span>
                                            </div>
                                            <p
                                                class="text-base-content/80 line-clamp-1 text-sm text-ellipsis"
                                            >
                                                It's called 'Dreamscape.' A
                                                must-watch!
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-box hover:bg-base-200 flex cursor-pointer items-center gap-3 px-2 py-2 transition-all active:scale-[.98]"
                                    >
                                        <img
                                            alt="chat"
                                            class="bg-base-200 mask mask-squircle size-11"
                                            src="/nexus/images/avatars/2.png"
                                        />
                                        <div class="grow">
                                            <div class="flex gap-1">
                                                <p class="grow">Ethan Patel</p>
                                                <span
                                                    class="text-base-content/60 text-xs"
                                                >
                                                    09:58 AM
                                                </span>
                                            </div>
                                            <p
                                                class="text-base-content/80 line-clamp-1 text-sm text-ellipsis"
                                            >
                                                Just got a new book. Excited to
                                                start reading.
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-box hover:bg-base-200 flex cursor-pointer items-center gap-3 px-2 py-2 transition-all active:scale-[.98]"
                                    >
                                        <img
                                            alt="chat"
                                            class="bg-base-200 mask mask-squircle size-11"
                                            src="/nexus/images/avatars/3.png"
                                        />
                                        <div class="grow">
                                            <div class="flex gap-1">
                                                <p class="grow">Sophia Nguyen</p>
                                                <span
                                                    class="text-base-content/60 text-xs"
                                                >
                                                    08:20 AM
                                                </span>
                                            </div>
                                            <p
                                                class="text-base-content/80 line-clamp-1 text-sm text-ellipsis"
                                            >
                                                How's your day going?
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-box hover:bg-base-200 flex cursor-pointer items-center gap-3 px-2 py-2 transition-all active:scale-[.98]"
                                    >
                                        <img
                                            alt="chat"
                                            class="bg-base-200 mask mask-squircle size-11"
                                            src="/nexus/images/avatars/4.png"
                                        />
                                        <div class="grow">
                                            <div class="flex gap-1">
                                                <p class="grow">Emily Chen</p>
                                                <span
                                                    class="text-base-content/60 text-xs"
                                                >
                                                    06:21 PM
                                                </span>
                                            </div>
                                            <p
                                                class="text-base-content/80 line-clamp-1 text-sm text-ellipsis"
                                            >
                                                Did you see that amazing sunset
                                                yesterday?
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-box hover:bg-base-200 flex cursor-pointer items-center gap-3 px-2 py-2 transition-all active:scale-[.98]"
                                    >
                                        <img
                                            alt="chat"
                                            class="bg-base-200 mask mask-squircle size-11"
                                            src="/nexus/images/avatars/5.png"
                                        />
                                        <div class="grow">
                                            <div class="flex gap-1">
                                                <p class="grow">Kelvin S.</p>
                                                <span
                                                    class="text-base-content/60 text-xs"
                                                >
                                                    08:15 AM
                                                </span>
                                            </div>
                                            <p
                                                class="text-base-content/80 line-clamp-1 text-sm text-ellipsis"
                                            >
                                                Not sure, what you talking about...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  End: Quick Chat -->
                    </div>
                    <div class="xl:col-span-3 2xl:col-span-4">
                        <!--  Start: Global Sales -->

                        <div class="card bg-base-100 shadow">
                            <div class="card-body gap-0 p-0">
                                <div class="flex items-center gap-3 px-5 pt-5">
                                    <span
                                        class="iconify lucide--globe-2 size-4.5"
                                    ></span>
                                    <span class="font-medium"
                                        >Global Sales (%)</span
                                    >
                                    <button
                                        class="btn btn-ghost btn-outline border-base-300 btn-sm z-1 ms-auto"
                                    >
                                        <span
                                            class="iconify lucide--eye size-4"
                                        ></span>
                                        Overview
                                    </button>
                                </div>
                                <div class="me-5 -mt-5 mb-1">
                                    <div id="global-sales-chart"></div>
                                </div>
                            </div>
                        </div>

                        <!--  End: Global Sales -->
                    </div>
                </div>
            </div>
        </div>
    </NexusLayout>
</template>
