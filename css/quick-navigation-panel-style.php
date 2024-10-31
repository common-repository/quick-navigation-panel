<?php
header("content-type: text/css");
$path  = '';

if(!defined('WP_LOAD_PATH')){
	$root = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/';

	if(file_exists($root.'wp-load.php')){
        define('WP_LOAD_PATH',$root);
	}else{
        if(file_exists($path.'wp-load.php')){
            define('WP_LOAD_PATH',$path);
        }else{
            exit("Cannot find wp-load.php");
        }
	}
}

require_once(WP_LOAD_PATH.'wp-load.php');

global $wpdb;

$qnp_prefix = "qnp_";
$settings = get_option($qnp_prefix."settings");
?>
#quick_navigation_panel{
    width: 100%;
    position: fixed;
    bottom: 0px;
    left: 0px;
    border-top: <?php echo($settings["border_size"]); ?> solid <?php echo($settings["border_color"]); ?>;
    border-bottom: <?php echo($settings["border_size"]); ?> solid <?php echo($settings["border_color"]); ?>;
    background: <?php echo($settings["background"]); ?>;
    z-index: 100;
    display: inline-block;
}

ul#quick_navigation_panel_menu{
	position: relative;
}

ul#quick_navigation_panel_menu, ul#quick_navigation_panel_menu ul{
	margin: 0;
	padding: 0;
	list-style: none;
}

ul#quick_navigation_panel_menu li{
	position: relative;
	float: left;
	line-height: 30px;
}

#quick_navigation_panel_menu li ul{
	position: absolute;
	left: 0;
	bottom: 30px;
	margin-left: -999em;
}

#quick_navigation_panel_menu li ul ul{
	position: absolute;
	left: 100%;
	bottom: 0;
}

ul#quick_navigation_panel_menu li a{
	display: block;
	text-decoration: none;
	color: <?php echo($settings["color"]); ?>;
	line-height: 30px;
    padding: 0 20px;
	background: <?php echo($settings["background"]); ?>;
}

ul#quick_navigation_panel_menu li li{
	clear:  left;
    border: <?php echo($settings["border_size"]); ?> solid <?php echo($settings["border_color"]); ?>;
    border-bottom: none;
    width: 110px;
}

ul#quick_navigation_panel_menu li li a{
    padding: 5px;
    text-align: left;
    width: 100px;
    line-height: 15px;
}

#quick_navigation_panel_menu li:hover a, #quick_navigation_panel_menu li.over a, #quick_navigation_panel_menu li:hover li:hover a, #quick_navigation_panel_menu li.over li.over a, #quick_navigation_panel_menu li:hover li:hover li:hover a, #quick_navigation_panel_menu li.over li.over li.over a, #quick_navigation_panel_menu li:hover li a:hover, #quick_navigation_panel_menu li.over li a:hover, #quick_navigation_panel_menu li:hover li:hover li:hover a:hover, #quick_navigation_panel_menu li.over li li a:hover, #quick_navigation_panel_menu li:hover li:hover li:hover li:hover a:hover, #quick_navigation_panel_menu li.over li.over li.over li.over a:hover{
	color: <?php echo($settings["hover_color"]); ?>;
	background-position: -30px
}

#quick_navigation_panel_menu li:hover li a, #quick_navigation_panel_menu li.over li a, #quick_navigation_panel_menu li:hover li:hover li a, #quick_navigation_panel_menu li.over li.over li a, #quick_navigation_panel_menu li:hover li:hover li:hover li a, #quick_navigation_panel_menu li.over li.over li.over li a{
	color: <?php echo($settings["color"]); ?>;
	background-position: 0 0;
}

ul#quick_navigation_panel_menu li:hover ul ul, ul#quick_navigation_panel_menu li:hover ul ul ul, ul#quick_navigation_panel_menu li.over ul ul, ul#quick_navigation_panel_menu li.over ul ul ul{
	margin-left: -999em;
}

ul#quick_navigation_panel_menu li:hover ul, ul#quick_navigation_panel_menu li li:hover ul, ul#quick_navigation_panel_menu li li li:hover ul, ul#quick_navigation_panel_menu li.over ul, ul#quick_navigation_panel_menu li li.over ul, ul#quick_navigation_panel_menu li li li.over ul{
	margin-left: 0;
}

ul#quick_navigation_panel_menu li li ul{
    border-bottom: <?php echo($settings["border_size"]); ?> solid <?php echo($settings["border_color"]); ?>;
}

#quick_navigation_panel div#quick_navigation_panel_searchform{
    text-align: right;
    margin: 5px 20px;
    float: right;
}

#quick_navigation_panel div#quick_navigation_panel_searchform form{
    margin: 0px;
    padding: 0px;
}

#quick_navigation_panel div#quick_navigation_panel_searchform #s{
    width: 200px;
}

#quick_navigation_panel_info{
    position: absolute;
    bottom: 0;
    right: 0;
}

#quick_navigation_panel_info img{
    cursor: pointer;
}

#quick_navigation_panel_info_panel{
    position: absolute;
    bottom: 0;
    right: 0;
    margin-bottom: 10px;
    padding: 10px;
    width: 170px;
    border: <?php echo($settings["border_size"]); ?> solid <?php echo($settings["border_color"]); ?>;
    background: <?php echo($settings["background"]); ?>;
}