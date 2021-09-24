<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Cronoprog Controller
 *
 * @property \App\Model\Table\CronoprogTable $Cronoprog
 * @method \App\Model\Entity\Cronoprogramma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CronoprogController extends AppController
{
/* public $paginate = [
        'limit' => 25,
        'order' => [
            'Cronoprogramma.id' => 'asc'
        ]
    ];*/
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Cronoprog = $this->Cronoprog->newEmptyEntity();
    $this->Authorization->authorize($Cronoprog);
  
     $query = $this->Cronoprog 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $cronoprog = $this->paginate($query);

    //    $this->set(compact('cronoprog'));
        
          
       $this->set(compact('cronoprog'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Cronoprog = $this->Cronoprog->newEmptyEntity();
    $this->Authorization->authorize($Cronoprog);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->Cronoprog 
     ->find('search', ['search' => $filtroCookie]);
    
        $cronoprog = $query->toArray();

                
        
        
    //    $this->set(compact('cronoprog'));
        
          
       $this->set(compact('cronoprog'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Cronoprog = $this->Cronoprog->newEmptyEntity();
    $this->Authorization->authorize($Cronoprog);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Cronoprog 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $cronoprog = $this->paginate($query);

    //    $this->set(compact('cronoprog'));
        
          
       $this->set(compact('cronoprog'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Cronoprog = $this->Cronoprog->newEmptyEntity();
    $this->Authorization->authorize($Cronoprog);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Cronoprog 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $cronoprog = $query;

    //    $this->set(compact('cronoprog'));
        
          
       $this->set(compact('cronoprog'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cronoprogramma = $this->Cronoprog->newEmptyEntity();
        $this->Authorization->authorize($cronoprogramma);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
        $this->set(compact('cronoprogramma'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $cronoprogramma = $this->Cronoprog->patchEntity($cronoprogramma, $this->request->getData());
            if ($this->Cronoprog->save($cronoprogramma)) {

  
                $this->Flash->success(__('The cronoprogramma stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$cronoprogramma'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $cronoprogramma->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('cronoprogramma non puo\' essere salvato, riprova'));
      
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
    
        $Cronoprog = $this->Cronoprog->newEmptyEntity();
        $this->Authorization->authorize($Cronoprog);
        
         $Cronoprog = $this->Cronoprog->patchEntity($Cronoprog, $this->request->getData());
         
         
         if (!($Cronoprog->getErrors())) { 
        if ($this->Cronoprog->save($Cronoprog) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Cronoprog->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Cronoprog->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Cronoprogramma id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cronoprogramma = $this->Cronoprog
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($cronoprogramma);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $cronoprogramma = $this->Cronoprog->get($id, [
            'contain' => [],
        ]);
        
        $this->set(compact('cronoprogramma'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $cronoprogramma = $this->Cronoprog->patchEntity($cronoprogramma, $this->request->getData());
            if ($this->Cronoprog->save($cronoprogramma)) {
                $this->Flash->success(__('The cronoprogramma has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The cronoprogramma could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Cronoprogramma id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Cronoprog = $this->Cronoprog->newEmptyEntity();
     $this->Authorization->authorize($Cronoprog);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $cronoprogramma = $this->Cronoprog->get($id, [
            'contain' => ['Interventi'],
        ]);

        $this->set(compact('cronoprogramma'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Cronoprogramma id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $cronoprogramma = $this->Cronoprog->get($id);
        $response = $this->getResponse();
        if ($this->Cronoprog->delete($cronoprogramma)) {
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
    $Cronoprog = $this->Cronoprog->newEmptyEntity();
    $this->Authorization->authorize($Cronoprog);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Cronoprog 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $cronoprog = $this->paginate($query);

    //    $this->set(compact('cronoprog'));
        
          
       $this->set(compact('cronoprog'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $cronoprogramma = $this->Cronoprog->newEmptyEntity();
        $this->Authorization->authorize($cronoprogramma);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $cronoprogramma = $this->Cronoprog->findById($return['returnid'])->firstOrFail();
        $nameTable->Cronoprog->link($related,[$cronoprogramma]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Cronoprogramma id.
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
$cronoprogramma=$this->Cronoprog->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Cronoprog
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Cronoprog->$modelsource->unlink($cronoprogramma, $q)) {
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
     * @param string|null $id Cronoprogramma id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cronoprogramma = $this->Cronoprog->get($id);
         $this->Authorization->authorize($cronoprogramma);   
        if ($this->Cronoprog->delete($cronoprogramma)) {
            $this->Flash->success(__('The cronoprogramma has been deleted.'));
        } else {
            $this->Flash->error(__('The cronoprogramma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
