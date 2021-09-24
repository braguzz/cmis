<?php
/**
 * Define the following constants to set tcpdf images default directory
 */
namespace App\View\Helper;
 
use Cake\View\Helper;

define ('K_TCPDF_EXTERNAL_CONFIG', true);
define ('K_PATH_IMAGES', WWW_ROOT.'img'.DS);


class PdfHelper  extends Helper                                 
{
    var $core;
    function __construct() {
        $this->core = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);  
       // return $this->core;
    }    
}


