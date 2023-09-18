<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import Notifications from '@/Components/Notifications.vue';
import { IconUser, IconGauge, IconSearch } from '@tabler/icons-vue';


</script>
<template>
    <div class="page">
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
                      <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm">
                            <IconUser />
                        </span>
                        <div class="d-none d-xl-block ps-2">
                          <div>{{ $page.props.auth.user.name }}</div>
                          <div class="mt-1 small text-muted">{{ $page.props.auth.user.email }}</div>
                        </div>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
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
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <IconGauge />
                                </span>
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </NavLink>
                        </ul>
                        <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                            <form action="./" method="get" autocomplete="off" novalidate="">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <IconSearch />
                                    </span>
                                    <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="page-header d-print-none" v-if="$slots.header">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                <slot name="header" />
                            </h2>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <slot name="actions" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <Notifications />
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
