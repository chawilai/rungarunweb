<script setup>
import { onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

onMounted(() => {
  // Load Swiper for hero carousel
  function ensureScript(src) {
    return new Promise((resolve) => {
      if (document.querySelector(`script[src="${src}"]`)) return resolve()
      const s = document.createElement('script')
      s.src = src
      s.onload = () => resolve()
      document.body.appendChild(s)
    })
  }
  function ensureCss(href) {
    if (document.querySelector(`link[href="${href}"]`)) return
    const l = document.createElement('link')
    l.rel = 'stylesheet'
    l.href = href
    document.head.appendChild(l)
  }

  ensureCss('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css')
  ensureScript('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js').then(() => {
    if (window.Swiper) {
      // eslint-disable-next-line no-new
      new window.Swiper('#hero-swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 16,
        autoplay: { delay: 3500 },
        pagination: { el: '.swiper-pagination', clickable: true },
      })
    }
  })

  // Topbar scroll behavior
  const topbar = document.getElementById('landing-topbar')
  if (topbar) {
    let last = window.scrollY
    const onScroll = () => {
      const y = window.scrollY
      topbar.dataset.scrolling = y > last ? 'down' : 'up'
      topbar.dataset.atTop = y <= 4 ? 'true' : 'false'
      last = y
    }
    window.addEventListener('scroll', onScroll, { passive: true })
    onScroll()
  }
})
</script>

<template>
  <Head title="Landing" />
  <div>
    <!-- Topbar -->
    <div id="landing-topbar" class="group fixed inset-x-0 z-[60] flex justify-center transition-[top] duration-500 data-[scrolling=down]:-top-full sm:container [&:not([data-scrolling=down])]:top-0 [&:not([data-scrolling=down])]:sm:top-4">
      <div class="group-data-[at-top=false]:bg-base-100 group-data-[at-top=false]:dark:bg-base-200 flex w-full items-center justify-between px-3 py-3 transition-all duration-500 group-data-[at-top=false]:w-[800px] group-data-[at-top=false]:shadow sm:rounded-full sm:px-6 lg:py-1.5">
        <div class="flex items-center gap-2">
          <div class="flex-none lg:hidden">
            <div class="drawer">
              <input id="landing-menu-drawer" type="checkbox" class="drawer-toggle" />
              <div class="drawer-content">
                <label for="landing-menu-drawer" class="btn drawer-button btn-ghost btn-square btn-sm">
                  <span class="iconify lucide--menu size-4.5" />
                </label>
              </div>
              <div class="drawer-side z-[50]">
                <label for="landing-menu-drawer" aria-label="close sidebar" class="drawer-overlay" />
                <ul class="menu bg-base-100 text-base-content min-h-full w-80 p-4">
                  <li><Link href="/dashboards-ecommerce">Dashboard</Link></li>
                  <li><a href="/components">Components</a></li>
                </ul>
              </div>
            </div>
          </div>
          <Link href="/dashboards-ecommerce" class="inline-flex items-center">
            <img alt="logo-light" class="h-5 dark:hidden" src="/nexus/images/logo/logo-light.png" />
            <img alt="logo-dark" class="hidden h-5 dark:block" src="/nexus/images/logo/logo-dark.png" />
          </Link>
        </div>
        <ul class="menu menu-horizontal hidden gap-2 px-0 lg:inline-flex">
          <li><Link href="/dashboards-ecommerce">Dashboard</Link></li>
          <li><a href="/components">Components</a></li>
        </ul>
        <div class="inline-flex items-center gap-3">
          <button aria-label="Toggle Theme" class="btn btn-square btn-ghost btn-sm border-transparent" @click="document.documentElement.toggleAttribute('data-theme');">
            <span class="iconify lucide--sun absolute size-4.5" />
          </button>
          <a href="https://daisyui.com/store/244268?aff=Db6q2" target="_blank" class="btn from-primary to-secondary group/purchase text-primary-content btn-sm max-sm:btn-square relative gap-2 border-0 bg-linear-to-r text-sm">
            <span class="iconify lucide--shopping-cart size-4" />
            <span class="max-sm:hidden">Buy Now</span>
            <div class="from-primary to-secondary absolute inset-x-0 top-1 -z-1 h-8 bg-linear-to-r opacity-40 blur-md transition-all duration-500 group-hover/purchase:opacity-60 group-hover/purchase:blur-lg" />
          </a>
        </div>
      </div>
    </div>

    <!-- Hero -->
    <div class="relative">
      <div class="absolute inset-0 -top-2 h-[800px] bg-[url(/nexus/images/landing/hero-bg-gradient.png)] [background-size:200%_60%] bg-no-repeat opacity-20 [background-position-x:center] sm:[background-size:100%_100%] dark:opacity-15" />
      <div class="relative z-10 container py-28 xl:py-40">
        <div class="flex flex-col items-center">
          <a class="flex items-center gap-1.5 rounded-full border border-white/60 bg-white/40 py-0.5 ps-1 pe-2 text-sm transition-all hover:bg-white/60 dark:border-white/5 dark:bg-white/5 dark:hover:bg-white/10" href="/components" target="_blank">
            <div class="bg-primary/10 border-primary/10 text-primary flex items-center justify-center rounded-full border px-1.5 py-0 text-xs font-medium dark:border-white/5 dark:bg-white/5 dark:text-white">v3</div>
            Endless Design
          </a>
          <div class="mt-4 max-w-[1000px]">
            <p class="text-center text-3xl leading-tight font-bold md:text-4xl lg:text-5xl 2xl:text-6xl">
              Flexible, Quick, Effortless<br />
              Ultimate <span class="animated-text bg-linear-to-r from-purple-500 via-blue-500 to-cyan-600 dark:from-purple-400 dark:via-blue-400 dark:to-cyan-400">Admin Dashboard</span>
            </p>
          </div>
          <div class="mt-4 max-w-[750px] sm:mt-6 xl:mt-8">
            <p class="text-center max-sm:text-sm md:text-lg">Launch powerful modern dashboards with customizable apps, components, blocks and integrations designed to accelerate workflows and boost efficiency.</p>
          </div>
          <div class="mt-6 inline-flex items-center gap-2.5 sm:gap-5 xl:mt-10">
            <Link href="/dashboards-ecommerce" class="btn btn-primary btn-lg gap-2.5">
              <span class="iconify lucide--monitor-dot size-5 sm:size-5.5" />
              <div class="text-start">
                <p class="text-sm/none">Dashboard</p>
                <p class="text-primary-content/70 mt-px text-[11px]/none">Preview</p>
              </div>
            </Link>
            <a href="/components" class="btn btn-ghost btn-neutral btn-lg gap-3 !border-transparent text-base dark:border-white dark:text-white dark:hover:bg-white dark:hover:text-black">
              <span class="iconify lucide--blocks size-5 sm:size-5.5" />
              Components
            </a>
          </div>

          <!-- Hero Swiper -->
          <div class="group relative mt-8 max-w-full md:mt-16 md:max-w-xl lg:max-w-3xl xl:mt-20 xl:max-w-5xl 2xl:max-w-6xl">
            <div class="border-base-100/20 bg-base-100/30 relative rounded-lg border-2 py-2">
              <div class="swiper" id="hero-swiper">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="mx-2">
                      <Link class="relative" href="/dashboards-ecommerce">
                        <img src="/nexus/images/landing/dashboard-ecommerce-light.jpg" class="h-full w-full rounded-lg dark:hidden" alt="hero-landing" />
                        <img src="/nexus/images/landing/dashboard-ecommerce-dark.jpg" class="hidden h-full w-full rounded-lg dark:block" alt="hero-landing" />
                      </Link>
                    </div>
                  </div>
                </div>
                <div class="swiper-pagination" />
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

