<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use BootstrapUI\View\UIView;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends UIView
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadHelper('Search.Search');
   
    
        
    //Menu
        $this->loadHelper('Icings/Menu.Menu');
   
     $menu = $this->Menu->create('main', [
          'templates' => [
        'menu' => '<nav {{attrs}}><div class="collapse navbar-collapse"><ul class="navbar-nav">{{items}}</ul></div></nav>',
        'item' => '<li{{attrs}}>{{link}}</li>',
    ],
    'menuAttributes' => [
        'class' => 'navbar navbar-expand-lg navbar-light bg-light',
    ],
  
    'nestedMenuClass' => 'dropdown-menu',
    'branchClass' => 'dropdown',
]);
$menu->addChild('Page A', [
    'uri' => ['controller' => 'Pages', 'action' => 'display', 'page-a'],
     'templates' => [
        'link' => '<a href="{{url}}"{{attrs}}>{{label}}</a>',
    ],
    'linkAttributes' => [
        'class' => 'nav-link',
       
    ]
]);
$menu->addChild('Dropdown', [
    'uri' => '#',
    'templates' => [
        'link' => '<a href="{{url}}"{{attrs}}>{{label}} <span class="caret"></span></a>',
    ],
    'linkAttributes' => [
        'class' => 'nav-link dropdown-toggle',
        'data-toggle' => 'dropdown',
        'role' => 'button',
        'aria-haspopup' => 'true',
        'aria-expanded' => 'false',
    ]
]);
$menu['Dropdown']->addChild('Page B', [
    'uri' => ['controller' => 'Pages', 'action' => 'display', 'page-b'],
     'templates' => [
        'link' => '<a href="{{url}}"{{attrs}}>{{label}}</a>',
    ],
    'linkAttributes' => [
        'class' => 'nav-link',
       
    ]
]);
$menu['Dropdown']->addChild('Divider', [
    'templates' => ['text' => ''],
    'attributes' => ['role' => 'separator', 'class' => 'divider'],
]);
$menu['Dropdown']->addChild('Page C', [
    'uri' => ['controller' => 'Pages', 'action' => 'display', 'page-c'],
     'templates' => [
        'link' => '<a href="{{url}}"{{attrs}}>{{label}}</a>',
    ],
    'linkAttributes' => [
        'class' => 'nav-link',
       
    ]
]);
$menu->addChild('Page D', [
    'uri' => ['controller' => 'Pages', 'action' => 'display', 'page-d'],
     'templates' => [
        'link' => '<a href="{{url}}"{{attrs}}>{{label}}</a>',
    ],
    'linkAttributes' => [
        'class' => 'nav-link',
       
    ]
]);
        
    }
}
