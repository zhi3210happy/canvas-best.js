<div class="wrap">
    <h2>Canvas-Best.js 设置</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Canvas_Best-group'); ?>
        <?php @do_settings_fields('WP_Canvas_Best-group'); ?>

        <?php do_settings_sections('WP_Canvas_Best'); ?>
        <?php @submit_button(); ?>
    </form>
    <hr />
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Canvas_Best-checkbox-group'); ?>
        <?php @do_settings_fields('WP_Canvas_Best-checkbox-group'); ?>

        <?php do_settings_sections('WP_Canvas_Best_Checkbox'); ?>
        <?php @submit_button(); ?>
    </form>
</div>