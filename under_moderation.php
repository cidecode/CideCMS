<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->finr,$permission->finw,'index','pagedie');

# Loading some more important informations
# Under moderation path
$theme = new Theme('under_moderation.php'); 

# Include page
include($theme->getThm_path());
?>