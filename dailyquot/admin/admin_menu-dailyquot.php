<?php
    $my_dailyquotStats	=	new cwd_dailyquot();
    $nbDailyquots		=	$my_dailyquotStats->count_dailyquots();
    //Library call
    require('../modules/dailyquot/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-quote-left nav_icon\"></i>Daily quote Manager<span class=\"badge badge-primary\">$nbDailyquots</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=dailyquot&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['DAILYQUOT_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=dailyquot&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['DAILYQUOT_ADMIN_MENU_CREATE']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=dailyquot&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['DAILYQUOT_ADMIN_MENU_CAT_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=dailyquot&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['DAILYQUOT_ADMIN_MENU_CAT_CREATE']."</a>
                    </li>
                </ul>          
            </li>";
?>