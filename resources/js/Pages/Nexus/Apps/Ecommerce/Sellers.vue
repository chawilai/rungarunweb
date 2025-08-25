<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
</script>

<template>
  <Head title="Ecommerce Sellers" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Sellers</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li>Ecommerce</li>
            <li class="opacity-80">Sellers</li>
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
                  <input class="w-24 sm:w-36" placeholder="Search sellers" aria-label="Search sellers" type="search" />
                </label>
              </div>
            </div>
            <div class="mt-4 overflow-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th><input id="seller_check_all" aria-label="Check all" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <th>ID</th><th>Name</th><th>Shop</th><th>Email</th><th>Mobile</th><th>Sales</th><th>Earning</th><th>Verified</th><th>Joined Date</th><th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th><input aria-label="Single check" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <td class="font-medium">1</td>
                    <td>
                      <div class="flex items-center space-x-3 truncate">
                        <img alt="Seller Image" class="mask mask-squircle bg-base-200 size-10" src="/nexus/images/avatars/9.png" />
                        <div>
                          <p class="font-medium">Anthony S. Amaya</p>
                          <p class="text-base-content/60 text-xs capitalize">male</p>
                        </div>
                      </div>
                    </td>
                    <td class="font-medium">Urban Chic Boutique</td>
                    <td>urban.chic@yahoo.com</td>
                    <td>402-788-1602</td>
                    <td>20</td>
                    <td>$1,240</td>
                    <td><div class="badge badge-soft badge-success">Verified</div></td>
                    <td>09 Jan 2024</td>
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

