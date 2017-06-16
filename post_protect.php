<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->finr,$permission->finw,'index','pagedie');

# Loading some more important informations
# Post protect path
$theme = new Theme('post_protect.php'); 

# Include page
include($theme->getThm_path());
?>