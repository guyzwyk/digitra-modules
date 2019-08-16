<?php
    //Library call
    require('../modules/exaction/langfiles/'.$langFile.'.php');
    $myExaction		= 	new cwd_exaction();
    $nbExaction		=	$myExaction->count_exactions();		//All
?>
<?php
    $admin_menu     =   "<li>
                            <a href=\"#\"><i class=\"fa fa-database nav_icon\"></i>".$mod_lang_output['DB_ADMIN_MENU']."<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"#\"><i class=\"fa fa-universal-access nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_NOSO_CRISIS"]."<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-third-level\">
                                        <li>
                                            <a href=\"admin.php?page=exaction&what=display\"><i class=\"fa fa-crosshairs nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_NOSO_EXACTIONS"]."<span class=\"badge badge-warning\">$nbExaction</span></a>
                                        </li>
                                        <li>
                                            <a href=\"admin.php?page=dox&what=display\"><i class=\"fa fa-file nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_NOSO_DOCUMENTATION"]."</a>
                                        </li>
                                    </ul>                                    
                                </li>
                                <li>
                                    <a href=\"#\"><i class=\"fa fa-users nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_STAFF_MINAT"]."<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-third-level\">
                                        <li>
                                            <a href=\"admin.php?page=staff&what=display\"><i class=\"fa fa-list nav_icon\"></i>Listing</a>
                                        </li>
                                        <li>
                                            <a href=\"admin.php?page=staff&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>Ajouter</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href=\"#\"><i class=\"fa fa-address-book nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_DIRECTORY"]."<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-third-level\">
                                        <li>
                                            <a href=\"admin.php?page=directory&what=display\"><i class=\"fa fa-list nav_icon\"></i>Listing</a>
                                        </li>
                                        <li>
                                            <a href=\"admin.php?page=directory&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>Ajouter</a>
                                        </li> 
                                    </ul>
                                </li>
                                <li>
                                    <a href=\"#\"><i class=\"fa fa-cogs nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_SETTINGS"]."<span class=\"fa arrow\"></span></a>
                                    <ul class=\"nav nav-third-level\">
                                        <li>
                                            <a href=\"admin.php?page=exaction&what=dataLoad\"><i class=\"fa fa-upload nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_SETTINGS_DATALOAD"]."</a>
                                        </li>
                                        <li>
                                            <a href=\"admin.php?page=exaction&what=dataFlush\"><i class=\"fa fa-times nav_icon\"></i>".$mod_lang_output["BD_ADMIN_MENU_SETTINGS_DATAFLUSH"]."</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>";
?>