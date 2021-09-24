<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Allocations Controller
 *
 * @property \App\Model\Table\AllocationsTable $Allocations
 * @method \App\Model\Entity\Allocation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AllocationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Allocations = $this->Allocations->newEmptyEntity();
    $this->Authorization->authorize($Allocations);
  
     $query = $this->Allocations 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Devices', 'Owners'],
        ];
        $allocations = $this->paginate($query);

    //    $this->set(compact('allocations'));
        
          
        $devices = $this->Allocations->Devices->find('list', ['limit' => 200]);
        $owners = $this->Allocations->Owners->find('list', ['limit' => 200]);
       $this->set(compact('allocations', 'devices', 'owners'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Allocations = $this->Allocations->newEmptyEntity();
    $this->Authorization->authorize($Allocations);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->Allocations 
     ->find('search', ['search' => $filtroCookie]);
    
    $query=$query->contain(['Devices', 'Owners']);
        $allocations = $query->toArray();

                
        
        
    //    $this->set(compact('allocations'));
        
          
        $devices = $this->Allocations->Devices->find('list', ['limit' => 200]);
        $owners = $this->Allocations->Owners->find('list', ['limit' => 200]);
       $this->set(compact('allocations', 'devices', 'owners'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Allocations = $this->Allocations->newEmptyEntity();
    $this->Authorization->authorize($Allocations);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Allocations 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Devices', 'Owners'],
        ];
        $allocations = $this->paginate($query);

    //    $this->set(compact('allocations'));
        
          
        $devices = $this->Allocations->Devices->find('list', ['limit' => 200]);
        $owners = $this->Allocations->Owners->find('list', ['limit' => 200]);
       $this->set(compact('allocations', 'devices', 'owners'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Allocations = $this->Allocations->newEmptyEntity();
    $this->Authorization->authorize($Allocations);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Allocations 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Devices', 'Owners'],
        ];
        $allocations = $this->paginate($query);

    //    $this->set(compact('allocations'));
        
          
        $devices = $this->Allocations->Devices->find('list', ['limit' => 200]);
        $owners = $this->Allocations->Owners->find('list', ['limit' => 200]);
       $this->set(compact('allocations', 'devices', 'owners'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $allocation = $this->Allocations->newEmptyEntity();
        $this->Authorization->authorize($allocation);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
         $devices = $this->Allocations->Devices->find('list', ['limit' => 0]);
         $owners = $this->Allocations->Owners->find('list', ['limit' => 0]);
        $this->set(compact('allocation', 'devices', 'owners'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->getData());
            if ($this->Allocations->save($allocation)) {

  
                $this->Flash->success(__('The allocation stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$allocation'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $allocation->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('allocation non puo\' essere salvato, riprova'));
      
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
    
        $Allocations = $this->Allocations->newEmptyEntity();
        $this->Authorization->authorize($Allocations);
        
         $Allocations = $this->Allocations->patchEntity($Allocations, $this->request->getData());
         
         
         if (!($Allocations->getErrors())) { 
        if ($this->Allocations->save($Allocations) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Allocations->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Allocations->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Allocation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $allocation = $this->Allocations
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($allocation);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $allocation = $this->Allocations->get($id, [
            'contain' => [],
        ]);
                          if ($allocation->device_id)  $devices = $this->Allocations->Devices->find('list',['conditions' => ['id' => $allocation->device_id]]);
                         else $devices = $this->Allocations->Devices->find('list',['limit' => 0]);
                          if ($allocation->owner_id)  $owners = $this->Allocations->Owners->find('list',['conditions' => ['id' => $allocation->owner_id]]);
                         else $owners = $this->Allocations->Owners->find('list',['limit' => 0]);
        
        $this->set(compact('allocation', 'devices', 'owners'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->getData());
            if ($this->Allocations->save($allocation)) {
                $this->Flash->success(__('The allocation has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The allocation could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Allocation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Allocations = $this->Allocations->newEmptyEntity();
     $this->Authorization->authorize($Allocations);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $allocation = $this->Allocations->get($id, [
            'contain' => ['Devices', 'Owners', 'Querynomail', 'Rifproceduras'],
        ]);

        $this->set(compact('allocation'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Allocation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $allocation = $this->Allocations->get($id);
        $response = $this->getResponse();
        if ($this->Allocations->delete($allocation)) {
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
    $Allocations = $this->Allocations->newEmptyEntity();
    $this->Authorization->authorize($Allocations);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Allocations 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Devices', 'Owners'],
        ];
        $allocations = $this->paginate($query);

    //    $this->set(compact('allocations'));
        
          
        $devices = $this->Allocations->Devices->find('list', ['limit' => 200]);
        $owners = $this->Allocations->Owners->find('list', ['limit' => 200]);
       $this->set(compact('allocations', 'devices', 'owners'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $allocation = $this->Allocations->newEmptyEntity();
        $this->Authorization->authorize($allocation);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $allocation = $this->Allocations->findById($return['returnid'])->firstOrFail();
        $nameTable->Allocations->link($related,[$allocation]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Allocation id.
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
$allocation=$this->Allocations->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Allocations
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Allocations->$modelsource->unlink($allocation, $q)) {
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
     * @param string|null $id Allocation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $allocation = $this->Allocations->get($id);
         $this->Authorization->authorize($allocation);   
        if ($this->Allocations->delete($allocation)) {
            $this->Flash->success(__('The allocation has been deleted.'));
        } else {
            $this->Flash->error(__('The allocation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
