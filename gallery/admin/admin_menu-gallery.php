<?php
    //Initializations for statistics
	$my_galleryStats	=	new cwd_gallery();
    $nb_galleryPix		=	$my_galleryStats->count_gallery('0');
    $nb_galleryAlbums	=	$my_galleryStats->count_gallery('1');
    
    //Library call
    require('../modules/gallery/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-picture-o nav_icon\"></i>Gallery Manager<span class=\"badge badge-primary\">$nb_galleryPix</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=gallery&what=display\"><i class=\"fa fa-eye nav_icon\"></i>Display photos</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=gallery&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>Insert photo</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=gallery&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display albums<span class=\"badge badge-warning\">$nb_galleryAlbums</span></a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=gallery&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create album</a>
                    </li>
                </ul>    
            </li>";
?>