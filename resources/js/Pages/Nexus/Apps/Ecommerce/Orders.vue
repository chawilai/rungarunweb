<script setup>
import { Head, Link } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
import { orders } from '@/data/ecommerce/orders'
</script>

<template>
  <Head title="Ecommerce Orders" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Orders</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li>Ecommerce</li>
            <li class="opacity-80">Orders</li>
          </ul>
        </div>
      </div>
      <div class="mt-6">
        <div class="card bg-base-100 mt-5 shadow">
          <div class="card-body p-0">
            <div class="flex items-center justify-between px-5 pt-5">
              <div class="inline-flex items-center gap-3">
                <label class="input input-sm">
                  <span class="iconify lucide--search text-base-content/80 size-3.5"></span>
                  <input class="w-24 sm:w-36" placeholder="Search along orders" aria-label="Search orders" type="search" />
                </label>
                <div class="hidden sm:block">
                  <select class="select select-sm w-36" aria-label="Category">
                    <option value="" disabled selected>Select Category</option>
                    <option>Fashion</option>
                    <option>Daily Need</option>
                    <option>Cosmetic</option>
                    <option>Electronics</option>
                    <option>Food</option>
                  </select>
                </div>
              </div>
              <Link class="btn btn-sm btn-primary" href="/dashboards-ecommerce">
                <span class="iconify lucide--monitor-dot size-4"></span>
                <span class="hidden sm:inline">Dashboard</span>
              </Link>
            </div>
            <div class="mt-4 overflow-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th class="px-6">
                      <input aria-label="Check all" class="checkbox checkbox-sm" type="checkbox" />
                    </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Customer</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="o in orders" :key="o.id" class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th class="px-6">
                      <input :aria-label="`Select order ${o.id}`" data-slot="single-checkbox" class="checkbox checkbox-sm" type="checkbox" />
                    </th>
                    <td class="font-medium">{{ o.id }}</td>
                    <td>{{ o.itemsCount }} Items</td>
                    <td>{{ o.customer }}</td>
                    <td class="text-sm font-medium">${{ o.price }}</td>
                    <td>
                      <div class="badge badge-soft" :class="o.payment === 'Paid' ? 'badge-success' : o.payment === 'Pending' ? 'badge-warning' : 'badge-error'">{{ o.payment }}</div>
                    </td>
                    <td class="text-sm">{{ o.status }}</td>
                    <td class="text-sm">{{ o.orderedAt }}</td>
                    <td>
                      <Link :aria-label="`View order ${o.id}`" href="/apps-ecommerce-orders">
                        <button :aria-label="`View order ${o.id}`" class="btn btn-square btn-ghost btn-sm">
                          <span class="iconify lucide--eye text-base-content/80 size-4"></span>
                        </button>
                      </Link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="flex items-center justify-between p-6">
              <div class="text-base-content/80 hover:text-base-content flex gap-2 text-sm">
                <span class="hidden sm:inline">Per page</span>
                <select class="select select-xs w-18" aria-label="Per page">
                  <option value="10">10</option>
                  <option value="20" selected>20</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select>
              </div>
              <span class="text-base-content/80 hidden text-sm lg:inline">Showing <span class="text-base-content font-medium">1 to 20</span> of 457 items</span>
              <div class="join">
                <button class="btn btn-sm join-item">Prev</button>
                <button class="btn btn-sm join-item btn-primary">1</button>
                <button class="btn btn-sm join-item">2</button>
                <button class="btn btn-sm join-item">3</button>
                <button class="btn btn-sm join-item">Next</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NexusLayout>
</template>

