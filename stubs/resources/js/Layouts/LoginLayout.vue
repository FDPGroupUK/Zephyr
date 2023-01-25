<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="row g-0 flex-fill bg-white">
      <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
        <div class="container container-tight my-5 px-lg-5">
          <div class="text-center mb-4">
            <Link href="/" class="navbar-brand navbar-brand-autodark">
                <ApplicationLogo />
            </Link>
          </div>
          <h2 class="text-center mb-3">
            Login to your account
          </h2>

          <slot />

        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">

        <div class="bg-cover h-100 min-vh-100" style="background-image: url('/assets/images/login_bg.jpg')"></div>
      </div>
    </div>
</template>
