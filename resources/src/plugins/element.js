//import Icon from '/components/elements/Icon.vue';

//import * as Icons from "@heroicons/vue/outline";
import * as Icons from "@heroicons/vue/solid";

//console.log(Icons);
export default {
  install: (app, options) => {
    //app.config.globalProperties.$translate = (key) => {
      //return key.split('.')
        //.reduce((o, i) => { if (o) return o[i] }, options)
    //}

    //app.provide('i18n', options)

    //app.directive('my-directive', {
      //mounted (el, binding, vnode, oldVnode) {

      //}
    //})

    app.mixin({
			components: {
				...Icons
			}

    })
  }
}
