<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->fpsr,$permission->fpsw,'index','');

# Loading some more important informations
# Search path
$theme = new Theme('search.php'); 

# Include page
include($theme->getThm_path());
?>