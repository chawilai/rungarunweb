<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
</script>

<template>
  <Head title="Ecommerce Products" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Products</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li>Ecommerce</li>
            <li class="opacity-80">Products</li>
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
                  <input class="w-24 sm:w-36" placeholder="Search products" aria-label="Search products" type="search" />
                </label>
                <div class="hidden sm:block">
                  <select class="select select-sm w-36" aria-label="Category">
                    <option value="" disabled selected>Select Category</option>
                    <option>Fashion</option><option>Daily Need</option><option>Cosmetic</option><option>Electronics</option><option>Food</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mt-4 overflow-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th><input aria-label="Check all" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Ratings</th><th>Orders</th><th>Stock</th><th>Created At</th><th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th><input aria-label="Single check" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <td>1001</td>
                    <td>
                      <div class="flex items-center space-x-3 truncate">
                        <img alt="Product" class="rounded-box size-10" src="/nexus/images/apps/ecommerce/products/1.jpg" />
                        <div>
                          <p class="font-medium">Men's tracking shoes</p>
                          <p class="text-base-content/60 text-xs">#SHOES</p>
                        </div>
                      </div>
                    </td>
                    <td>Fashion</td>
                    <td class="text-sm font-medium">$29</td>
                    <td>4.6</td>
                    <td>136</td>
                    <td><div class="badge badge-soft badge-success">In stock</div></td>
                    <td>14 Feb 2024</td>
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

