<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
import { products } from '@/data/ecommerce/products'
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
                  <tr v-for="p in products" :key="p.id" class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <th><input :aria-label="`Select product ${p.id}`" class="checkbox checkbox-sm" type="checkbox" /></th>
                    <td>{{ p.id }}</td>
                    <td>
                      <div class="flex items-center space-x-3 truncate">
                        <img :alt="p.name" class="rounded-box size-10" :src="p.image" />
                        <div>
                          <p class="font-medium">{{ p.name }}</p>
                          <p class="text-base-content/60 text-xs">{{ p.tag }}</p>
                        </div>
                      </div>
                    </td>
                    <td>{{ p.category }}</td>
                    <td class="text-sm font-medium">${{ p.price }}</td>
                    <td>{{ p.rating }}</td>
                    <td>{{ p.orders }}</td>
                    <td>
                      <div class="badge" :class="p.stock === 'In stock' ? 'badge-soft badge-success' : p.stock === 'Low stock' ? 'badge-soft badge-warning' : 'badge-soft badge-error'">
                        {{ p.stock }}
                      </div>
                    </td>
                    <td>{{ p.createdAt }}</td>
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

