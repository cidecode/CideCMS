<?php

# This file is loading something very important
require('load.php');

# Check user permission
//$permission->perm_check_up($permission->finr,$permission->finw,'index','pagedie');

# Home page path
$theme = new Theme('index.php'); 

# Include page
include($theme->getThm_path());

?>