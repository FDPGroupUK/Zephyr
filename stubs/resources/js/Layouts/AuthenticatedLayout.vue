<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

const showDropdown = ref(false);
</script>

<template>
    <div class="page">
      <!-- Navbar -->
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <Link :href="route('dashboard')" class="navbar-brand navbar-brand-autodark">
                <ApplicationLogo />
            </Link>
          </h1>

          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" @click="showDropdown = !showDropdown" class="nav-link d-flex lh-1 text-reset p-0 show" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                       <circle cx="12" cy="7" r="4"></circle>
                       <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </span>
                <div class="d-none d-xl-block ps-2">
                  <div>{{ $page.props.auth.user.name }}</div>
                  <div class="mt-1 small text-muted">{{ $page.props.auth.user.email }}</div>
                </div>
              </a>
              <div v-if="showDropdown" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow show" data-bs-popper="static">
                <Link class="dropdown-item" :href="route('profile.edit')"> Profile</Link>
                <Link class="dropdown-item" :href="route('logout')" method="post" as="button">Log Out</Link>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">

                <li class="nav-item">
                  <a class="nav-link" href="./" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Home
                    </span>
                  </a>
                </li>

                  <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gauge" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                         <circle cx="12" cy="12" r="9"></circle>
                         <circle cx="12" cy="12" r="1"></circle>
                         <line x1="13.41" y1="10.59" x2="16" y2="8"></line>
                         <path d="M7 12a5 5 0 0 1 5 -5"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      Dashboard
                    </span>
                  </NavLink>

                  <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                         <circle cx="12" cy="12" r="9"></circle>
                         <circle cx="12" cy="10" r="3"></circle>
                         <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      Profile
                    </span>
                  </NavLink>

              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none" v-if="$slots.header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  <slot name="header" />
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <!-- Content here -->
            <slot />
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                Copyright &copy; {{ new Date().getFullYear() }} All rights reserved.
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
</template>
