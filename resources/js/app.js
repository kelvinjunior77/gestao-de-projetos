import './bootstrap';
//import '../css/teste.css';
//import '../assets/js/script.js';
//import '../template/script.js';


// Importa scripts do template
import {
    layout_change,
    layout_theme_sidebar_change,
    change_box_container,
    layout_caption_change,
    layout_rtl_change,
    preset_change,
    main_layout_change
} from './utils/theme.js';


import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'

import '../js/template/script.js'
import '../js/template/layout-horizontal.js'
import { initTemplate } from './utils/initTemplate.js';

createInertiaApp({

    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)

        // 🟢 Inicializa scripts na primeira renderização
        setTimeout(initTemplate, 100);

        // 🟢 Reexecuta scripts toda vez que mudar de página (Inertia)
        router.on('navigate', () => {
            setTimeout(initTemplate, 150);
        });
    },
});

// 🟢 Chama as configurações iniciais do layout (antes de montar o Vue)
layout_change('dark');
layout_theme_sidebar_change(true);
change_box_container(false);
layout_caption_change(true);
layout_rtl_change(false);
preset_change('preset-1');
main_layout_change('vertical');