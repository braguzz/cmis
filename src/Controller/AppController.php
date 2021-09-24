<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;


  use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  //PB  
  public $sslUserId = null;    
  
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization', [
                 'skipAuthorization' => [
                 'login','',
        ]
    ]);

   $this->loadComponent('Search.Search', [
        // This is default config. You can modify "actions" as needed to make
        // the Search component work only for specified methods.
        'actions' => ['index', 'lookup','indexexternal'],
    ]);
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
   //PB Definisco MYAPP
   define('MYAPP', rtrim(Router::url('/', true),"/"));
 //  pr(MYAPP);exit();
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);
    // for all controllers in our application, make index and view
    // actions public, skipping the authentication check
    //    $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    $this->Authentication->addUnauthenticatedActions(['login', 'register','logout',]);

     $this->sslUserId = getSSLUser();
     $UserAuth = $this->getRequest()->getSession('Auth.codice_fiscale');
 
     //Configurazioni RegTosc 
     $regtoscConf= Configure::read('regtoscConf');
     $this->set('regtoscConf', $regtoscConf);
     
    //estrazione role_id 
     $user_dati = $this->Authentication->getIdentity();
        if (!empty($user_dati)) {
            $roleId = $user_dati->role_id;
            if ($roleId===6)   return $this->render('/Users/inactive');// utente inattivo    
            $this->set('role_id', $roleId);
            $this->set('cf', $user_dati->codice_fiscale);
            
              // Per inserire nei menu i report
        $this->loadModel('ReportSql.Reports');
        $Rep = $this->Reports->find('list', array(
            'conditions' => array('menu' => 1)
        ));
        $rep = $Rep->toArray();
        $this->set('rep', $rep);
      /*  $this->loadModel('Reports.Chart');
        $Cha = $this->Chart->find('all', array(
            'conditions' => array('Chart.menu' => 1)
        ));
        $this->set('cha', $Cha);*/
            
            
        }
    //fine estrazione role_id    
      
        
    } 
 
    
    
 
   public function beforeRender(\Cake\Event\EventInterface $event) {
    parent::beforeRender($event);
    $this->viewBuilder()->Setlayout('TwitterBootstrap/default');
}     
    
    
    

    
}
