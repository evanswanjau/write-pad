<?php
/*
--------------------------------------------------------------------------------
infused_cogs.php
--------------------------------------------------------------------------------
Carries/links all the files in the engine making it easierto link it with the
other fron-end html files. Rather thancalling each single file multiple times.
--------------------------------------------------------------------------------
*/

session_start(); # initilizes session variable

# reqest subordinate files
require_once 'connection.php';
require_once 'cogs.php';


 ?>
