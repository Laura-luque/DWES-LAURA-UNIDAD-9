<?php
namespace App\Controllers;

class BaseController
{
    public function renderHTML ($fileName, $data=[])
    {
        ob_start();
        include($fileName);
        return ob_get_clean();
    }
}