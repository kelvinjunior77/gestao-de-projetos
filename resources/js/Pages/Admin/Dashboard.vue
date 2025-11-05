<template>
    <!------
  <div v-if="$page.props.auth.user">
            <div class="">
                <p>ID do usuário: {{ $page.props.auth.user.id }}</p>
                <p>Nome: {{ $page.props.auth.user.name }}</p>
                <p>Tipo: {{ $page.props.auth.user.tipo }}</p>
            </div> 
        </div>-->

    <Layout>
        <template #main-content>
              <div class="grid grid-cols-12 gap-x-6">
          <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <a href="">
              <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Projetos</h5>
          
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                  <!---  <i class="feather icon-arrow-up text-success-500 text-[30px] mr-1.5"></i>-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-git2-icon lucide-folder-git-2"><path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"/><circle cx="13" cy="12" r="2"/><path d="M18 19c-2.8 0-5-2.2-5-5v8"/><circle cx="20" cy="19" r="2"/></svg>
                  </h3>
                  <p class="mb-0" style="font-size: 24px!important;">10</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 100%"></div>
                </div>
              </div>
            </div>
            </a>
            
          </div>
          <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <a href="">
              <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Projetos Finalizado</h5>
          
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                  <!---  <i class="feather icon-arrow-up text-success-500 text-[30px] mr-1.5"></i>-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-check-icon lucide-folder-check"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/><path d="m9 13 2 2 4-4"/></svg>
                  </h3>
                  <p class="mb-0" style="font-size: 24px!important;">10</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 100%"></div>
                </div>
              </div>
            </div>
            </a>
            
          </div>
          <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <a href=""> 
              <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Tarefas</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">

                  <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list-icon lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                    
                  </h3>
                  <p class="mb-0" style="font-size: 24px!important;">36</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-2 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 100%"></div>
                </div>
              </div>
            </div>
          </a>
           
          </div>
          <div class="col-span-12 xl:col-span-4">
            <a href="">
              <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Tarefas Finalizado</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-check-icon lucide-clipboard-check"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                  </h3>
                  <p class="mb-0" style="font-size: 24px!important;">80</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 100%"></div>
                </div>
              </div>
            </div>
            </a>
            
          </div>

            <div class="col-span-12 xl:col-span-4">
            <a href="">
              <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Desenvolvedores</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                  </h3>
                  <p class="mb-0" style="font-size: 24px!important;">80</p>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-6 dark:bg-themedark-bodybg">
                  <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar"
                    style="width: 100%"></div>
                </div>
              </div>
            </div>
            </a>
            
          </div>

          <!------
          <div class="col-span-12 xl:col-span-4">
            <div class="card card-social">
              <div class="card-body border-b border-theme-border dark:border-themedark-border">
                <div class="flex items-center justify-center">
                  <div class="shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                  </div>
                  <div class="grow ltr:text-right rtl:text-left">
                    <h3 class="mb-2">22</h3>
                    <h5 class="text-success-500 mb-0"><span class="text-muted">Desenvolvedores</span></h5>
                  </div>
                </div>
              </div>
              <div class="card-body">
                  <div class="col-span-6">
                    
                    <div class="w-full bg-theme-bodybg rounded-lg h-1.5 dark:bg-themedark-bodybg">
                      <div class="bg-theme-bg-2 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: 100%"></div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <div class="card card-social">
              <div class="card-body border-b border-theme-border dark:border-themedark-border">
                <div class="flex items-center justify-center">
                  <div class="shrink-0">
                    <i class="fab fa-google-plus-g text-danger-500 text-[36px]"></i>
                  </div>
                  <div class="grow ltr:text-right rtl:text-left">
                    <h3 class="mb-2">10,500</h3>
                    <h5 class="text-purple-500 mb-0">+5.9% <span class="text-muted">Total Likes</span></h5>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="grid grid-cols-12 gap-x-6">
                  <div class="col-span-6">
                    <h6 class="text-center mb-2.5"><span class="text-muted m-r-5">Target:</span>25,998</h6>
                    <div class="w-full bg-theme-bodybg rounded-lg h-1.5 dark:bg-themedark-bodybg">
                      <div class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: 80%"></div>
                    </div>
                  </div>
                  <div class="col-span-6">
                    <h6 class="text-center mb-2.5"><span class="text-muted m-r-5">Duration:</span>900</h6>
                    <div class="w-full bg-theme-bodybg rounded-lg h-1.5 dark:bg-themedark-bodybg">
                      <div class="bg-theme-bg-2 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]" role="progressbar" style="width: 50%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>--->

      
          <div class="col-span-12 xl:col-span-8 md:col-span-6">
            <div class="card table-card">
              <div class="card-header">
                <h5>Tarefas Finalizadas Recentes</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tbody>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" :src="avatar-1" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Isabella Christensen</h6>
                          <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-success text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            11 MAY 12:56
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">Rejeitar</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Aprovar</a>
                        </td>
                      </tr>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../assets/images/user/avatar-2.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Mathilde Andersen</h6>
                          <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-danger text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            11 MAY 10:35
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">Rejeitar</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Aprovar</a>
                        </td>
                      </tr>
                   
                   
                    
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

              <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <div class="card user-list">
              <div class="card-header">
                <h5>Avaliação</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-1 mb-5">
                  <h2 class="font-light flex items-center m-0">
                    4.7
                    <i class="fas fa-star text-[10px] ml-2.5 text-warning-500"></i>
                  </h2>
                  <h6 class="flex items-center m-0">
                    0.4
                    <i class="fas fa-caret-up text-success text-[22px] ml-2.5"></i>
                  </h6>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    5
                  </h6>
                  <h6>384</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 70%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    4
                  </h6>
                  <h6>145</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 35%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    3
                  </h6>
                  <h6>24</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 25%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    2
                  </h6>
                  <h6>1</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 10%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    1
                  </h6>
                  <h6>0</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mt-4 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 0%"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </template>
    </Layout>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Header from '../Layouts/Header.vue';
import NavBar from '../Layouts/NavBar.vue';
import Main from '../Layouts/Main.vue';
import Layout from '../Layouts/Layout.vue';

</script>