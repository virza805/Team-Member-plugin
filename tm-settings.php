<?php

// === >>>> Dashboard Left side Team Member Sub menu <<<< === \\
add_action( 'admin_menu', 'tm_setting_submenu' );
function tm_setting_submenu() {
  add_submenu_page(
      'edit.php?post_type=team_member',
      __('Team Member Setting','tm'),
      'Setting',
      'manage_options',
      'setting',
      'tm_setting_fun'
  );
}

function tm_setting_fun(){

    ?>
<div class="setting-wrap">
    <div class="setting-row">
        <h2>WordPress Member Plugin</h2>
        <h3>use this [team_members qty="3" img="top" btn="yes"]</h3>
        <ol>
            <li> [ <b style="color:Green;">Done</b> ] Register a post type named ‘Team Member’. Each team member has a Name, Picture, Bio and Position.</li>
            <li> [ <b style="color:Green;">Done</b> ] Register a taxonomy to that post type named ‘Member type’. Should be hierarchical.</li>
            <li> [ <b style="color:Green;">Done</b> ] Output should return by a shortcode named ‘team_members’.</li>
            <li> [ <b style="color:Green;">Done</b> ] Shortcode must accept 3 parameters, number of team members to show, the position of image in the html template and if display or not ‘See all’ Button (Dont).</li>
            <li> [ <b style="color:Green;">Done</b> ] There should be 2 designs of template based on shortcode parameters, first one is image position on top and second one is image position on bottom. Default is image position on top.</li>
            <li> [ <b style="color:Green;">Done</b> ] Output returned by shortcode must have a button to go the archive page of all team members. By default, this button is visible. See the sample below: </li>
            <li> [ <b style="color:Green;">Done</b> ] Name and Image should be clickable and on click they should go to single page where bio of team member will also display.</li>
        </ol>

        <b>Bonus options: </b>
        <h3>If you can do the following things it will added as an advantage but this are not required.</h3>
        <ol>
            <li> [ <b style="color:Green;">Done</b> ] Pagination in archive page.</li>
            <li> [ <b style="color:Green;">Done</b> ] A settings page for changing Post type name and URL slug.</li>
            <li>Try to do everything in Object Oriented PHP.</li>
        </ol>
        <p>------------------------------------------------- Best of Luck and Happy Coding -----------------------------------------------</p>
        
    </div>

    <div class="setting-row">
        <form action="options.php" method="post">
            <?php wp_nonce_field('update-options'); ?>
            <label for="tm1">changing Post type Defauld is team_member</label>
            <input id="tm1" type="text" name="tm_post_type" value="<?php echo get_option('tm_post_type'); ?>"> <br>

            <label for="tm1">slug </label>
            <input id="tm1" type="text" name="tm_slug" value="<?php echo get_option('tm_slug'); ?>"><br>

            <label for="tm1">url </label>
            <input id="tm1" type="text" name="tm_url" value="<?php echo get_option('tm_url'); ?>"><br>

            <!-- Round Corner -->
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="page_options"  value="tm_post_type, tm_slug, tm_url">
            <input type="submit" name="submit" value="<?php _e('Save Changes', 'tm') ?>">
        </form>
    </div>

    

</div>
    <?php
}

