import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import store from './store';
import { createStore } from 'vuex'

const vuexStore = createStore(store)

const optionsToast = {
  position: "top-right",
  timeout: 2815,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: true,
  closeButton: "button",
  icon: true,
  rtl: false
};

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuexStore)
      .use(Toast, optionsToast)
      .mixin({methods: {route}})
      .mount(el)
  },
})