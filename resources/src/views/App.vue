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
								<div class="w-full text-gray-800 dark:text-white flex items-center px-6 p-2 my-2 bg-gray-100">
									<component :is="route[0].icon" class="w-5 mr-3"></component>
									{{ group }}
									<chevron-down-icon class="w-5 ml-auto"></chevron-down-icon>
								</div>
								<div>
									<div v-for="r in route" class="px-6">
										{{r.path}}
									</div>
								</div>
							</div>
<!--
							<router-link to="/dashboard/home" class="w-full text-gray-800 dark:text-white flex items-center pl-6 p-2 my-2 transition-colors duration-200 justify-start border-l-4 border-purple-500">
								<home-icon class="w-5 mr-3"></home-icon>
								Dashboard -> Dashboard / Home
							</router-link>
-->
<!--
							<router-link to="/manage/cache" class="w-full text-gray-400 flex items-center pl-6 p-2 my-2 transition-colors duration-200 justify-start hover:text-gray-800 border-l-4 border-transparent" href="#">
								<cog-icon class="w-5 mr-3"></cog-icon>
								Manage
								<span class="p-1 ml-4 rounded-lg bg-gray-200 text-gray-400 text-xs">
									0
								</span>
							</router-link>
							<router-link to="/developer/route" class="w-full text-gray-400 flex items-center pl-6 p-2 my-2 transition-colors duration-200 justify-start hover:text-gray-800 border-l-4 border-transparent">
								<beaker-icon class="w-5 mr-3"></beaker-icon>
								Developer -> Developer / Route
							</router-link>
							<router-link to="/developer/menu" class="w-full text-gray-400 flex items-center pl-6 p-2 my-2 transition-colors duration-200 justify-start hover:text-gray-800 border-l-4 border-transparent">
								<beaker-icon class="w-5 mr-3"></beaker-icon>
								Developer -> Developer / Menu
							</router-link>
-->
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
				name: 'cog-icon',
				children : [
					{ path: 'cache', name: 'Cache' },
					{ path: 'job', name: 'Job' },
				]
			},
			{
				path: '/log',
				name: 'Log',
				name: 'book-icon',
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
				name: 'baker-icon',
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
				menuOpen: 'Dashboard',
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
			}
		}
	}
</script>
