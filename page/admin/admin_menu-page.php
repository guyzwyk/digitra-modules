<?php
    //Library call
    require('../modules/page/langfiles/'.$langFile.'.php');
?>
<?php
$admin_menu_page =   "<li>
            <a href=\"#\"><i class=\"fa fa-user nav_icon\"></i>Pages Manager<span class=\"badge badge-warning\">$nbPages</span><span class=\"fa arrow\"></span></a>
            <ul class=\"nav nav-second-level\">
                <li>
                    <a href=\"admin.php?page=page&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_DISPLAY']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=page&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_CREATE']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=page&what=contentEdit\"><i class=\"fa fa-edit nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_CONTENT_EDIT']."</a>
                </li>
                <li>
                    <a href=\"admin.php?page=page&what=moduleAssign\"><i class=\"fa fa-exchange nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_MODULE_ASSIGN']."</a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>";

$editor_menu_page = "<li>
                    <a href=\"#\"><i class=\"fa fa-user nav_icon\"></i>Pages Manager<span class=\"badge badge-warning\">$nbPages</span><span class=\"fa arrow\"></span></a>
                    <ul class=\"nav nav-second-level\">
                        <li>
                            <a href=\"admin.php?page=page&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_DISPLAY']."</a>
                        </li>
                        <li>
                            <a href=\"admin.php?page=page&what=contentEdit\"><i class=\"fa fa-edit nav_icon\"></i>".$mod_lang_output['PAGE_ADMIN_MENU_CONTENT_UPDATE']."</a>
                        </li>
                    </ul>
            <!-- /.nav-second-level -->
        </li>";
?>