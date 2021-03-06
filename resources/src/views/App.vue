<template>
	<!-- Application -->
	<main class="bg-gray-100 dark:bg-gray-800 h-screen overflow-hidden relative">
		<div class="flex items-start justify-between">

			<!-- Main Sidebar -->
			<div :class="sidebarOpen? '':'hidden'" class="h-screen w-screen bg-gray-800 fixed z-50 opacity-50" @click="sidebarOpen=false"></div>
			<div :class="sidebarOpen? 'fixed':'relative hidden'" class="h-screen lg:block shadow-lg z-50 w-80">
				<div class="bg-white h-full dark:bg-gray-700">
					<div class="flex items-center justify-start pt-6 ml-4">
						<img src="https://placeimg.com/100/100/icon" class="h-10 mr-3"/>
						<span class="font-bold dark:text-white text-xl">
							{{ $config.name }}
						</span>
					</div>
					<nav class="mt-6">
						<div>
							<div v-for="route,group in routes">
								<div @click="toggleMenuOpen(group)"
									:class="{
										'bg-gray-200': menuOpen.includes(group),
										'border-l-4 border-purple-500': group == menuActive.split('/')[0]
									}"
									class="w-full text-gray-800 dark:text-white dark:bg-gray-700 flex items-center px-6 p-2 mt-3 hover:bg-gray-300 dark:hover:bg-gray-800">
									<component :is="route[0].icon" class="w-5 mr-3"></component>
									{{ group }}
									<chevron-up-icon v-if="menuOpen.includes(group)" class="w-5 ml-auto"></chevron-up-icon>
									<chevron-down-icon v-else class="w-5 ml-auto"></chevron-down-icon>
								</div>
								<div v-show="menuOpen.includes(group)">
									<div v-for="r in route">
										<router-link :to="r.path + '/' + r.children[0].path"
											@click="setMenuActive(group + '/' + r.name)"
											:class="{
												'bg-gray-100': menuOpen.includes(group),
												'border-l-4 border-purple-500': r.name == menuActive.split('/')[1]
											}"
											class="w-full text-gray-800 dark:text-white dark:bg-gray-700 flex items-center px-6 p-2 hover:bg-gray-200 dark:hover:bg-gray-800">
											<chevron-right-icon class="w-5 mr-3"></chevron-right-icon>
											{{ r.name }}
										</router-link>
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>

			<!-- Main Application -->
			<div class="flex flex-col w-full">
				<header class="w-full h-16 z-40 flex items-center justify-between">
					<div class="block lg:hidden ml-6">
						<button class="flex p-2 items-center rounded-full bg-white shadow text-gray-500 text-md" @click="sidebarOpen=true">
							<menu-icon class="w-5"></menu-icon>
						</button>
					</div>
					<div class="relative z-20 flex flex-col justify-end px-3 md:w-full">
						<div class="relative p-1 flex items-center w-full space-x-4 justify-end">
							<button class="flex p-2 items-center rounded-full bg-white shadow text-gray-400 hover:text-gray-700 text-md" @click="toggleTheme">
								<moon-icon class="w-5"></moon-icon>
							</button>
							<button class="flex p-2 items-center rounded-full bg-white shadow text-gray-400 hover:text-gray-700 text-md">
								<bell-icon class="w-5"></bell-icon>
							</button>
							<span class="w-1 h-8 rounded-lg bg-gray-200">
							</span>
							<a href="#" class="block relative">
								<img alt="profil" src="https://placeimg.com/100/100/ava" class="mx-auto object-cover rounded-full h-10 w-10 "/>
							</a>
							<button class="flex items-center text-gray-500 dark:text-white text-md">
								{{ user.name }}
								<chevron-down-icon class="w-5"></chevron-down-icon>
							</button>
						</div>
					</div>
				</header>

				<router-view></router-view>

			</div>
		</div>
	</main>

</template>

<script>
	const routes = {
		Dashboard: [
				{
					path: '/dashboard',
					name: 'Dashboard',
					icon: 'home-icon',
					children : [
						{ path: 'home', name: 'Home' }
					]
				},
			],
		Manage: [
			{
				path: '/user',
				name: 'User',
				icon: 'cog-icon',
				children : [
					{ path: 'user', name: 'User' },
					{ path: 'profile', name: 'Profile' },
					{ path: 'notification', name: 'Notification' }
				]
			},
			{
				path: '/manage',
				name: 'Manage',
				icon: 'cog-icon',
				children : [
					{ path: 'cache', name: 'Cache' },
					{ path: 'job', name: 'Job' },
				]
			},
			{
				path: '/log',
				name: 'Log',
				icon: 'book-icon',
				children : [
					{ path: 'audit', name: 'Audit Log' },
					{ path: 'system', name: 'System Log' },
				]
			},
		],
		Developer: [
			{
				path: '/developer',
				name: 'Developer',
				icon: 'beaker-icon',
				children : [
					{ path: 'route', name: 'Route' },
					{ path: 'group', name: 'Group' },
					{ path: 'menu', name: 'Menu' }
				]
			}
		]
	};
	export default {
		provide(){
			return {
				user : this.user,
				routes : this.routes
			}
		},
		data() {
			return {
				theme: 'light',
				sidebarOpen: false,
				menuOpen: ['Dashboard','Manage'],
				menuActive: 'Dashboard/Dashboard',
				routes,
				user:{
					name: 'Drax',
					email: 'pondrax3@gmail.com'
				}
			};
		},
		mounted(){
			if(this.$route.path == '/'){
				this.$router.replace('/dashboard/home');
			}
			this.setTheme();
		},
		methods:{
			setTheme(){
				if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
					this.theme = 'dark';
					document.documentElement.classList.add('dark');
				} else {
					this.theme = 'light';
					document.documentElement.classList.remove('dark')
				}
			},
			toggleTheme(){
				localStorage.theme = this.theme === 'dark' ? 'light' : 'dark';
				this.setTheme();
			},
			toggleMenuOpen(menu){
				var index = this.menuOpen.indexOf(menu);
				if(index !== -1){
					this.menuOpen.splice(index,1);
				}else{
					this.menuOpen.push(menu);
				}
			},
			setMenuActive(menu){
				this.menuActive = menu;
			}
		}
	}
</script>
