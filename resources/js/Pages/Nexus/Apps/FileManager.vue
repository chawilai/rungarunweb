<script setup>
import { Head } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import NexusLayout from '@/Layouts/NexusLayout.vue'

onMounted(() => {
  // no scripts needed for static UI; drawers are pure CSS
})
</script>

<template>
  <Head title="File Manager" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="grid grid-cols-1 gap-6 xl:grid-cols-3 2xl:grid-cols-4">
        <div class="col-span-1 xl:col-span-2 2xl:col-span-3">
          <div class="flex items-center justify-between">
            <p class="text-lg font-medium">File Manager</p>
            <div class="inline-flex items-center gap-3">
              <!-- Overview as Drawer (visible on small screens) -->
              <div class="drawer drawer-end">
                <input id="apps-file-overview-drawer" class="drawer-toggle" aria-label="File Overview Trigger" type="checkbox" />
                <div class="drawer-content">
                  <label for="apps-file-overview-drawer" class="btn drawer-button btn-sm btn-ghost border-base-300 flex xl:hidden">
                    <span class="iconify lucide--folder-kanban size-4"></span>
                  </label>
                </div>
                <div class="drawer-side z-[50]">
                  <label for="apps-file-overview-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                  <div class="w-72 p-2">
                    <div class="card bg-base-100 card-border">
                      <div class="card-body gap-2">
                        <div class="flex items-center justify-between">
                          <p class="font-medium">Overview</p>
                          <button class="btn btn-success btn-outline btn-sm border-transparent">Upgrade Now</button>
                        </div>
                        <div class="card card-border bg-primary/5 border-primary/10 mt-2">
                          <div class="card-body p-3">
                            <div class="flex items-center gap-2.5">
                              <span class="iconify lucide--hard-drive text-primary size-4.5"></span>
                              <span class="text-primary font-medium">Local Storage</span>
                              <span class="text-primary ms-auto text-sm font-medium">64%</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between gap-2 text-sm">
                              <span class="font-medium">162 GB</span>
                              <span class="text-base-content/80 text-xs">Used of 250 GB</span>
                            </div>
                            <progress max="250" value="160" class="progress progress-primary mt-1 h-1.5"></progress>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Files grid -->
          <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <div class="card bg-base-100 card-border">
              <div class="card-body p-4">
                <div class="flex items-center gap-3">
                  <span class="iconify lucide--folder text-warning size-6"></span>
                  <div>
                    <p class="font-medium">Designs</p>
                    <p class="text-xs text-base-content/60">23 items</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-base-100 card-border">
              <div class="card-body p-4">
                <div class="flex items-center gap-3">
                  <span class="iconify lucide--file-text text-info size-6"></span>
                  <div>
                    <p class="font-medium">Proposal.pdf</p>
                    <p class="text-xs text-base-content/60">1.2 MB</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-base-100 card-border">
              <div class="card-body p-4">
                <div class="flex items-center gap-3">
                  <span class="iconify lucide--image text-success size-6"></span>
                  <div>
                    <p class="font-medium">Hero.jpg</p>
                    <p class="text-xs text-base-content/60">3.4 MB</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-base-100 card-border">
              <div class="card-body p-4">
                <div class="flex items-center gap-3">
                  <span class="iconify lucide--file-spreadsheet text-primary size-6"></span>
                  <div>
                    <p class="font-medium">Revenue.xlsx</p>
                    <p class="text-xs text-base-content/60">512 KB</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side Overview (visible on xl+) -->
        <div class="hidden xl:block">
          <div class="card bg-base-100 card-border">
            <div class="card-body gap-2">
              <div class="flex items-center justify-between">
                <p class="font-medium">Overview</p>
                <button class="btn btn-success btn-outline btn-sm border-transparent">Upgrade Now</button>
              </div>
              <div class="card card-border bg-primary/5 border-primary/10 mt-2">
                <div class="card-body p-3">
                  <div class="flex items-center gap-2.5">
                    <span class="iconify lucide--hard-drive text-primary size-4.5"></span>
                    <span class="text-primary font-medium">Local Storage</span>
                    <span class="text-primary ms-auto text-sm font-medium">64%</span>
                  </div>
                  <div class="mt-2 flex items-center justify-between gap-2 text-sm">
                    <span class="font-medium">162 GB</span>
                    <span class="text-base-content/80 text-xs">Used of 250 GB</span>
                  </div>
                  <progress max="250" value="160" class="progress progress-primary mt-1 h-1.5"></progress>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NexusLayout>
</template>
