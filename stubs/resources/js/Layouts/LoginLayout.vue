<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="row g-0 flex-fill">
      <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
        <div class="container container-tight my-5 px-lg-5">
          <div class="text-center mb-4">
            <Link href="/">
                <ApplicationLogo class="navbar-brand navbar-brand-autodark" />
            </Link>
          </div>
          <h2 class="text-center mb-3">
            Login to your account
          </h2>

          <slot />

        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">

        <div class="bg-cover h-100 min-vh-100" style="background-image: url(./static/photos/finances-us-dollars-and-bitcoins-currency-money-2.jpg)"></div>
      </div>
    </div>
</template>
