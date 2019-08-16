<?php
    //Initializations for statistics
    $my_bannerStats	    =	new cwd_banner();
    $nbBanners			=	$my_bannerStats->count_banners();
    //Library call
    require('../modules/banner/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-flag-o nav_icon\"></i>Banners Manager<span class=\"badge badge-primary\">$nbBanners</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=banner&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['BANNER_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=banner&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['BANNER_ADMIN_MENU_CREATE']."</a>
                    </li>
                </ul>     
            </li>";
?>