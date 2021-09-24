<?php
//PB Helper Per menu principale
/* src/View/Helper/CssMenuHelper.php */
namespace App\View\Helper;

use Cake\View\Helper;

class CssMenuHelper extends Helper
{
    public $helpers = array('Html');
    /*
     * display a menu list.
     * @arg $data: a nested associative array.  The keys are the text that
     *     is displayed for that menu item.  If the value is an array, it is
     *    treated as a sub menu, with the same format.  Otherwise it is
     *    interpreted as a URL to be used for a link.
     * @arg $type: the type of array.  Can be right, left, or down.
     */
    public function menu($data=array(), $pos)
    {
       // return $this->output($this->_cm_render($data,0, $pos));
        return $this->_cm_render($data,0, $pos);
      
        echo $this->_cm_render($data,0, $pos);exit;
    }

    /* render a menu.
     * This is a helper for recursion.  The arguments are the
     * same as for $this->menu().
     */
    function _cm_render($arr=array(), $level, $pos)
    {
       
        $sRoot = MYAPP;

                $out='';
                $class_ul='';
                $class_li='nav-item';
                $caret="";
                $mrauto="";
               if ($pos=='navbar-left') $mrauto="mr-auto";
                if ($level == 0) {
                    $class_ul = 'navbar-nav ' . $mrauto . ' ' . $pos; $caret='<span class="caret"></span>';
                    
                }
                if ($level == 1)
                {
                    $class_ul = 'dropdown-menu';
                   $class_li = 'nav-item dropdown';
                }
                    //controlla se li ha un child
              //     if (!empty($val['children'])) {
                        
                    
                    if ($level >= 1) {
                        $class_li = 'dropdown-item';// p' . $pos;
                     if ($pos=="navbar-left")     $class_ul = 'submenu dropdown-menu';
                     else {
                         $class_ul = 'submenu submenu-left dropdown-menu';
                     }
                     
                }


                $out .= '<ul class="' . $class_ul .'">';
                 foreach ($arr as $key => $val) {
                    if (!empty($val['title']) && ($val['title']=='notitle')) {$key="";}
                    $icon="";
                    if (!empty($val['icon'])) $icon ='<i class="fa fa-lg ' . $val['icon'] . ' fa-inverse" style="vertical-align: middle;"></i> ';
                   
                    
                    if (!empty($val['children'])) {
                        $out .= '<li class="nav-item dropdown">' .'<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true">'. $icon . $key. $caret .' </a>';
                        $out .=$this->_cm_render($val['children'],$level+1, $pos);
                        $out .= "</li>";
                    } else {
                             $out .= '<li class="' . $class_li .'"><a class="nav-link" href="'.$sRoot.$val['action'].'">'. $icon .$key.'</a></li>';
                    }
         
                    }
        $out .= "</ul>";

        return $out;
    }
}
?>
