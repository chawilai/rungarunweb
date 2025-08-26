<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import NexusLayout from '@/Layouts/NexusLayout.vue'
import { orders as allOrders } from '@/data/ecommerce/orders'

// Filters
const search = ref('')
const category = ref('')

// Pagination
const perPage = ref(20)
const currentPage = ref(1)

// Filtered data
const filteredOrders = computed(() => {
  const q = search.value.trim().toLowerCase()
  const cat = category.value
  return allOrders.filter(o => {
    if (cat && o.category !== cat) return false
    if (!q) return true
    const hay = `${o.id} ${o.customer} ${o.status} ${o.payment}`.toLowerCase()
    return hay.includes(q)
  })
})

const totalItems = computed(() => filteredOrders.value.length)
const pageCount = computed(() => Math.max(1, Math.ceil(totalItems.value / perPage.value)))

watch(perPage, () => { currentPage.value = 1 })
watch(search, () => { currentPage.value = 1 })
watch(category, () => { currentPage.value = 1 })

const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  return filteredOrders.value.slice(start, start + perPage.value)
})

const showingFrom = computed(() => {
  if (totalItems.value === 0) return 0
  return (currentPage.value - 1) * perPage.value + 1
})
const showingTo = computed(() => Math.min(totalItems.value, currentPage.value * perPage.value))

function goToPage(n) {
  const p = Math.min(Math.max(1, n), pageCount.value)
  if (p !== currentPage.value) currentPage.value = p
}
function prevPage() { goToPage(currentPage.value - 1) }
function nextPage() { goToPage(currentPage.value + 1) }

const visiblePages = computed(() => {
  const pages = pageCount.value
  const max = 5
  if (pages <= max) return Array.from({ length: pages }, (_, i) => i + 1)
  const cur = currentPage.value
  const half = Math.floor(max / 2)
  let start = Math.max(1, cur - half)
  let end = Math.min(pages, start + max - 1)
  if (end - start + 1 < max) start = Math.max(1, end - max + 1)
  return Array.from({ length: end - start + 1 }, (_, i) => start + i)
})

// Row selection
const selectedIds = ref(new Set())
const pageIds = computed(() => paginatedOrders.value.map(o => o.id))
const isAllChecked = computed(() => pageIds.value.length > 0 && pageIds.value.every(id => selectedIds.value.has(id)))
const isIndeterminate = computed(() => {
  const count = pageIds.value.filter(id => selectedIds.value.has(id)).length
  return count > 0 && count < pageIds.value.length
})
function toggleAll(e) {
  const checked = e.target.checked
  const ids = pageIds.value
  if (checked) ids.forEach(id => selectedIds.value.add(id))
  else ids.forEach(id => selectedIds.value.delete(id))
}
function toggleOne(id, checked) {
  if (checked) selectedIds.value.add(id)
  else selectedIds.value.delete(id)
}
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
                  <input v-model.trim="search" class="w-24 sm:w-36" placeholder="Search along orders" aria-label="Search orders" type="search" />
                </label>
                <div class="hidden sm:block">
                  <select class="select select-sm w-36" aria-label="Category" v-model="category">
                    <option value="">Select Category</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Daily Need">Daily Need</option>
                    <option value="Cosmetic">Cosmetic</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Food">Food</option>
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
                      <input aria-label="Check all" class="checkbox checkbox-sm" type="checkbox"
                             :checked="isAllChecked" :indeterminate.prop="isIndeterminate" @change="toggleAll" />
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Price</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ordered At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="o in paginatedOrders" :key="o.id" class="hover:bg-base-200/40 cursor-pointer *:text-nowrap">
                    <td class="px-6">
                      <input :aria-label="`Select order ${o.id}`" data-slot="single-checkbox" class="checkbox checkbox-sm" type="checkbox"
                             :checked="selectedIds.has(o.id)" @change="toggleOne(o.id, $event.target.checked)" />
                    </td>
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
                <select class="select select-xs w-18" aria-label="Per page" v-model.number="perPage">
                  <option :value="5">5</option>
                  <option :value="10">10</option>
                  <option :value="20">20</option>
                  <option :value="50">50</option>
                  <option :value="100">100</option>
                </select>
              </div>
              <span class="text-base-content/80 hidden text-sm lg:inline">Showing <span class="text-base-content font-medium">{{ showingFrom }} to {{ showingTo }}</span> of {{ totalItems }} items</span>
              <div class="join">
                <button class="btn btn-sm join-item" :disabled="currentPage===1" @click="prevPage">Prev</button>
                <button v-for="p in visiblePages" :key="p" class="btn btn-sm join-item" :class="{ 'btn-primary': currentPage===p }" @click="goToPage(p)">{{ p }}</button>
                <button class="btn btn-sm join-item" :disabled="currentPage===pageCount" @click="nextPage">Next</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NexusLayout>
</template>

