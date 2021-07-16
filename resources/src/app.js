import '/bootstrap.js';
import '/assets/styles/app.css';

import { createApp } from 'vue';

import i18n from '/i18n.js';
import router from '/router.js';
import element from '/plugins/element.js';

import App from '/views/App.vue';

const app = createApp(App);

app.use(i18n);
app.use(router);
app.use(element);

app.config.globalProperties.$config = config;

window.app = app.mount('#app')
