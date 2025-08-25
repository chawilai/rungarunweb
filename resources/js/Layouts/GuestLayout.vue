<script setup>

import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen flex items-center justify-center p-4" data-theme="light">
    <div class="w-full max-w-md">
      <div class="flex justify-center mb-6">
        <Link href="/dashboards-ecommerce">
          <img alt="logo" class="h-6" src="/nexus/images/logo/logo-light.png" />
        </Link>
      </div>
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
