<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->fpsr,$permission->fpsw,'index','');

# Page path
$theme = new Theme('page.php'); 

# Include page
include($theme->getThm_path());


?>