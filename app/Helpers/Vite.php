<?php

if (!function_exists('vite')) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param string $path
	 * @param string $manifestDirectory
	 *
	 * @throws \Exception
	 *
	 * @return \Illuminate\Support\HtmlString
	 */
	function vite($path)
	{
		$port	= isset($_ENV['HMR_PORT']) ? $_ENV['HMR_PORT'] : 3000;

		$devMode = file_exists(base_path('vitelock'));
		if($devMode){
			$url	= "http://localhost:$port";
			echo "<script type='module' crossorigin src='$url/$path'></script>";
		}else{
			//read manifest
			$file = base_path('public/dist/manifest.json');
			if(!file_exists($file)){
				throw new Exception(
					"No vite serve or production exists"
				);
			}
			$manifest = json_decode(file_get_contents($file),true);

			foreach($manifest as $key=>$asset){
				$slug = dirname($path);
				if($key == basename($path)){
					foreach($asset['css'] as $css){
						$compiled[] =  loadCss($slug . '/' . $css);
					}
					$compiled[] =  loadJs($slug . '/' . $asset['file']);
				}
			}
			echo implode(PHP_EOL . "\t", $compiled);
		}
	}
	function loadJs($path){
		return "<script type='module' src='". url($path) ."'></script>";
	}
	function loadCss($path){
		return "<link rel='stylesheet' href='". url($path) ."'>";
	}
}
