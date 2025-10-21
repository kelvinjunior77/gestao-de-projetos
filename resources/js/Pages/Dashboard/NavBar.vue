<script setup>
import logo from '@images/logo-white.svg';
import logoLight from '@images/favicon.svg';
</script>


<template>
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header flex items-center py-4 px-6 h-header-height">
                <a href="../dashboard/index.html" class="b-brand flex items-center gap-3">
                    <!-- ========   Change your logo from here   ============ -->
                    <img :src="logo" class="img-fluid logo logo-lg" alt="logo" />

                    <img :src="logoLight" class="img-fluid logo logo-sm" alt="logo" />
                </a>
            </div>
            <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Navegação</label>
                    </li>
                    <li class="pc-item">
                        <a href="../dashboard/index.html" class="pc-link">
                            <span class="pc-micon">
                                <i data-feather="home"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Usuarios</label>
                        <i data-feather="feather"></i>
                    </li>
                     <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-justify-icon lucide-text-align-justify"><path d="M3 5h18"/><path d="M3 12h18"/><path d="M3 19h18"/></svg>

                            </span><span class="pc-mtext">Cadastrar</span><span class="pc-arrow">
                                
                                
                                </span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="#!">Usuario</a></li>
                            <!--- <li class="pc-item pc-hasmenu">

                                <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i
                                            class="ti ti-chevron-right"></i></span></a>
                            </li>
                           
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i
                                            class="ti ti-chevron-right"></i></span></a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                    <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                    <li class="pc-item pc-hasmenu">
                                        <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                    class="ti ti-chevron-right"></i></span></a>
                                        <ul class="pc-submenu">
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                            <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>---->
                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../elements/bc_color.html" class="pc-link">
                            <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg></span>

                            <span class="pc-mtext">Desenvolvedores</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../elements/bc_typography.html" class="pc-link">
                            <span class="pc-micon"> <i data-feather="type"></i></span>
                            <span class="pc-mtext">Typography</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../elements/icon-feather.html" class="pc-link">
                            <span class="pc-micon"> <i data-feather="feather"></i></span>
                            <span class="pc-mtext">Icons</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Pages</label>
                        <i data-feather="monitor"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../pages/login-v1.html" class="pc-link" target="_blank">
                            <span class="pc-micon"> <i data-feather="lock"></i></span>
                            <span class="pc-mtext">Login</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../pages/register-v1.html" class="pc-link" target="_blank">
                            <span class="pc-micon"> <i data-feather="user-plus"></i></span>
                            <span class="pc-mtext">Register</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Other</label>
                        <i data-feather="sidebar"></i>
                    </li>
                   
                    <li class="pc-item">
                        <a href="../other/sample-page.html" class="pc-link">
                            <span class="pc-micon">
                                <i data-feather="sidebar"></i>
                            </span>
                            <span class="pc-mtext">Sample page</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>