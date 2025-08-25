<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
import { shops } from '@/data/ecommerce/shops'
</script>

<template>
  <Head title="Ecommerce Shops" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Shops</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li>Ecommerce</li>
            <li class="opacity-80">Shops</li>
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
                  <input class="w-24 sm:w-36" placeholder="Search shops" aria-label="Search shops" type="search" />
                </label>
              </div>
            </div>
            <div class="mt-4 overflow-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col"><input id="shop_check_all" aria-label="Check all" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <th scope="col">ID</th><th scope="col">Name</th><th scope="col">Seller</th><th scope="col">Email</th><th scope="col">Mobile</th><th scope="col">Sales</th><th scope="col">Rating</th><th scope="col">Earning</th><th scope="col">Verified</th><th scope="col">Joined Date</th><th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="s in shops" :key="s.id" class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th scope="row"><input :aria-label="`Select shop ${s.id}`" data-slot="single-checkbox" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <td class="font-medium">{{ s.id }}</td>
                    <td class="font-medium">{{ s.name }}</td>
                    <td>{{ s.seller }}</td>
                    <td>{{ s.email }}</td>
                    <td>{{ s.mobile }}</td>
                    <td>{{ s.sales }}</td>
                    <td>
                      <div class="flex items-center gap-1">
                        <span class="iconify lucide--star text-success size-4"></span>
                        {{ s.rating }} <span class="text-base-content/80 text-xs">({{ s.ratingCount }})</span>
                      </div>
                    </td>
                    <td>{{ s.earning }}</td>
                    <td><div class="badge badge-soft" :class="s.verified ? 'badge-success' : 'badge-warning'">{{ s.verified ? 'Verified' : 'Unverified' }}</div></td>
                    <td>{{ s.joined }}</td>
                    <td><button class="btn btn-square btn-ghost btn-sm" aria-label="View"><span class="iconify lucide--eye size-4"></span></button></td>
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

