<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Client;

use Cake\Cache\Cache;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    
     /**
     * landing method
     *
     * e' la pagina iniziale
     */
    public function landing()
    {
    
     }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
         $user = $this->Users->newEmptyEntity();
         $this->Authorization->authorize($user);
          
       $users = $this->paginate($this->Users);
 
       $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles'],
        ]);
       $this->Authorization->authorize($user);  

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
         $this->Authorization->authorize($user);
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user','roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
            $this->Authorization->authorize($user);   
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
         $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user','roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
          $this->Authorization->authorize($user);   
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);
    // Configure the login action to not require authentication, preventing
    // the infinite redirect loop issue
    $this->Authentication->addUnauthenticatedActions(['login','register','logout']);
}

public function login($what = null)
{
    $this->Authorization->skipAuthorization();
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();
    
    // regardless of POST or GET, redirect if user is logged in
    if ($result->isValid()) {
        // redirect to /landingpage after login success
        $lp=Configure::read('regtoscConf.landingPage');
        $redirect = $this->request->getQuery('redirect', $lp);
        $this->logaccess('dummyuser');
        return $this->redirect($redirect);
    }
    // display error if user submitted and authentication failed
    if ($this->request->is('post') && !$result->isValid()) {
        $this->Flash->error(__('Invalid username or password'));
    }
}

/**
 * Logout method
 *
 * @return void
 */
	public function logout() 
    {
             $arpaConf = Configure::read('regtoscConf.arpaAuthenticator');
            
             $this->Authorization->skipAuthorization(); 
 
      
        $this->Authentication->logout();
        return $this->redirect($arpaConf['arpa'].'/logout?redirect_uri='.Router::url('/', true));
  
	}


    
  public function register($what = null) {
        $this->Authorization->skipAuthorization(); 
        $user = $this->Users->newEmptyEntity();   
        if ($this->request->is('post')) {
            
            $this->loadModel('Roles');
            $roles = $this->Roles->find()
                    ->where(['Roles.name' => 'inactive'])
                    ->first();
            if (!$roles) {
                ////$this->Session->setFlash(__('Invalid <inactive> group.'));
                $this->Flash->error(__('Invalid <inactive> group.'));
            }

            $user = $this->Users->patchEntity($user, $this->request->getData());
            //prendo password non criptata
            $password = $this->request->getData('password');
            if ($this->Users->save($user)) {
                //$this->Flash->success(__('The user has been saved.'));
                $this->set('password', $password);
                $this->set('info_utente', $user);
                //pagina di esito della registrazione
                return $this->render('/Users/esito_registrazione');
            } else 
            {
                $this->Flash->error(__("L'utente non puo' essere salvato o esiste gia'. Riprova."));
            }
        }    


            /*             * **
              $this->Flash->success(__('Your registration information was accepted.')." ".
              __('Please wait for administrators handling your request.'),'default',array('class'=>'success'));
              return $this->redirect(array('controller'=> 'pages','action'=>'display','home'));
             * *** */
      

        // prepara input registrazione 
        $this->loadModel('Roles');
        $roles = $this->Roles->find()
                ->where(['Roles.name' => 'inactive'])
                ->first();
        if (!$roles) {
            ////$this->Session->setFlash(__('Invalid <inactive> group.'));
            $this->Flash->error(__('Invalid <inactive> group.'));
        }
        $cf="";
        //  se in Session SSL con Smartcard inizializza il codice fiscale	
        if ($this->sslUserId) {
            
            $this->request->getData['User']['codice_fiscale'] = $this->sslUserId;
            //    

            $cf = $this->sslUserId;
            //  print_r($user) ; exit();
           
        }
        //  se in Session SSL con Arpa inizializza il codice fiscale	
    $arpaCf = $this->request->getSession()->read('arpaCf');
         
        if ($arpaCf) {
            
            $this->request->getData['User']['codice_fiscale'] = $arpaCf;
            //    

            $cf = $arpaCf;
            //  print_r($user) ; exit();
           
        } 
        
         $this->set(compact('cf'));
         $this->set(compact('user'));

   //     $this->request->getData['User']['role_id'] = $roles['Role']['id'];
        //$this->set(compact('groups'));
    }
    
   
    protected function logaccess($user) 
{
    try {
           $log = Configure::read('regtoscConf.logAccess');
        if ($log) {
            $server='www321.regione.toscana.it';
           $PageTitle = Configure::read('regtoscConf.pagetitle');
            $url=Router::url(null, true);
            $link = "http://" . $server . '/logrest/rest_logs.json';
            $data = null;
            $http = new Client();
            $data['Log']['name'] = $PageTitle;
            //$data['Log']['utente'] = $user;
            $data['Log']['utente'] = '';        //vuoto, per la privacy
            $data['Log']['url'] = $url;
            $data['Log']['log'] = $log;

            $data['User']['up']="a4462ba49f7f755d9e0479b27db886e1d285542d";

            $response = $http->post($link, $data,
                    [   'ssl_verify_host' => false,
                        'ssl_verify_peer' => false,
                        'ssl_verify_peer_name' => false,
                        'allow_self_signed' => true,
                        'timeout' => 2]
                    );
            $a=1;
            //$this->set('response_code', $response->code);
            //$this->set('response_body', $response->body);
        }
    } 
    catch (Exception $ex) {       
    }
}  
  
  public function homert()
     {
         return $this->redirect('http://www.regione.toscana.it');
     }    
  
 
    
    

}
