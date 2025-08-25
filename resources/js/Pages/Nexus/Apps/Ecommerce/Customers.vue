<script setup>
import { Head } from '@inertiajs/vue3'
import NexusLayout from '@/Layouts/NexusLayout.vue'
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
      <div class="mt-6">Coming soon...</div>
    </div>
  </NexusLayout>
</template>

