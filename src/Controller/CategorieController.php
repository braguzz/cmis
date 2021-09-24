<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Categorie Controller
 *
 * @property \App\Model\Table\CategorieTable $Categorie
 * @method \App\Model\Entity\Categoria[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategorieController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Categorie = $this->Categorie->newEmptyEntity();
    $this->Authorization->authorize($Categorie);
  
     $query = $this->Categorie 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $categorie = $this->paginate($query);

    //    $this->set(compact('categorie'));
        
          
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
       $this->set(compact('categorie', 'libri'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Categorie = $this->Categorie->newEmptyEntity();
    $this->Authorization->authorize($Categorie);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->Categorie 
     ->find('search', ['search' => $filtroCookie]);
    
        $categorie = $query->toArray();

                
        
        
    //    $this->set(compact('categorie'));
        
          
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
       $this->set(compact('categorie', 'libri'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Categorie = $this->Categorie->newEmptyEntity();
    $this->Authorization->authorize($Categorie);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Categorie 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $categorie = $this->paginate($query);

    //    $this->set(compact('categorie'));
        
          
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
       $this->set(compact('categorie', 'libri'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Categorie = $this->Categorie->newEmptyEntity();
    $this->Authorization->authorize($Categorie);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Categorie 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $categorie = $this->paginate($query);

    //    $this->set(compact('categorie'));
        
          
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
       $this->set(compact('categorie', 'libri'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoria = $this->Categorie->newEmptyEntity();
        $this->Authorization->authorize($categoria);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
        $this->set(compact('categoria', 'libri'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $categoria = $this->Categorie->patchEntity($categoria, $this->request->getData());
            if ($this->Categorie->save($categoria)) {

  
                $this->Flash->success(__('The categoria stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$categoria'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $categoria->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('categoria non puo\' essere salvato, riprova'));
      
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
    
        $Categorie = $this->Categorie->newEmptyEntity();
        $this->Authorization->authorize($Categorie);
        
         $Categorie = $this->Categorie->patchEntity($Categorie, $this->request->getData());
         
         
         if (!($Categorie->getErrors())) { 
        if ($this->Categorie->save($Categorie) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Categorie->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Categorie->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoria = $this->Categorie
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($categoria);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      

                $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
        $this->set(compact('categoria', 'libri'));
        $categoria = $this->Categorie->get($id, [
            'contain' => ['Libri'],
        ]);
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $categoria = $this->Categorie->patchEntity($categoria, $this->request->getData());
            if ($this->Categorie->save($categoria)) {
                $this->Flash->success(__('The categoria has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The categoria could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Categorie = $this->Categorie->newEmptyEntity();
     $this->Authorization->authorize($Categorie);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $categoria = $this->Categorie->get($id, [
            'contain' => ['Libri'],
        ]);

        $this->set(compact('categoria'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $categoria = $this->Categorie->get($id);
        $response = $this->getResponse();
        if ($this->Categorie->delete($categoria)) {
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
    $Categorie = $this->Categorie->newEmptyEntity();
    $this->Authorization->authorize($Categorie);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Categorie 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $categorie = $this->paginate($query);

    //    $this->set(compact('categorie'));
        
          
        $libri = $this->Categorie->Libri->find('list', ['limit' => 200]);
       $this->set(compact('categorie', 'libri'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $categoria = $this->Categorie->newEmptyEntity();
        $this->Authorization->authorize($categoria);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $categoria = $this->Categorie->findById($return['returnid'])->firstOrFail();
        $nameTable->Categorie->link($related,[$categoria]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Categoria id.
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
$categoria=$this->Categorie->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Categorie
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Categorie->$modelsource->unlink($categoria, $q)) {
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
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoria = $this->Categorie->get($id);
         $this->Authorization->authorize($categoria);   
        if ($this->Categorie->delete($categoria)) {
            $this->Flash->success(__('The categoria has been deleted.'));
        } else {
            $this->Flash->error(__('The categoria could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
