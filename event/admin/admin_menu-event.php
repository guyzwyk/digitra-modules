<?php
    //Initializations for statistics
    $my_eventStats		=	new cwd_event();
    $nbEvents		    =	$my_eventStats->count_events();
    //Library call
    require('../modules/event/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-calendar nav_icon\"></i>Events Manager<span class=\"badge badge-primary\">$nbEvents</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=event&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['EVENT_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=event&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['EVENT_ADMIN_MENU_CREATE']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=event&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['EVENT_ADMIN_MENU_CAT_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=event&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['EVENT_ADMIN_MENU_CAT_CREATE']."</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>";
?>