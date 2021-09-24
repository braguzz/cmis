<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Dischi Controller
 *
 * @property \App\Model\Table\DischiTable $Dischi
 * @method \App\Model\Entity\Disco[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DischiController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * 
     * 
     */
    
     public $paginate = [
        'limit' => 25,
        'order' => [
            'Disco.id' => 'asc'
        ]
    ];
    
    public function index()
    {
    $Dischi = $this->Dischi->newEmptyEntity();
    $this->Authorization->authorize($Dischi);
  
     $query = $this->Dischi 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $dischi = $this->paginate($query);

    //    $this->set(compact('dischi'));
        
          
        $lingue = $this->Dischi->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Dischi->Autori->find('list', ['limit' => 200]);
       $this->set(compact('dischi', 'lingue', 'autori'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Dischi = $this->Dischi->newEmptyEntity();
    $this->Authorization->authorize($Dischi);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = $this->request->getCookie('filtroCookie');
  
     $query = $this->Dischi 
     ->find('search', ['search' => $filtroCookie]);
    
    $query=$query->contain(['Lingue', 'Autori']);
        $dischi = $query->toArray();

                
        
        
    //    $this->set(compact('dischi'));
        
          
        $lingue = $this->Dischi->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Dischi->Autori->find('list', ['limit' => 200]);
       $this->set(compact('dischi', 'lingue', 'autori'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Dischi = $this->Dischi->newEmptyEntity();
    $this->Authorization->authorize($Dischi);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
     $query = $this->Dischi 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $dischi = $this->paginate($query);

    //    $this->set(compact('dischi'));
        
          
        $lingue = $this->Dischi->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Dischi->Autori->find('list', ['limit' => 200]);
       $this->set(compact('dischi', 'lingue', 'autori'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Dischi = $this->Dischi->newEmptyEntity();
    $this->Authorization->authorize($Dischi);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
     $query = $this->Dischi 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $dischi = $this->paginate($query);

    //    $this->set(compact('dischi'));
        
          
        $lingue = $this->Dischi->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Dischi->Autori->find('list', ['limit' => 200]);
       $this->set(compact('dischi', 'lingue', 'autori'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $disco = $this->Dischi->newEmptyEntity();
        $this->Authorization->authorize($disco);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
         $lingue = $this->Dischi->Lingue->find('list', ['limit' => 0]);
         $autori = $this->Dischi->Autori->find('list', ['limit' => 0]);
        $this->set(compact('disco', 'lingue', 'autori'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $disco = $this->Dischi->patchEntity($disco, $this->request->getData());
            if ($this->Dischi->save($disco)) {

  
                $this->Flash->success(__('The disco stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$disco'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $disco->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('disco non puo\' essere salvato, riprova'));
      
            }
        }  
        
        
        
        
        
        
        
    }

public function add_ajax_belong() 
    {
   
    }
/**-----------------------------------------------------------------------------
 * addfromadd method
 * Per aggiungere  provenendo dalla vista add ( o edit) di una altra tabella
 * viene chiamata dal controller add di questo Controller nel caso venga chiamato 
 * da un add di un altro Controller. In casi come questi la add di questo Controller
 * visualizza la vista add_ajax_belong.ctp che per salvare utilizza via ajax addfromadd()
 * @return void
 *----------------------------------------------------------------------------*/    
    public function addfromadd() 
    { 
        $this->autoRender = false;
        $return=$this->request->getParam('pass');
        if (empty($return)) {
            $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
    
        $Dischi = $this->Dischi->newEmptyEntity();
        $this->Authorization->authorize($Dischi);
        
         $Dischi = $this->Dischi->patchEntity($Dischi, $this->request->getData());
         
         
         if (!($Dischi->getErrors())) { 
        if ($this->Dischi->save($Dischi) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Dischi->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Dischi->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Disco id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $disco = $this->Dischi
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($disco);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      

                  if ($disco->lingua_id)  $lingue = $this->Dischi->Lingue->find('list',['conditions' => ['id' => $disco->lingua_id]]);
                 else $lingue = $this->Dischi->Lingue->find('list',['limit' => 0]);
          if ($disco->autore_id)  $autori = $this->Dischi->Autori->find('list',['conditions' => ['id' => $disco->autore_id]]);
                 else $autori = $this->Dischi->Autori->find('list',['limit' => 0]);
        $this->set(compact('disco', 'lingue', 'autori'));
        $disco = $this->Dischi->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $disco = $this->Dischi->patchEntity($disco, $this->request->getData());
            if ($this->Dischi->save($disco)) {
                $this->Flash->success(__('The disco has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The disco could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Disco id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Dischi = $this->Dischi->newEmptyEntity();
     $this->Authorization->authorize($Dischi);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $disco = $this->Dischi->get($id, [
            'contain' => ['Lingue', 'Autori'],
        ]);

        $this->set(compact('disco'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Disco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $disco = $this->Dischi->get($id);
        $response = $this->getResponse();
        if ($this->Dischi->delete($disco)) {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'0', 'id'=> $id]  ) );
            flush();
            } else {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'1', 'id'=> $id]  ) );
            flush();   
            }
        }
    }



    /**
     * Indexexternal method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexexternal()
    {
    $Dischi = $this->Dischi->newEmptyEntity();
    $this->Authorization->authorize($Dischi);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Dischi 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $dischi = $this->paginate($query);

    //    $this->set(compact('dischi'));
        
          
        $lingue = $this->Dischi->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Dischi->Autori->find('list', ['limit' => 200]);
       $this->set(compact('dischi', 'lingue', 'autori'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $disco = $this->Dischi->newEmptyEntity();
        $this->Authorization->authorize($disco);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $disco = $this->Dischi->findById($return['returnid'])->firstOrFail();
        $nameTable->Dischi->link($related,[$disco]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Disco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removehabtmajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $response = $this->getResponse();
        $return=$this->request->getData();
        $return = $return['data'];
        if (empty($return['modelsource']))
        {           $return['modelsource']=""; 
                    $return['from']=""; 
                    $return['fromid']=""; 
                    $return['souceid']="";   
        }
$disco=$this->Dischi->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Dischi
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Dischi->$modelsource->unlink($disco, $q)) {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'0', 'id'=> $id]  ) );
            flush();
            } else {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'1', 'id'=> $id]  ) );
            flush();   
            }
        }
    }


    /**
     * Delete method
     *
     * @param string|null $id Disco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $disco = $this->Dischi->get($id);
         $this->Authorization->authorize($disco);   
        if ($this->Dischi->delete($disco)) {
            $this->Flash->success(__('The disco has been deleted.'));
        } else {
            $this->Flash->error(__('The disco could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
