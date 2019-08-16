<?php
    //Initializations for statistics
    $my_annonceStats	=	new cwd_annonce();
    $nbAnnonces			=	$my_annonceStats->count_annonces();
    //Library call
    require('../modules/annonce/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-bullhorn nav_icon\"></i>Notices Manager<span class=\"badge badge-primary\">$nbAnnonces</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=annonce&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['ANNONCE_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=annonce&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['ANNONCE_ADMIN_MENU_CREATE']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=annonce&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['ANNONCE_ADMIN_MENU_CAT_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=annonce&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['ANNONCE_ADMIN_MENU_CAT_CREATE']."</a>
                    </li>
                </ul>   
            </li>";
?>