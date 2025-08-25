<script setup>
import { Head } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import NexusLayout from '@/Layouts/NexusLayout.vue'

onMounted(() => {
  // Ensure SimpleBar CSS/JS for scroll areas
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
  ensureCss('https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.min.css')
  ensureScript('https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.7/simplebar.min.js')
})
</script>

<template>
  <Head title="Chat" />
  <NexusLayout>
    <div class="p-4 md:p-6">
      <div class="flex items-center justify-between">
        <p class="text-lg font-medium">Chat</p>
        <div class="breadcrumbs hidden p-0 text-sm sm:inline">
          <ul>
            <li><a href="/dashboards-ecommerce">Nexus</a></li>
            <li>Apps</li>
            <li class="opacity-80">Chat</li>
          </ul>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 mt-6">
        <!-- Chat list -->
        <div class="lg:col-span-5 xl:col-span-4 2xl:col-span-3">
          <div class="card bg-base-100 shadow">
            <div class="card-body">
              <div class="flex items-center justify-between gap-3">
                <label class="input">
                  <span class="iconify lucide--search text-base-content/80 size-4"></span>
                  <input class="w-36" placeholder="Search" />
                </label>
                <button class="btn btn-primary btn-sm">
                  <span class="iconify lucide--message-square-plus size-4"></span>
                  New
                </button>
              </div>
              <div class="mt-4" data-simplebar style="max-height: 520px;">
                <ul class="menu gap-1 px-0">
                  <li>
                    <a class="justify-between rounded-box">
                      <div class="flex items-center gap-3">
                        <img class="mask mask-squircle bg-base-200 size-9" src="/nexus/images/avatars/2.png" alt="avatar" />
                        <div>
                          <p class="font-medium">Ava Johnson</p>
                          <p class="text-xs opacity-60">Hey, how's it going?</p>
                        </div>
                      </div>
                      <span class="badge badge-primary text-xs">2</span>
                    </a>
                  </li>
                  <li>
                    <a class="rounded-box">
                      <div class="flex items-center gap-3">
                        <img class="mask mask-squircle bg-base-200 size-9" src="/nexus/images/avatars/3.png" alt="avatar" />
                        <div>
                          <p class="font-medium">Liam Brown</p>
                          <p class="text-xs opacity-60">Let's meet at 5</p>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Conversation -->
        <div class="lg:col-span-7 xl:col-span-8 2xl:col-span-9">
          <div class="card bg-base-100 shadow">
            <div class="card-body p-0">
              <!-- Header -->
              <div class="flex items-center justify-between p-4">
                <div class="flex items-center gap-3">
                  <img class="mask mask-squircle bg-base-200 size-10" src="/nexus/images/avatars/2.png" alt="avatar" />
                  <div>
                    <p class="font-medium">Ava Johnson</p>
                    <p class="text-xs text-base-content/60">Active 2m ago</p>
                  </div>
                </div>
                <div class="inline-flex gap-2">
                  <button class="btn btn-square btn-ghost btn-sm" aria-label="Call"><span class="iconify lucide--phone size-4"></span></button>
                  <button class="btn btn-square btn-ghost btn-sm" aria-label="Video"><span class="iconify lucide--video size-4"></span></button>
                  <button class="btn btn-square btn-ghost btn-sm" aria-label="More"><span class="iconify lucide--more-vertical size-4"></span></button>
                </div>
              </div>
              <hr class="border-base-300" />

              <!-- Messages -->
              <div data-simplebar class="h-[calc(100vh_-_320px)] p-5">
                <div class="chat chat-start">
                  <div class="chat-image avatar">
                    <div class="w-10">
                      <img class="mask mask-squircle bg-base-200 p-0.5" src="/nexus/images/avatars/2.png" alt="avatar" />
                    </div>
                  </div>
                  <div class="chat-bubble bg-base-200 text-sm">Hey, how's it going?</div>
                  <div class="chat-footer text-base-content/60">04:31 PM</div>
                </div>
                <div class="chat chat-end">
                  <div class="chat-image avatar">
                    <div class="w-10">
                      <img class="mask mask-squircle bg-base-200 p-0.5" src="/nexus/images/avatars/1.png" alt="me" />
                    </div>
                  </div>
                  <div class="chat-bubble bg-base-200 text-sm">I'm doing well, thanks! You?</div>
                  <div class="chat-footer text-base-content/60">04:33 PM</div>
                </div>
              </div>

              <!-- Input -->
              <form class="bg-base-200 flex items-center gap-3 p-4">
                <button class="btn btn-ghost btn-sm btn-circle" type="button" aria-label="Attachment">
                  <span class="iconify lucide--paperclip size-4.5"></span>
                </button>
                <input class="input grow" required placeholder="Type a message..." type="text" aria-label="Message" name="message" />
                <button class="btn btn-primary btn-circle btn-sm" type="submit" aria-label="Send message">
                  <span class="iconify lucide--send-horizonal size-4.5"></span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </NexusLayout>
</template>
