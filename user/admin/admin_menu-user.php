<?php
    //Library call
    require('../modules/user/langfiles/'.$langFile.'.php');
?>
<?php
$admin_menu_user =   "<li>
            <a href=\"#\"><i class=\"fa fa-user nav_icon\"></i>Users Manager<span class=\"badge badge-warning\">$nbUsers</span><span class=\"fa arrow\"></span></a>
            <ul class=\"nav nav-second-level\">
                <li>
                    <a href=\"admin.php?page=user&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['USER_ADMIN_MENU_DISPLAY']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=user&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['USER_ADMIN_MENU_CREATE']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=user&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['USER_ADMIN_MENU_CAT_DISPLAY']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=user&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['USER_ADMIN_MENU_CAT_CREATE']."</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>";

$editor_menu_user = "<li>
            <a href=\"#\"><i class=\"fa fa-user nav_icon\"></i>Users Manager<span class=\"badge badge-warning\">$nbUsers</span><span class=\"fa arrow\"></span></a>
            <ul class=\"nav nav-second-level\">
                <li>
                    <a href=\"admin.php?page=user&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['USER_ADMIN_MENU_DISPLAY']."</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>";
?>