import { createRouter, createWebHashHistory } from 'vue-router';

import Main from '/views/App/Main.vue';

const modules = import.meta.glob('/views/App/*/*.vue')

let routes = [];
Object.entries(modules).map(([k,component])=>{
	var [group,name] = k.replace(/\/views\/App\/|.vue/g,'').split('/');
	var index = routes.findIndex((o)=>o.name == group);
	var children = {
		path: name.toLowerCase(),
		name,
		component
	};
	if( index ==-1){
		routes.push({
			path: '/' + group.toLowerCase(),
			name: group,
			component: Main,
			children:[
				children,
			]
		})
	}else{
		routes[index].children.push(children)
	}
})

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router;
