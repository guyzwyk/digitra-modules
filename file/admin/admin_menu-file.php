<?php
    //Initializations for statistics
    $my_fileStats	=	new cwd_file();
    $file	        =	new cwd_file();
    $nbFiles		=	$my_fileStats->count_files();

    //Library call
    require('../modules/file/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-file nav_icon\"></i>Files Manager<span class=\"badge badge-primary\">$nbFiles</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\"><!-- <a name=\"FILES\"></a> -->
                    <li>
                        <a href=\"admin.php?page=file&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['FILE_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=file&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['FILE_ADMIN_MENU_CREATE']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=file&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['FILE_ADMIN_MENU_CAT_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=file&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['FILE_ADMIN_MENU_CAT_CREATE']."</a>
                    </li>
                </ul>
            </li>";
?>