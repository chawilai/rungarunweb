<script setup>
import { onMounted, ref, computed } from 'vue'

const langFlags = {
  en: 'https://flagcdn.com/us.svg',
  hi: 'https://flagcdn.com/in.svg',
  es: 'https://flagcdn.com/es.svg',
  zh: 'https://flagcdn.com/cn.svg',
  ar: 'https://flagcdn.com/rs.svg',
}
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
  language: 'en',
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
  // theme (system follows OS preference)
  let themeToApply = config.value.theme
  if (themeToApply === 'system') {
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
    themeToApply = prefersDark ? 'dark' : 'light'
  }
  html.setAttribute('data-theme', themeToApply)

  // sidebar theme
  const sidebar = document.getElementById('layout-sidebar')
  if (sidebar) {
    if (
      config.value.sidebarTheme === 'dark' &&
      ['light', 'contrast'].includes(themeToApply)
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

function setTheme(theme) {
  config.value.theme = theme
  updateAndApply()
}

function setLanguage(lang) {
  config.value.language = lang
  updateAndApply()
}

const currentFlag = computed(() => langFlags[config.value.language] || langFlags.en)

onMounted(() => {
  loadConfig()
  applyConfig()

  // fullscreen media sync
  const fullscreenMedia = window.matchMedia('(display-mode: fullscreen)')
  const fsListener = () => {
    config.value.fullscreen = fullscreenMedia.matches
    updateAndApply()
  }
  fullscreenMedia.addEventListener('change', fsListener)

  // system theme changes
  const mql = window.matchMedia('(prefers-color-scheme: dark)')
  const themeListener = () => {
    if (config.value.theme === 'system') applyConfig()
  }
  try { mql.addEventListener('change', themeListener) } catch (_) { mql.onchange = themeListener }
})

// Active menu handling based on current URL (SSR-safe)
const page = usePage()
const currentPath = computed(() => {
  const u = typeof page.url === 'string' ? page.url : '/'
  return u.split('?')[0]
})
function isActive(href) {
  try {
    const u = new URL(href, window.location.origin)
    return u.pathname === currentPath.value
  } catch {
    return href === currentPath.value
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
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" :checked="isActive('/dashboards-ecommerce') || isActive('/dashboards-crm') || isActive('/dashboards-gen-ai')" />
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
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" :checked="isActive('/apps-ecommerce-orders') || isActive('/apps-ecommerce-products') || isActive('/apps-ecommerce-sellers') || isActive('/apps-ecommerce-customers') || isActive('/apps-ecommerce-shops')" />
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

              <!-- Agentic Hub (separate under Overview) -->
              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" :checked="isActive('/agentic-storage')" />
                <div class="collapse-title px-2.5 py-1.5">
                  <span class="iconify lucide--bot-message-square size-4"></span>
                  <span class="grow">Agentic Hub</span>
                  <span class="iconify lucide--chevron-right arrow-icon size-3.5"></span>
                </div>
                <div class="collapse-content ms-6.5 !p-0">
                  <div class="mt-0.5 space-y-0.5">
                    <Link class="menu-item" href="/agentic-storage" :class="{ active: isActive('/agentic-storage') }">
                      <span class="grow">Storage</span>
                      <div class="ms-auto inline-flex gap-2">
                        <div class="border-primary/20 bg-primary/10 text-primary rounded-box border px-1.5 text-[12px]">New</div>
                      </div>
                    </Link>
                  </div>
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
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" :checked="isActive('/login') || isActive('/register') || isActive('/forgot-password') || currentPath.startsWith('/reset-password')" />
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
                    <Link class="menu-item" href="/reset-password/demo-token" :class="{ active: currentPath.startsWith('/reset-password') }"><span class="grow">Reset Password</span></Link>
                  </div>
                </div>
              </div>

              <div class="group collapse">
                <input aria-label="Sidemenu item trigger" type="checkbox" class="peer" name="sidebar-menu-parent-item" :checked="isActive('/pages-settings') || isActive('/pages-get-help')" />
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

          <div class="inline-flex items-center gap-0.5">
            <!-- Language -->
            <div class="dropdown dropdown-bottom dropdown-center">
              <button type="button" class="btn btn-ghost btn-circle btn-sm" aria-haspopup="menu" aria-label="Languages">
                <img :src="currentFlag" alt="Flag" class="rounded-box size-4.5 object-cover" />
              </button>
              <div class="dropdown-content bg-base-100 rounded-box mt-2 w-40 shadow">
                <ul class="menu w-full p-2">
                  <li><a href="#" class="flex items-center gap-2" @click.prevent="setLanguage('en')"><img src="https://flagcdn.com/us.svg" class="rounded-box size-4.5 object-cover" alt="English" /><span>English</span></a></li>
                  <li><a href="#" class="flex items-center gap-2" @click.prevent="setLanguage('hi')"><img src="https://flagcdn.com/in.svg" class="rounded-box size-4.5 object-cover" alt="Hindi" /><span>Hindi</span></a></li>
                  <li><a href="#" class="flex items-center gap-2" @click.prevent="setLanguage('es')"><img src="https://flagcdn.com/es.svg" class="rounded-box size-4.5 object-cover" alt="Spanish" /><span>Spanish</span></a></li>
                  <li><a href="#" class="flex items-center gap-2" @click.prevent="setLanguage('zh')"><img src="https://flagcdn.com/cn.svg" class="rounded-box size-4.5 object-cover" alt="Chinese" /><span>Chinese</span></a></li>
                  <li><a href="#" class="flex items-center gap-2" @click.prevent="setLanguage('ar')"><img src="https://flagcdn.com/rs.svg" class="rounded-box size-4.5 object-cover" alt="Arabic" /><span>Arabic</span></a></li>
                </ul>
              </div>
            </div>

            <!-- Theme control: system / light / dark / contrast -->
            <div class="dropdown dropdown-end">
              <button type="button" class="btn btn-ghost btn-circle btn-sm relative overflow-hidden" aria-haspopup="menu" aria-label="Toggle Theme">
                <span class="iconify lucide--sun absolute size-4.5 -translate-y-4 opacity-0 transition-all duration-300 group-data-[theme=light]/html:translate-y-0 group-data-[theme=light]/html:opacity-100"></span>
                <span class="iconify lucide--moon absolute size-4.5 translate-y-4 opacity-0 transition-all duration-300 group-data-[theme=dark]/html:translate-y-0 group-data-[theme=dark]/html:opacity-100"></span>
                <span class="iconify lucide--palette absolute size-4.5 opacity-100 group-data-[theme=dark]/html:opacity-0 group-data-[theme=light]/html:opacity-0"></span>
              </button>
              <ul class="dropdown-content menu bg-base-100 rounded-box z-[1] w-40 p-2 shadow">
                <li><a href="#" @click.prevent="setTheme('system')">System</a></li>
                <li><a href="#" @click.prevent="setTheme('light')">Light</a></li>
                <li><a href="#" @click.prevent="setTheme('dark')">Dark</a></li>
                <li><a href="#" @click.prevent="setTheme('contrast')">Contrast</a></li>
              </ul>
            </div>

            <!-- Customization (right drawer) -->
            <div class="drawer drawer-end">
              <input id="layout-rightbar-drawer" class="drawer-toggle" type="checkbox" />
              <div class="drawer-content">
                <label for="layout-rightbar-drawer" class="btn btn-circle btn-ghost btn-sm drawer-button" aria-label="Customization">
                  <span class="iconify lucide--settings-2 size-4.5"></span>
                </label>
              </div>
              <div class="drawer-side z-[60]">
                <label for="layout-rightbar-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="h-full w-80 bg-base-100 p-4 sm:w-96">
                  <p class="font-medium">Theme</p>
                  <div class="mt-3 grid grid-cols-3 gap-3">
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('light')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">Light</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('contrast')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">Contrast</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('material')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">Material</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('dark')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">Dark</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('dim')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">Dim</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('material-dark')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-xs capitalize">Material Dark</p>
                      </div>
                    </a>
                    <a href="#" class="rounded-box group relative" @click.prevent="setTheme('system')">
                      <div class="bg-base-200 rounded-box pt-5 pb-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                          <span class="rounded-box bg-primary h-6 w-3"></span>
                          <span class="rounded-box bg-secondary h-6 w-3"></span>
                          <span class="rounded-box bg-success h-6 w-3"></span>
                        </div>
                        <p class="mt-1.5 text-sm capitalize">System</p>
                      </div>
                    </a>
                  </div>

                  <div class="mt-6">
                    <p class="font-medium">Sidebar</p>
                    <div class="mt-3 grid grid-cols-2 gap-3">
                      <button class="border-base-300 hover:bg-base-200 rounded-box inline-flex items-center justify-center gap-2 border p-2" @click="config.sidebarTheme='light'; updateAndApply()">
                        <span class="iconify lucide--sun size-4.5"></span> Light
                      </button>
                      <button class="border-base-300 hover:bg-base-200 rounded-box inline-flex items-center justify-center gap-2 border p-2" @click="config.sidebarTheme='dark'; updateAndApply()">
                        <span class="iconify lucide--moon size-4.5"></span> Dark
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Notifications -->
            <div class="dropdown dropdown-bottom sm:dropdown-end dropdown-center">
              <button type="button" role="button" class="btn btn-circle btn-ghost btn-sm relative" aria-label="Notifications">
                <span class="iconify lucide--bell motion-preset-seesaw size-4.5"></span>
                <div class="status status-error status-sm absolute end-1 top-1"></div>
              </button>
              <div class="dropdown-content bg-base-100 rounded-box mt-1 w-84 shadow-md duration-1000 hover:shadow-lg">
                <div class="bg-base-200/30 rounded-t-box border-base-200 border-b ps-4 pe-2 pt-3">
                  <div class="flex items-center justify-between">
                    <p class="font-medium">Notification</p>
                    <button class="btn btn-xs btn-circle btn-ghost" aria-label="Close" @click="() => {}">
                      <span class="iconify lucide--x size-4"></span>
                    </button>
                  </div>
                  <div class="-ms-2 mt-2 -mb-px flex items-center justify-between">
                    <div role="tablist" class="tabs tabs-sm tabs-border">
                      <div role="tab" class="tab tab-active gap-2 px-3 font-medium">
                        <span>All</span>
                        <div class="badge badge-sm">4</div>
                      </div>
                      <div role="tab" class="tab gap-2 px-3"><span>Team</span></div>
                      <div role="tab" class="tab gap-2 px-3"><span>AI</span></div>
                      <div role="tab" class="tab gap-2 px-3"><span>@mention</span></div>
                    </div>
                  </div>
                </div>

                <!-- Notification items (static demo) -->
                <div class="hover:bg-base-200/20 relative flex items-start gap-3 p-4 transition-all">
                  <div class="avatar avatar-online size-12">
                    <img src="/nexus/images/avatars/2.png" class="from-primary/80 to-primary/60 mask mask-squircle bg-linear-to-b px-1 pt-1" alt="">
                  </div>
                  <div class="grow">
                    <p class="text-sm leading-tight">Lena submitted a draft for review.</p>
                    <p class="text-base-content/60 text-xs">15 min ago</p>
                    <div class="mt-2 flex items-center gap-2">
                      <button class="btn btn-sm btn-primary">Approve</button>
                      <button class="btn btn-sm btn-outline border-base-300">Decline</button>
                    </div>
                  </div>
                  <div class="status status-primary absolute end-4 top-4 size-1.5"></div>
                </div>
                <hr class="border-base-300 border-dashed">
                <div class="hover:bg-base-200/20 flex items-start gap-3 p-4 transition-all">
                  <div class="avatar avatar-offline size-12">
                    <img src="/nexus/images/avatars/4.png" class="from-secondary/80 to-secondary/60 mask mask-squircle bg-linear-to-b px-1 pt-1" alt="">
                  </div>
                  <div class="grow">
                    <p class="text-sm leading-tight">Kai mentioned you in a project.</p>
                    <p class="text-base-content/60 text-xs">22 min ago</p>
                    <div class="from-base-200 via-base-200/80 rounded-box mt-2 flex items-center justify-between gap-2 bg-linear-to-r to-transparent py-1 ps-2.5">
                      <p class="text-sm">Check model inputs?</p>
                      <button class="btn btn-xs btn-ghost text-xs">
                        <span class="iconify lucide--reply size-3.5"></span>
                        Reply
                      </button>
                    </div>
                  </div>
                </div>
                <hr class="border-base-300 border-dashed">
                <div class="hover:bg-base-200/20 flex items-start gap-3 p-4 transition-all">
                  <div class="avatar size-12">
                    <img src="/nexus/images/avatars/5.png" class="mask mask-squircle bg-linear-to-b from-orange-500/80 to-orange-500/60 px-1 pt-1" alt="">
                  </div>
                  <div class="grow">
                    <p class="text-sm leading-tight">Your latest results are ready</p>
                    <div class="border-base-200 rounded-box mt-2 flex items-center justify-between gap-2 border px-2.5 py-1.5">
                      <p class="text-sm">
                        Forecast Report
                        <span class="text-base-content/60 text-xs">(12 MB)</span>
                      </p>
                      <button class="btn btn-xs btn-square btn-ghost text-xs">
                        <span class="iconify lucide--arrow-down-to-line size-4"></span>
                      </button>
                    </div>
                    <div class="border-base-200 rounded-box mt-2 flex items-center justify-between gap-2 border px-2.5 py-1.5">
                      <p class="text-sm">
                        Generated Summary
                        <span class="text-base-content/60 text-xs">(354 KB)</span>
                      </p>
                      <button class="btn btn-xs btn-square btn-ghost text-xs">
                        <span class="iconify lucide--arrow-down-to-line size-4"></span>
                      </button>
                    </div>
                  </div>
                </div>
                <hr class="border-base-200">
                <div class="flex items-center justify-between px-2 py-2">
                  <button class="btn btn-sm btn-soft btn-primary">View All</button>
                  <div class="flex items-center gap-1">
                    <button class="btn btn-sm btn-square btn-ghost">
                      <span class="iconify lucide--check-check size-4"></span>
                    </button>
                    <button class="btn btn-sm btn-square btn-ghost">
                      <span class="iconify lucide--bell-ring size-4"></span>
                    </button>
                    <button class="btn btn-sm btn-square btn-ghost">
                      <span class="iconify lucide--settings size-4"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Profile drawer -->
            <div class="drawer drawer-end">
              <input id="topbar-profile-drawer" type="checkbox" class="drawer-toggle" />
              <div class="drawer-content">
                <label for="topbar-profile-drawer" class="btn btn-ghost flex items-center gap-2 px-1.5">
                  <div class="avatar">
                    <div class="bg-base-200 mask mask-squircle w-8">
                      <img src="/nexus/images/avatars/1.png" alt="Avatar" />
                    </div>
                  </div>
                  <div class="text-start">
                    <p class="text-sm/none">Denish</p>
                    <p class="text-base-content/50 mt-0.5 text-xs/none">Team</p>
                  </div>
                </label>
              </div>
              <div class="drawer-side z-[60]">
                <label for="topbar-profile-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="h-full w-72 p-2 sm:w-84">
                  <div class="bg-base-100 rounded-box relative flex h-full flex-col pt-4 sm:pt-8">
                    <label for="topbar-profile-drawer" class="btn btn-xs btn-circle btn-ghost absolute start-2 top-2" aria-label="Close">
                      <span class="iconify lucide--x size-4"></span>
                    </label>
                    <div class="flex flex-col items-center">
                      <div class="relative">
                        <div class="avatar bg-base-200 isolate size-20 cursor-pointer overflow-hidden rounded-full px-1 pt-1 md:size-24">
                          <img src="/nexus/images/avatars/1.png" alt="User Avatar" />
                        </div>
                        <div class="bg-base-100 absolute end-0 bottom-0 flex items-center justify-center rounded-full p-1.5 shadow-sm">
                          <span class="iconify lucide--pencil size-4"></span>
                        </div>
                      </div>
                      <p class="mt-4 text-lg/none font-medium sm:mt-8">John Doe</p>
                      <p class="text-base-content/60 mt-1 text-sm">john@company.com</p>
                      <div class="mt-4 flex items-center gap-2 *:cursor-pointer sm:mt-6">
                        <div class="avatar bg-base-200 size-10 overflow-hidden rounded-full px-1 pt-1">
                          <img src="/nexus/images/avatars/2.png" alt="Team member" />
                        </div>
                        <div class="avatar bg-base-200 size-10 overflow-hidden rounded-full px-1 pt-1">
                          <img src="/nexus/images/avatars/3.png" alt="Team member" />
                        </div>
                        <div class="avatar bg-base-200 size-10 overflow-hidden rounded-full px-1 pt-1">
                          <img src="/nexus/images/avatars/4.png" alt="Team member" />
                        </div>
                        <div class="bg-base-200 border-base-300 flex size-10 items-center justify-center rounded-full border border-dashed">
                          <span class="iconify lucide--plus size-4.5"></span>
                        </div>
                      </div>
                    </div>
                    <div class="border-base-300 mt-4 grow overflow-auto border-t border-dashed px-2 sm:mt-6">
                      <ul class="menu w-full p-2">
                        <li class="menu-title">Account</li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--user size-4.5"></span>
                            <span>View Profile</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--users size-4.5"></span>
                            <span>Team</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--mail-plus size-4.5"></span>
                            <span>Invites</span>
                            <div class="badge badge-sm">4</div>
                          </a>
                        </li>
                        <li class="menu-title">Platform</li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--settings size-4.5"></span>
                            <span>Settings</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--credit-card size-4.5"></span>
                            <span>Billing</span>
                          </a>
                        </li>
                        <li>
                          <a href="#">
                            <span class="iconify lucide--help-circle size-4.5"></span>
                            <span>Support</span>
                          </a>
                        </li>
                        <li>
                          <a class="text-error hover:bg-error/10" href="#">
                            <span class="iconify lucide--log-out size-4.5"></span>
                            <span>Sign Out</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="rounded-box from-primary to-secondary text-primary-content m-4 mt-auto flex cursor-pointer flex-col items-center justify-center bg-linear-to-br p-4 text-center transition-all hover:opacity-95 sm:p-6">
                      <div class="bg-primary-content/10 border-primary-content/10 flex items-center justify-center rounded-full border p-1.5 sm:p-2.5">
                        <span class="iconify lucide--zap size-5 sm:size-6"></span>
                      </div>
                      <p class="mt-2 font-mono text-[11px] font-medium tracking-wider uppercase opacity-70 sm:mt-4">Upgrade your plan</p>
                      <p class="mt-1 leading-none font-medium sm:text-lg">Save <span class="font-semibold underline">30%</span> today</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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

