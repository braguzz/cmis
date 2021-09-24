<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Autori Controller
 *
 * @property \App\Model\Table\AutoriTable $Autori
 * @method \App\Model\Entity\Autore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AutoriController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Autori = $this->Autori->newEmptyEntity();
    $this->Authorization->authorize($Autori);
  
     $query = $this->Autori 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Generi'],
        ];
        $autori = $this->paginate($query);

    //    $this->set(compact('autori'));
        
          
        $generi = $this->Autori->Generi->find('list', ['limit' => 200]);
       $this->set(compact('autori', 'generi'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Autori = $this->Autori->newEmptyEntity();
    $this->Authorization->authorize($Autori);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->Autori 
     ->find('search', ['search' => $filtroCookie]);
    
    $query=$query->contain(['Generi']);
        $autori = $query->toArray();

                
        
        
    //    $this->set(compact('autori'));
        
          
        $generi = $this->Autori->Generi->find('list', ['limit' => 200]);
       $this->set(compact('autori', 'generi'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Autori = $this->Autori->newEmptyEntity();
    $this->Authorization->authorize($Autori);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Autori 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Generi'],
        ];
        $autori = $this->paginate($query);

    //    $this->set(compact('autori'));
        
          
        $generi = $this->Autori->Generi->find('list', ['limit' => 200]);
       $this->set(compact('autori', 'generi'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Autori = $this->Autori->newEmptyEntity();
    $this->Authorization->authorize($Autori);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Autori 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Generi'],
        ];
        $autori = $this->paginate($query);

    //    $this->set(compact('autori'));
        
          
        $generi = $this->Autori->Generi->find('list', ['limit' => 200]);
       $this->set(compact('autori', 'generi'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $autore = $this->Autori->newEmptyEntity();
        $this->Authorization->authorize($autore);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
         $generi = $this->Autori->Generi->find('list', ['limit' => 0]);
        $this->set(compact('autore', 'generi'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $autore = $this->Autori->patchEntity($autore, $this->request->getData());
            if ($this->Autori->save($autore)) {

  
                $this->Flash->success(__('The autore stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$autore'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $autore->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('autore non puo\' essere salvato, riprova'));
      
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
    
        $Autori = $this->Autori->newEmptyEntity();
        $this->Authorization->authorize($Autori);
        
         $Autori = $this->Autori->patchEntity($Autori, $this->request->getData());
         
         
         if (!($Autori->getErrors())) { 
        if ($this->Autori->save($Autori) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Autori->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Autori->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Autore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $autore = $this->Autori
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($autore);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $autore = $this->Autori->get($id, [
            'contain' => [],
        ]);
                  if ($autore->genere_id)  $generi = $this->Autori->Generi->find('list',['conditions' => ['id' => $autore->genere_id]]);
                 else $generi = $this->Autori->Generi->find('list',['limit' => 0]);
        $this->set(compact('autore', 'generi'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $autore = $this->Autori->patchEntity($autore, $this->request->getData());
            if ($this->Autori->save($autore)) {
                $this->Flash->success(__('The autore has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The autore could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Autore id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Autori = $this->Autori->newEmptyEntity();
     $this->Authorization->authorize($Autori);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $autore = $this->Autori->get($id, [
            'contain' => ['Generi', 'Dischi', 'Libri'],
        ]);

        $this->set(compact('autore'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Autore id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $autore = $this->Autori->get($id);
        $response = $this->getResponse();
        if ($this->Autori->delete($autore)) {
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
    $Autori = $this->Autori->newEmptyEntity();
    $this->Authorization->authorize($Autori);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Autori 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Generi'],
        ];
        $autori = $this->paginate($query);

    //    $this->set(compact('autori'));
        
          
        $generi = $this->Autori->Generi->find('list', ['limit' => 200]);
       $this->set(compact('autori', 'generi'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $autore = $this->Autori->newEmptyEntity();
        $this->Authorization->authorize($autore);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $autore = $this->Autori->findById($return['returnid'])->firstOrFail();
        $nameTable->Autori->link($related,[$autore]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Autore id.
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
$autore=$this->Autori->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Autori
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Autori->$modelsource->unlink($autore, $q)) {
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
     * @param string|null $id Autore id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $autore = $this->Autori->get($id);
         $this->Authorization->authorize($autore);   
        if ($this->Autori->delete($autore)) {
            $this->Flash->success(__('The autore has been deleted.'));
        } else {
            $this->Flash->error(__('The autore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
