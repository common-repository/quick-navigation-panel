<?php
/*
Plugin Name: Quick Navigation Panel
Plugin URI: http://rubensargsyan.com/wordpress-plugin-quick-navigation-panel/
Description: This plugin helps the visitors to navigate more quickly. <a href="options-general.php?page=quick-navigation-panel.php">Settings</a>
Version: 1.1
Author: Ruben Sargsyan
Author URI: http://rubensargsyan.com/
*/

/*  Copyright 2012 Ruben Sargsyan (email: info@rubensargsyan.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$qnp_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$qnp_title = "Quick Navigation Panel";
$qnp_prefix = "qnp_";

function load_quick_navigation_panel(){
    $qnp_prefix = "qnp_";
    $qnp_version = "1.1";

    if(get_option("quick_navigation_panel_version")===false){
        add_option("quick_navigation_panel_version",$qnp_version);
    }elseif(get_option("quick_navigation_panel_version")<$qnp_version){
        if(get_option("quick_navigation_panel_version")=="1.0"){
            $qnp_settings = get_option("quick_navigation_panel_settings");

            $blocks = array();

            if(!empty($qnp_settings["quick_navigation_panel_blocks"])){
                foreach($qnp_settings["quick_navigation_panel_blocks"] as $key => $value){
                    $blocks[str_replace("quick_navigation_panel_","",$key)] = $value;
                }
            }

            $exclude = "";
            $external_css_file = "";
            $color = $qnp_settings["quick_navigation_panel_color"];
            $hover_color = $qnp_settings["quick_navigation_panel_hover_color"];
            $border_size = $qnp_settings["quick_navigation_panel_border_size"];
            $border_color = $qnp_settings["quick_navigation_panel_border_color"];
            $background = $qnp_settings["quick_navigation_panel_background"];
         
            add_option($qnp_prefix."settings",array("blocks"=>$blocks,"exclude"=>$exclude,"external_css_file"=>$external_css_file,"color"=>$color,"hover_color"=>$hover_color,"border_size"=>$border_size,"border_color"=>$border_color,"background"=>$background));

            delete_option("quick_navigation_panel_settings");
        }

        update_option("quick_navigation_panel_version",$qnp_version);
    }

    if(get_option($qnp_prefix."settings")===false){
        set_default_quick_navigation_panel_settings();
    }
}

function set_default_quick_navigation_panel_settings(){
    $qnp_prefix = "qnp_";

    $blocks = array("pages"=>"yes","categories"=>"yes","archive"=>"yes","tags"=>"yes","search"=>"yes");
    $exclude = "";
    $external_css_file = "";
    $color = "#214579";
    $hover_color = "#750909";
    $border_size = "1px";
    $border_color = "#000000";
    $background = "#EEEEEE";

    $settings = array("blocks"=>$blocks,"exclude"=>$exclude,"external_css_file"=>$external_css_file,"color"=>$color,"hover_color"=>$hover_color,"border_size"=>$border_size,"border_color"=>$border_color,"background"=>$background);

    add_option($qnp_prefix."settings",$settings);
}

function update_quick_navigation_panel_settings($settings){
    global $qnp_prefix;

    $current_settings = get_option($qnp_prefix."settings");

    $settings = array_merge($current_settings,$settings);

    update_option($qnp_prefix."settings",$settings);
}

function quick_navigation_panel_menu(){
    if(function_exists('add_options_page')){
        add_options_page('Quick Navigation Panel','Quick Navigation Panel', 'manage_options', basename(__FILE__), 'quick_navigation_panel_admin') ;
    }
}

function quick_navigation_panel_admin(){
    global $qnp_url, $qnp_title, $qnp_prefix;
    ?>
    <script src="<?php echo($qnp_url.'javascript/jscolor.js'); ?>" type="text/javascript"></script>
    <?php

    if($_GET["page"]==basename(__FILE__)){
        if($_POST["action"]=="save"){
            $settings = get_option($qnp_prefix."settings");

            $blocks = array();

            if(!empty($_POST[$qnp_prefix."blocks"])){
                foreach($_POST[$qnp_prefix."blocks"] as $block){
                    $blocks[str_replace($qnp_prefix,"",$block)] = "yes";
                }
            }else{
                $blocks = $settings[$qnp_prefix."blocks"];
            }

            $exclude = esc_attr($_POST[$qnp_prefix."exclude"]);
            $external_css_file = esc_url($_POST[$qnp_prefix."external_css_file"]);
            $color = "#".trim(strip_tags(substr($_POST[$qnp_prefix."color"],0,6)));
            $hover_color = "#".trim(strip_tags(substr($_POST[$qnp_prefix."hover_color"],0,6)));
            $border_size = trim(strip_tags($_POST[$qnp_prefix."border_size"]));
            $border_color = "#".trim(strip_tags(substr($_POST[$qnp_prefix."border_color"],0,6)));
            $background = "#".trim(strip_tags(substr($_POST[$qnp_prefix."background"],0,6)));

            $settings_new = array("blocks"=>$blocks,"exclude"=>$exclude,"external_css_file"=>$external_css_file,"color"=>$color,"hover_color"=>$hover_color,"border_size"=>$border_size,"border_color"=>$border_color,"background"=>$background);

            update_quick_navigation_panel_settings($settings_new);

            echo('<div id="message" class="updated fade"><p><strong>Saved.</strong></p></div>');
        }elseif($_POST["action"]=="reset"){
            delete_option($qnp_prefix."settings");

            echo('<div id="message" class="updated fade"><p><strong>Reset.</strong></p></div>');
        }
    }

    if(get_option($qnp_prefix."settings")===false){
        set_default_quick_navigation_panel_settings();
    }

    $settings = get_option($qnp_prefix."settings");
    ?>
    <div class="wrap">
      <div style="margin: 20px 0; text-align: center; display: inline-block"><div style="float: left"><div><a href="http://blorner.com?utm_source=share-buttons-simple-use&utm_medium=banner&utm_campaign=admin" target="_blank"><img src="http://banners.blorner.com/blorner.com-468x60.jpg" alt="Blorner" style="border: none" /></a></div><div style="margin-top: 30px"><a href="https://secure1.inmotionhosting.com/cgi-bin/gby/clickthru.cgi?id=rubensargsyan&page=1" target="_blank"><img src="http://creatives.inmotionhosting.com/branded-single-feature/468x60.gif" border=0></a></div></div><div style="float: right; margin-left: 50px; text-align: justify; width: 400px; border: 1px solid #DFDFDF; padding: 10px;"><div style="float: left; margin-right: 10px;"><a href="http://rubensargsyan.com/wordpress-plugin-ubm-premium/" target="_blank"><img src="http://rubensargsyan.com/images/ubm-premium.png" alt="UBM Premium" style="border: none" /></a></div><div style="font-size: 11px">UBM Premium is the ultimate banner manager WordPress plugin for the serious bloggers. Rotate banners based on performance, track outgoing clicks, control nofollow/dofollow and much more. The perfect solution for all affiliate marketers and webmasters.</div></div></div>

      <h2><?php echo $qnp_title; ?> Settings</h2>
      <br />
      <form method="post">
        <table width="100%" border="0" id="quick_navigation_panel_settings_table">
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Blocks</strong></td>
            <td width="80%">
                <label for="<?php echo($qnp_prefix); ?>pages">Pages:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>pages" value="<?php echo($qnp_prefix); ?>pages" type="checkbox" <?php if($settings["blocks"]["pages"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($qnp_prefix); ?>categories">Categories:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>categories" value="<?php echo($qnp_prefix); ?>categories" type="checkbox" <?php if($settings["blocks"]["categories"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($qnp_prefix); ?>archive">Archive:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>archive" value="<?php echo($qnp_prefix); ?>archive" type="checkbox" <?php if($settings["blocks"]["archive"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($qnp_prefix); ?>authors">Authors:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>authors" value="<?php echo($qnp_prefix); ?>authors" type="checkbox" <?php if($settings["blocks"]["authors"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($qnp_prefix); ?>tags">Tags:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>tags" value="<?php echo($qnp_prefix); ?>tags" type="checkbox" <?php if($settings["blocks"]["tags"]=="yes"){ echo('checked="checked"'); } ?> />&nbsp;&nbsp;<label for="<?php echo($qnp_prefix); ?>search">Search:</label> <input name="<?php echo($qnp_prefix); ?>blocks[]" id="<?php echo($qnp_prefix); ?>search" value="<?php echo($qnp_prefix); ?>search" type="checkbox" <?php if($settings["blocks"]["search"]=="yes"){ echo('checked="checked"'); } ?> />
            </td>
          </tr>
          <tr>
            <td><small>Check those, which will be shown on the quick navigation panel</small></td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Exclude</strong></td>
            <td width="80%">
                <input name="<?php echo($qnp_prefix); ?>exclude" id="<?php echo($qnp_prefix); ?>exclude" type="text" style="width:200px;" value="<?php echo($settings["exclude"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Write here (separate by commas) the pages or posts IDs to exclude (Example: 3,14,45,127 ...).</small></td>
          </tr>
          <tr>
            <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>External CSS file</strong></td>
            <td width="80%">
                <input name="<?php echo($qnp_prefix); ?>external_css_file" id="<?php echo($qnp_prefix); ?>external_css_file" type="text" style="width:400px;" value="<?php echo($settings["external_css_file"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Set external CSS file URL. If an external CSS file is set, the style set in the "Quick Navigation Panel Settings" will be ignored.</small></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Navigation Panel Text Color</strong></td>
            <td width="80%">
                <input autocomplete="off" class="color" name="<?php echo($qnp_prefix); ?>color" id="<?php echo($qnp_prefix); ?>color" type="text" style="width:100px;" value="<?php echo($settings["color"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Click on the text field to set another color.</small></td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Navigation Panel Hover Text Color</strong></td>
            <td width="80%">
                <input autocomplete="off" class="color" name="<?php echo($qnp_prefix); ?>hover_color" id="<?php echo($qnp_prefix); ?>hover_color" type="text" style="width:100px;" value="<?php echo($settings["hover_color"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Click on the text field to set another color.</small></td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Navigation Panel Border Size</strong></td>
            <td width="80%">
                <input name="<?php echo($qnp_prefix); ?>border_size" id="<?php echo($qnp_prefix); ?>border_size" type="text" style="width:100px;" value="<?php echo($settings["border_size"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>This option sets the border size (Example: 1px, 0.8pt, 0.2em ... ) of the quick navigation panel.</small></td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Navigation Panel Border Color</strong></td>
            <td width="80%">
                <input autocomplete="off" class="color" name="<?php echo($qnp_prefix); ?>border_color" id="<?php echo($qnp_prefix); ?>border_color" type="text" style="width:100px;" value="<?php echo($settings["border_color"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Click on the text field to set another color.</small></td>
          </tr>
          <tr>
            <td width="20%" rowspan="2" valign="middle"><strong>Navigation Panel Background Color</strong></td>
            <td width="80%">
                <input autocomplete="off" class="color" name="<?php echo($qnp_prefix); ?>background" id="<?php echo($qnp_prefix); ?>background" type="text" style="width:100px;" value="<?php echo($settings["background"]); ?>" />
            </td>
          </tr>
          <tr>
            <td><small>Click on the text field to set another color.</small></td>
          </tr>
          <tr>
            <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <p class="submit">
          <input name="save" type="submit" value="Save changes" />
          <input type="hidden" name="action" value="save" />
        </p>
      </form>
      <form method="post">
        <p class="submit">
          <input name="reset" type="submit" value="Reset" />
          <input type="hidden" name="action" value="reset" />
        </p>
      </form>
    </div>
    <?php
}

function quick_navigation_panel_header(){
    global $qnp_url, $qnp_prefix;

    $settings = get_option($qnp_prefix."settings");

    $external_css_file = $settings["external_css_file"];
?>
    <link rel="stylesheet" href="<?php if(($external_css_file!="")){ echo($external_css_file); }else{ echo($qnp_url."css/quick-navigation-panel-style.php"); } ?>" type="text/css" />
    <!--[if lt IE 7]>
    <link rel="stylesheet" href="<?php echo($qnp_url); ?>css/quick-navigation-panel-iestyle.php" type="text/css" />

    <script type="text/javascript">

    quick_navigation_panel_hover = function() {
    	var quick_navigation_panel_lis = document.getElementById("quick_navigation_panel_menu").getElementsByTagName("li");
    	for (var i=0; i<quick_navigation_panel_lis.length; i++) {
    		quick_navigation_panel_lis[i].onmouseover=function() {
    			this.className+=" over";
    		}
    		quick_navigation_panel_lis[i].onmouseout=function() {
    			this.className=this.className.replace(new RegExp(" over\\b"), "");
    		}
    	}
    }
    if(window.attachEvent) window.attachEvent("onload", quick_navigation_panel_hover);

    </script>
    <![endif]-->
<?php
}

function quick_navigation_panel(){
    global $qnp_prefix, $qnp_url, $qnp_title;

    $settings = get_option($qnp_prefix."settings");

    $exclude = $settings["exclude"];

    if(trim($exclude)!="" && (is_single() || is_page())){
        $exclude_ids = explode(",",$exclude);

        foreach($exclude_ids as $exclude_id){
            if(get_the_ID()==intval($exclude_id)){
                return;
            }
        }
    }

    $blocks = $settings["blocks"];
?>
    <div id="quick_navigation_panel" class="quick_navigation_panel">
        <ul id="quick_navigation_panel_menu">
            <?php if($blocks["pages"]=="yes"){ ?>
            <li><a href="#"><?php _e("Pages"); ?></a>
                <ul>
                    <li><a href="<?php bloginfo('url'); ?>"><?php _e("Home"); ?></a></li>
                    <?php
                    $pages = get_pages("parent=0&sort_column=menu_order&sort_order=asc");

                    if(!empty($pages)){
                        foreach($pages as $page){
                            $subpages = get_pages("child_of=".$page->ID."&sort_column=menu_order&sort_order=asc");
                        ?>
                            <li><a href="<?php echo(get_page_link($page->ID)); ?>"><?php echo($page->post_title); ?><?php if(!empty($subpages)){ echo(" &raquo;"); } ?></a>
                        <?php
                            if(!empty($subpages)){
                                ?>
                                <ul>
                                <?php
                                foreach($subpages as $subpage){
                                ?>
                                    <li><a href="<?php echo(get_page_link($subpage->ID)); ?>"><?php echo($subpage->post_title); ?></a></li>
                                <?php
                                }
                                ?>
                                </ul>
                                <?php
                            }
                            ?>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
            <?php } ?>
            <?php if($blocks["categories"]=="yes"){ ?>
        	<li><a href="#"><?php _e("Categories"); ?></a>
                <ul>
                    <?php
                    $categories = get_categories("parent=0");

                    if(!empty($categories)){
                        foreach($categories as $category){
                            $subcategories = get_categories("child_of=".$category->term_id);
                        ?>
                            <li><a href="<?php echo(get_category_link($category->term_id)); ?>"><?php echo($category->name); ?><?php if(!empty($subcategories)){ echo(" &raquo;"); } ?></a>
                        <?php
                            if(!empty($subcategories)){
                                ?>
                                <ul>
                                <?php
                                foreach($subcategories as $subcategory){
                                ?>
                                    <li><a href="<?php echo(get_category_link($subcategory->term_id)); ?>"><?php echo($subcategory->name); ?></a></li>
                                <?php
                                }
                                ?>
                                </ul>
                                <?php
                            }
                            ?>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
        	</li>
            <?php } ?>
            <?php if($blocks["archive"]=="yes"){ ?>
            <li><a href="#"><?php _e("Archive"); ?></a>
                <ul>
                    <?php wp_get_archives("type=monthly&limit=15"); ?>
                </ul>
        	</li>
            <?php } ?>
            <?php if($blocks["authors"]=="yes"){ ?>
            <li><a href="#"><?php _e("Authors"); ?></a>
                <ul>
                    <?php wp_list_authors("exclude_admin=0"); ?>
                </ul>
        	</li>
            <?php } ?>
            <?php if($blocks["tags"]=="yes"){ ?>
            <li><a href="#"><?php _e("Tags"); ?></a>
                <ul>
                    <?php
                    $tags = get_tags("number=15&orderby=count&order=desc");

                    if(!empty($tags)){
                        foreach($tags as $tag){
                        ?>
                        <li><a href="<?php echo(get_tag_link($tag->term_id)); ?>"><?php echo($tag->name); ?></a></li>
                        <?php
                        }
                    }
                    ?>
                </ul>
        	</li>
            <?php } ?>
        </ul>
        <?php if($blocks["search"]=="yes"){ ?>
        <div id="quick_navigation_panel_searchform">
        <form method="get" action="<?php bloginfo('url'); ?>/">
        	<input type="text" value="" name="s" id="s" />
        	<input type="submit" id="quick_navigation_panel_searchsubmit" value="<?php _e("Search"); ?>" />
        </form>
        </div>
        <?php } ?>
        <div id="quick_navigation_panel_info"><a href="http://rubensargsyan.com/wordpress-plugin-quick-navigation-panel/" target="_blank"><img src="<?php echo($qnp_url); ?>info.gif" alt="Info"></a></div>
    </div>
<?php
}

add_action("plugins_loaded","load_quick_navigation_panel");
add_action("admin_menu", "quick_navigation_panel_menu");
add_action("wp_head", "quick_navigation_panel_header");
add_action("wp_footer", "quick_navigation_panel");
?>