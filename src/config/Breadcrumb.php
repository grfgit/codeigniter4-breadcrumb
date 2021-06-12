<?php
namespace GRFG\Breadcrumb\Config;

use CodeIgniter\Config\BaseConfig;

class Breadcrumb extends BaseConfig
{
    /**
     * -------------------------------------------------------------------
     * BREADCRUMB CONFIG
     * -------------------------------------------------------------------
     * This file will contain some breadcrumbs' settings.
     *
     * $config['crumb_divider']		The string used to divide the crumbs
     * $config['tag_open'] 			The opening tag for breadcrumb's holder.
     * $config['tag_close'] 			The closing tag for breadcrumb's holder.
     * $config['crumb_open'] 		The opening tag for breadcrumb's holder.
     * $config['crumb_close'] 		The closing tag for breadcrumb's holder.
     *
     * Defaults provided for twitter bootstrap 2.0
     */

    public $tagOpen = '<ol class="breadcrumb p-0 mb-0">';

    public $tagClose = '</ol>';

    public $crumbOpen = '<li class="breadcrumb-item">';

    public $crumbLastOpen = '<li class="breadcrumb-item active">';

    public $crumbClose = '</li>';

}
