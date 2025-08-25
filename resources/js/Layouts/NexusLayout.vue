<script setup>
import { onMounted, ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

// Minimal theme/layout controller port from html/js/app.js
const html = document.documentElement
const configKey = '__NEXUS_CONFIG_v3.0__'
const defaultConfig = {
  theme: 'system',
  direction: 'ltr',
  fontFamily: 'default',
  sidebarTheme: 'light',
  fullscreen: false,
}
const config = ref({ ...defaultConfig })

function loadConfig() {
  try {
    const cache = localStorage.getItem(configKey)
    config.value = cache ? JSON.parse(cache) : { ...defaultConfig }
  } catch (e) {
    config.value = { ...defaultConfig }
  }
}

function saveConfig() {
  localStorage.setItem(configKey, JSON.stringify(config.value))
}

function applyConfig() {
  // theme
  if (config.value.theme === 'system') html.removeAttribute('data-theme')
  else html.setAttribute('data-theme', config.value.theme)

  // sidebar theme
  const sidebar = document.getElementById('layout-sidebar')
  if (sidebar) {
    if (
      config.value.sidebarTheme === 'dark' &&
      ['light', 'contrast'].includes(config.value.theme)
    ) {
      sidebar.setAttribute('data-theme', config.value.sidebarTheme)
    } else sidebar.removeAttribute('data-theme')
  }

  html.setAttribute('data-sidebar-theme', config.value.sidebarTheme)
  html.dir = config.value.direction

  if (config.value.fullscreen) html.setAttribute('data-fullscreen', '')
  else html.removeAttribute('data-fullscreen')

  if (config.value.fontFamily !== 'default')
    html.setAttribute('data-font-family', config.value.fontFamily)
  else html.removeAttribute('data-font-family')
}

function updateAndApply() {
  saveConfig()
  applyConfig()
}

onMounted(() => {
  loadConfig()
  applyConfig()

  // fullscreen media sync
  const fullscreenMedia = window.matchMedia('(display-mode: fullscreen)')
  const listener = () => {
    config.value.fullscreen = fullscreenMedia.matches
    updateAndApply()
  }
  fullscreenMedia.addEventListener('change', listener)
})

// Active menu handling based on current URL
const { url } = usePage()
function isActive(href) {
  try {
    const u = new URL(href, window.location.origin)
    return u.pathname === window.location.pathname
  } catch {
    return href === window.location.pathname
  }
}
</script>

<template>
  <div class="size-full">
    <div class="flex">
      <!-- Sidebar -->
      <input type="checkbox" id="layout-sidebar-toggle-trigger" class="hidden" aria-label="Toggle layout sidebar" />
      <input type="checkbox" id="layout-sidebar-hover-trigger" class="hidden" aria-label="Dense layout sidebar" />
      <div id="layout-sidebar-hover" class="bg-base-300 h-screen w-1" />

      <div id="layout-sidebar" class="sidebar-menu sidebar-menu-activation">
        <div class="flex min-h-16 items-center justify-between gap-3 ps-5 pe-4">
          <Link href="/dashboards-ecommerce">
            <img alt="logo-dark" class="hidden h-5 dark:inline" src="/nexus/images/logo/logo-dark.png" />
            <img alt="logo-light" class="h-5 dark:hidden" src="/nexus/images/logo/logo-light.png" />
          </Link>
          <label for="layout-sidebar-hover-trigger" title="Toggle sidebar hover" class="btn btn-circle btn-ghost btn-sm text-base-content/50 relative max-lg:hidden">
            <span class="iconify lucide--panel-left-close absolute size-4.5 opacity-100 transition-all duration-300 group-has-[[id=layout-sidebar-hover-trigger]:checked]/html:opacity-0"></span>
            <span class="iconify lucide--panel-left-dashed absolute size-4.5 opacity-0 transition-all duration-300 group-has-[[id=layout-sidebar-hover-trigger]:checked]/html:opacity-100"></span>
          </label>
        </div>

        <div class="relative min-h-0 grow">
          <div data-simplebar class="size-full">
            <div class="mb-3 space-y-0.5 px-2.5">
              <p class="menu-label px-2.5 pt-3 pb-1.5 first:pt-0">Overview</p>
              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" />
                <div class="collapse-title px-2.5 py-1.5">
                  <span class="iconify lucide--monitor-dot size-4"></span>
                  <span class="grow">Dashboard</span>
                  <span class="iconify lucide--chevron-right arrow-icon size-3.5"></span>
                </div>
                <div class="collapse-content ms-6.5 !p-0">
                  <div class="mt-0.5 space-y-0.5">
                    <Link class="menu-item" href="/dashboards-ecommerce" :class="{ active: isActive('/dashboards-ecommerce') }">
                      <span class="grow">Ecommerce</span>
                    </Link>
                    <Link class="menu-item" href="/dashboards-crm" :class="{ active: isActive('/dashboards-crm') }">
                      <span class="grow">CRM</span>
                    </Link>
                    <Link class="menu-item" href="/dashboards-gen-ai" :class="{ active: isActive('/dashboards-gen-ai') }">
                      <span class="grow">Gen AI</span>
                    </Link>
                  </div>
                </div>
              </div>

              <p class="menu-label px-2.5 pt-3 pb-1.5 first:pt-0">Apps</p>
              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" />
                <div class="collapse-title px-2.5 py-1.5">
                  <span class="iconify lucide--store size-4"></span>
                  <span class="grow">Ecommerce</span>
                  <span class="iconify lucide--chevron-right arrow-icon size-3.5"></span>
                </div>
                <div class="collapse-content ms-6.5 !p-0">
                  <div class="mt-0.5 space-y-0.5">
                    <Link class="menu-item" href="/apps-ecommerce-orders" :class="{ active: isActive('/apps-ecommerce-orders') }"><span class="grow">Orders</span></Link>
                    <Link class="menu-item" href="/apps-ecommerce-products" :class="{ active: isActive('/apps-ecommerce-products') }"><span class="grow">Products</span></Link>
                    <Link class="menu-item" href="/apps-ecommerce-sellers" :class="{ active: isActive('/apps-ecommerce-sellers') }"><span class="grow">Sellers</span></Link>
                    <Link class="menu-item" href="/apps-ecommerce-customers" :class="{ active: isActive('/apps-ecommerce-customers') }"><span class="grow">Customers</span></Link>
                    <Link class="menu-item" href="/apps-ecommerce-shops" :class="{ active: isActive('/apps-ecommerce-shops') }"><span class="grow">Shops</span></Link>
                  </div>
                </div>
              </div>

              <Link class="menu-item" href="/apps-file-manager" :class="{ active: isActive('/apps-file-manager') }">
                <span class="iconify lucide--server size-4"></span>
                <span class="grow">File Manager</span>
              </Link>
              <Link class="menu-item" href="/apps-chat" :class="{ active: isActive('/apps-chat') }">
                <span class="iconify lucide--messages-square size-4"></span>
                <span class="grow">Chat</span>
              </Link>

              <p class="menu-label px-2.5 pt-3 pb-1.5 first:pt-0">Extras</p>
              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" />
                <div class="collapse-title px-2.5 py-1.5">
                  <span class="iconify lucide--shield-check size-4"></span>
                  <span class="grow">Auth</span>
                  <span class="iconify lucide--chevron-right arrow-icon size-3.5"></span>
                </div>
                <div class="collapse-content ms-6.5 !p-0">
                  <div class="mt-0.5 space-y-0.5">
                    <Link class="menu-item" href="/login" :class="{ active: isActive('/login') }"><span class="grow">Login</span></Link>
                    <Link class="menu-item" href="/register" :class="{ active: isActive('/register') }"><span class="grow">Register</span></Link>
                    <Link class="menu-item" href="/forgot-password" :class="{ active: isActive('/forgot-password') }"><span class="grow">Forgot Password</span></Link>
                    <Link class="menu-item" href="/forgot-password" :class="{ active: isActive('/forgot-password') }"><span class="grow">Reset Password</span></Link>
                  </div>
                </div>
              </div>

              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" />
                <div class="collapse-title px-2.5 py-1.5">
                  <span class="iconify lucide--files size-4"></span>
                  <span class="grow">Pages</span>
                  <span class="iconify lucide--chevron-right arrow-icon size-3.5"></span>
                </div>
                <div class="collapse-content ms-6.5 !p-0">
                  <div class="mt-0.5 space-y-0.5">
                    <Link class="menu-item" href="/pages-settings" :class="{ active: isActive('/pages-settings') }"><span class="grow">Settings</span></Link>
                    <Link class="menu-item" href="/pages-get-help" :class="{ active: isActive('/pages-get-help') }"><span class="grow">Get Help</span></Link>
                  </div>
                </div>
              </div>

              <a class="menu-item" target="_blank" href="/landing">
                <span class="iconify lucide--file size-4"></span>
                <span class="grow">Landing</span>
              </a>
              <a class="menu-item" target="_blank" href="/layout-builder">
                <span class="iconify lucide--blocks size-4"></span>
                <span class="grow">Layout Builder</span>
                <div class="ms-auto inline-flex gap-2">
                  <div class="border-primary/20 bg-primary/10 text-primary rounded-box border px-1.5 text-[12px]">New</div>
                </div>
              </a>
            </div>
          </div>
          <div class="from-base-100/60 pointer-events-none absolute start-0 end-0 bottom-0 h-7 bg-linear-to-t to-transparent" />
        </div>

        <div class="mb-2">
          <a target="_blank" class="group rounded-box relative mx-2.5 block gap-3" href="/components">
            <div class="rounded-box absolute inset-0 bg-gradient-to-r from-transparent to-transparent transition-opacity duration-300 group-hover:opacity-0"></div>
            <div class="from-primary to-secondary rounded-box absolute inset-0 bg-gradient-to-r opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative flex h-10 items-center gap-3 px-3">
              <i class="iconify lucide--shapes text-primary size-4.5 transition-all duration-300 group-hover:text-white"></i>
              <p class="from-primary to-secondary bg-gradient-to-r bg-clip-text font-medium text-transparent transition-all duration-300 group-hover:text-white">Components</p>
              <i class="iconify lucide--chevron-right text-secondary ms-auto size-4.5 transition-all duration-300 group-hover:text-white"></i>
            </div>
          </a>
          <hr class="border-base-300 my-2 border-dashed" />
          <!-- Profile dropdown omitted for brevity -->
        </div>
      </div>

      <label for="layout-sidebar-toggle-trigger" id="layout-sidebar-backdrop"></label>

      <!-- Main column -->
      <div class="flex h-screen min-w-0 grow flex-col overflow-auto">
        <!-- Topbar (search and controls simplified) -->
        <nav aria-label="Navbar" class="flex items-center justify-between px-3" id="layout-topbar">
          <div class="inline-flex items-center gap-3">
            <label class="btn btn-square btn-ghost btn-sm group-has-[[id=layout-sidebar-hover-trigger]:checked]/html:hidden" aria-label="Leftmenu toggle" for="layout-sidebar-toggle-trigger">
              <span class="iconify lucide--menu size-5"></span>
            </label>
            <label class="btn btn-square btn-ghost btn-sm hidden group-has-[[id=layout-sidebar-hover-trigger]:checked]/html:flex" aria-label="Leftmenu toggle" for="layout-sidebar-hover-trigger">
              <span class="iconify lucide--menu size-5"></span>
            </label>
          </div>

          <div class="inline-flex items-center gap-2">
            <!-- Theme toggle -->
            <button class="btn btn-ghost btn-sm" @click="config.theme = config.theme==='light' ? 'dark' : 'light'; updateAndApply();">
              <span class="iconify lucide--sun" v-if="config.theme==='light'"></span>
              <span class="iconify lucide--moon" v-else></span>
            </button>
          </div>
        </nav>

        <!-- Page content -->
        <div id="layout-content" class="min-w-0 grow">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

