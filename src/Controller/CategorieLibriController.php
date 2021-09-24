<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * CategorieLibri Controller
 *
 * @property \App\Model\Table\CategorieLibriTable $CategorieLibri
 * @method \App\Model\Entity\CategorieLibro[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategorieLibriController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
    $this->Authorization->authorize($CategorieLibri);
  
     $query = $this->CategorieLibri 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Libri', 'Categorie'],
        ];
        $categorieLibri = $this->paginate($query);

    //    $this->set(compact('categorieLibri'));
        
          
        $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 200]);
        $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('categorieLibri', 'libri', 'categorie'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
    $this->Authorization->authorize($CategorieLibri);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->CategorieLibri 
     ->find('search', ['search' => $filtroCookie]);
    
    $query=$query->contain(['Libri', 'Categorie']);
        $categorieLibri = $query->toArray();

                
        
        
    //    $this->set(compact('categorieLibri'));
        
          
        $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 200]);
        $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('categorieLibri', 'libri', 'categorie'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
    $this->Authorization->authorize($CategorieLibri);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->CategorieLibri 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Libri', 'Categorie'],
        ];
        $categorieLibri = $this->paginate($query);

    //    $this->set(compact('categorieLibri'));
        
          
        $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 200]);
        $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('categorieLibri', 'libri', 'categorie'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
    $this->Authorization->authorize($CategorieLibri);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->CategorieLibri 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Libri', 'Categorie'],
        ];
        $categorieLibri = $this->paginate($query);

    //    $this->set(compact('categorieLibri'));
        
          
        $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 200]);
        $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('categorieLibri', 'libri', 'categorie'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categorieLibro = $this->CategorieLibri->newEmptyEntity();
        $this->Authorization->authorize($categorieLibro);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
         $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 0]);
         $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 0]);
        $this->set(compact('categorieLibro', 'libri', 'categorie'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $categorieLibro = $this->CategorieLibri->patchEntity($categorieLibro, $this->request->getData());
            if ($this->CategorieLibri->save($categorieLibro)) {

  
                $this->Flash->success(__('The categorie libro stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$categorieLibro'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $categorieLibro->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('categorieLibro non puo\' essere salvato, riprova'));
      
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
    
        $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
        $this->Authorization->authorize($CategorieLibri);
        
         $CategorieLibri = $this->CategorieLibri->patchEntity($CategorieLibri, $this->request->getData());
         
         
         if (!($CategorieLibri->getErrors())) { 
        if ($this->CategorieLibri->save($CategorieLibri) )
            {
            $this->Flash->success(__('salvato'));
            $st = $CategorieLibri->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->CategorieLibri->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Categorie Libro id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categorieLibro = $this->CategorieLibri
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($categorieLibro);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $categorieLibro = $this->CategorieLibri->get($id, [
            'contain' => [],
        ]);
                  if ($categorieLibro->libro_id)  $libri = $this->CategorieLibri->Libri->find('list',['conditions' => ['id' => $categorieLibro->libro_id]]);
                 else $libri = $this->CategorieLibri->Libri->find('list',['limit' => 0]);
          if ($categorieLibro->categoria_id)  $categorie = $this->CategorieLibri->Categorie->find('list',['conditions' => ['id' => $categorieLibro->categoria_id]]);
                 else $categorie = $this->CategorieLibri->Categorie->find('list',['limit' => 0]);
        $this->set(compact('categorieLibro', 'libri', 'categorie'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $categorieLibro = $this->CategorieLibri->patchEntity($categorieLibro, $this->request->getData());
            if ($this->CategorieLibri->save($categorieLibro)) {
                $this->Flash->success(__('The categorie libro has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The categorie libro could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Categorie Libro id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
     $this->Authorization->authorize($CategorieLibri);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $categorieLibro = $this->CategorieLibri->get($id, [
            'contain' => ['Libri', 'Categorie'],
        ]);

        $this->set(compact('categorieLibro'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Categorie Libro id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $categorieLibro = $this->CategorieLibri->get($id);
        $response = $this->getResponse();
        if ($this->CategorieLibri->delete($categorieLibro)) {
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
    $CategorieLibri = $this->CategorieLibri->newEmptyEntity();
    $this->Authorization->authorize($CategorieLibri);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->CategorieLibri 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Libri', 'Categorie'],
        ];
        $categorieLibri = $this->paginate($query);

    //    $this->set(compact('categorieLibri'));
        
          
        $libri = $this->CategorieLibri->Libri->find('list', ['limit' => 200]);
        $categorie = $this->CategorieLibri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('categorieLibri', 'libri', 'categorie'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $categorieLibro = $this->CategorieLibri->newEmptyEntity();
        $this->Authorization->authorize($categorieLibro);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $categorieLibro = $this->CategorieLibri->findById($return['returnid'])->firstOrFail();
        $nameTable->CategorieLibri->link($related,[$categorieLibro]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Categorie Libro id.
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
$categorieLibro=$this->CategorieLibri->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->CategorieLibri
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->CategorieLibri->$modelsource->unlink($categorieLibro, $q)) {
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
     * @param string|null $id Categorie Libro id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categorieLibro = $this->CategorieLibri->get($id);
         $this->Authorization->authorize($categorieLibro);   
        if ($this->CategorieLibri->delete($categorieLibro)) {
            $this->Flash->success(__('The categorie libro has been deleted.'));
        } else {
            $this->Flash->error(__('The categorie libro could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
