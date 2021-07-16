<template>
	<div class="overflow-auto h-screen">
		<!-- Tabs -->
		<div class="py-2 px-6 sm:ml-16 lg:ml-0 sm:fixed z-40 top-0">
			<ul class="inline-flex w-full">
				<li v-for="tab in tabs"
						:class="{'border-b-4 border-blue-400':activePath == path + '/' + tab.path}">
					<router-link :to="path + '/' +tab.path"
						class="inline-block px-4 py-2 text-gray-800 dark:text-white rounded-t opacity-50 hover:text-blue-800">{{ tab.name }}</router-link>
				</li>
			</ul>
		</div>
<!--
		{{user}}
-->

		<!-- Tab Contents -->
		<div class="py-4">
			<router-view></router-view>
		</div>
	</div>
</template>

<script>
	export default{
		inject:['user'],
		data(){
			return {};
		},
		computed:{
			path(){
				return '/' + this.$route.path.split('/')[1];
			},
			tabs(){
				return this.$router.options.routes.find(route=>route.path == this.path).children
			},
			activePath(){
				return this.$route.path;
			}
		}
	}
</script>
