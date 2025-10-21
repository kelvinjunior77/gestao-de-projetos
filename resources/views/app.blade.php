<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <title>Gestão de projeto</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- Fonts e icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />

    <!-- Carrega scripts do template ANTES do Vite -->
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/icon/custom-icon.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/component.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Vite (Vue) -->
    @vite('resources/js/app.js')
    @inertiaHead
  </head>
  <body>
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
      ...
    </div>

    @inertia

    <div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]"></div>

    <!-- Chamadas iniciais: use os valores corretos -->
    <script>
      // theme_change espera 'light' ou 'dark'
      layout_change('dark');               // exemplo: inicia em dark. Troque para 'light' se quiser.
      // sidebar: usa 'true' para ativar o tema de sidebar (conforme sua função)
      layout_theme_sidebar_change('true');
      // container 'true' => boxed, 'false' => fullwidth (conforme sua função)
      change_box_container('false');
      // caption: 'true' ou 'false'
      layout_caption_change('true');
      // rtl: 'true' ou 'false'
      layout_rtl_change('false');
      // preset ex: 'preset-1'
      preset_change('preset-1');
      // main layout
      main_layout_change('vertical');
    </script>
  </body>
</html>
