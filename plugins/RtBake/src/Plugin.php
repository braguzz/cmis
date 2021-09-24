<?php
declare(strict_types=1);

namespace RtBake;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

//brag
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
//fine brag

/**
 * Plugin for RrBake
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        //brag
          if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } 
        //fine brag
        
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'RtBake',
            ['path' => '/rt-bake'],
            function (RouteBuilder $builder) {
                // Add custom routes here

                $builder->fallbacks();
            }
        );
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middleware The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here

        return $middlewareQueue;
    }
  
    
 //brag   
    protected function bootstrapCli(): void
    {
EventManager::instance()->on(
    'Bake.beforeRender.Controller.controller',
    function (EventInterface $event) {
        $view = $event->getSubject();
        
     /*   if ($view->get('name') === 'Users') {
            // add the login and logout actions to the Users controller
            $view->set('actions', [
                'login',
                'logout',
                'index',
                'view',
                'add',
                'edit',
                'delete'
            ]);
        }*/
        $view->set('actions', [   
            'index',
            'esportacsv',
            'esportapdf',
            'esportaxls',
            'add',
            'add_ajax_belong',
            'addfromadd',
            'edit',
            'view',
            'removeajaxbelong',
            'indexexternal',
            'addhabtm',
            'removehabtmajaxbelong',
            'delete',
       /*      

             
            'selezioneAjax',
            'indexTab',           
               
            'index_from_add',
            'index_from_add_results',
            'indexfromadd',
            'indexexternal',

            'removeselection',
            'deleteselection',
            
               */
           /*
           
          
        /*    'beforeFilter'*/
            ]); 
        
        
    }
);
    } 
    
     //fine brag  
    
    
}
