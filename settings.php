<?php

if(!class_exists('WP_Canvas_Best_Settings')) {     //判断是否存在WP_Canvas_Best_Settings的class。
	class WP_Canvas_Best_Settings {                //创建class
		/**
		 * Construct the plugin object
		 */
		public function __construct() {                   //创建构造器
			// register actions                                                  
            add_action('admin_init', array(&$this, 'admin_init'));      //登记行为 名为 admin_init实例, 执行回调array，设置当前实例引用 amdmin_init.   
        	add_action('admin_menu', array(&$this, 'add_menu'));
            add_action('wp_footer', array(&$this, 'add_canvas_best'));
		} // END public function __construct

        private function wrap_var($v) {                  //判断设置是否启用函数。
            if ($v === false) return true;
            if ($v) return true;
            return false;
        }

        // private function hex2rgb($hex) {             //hex颜色转换为rbg函数
        //     $hex = str_replace("#", "", $hex);

        //     if(strlen($hex) == 3) {
        //         $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        //         $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        //         $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        //     } else {
        //         $r = hexdec(substr($hex,0,2));
        //         $g = hexdec(substr($hex,2,2));
        //         $b = hexdec(substr($hex,4,2));
        //     }
        //     return array($r, $g, $b);
        // }

		public function add_canvas_best() {                              //启动canvas
            //判断当前页面是否开启
            //is_home 、 is_archive 、 is_singular 、 is_search 、 is_404
            $will_show = false;

            $is_home = $this->wrap_var(get_option('cn_setting_ishome'));             //页面设置是否开启,并赋值
            $is_archive = $this->wrap_var(get_option('cn_setting_isarchive'));
            $is_singular = $this->wrap_var(get_option('cn_setting_issingular'));
            $is_search = $this->wrap_var(get_option('cn_setting_issearch'));
            $is_404 = $this->wrap_var(get_option('cn_setting_is404'));

            if (is_home() && $is_home === is_home()) $will_show = true;             //开启show
            else if (is_singular() && $is_singular === is_singular()) $will_show = true;
            else if (is_archive() && $is_archive === is_archive()) $will_show = true;
            else if (is_search() && $is_search === is_search()) $will_show = true;
            else if (is_404() && $is_404 === is_404()) $will_show = true;

            if ($will_show) {                                                  //获取设置值，如果不存在赋予初始值。
                $setting_color = get_option('cn_setting_color');
                if ($setting_color === false) $setting_color = '360';
                $setting_opacity = get_option('cn_setting_opacity');
                if ($setting_opacity === false)  $setting_opacity = '1';
                $setting_count = get_option('cn_setting_count');
                if ($setting_count === false)  $setting_count = '3000';
                $setting_zindex = get_option('cn_setting_zindex');
                if ($setting_zindex === false)  $setting_zindex = '1';
                $setting_speed = get_option('cn_setting_speed');
                if ($setting_speed === false)  $setting_speed = '4';
                $setting_range = get_option('cn_setting_range');
                if ($setting_range === false)  $setting_range = '80';
                $setting_lineAlpha = get_option('cn_setting_linealpha');
                if ($setting_fillstlye === false)  $setting_lineAlpha = '0.05';
/*                  $setting_fillstlye = get_option('cn_setting_fillstyle');
                if ($setting_fillstlye === false)  $setting_fillstlye = '0.05'; */

                // if (strpos($setting_color, '#') === 0) {                     //如果颜色第一位是# 则把hex转换为rgb模式。
                //     $setting_color = $this->hex2rgb($setting_color);
                //     $setting_color = join(',', $setting_color);
                // }                                                          //输出带有属性值的script标签。
                echo "<script type='text/javascript'  speed='$setting_speed' range='$setting_range' lineAlpha='$setting_lineAlpha' color='$setting_color' zIndex='$setting_zindex' opacity='$setting_opacity' count='$setting_count' src='/wp-content/plugins/canvas-best/canvas-best.min.js'></script>";
            }       
        }
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
        	// register your plugin's settings  登记设定
        	register_setting('WP_Canvas_Best-group', 'cn_setting_color');
        	register_setting('WP_Canvas_Best-group', 'cn_setting_opacity');
            register_setting('WP_Canvas_Best-group', 'cn_setting_count');
            register_setting('WP_Canvas_Best-group', 'cn_setting_zindex');
            register_setting('WP_Canvas_Best-group', 'cn_setting_speed');
            register_setting('WP_Canvas_Best-group', 'cn_setting_range');
            register_setting('WP_Canvas_Best-group', 'cn_setting_linealpha');
            //  register_setting('WP_Canvas_Best-group', 'cn_setting_fillstyle'); 
        	// add your settings section  增加section
        	add_settings_section(
        	    'WP_Canvas_Best-section', 
        	    '1. Canvas-Best.js 配置参数', 
        	    array(&$this, 'settings_section_WP_Canvas_Best'), 
        	    'WP_Canvas_Best'
        	);
        	
        	// add your setting's fields  增加fields
            add_settings_field(
                'WP_Canvas_Best-setting_color', 
                '线条颜色: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_color',
                    'value' => '360',
                    'type' => 'text'
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_opacity', 
                '线条透明度: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_opacity',
                    'value' => '1',
                    'type' => 'text'
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_count', 
                '线条数量: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_count',
                    'value' => '3000',
                    'type' => 'number'
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_zindex', 
                'CSS zIndex(背景的z-index属性，CSS属性用于控制所在层的位置): ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_zindex',
                    'value' => '1',
                    'type' => 'number'
                )
            );
             add_settings_field(
                'WP_Canvas_Best-setting_speed', 
                '速度: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_speed',
                    'value' => '4',
                    'type' => 'text'
                )
            );
             add_settings_field(
                'WP_Canvas_Best-setting_range', 
                '长度: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_range',
                    'value' => '80',
                    'type' => 'text'
                )
            );
             add_settings_field(
                'WP_Canvas_Best-setting_linealpha', 
                '色彩深度: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_linealpha',
                    'value' => '0.05',
                    'type' => 'text'
                )
            );
      /*        add_settings_field(
                'WP_Canvas_Best-setting_fillstyle', 
                '填充透明度: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Best', 
                'WP_Canvas_Best-section',
                array(
                    'field' => 'cn_setting_fillstyle',
                    'value' => '0.05',
                    'type' => 'text'
                )
            ); */
            // setting 2
            register_setting('WP_Canvas_Best-checkbox-group', 'cn_setting_ishome');
            register_setting('WP_Canvas_Best-checkbox-group', 'cn_setting_issearch');
            register_setting('WP_Canvas_Best-checkbox-group', 'cn_setting_issingular');
            register_setting('WP_Canvas_Best-checkbox-group', 'cn_setting_isarchive');
            register_setting('WP_Canvas_Best-checkbox-group', 'cn_setting_is404');

            // add your settings section
            add_settings_section(
                'WP_Canvas_Best-checkbox-section', 
                '2. 哪些页面开启', 
                array(&$this, 'settings_section_WP_Canvas_Best_Checkbox'), 
                'WP_Canvas_Best_Checkbox'
            );

            add_settings_field(
                'WP_Canvas_Best-setting_ishome', 
                'Index(首页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Best_Checkbox', 
                'WP_Canvas_Best-checkbox-section',
                array(
                    'field' => 'cn_setting_ishome', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_isarchive', 
                'Archive(归档页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Best_Checkbox', 
                'WP_Canvas_Best-checkbox-section',
                array(
                    'field' => 'cn_setting_isarchive', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_issingular', 
                'Singular(文章单页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Best_Checkbox', 
                'WP_Canvas_Best-checkbox-section',
                array(
                    'field' => 'cn_setting_issingular', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_issearch', 
                'Search(搜索页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Best_Checkbox', 
                'WP_Canvas_Best-checkbox-section',
                array(
                    'field' => 'cn_setting_issearch', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Best-setting_is404', 
                '404(404页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Best_Checkbox', 
                'WP_Canvas_Best-checkbox-section',
                array(
                    'field' => 'cn_setting_is404', 'value' => true
                )
            );
            //is_home、is_archive、is_singular、is_search、is_404

        } // END public static function activate
        public function settings_section_WP_Canvas_Best_Checkbox() {
            echo '这里配置哪些页面开启, 打开canvas-best.js';
        }

        public function settings_section_WP_Canvas_Best() {
            echo '这些配置是设置<a target="_blank" href="https://github.com/aTool-org/canvas-best-for-wp">Canvas-Best.js</a>. 需要帮助? <a target="_blank" href="http://www.atool.org/">点这里</a>.';
        }

        public function settings_field_checkbox($args) {  //多选框函数
            $field = $args['field'];
            $value = $this->wrap_var(get_option($field));

            if ($value) {
                $value = "checked='checked'";
            }
            else {
                $value = '';
            }
            echo sprintf('<input type="checkbox" name="%s" id="%s" %s />', $field, $field, $value);
        }
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args) {   //输入框函数
            $field = $args['field'];
            $type = $args['type'];
            $value = get_option($field);
            if ($value === false) {
                $value = $args['value'];
            }
            echo sprintf('<input type="%s" name="%s" id="%s" value="%s" />', $type, $field, $field, $value);
        }
        
        /**
         * add a menu
         */		
        public function add_menu() {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Canvas-Best.js Setting', 
        	    'Canvas-Best.js', 
        	    'manage_options', 
        	    'WP_Canvas_Best', 
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */		
        public function plugin_settings_page() {
        	if(!current_user_can('manage_options')) {
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
        	// Render the settings template
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class WP_Canvas_Best_Settings
} // END if(!class_exists('WP_Canvas_Best_Settings'))
