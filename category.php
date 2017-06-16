<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->fctr,$permission->fctw,'index','');

# Loading some more important informations
# Category path
$theme = new Theme('category.php'); 

# Include page
include($theme->getThm_path());


?>