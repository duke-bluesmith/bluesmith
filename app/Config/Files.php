<?php

namespace Config;

/*
*
* This file contains example values to alter default library behavior.
* Recommended usage:
*	1. Copy the file to app/Config/Files.php
*	2. Change any values
*	3. Remove any lines to fallback to defaults
*
*/

class Files extends \Tatter\Files\Config\Files
{
    // Layouts to use for general access and for administration
    public $layouts = [
        'public' => 'layouts/public',
        'manage' => 'layouts/manage',
    ];
}
