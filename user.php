<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->fusr,$permission->fusw,'index','');

# Loading some more important informations
# User path
$theme = new Theme('user.php'); 

# Include page
include($theme->getThm_path());


?>