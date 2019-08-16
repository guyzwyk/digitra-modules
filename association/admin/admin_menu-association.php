<?php
    //Initializations for statistics
    $my_associationStats	=	new cwd_association();
    $nbAssociations			=	$my_associationStats->count_associations();
    //Library call
    require('../modules/association/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-bullhorn nav_icon\"></i>Association Manager<span class=\"badge badge-primary\">$nbaAssociations</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=association&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['ASSOCIATION_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=association&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['ASSOCIATION_ADMIN_MENU_CREATE']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=association&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['ASSOCIATION_ADMIN_MENU_CAT_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=association&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['ASSOCIATION_ADMIN_MENU_CAT_CREATE']."</a>
                    </li>
                </ul>   
            </li>";
?>
