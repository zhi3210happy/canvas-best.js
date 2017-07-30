<?php
/*
Plugin Name: Canvas-Best.js
Plugin URI: https://github.com/zhi3210happy/canvas-best.js
Description: [正版]A wordpress plugin for canvas-best.js | 一个很炫酷网页背景效果（canvas-best.js）的wordpress插件。
Version: 1.0.1
Author: Even
Author URI: http://www.zhi3210happy.xin/
License: MIT
*/

if(!class_exists('WP_Canvas_Best')) {
	class WP_Canvas_Best {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));  //引入 当前目录替代%s返回的目录文件 ,dirname(__FILE__)表示当前文件的绝对路径
			$WP_Canvas_Best_Settings = new WP_Canvas_Best_Settings();     //生成设置实例。

			$plugin = plugin_basename(__FILE__);                          //插件当前文件名赋值，plugin_basename(__FILE__)表示插件当前文件的文件名称。
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' )); //设置过滤钩子（名称，挂载的函数）， array( $this, 'plugin_settings_link' )表示将函数引用到当前实例
		} // END public function __construct                                                   
                                                                                                
		/**
		 * Activate the plugin
		 */
		public static function activate() {
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate() {
			// Do nothing
		} // END public static function deactivate

		// Add the settings link to the plugins page               
		function plugin_settings_link($links) {                          //插件页面 名为设置标签 的指向。
			$settings_link = '<a href="options-general.php?page=WP_Canvas_Best">设置</a>'; //a标签url
			array_unshift($links, $settings_link);   // 将$settings_link 插入$links第一位
			return $links;
		}


	} // END class WP_Canvas_Best
} // END if(!class_exists('WP_Canvas_Best'))

if(class_exists('WP_Canvas_Best'))
{
	// Installation and uninstallation hooks         登记启用和停用的hook
	register_activation_hook(__FILE__, array('WP_Canvas_Best', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Canvas_Best', 'deactivate'));

	// instantiate the plugin class
	$WP_Canvas_Best = new WP_Canvas_Best();     //生成实例。

}
