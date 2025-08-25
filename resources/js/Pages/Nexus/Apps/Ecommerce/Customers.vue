<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
import { customers } from '@/data/ecommerce/customers'
</script>

<template>
  <Head title="Ecommerce Customers" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Customers</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li>Ecommerce</li>
            <li class="opacity-80">Customers</li>
          </ul>
        </div>
      </div>
      <div class="mt-6">
        <div class="card bg-base-100 shadow">
          <div class="card-body p-0">
            <div class="flex items-center justify-between px-5 pt-5">
              <div class="inline-flex items-center gap-3">
                <label class="input input-sm">
                  <span class="iconify lucide--search text-base-content/80 size-3.5"></span>
                  <input class="w-24 sm:w-36" placeholder="Search customers" aria-label="Search customers" type="search" />
                </label>
              </div>
            </div>
            <div class="mt-4 overflow-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th><input id="customer_check_all" aria-label="Check all" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Sales</th><th>Earning</th><th>Verified</th><th>Joined Date</th><th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="c in customers" :key="c.id" class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th><input :aria-label="`Select customer ${c.id}`" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <td class="font-medium">{{ c.id }}</td>
                    <td>
                      <div class="flex items-center space-x-3 truncate">
                        <img :alt="c.name" class="mask mask-squircle bg-base-200 size-10" :src="c.avatar" />
                        <div>
                          <p class="font-medium">{{ c.name }}</p>
                          <p class="text-base-content/80 text-xs capitalize">{{ c.gender }}</p>
                        </div>
                      </div>
                    </td>
                    <td>{{ c.email }}</td>
                    <td>{{ c.mobile }}</td>
                    <td>{{ c.sales }}</td>
                    <td>{{ c.earning }}</td>
                    <td>
                      <div class="badge badge-soft" :class="c.verified ? 'badge-success' : 'badge-warning'">{{ c.verified ? 'Verified' : 'Unverified' }}</div>
                    </td>
                    <td>{{ c.joined }}</td>
                    <td>
                      <button class="btn btn-square btn-ghost btn-sm" aria-label="View"><span class="iconify lucide--eye size-4"></span></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NexusLayout>
</template>

