<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Cookie\Cookie;

/**
 * Libri Controller
 *
 * @property \App\Model\Table\LibriTable $Libri
 * @method \App\Model\Entity\Libro[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LibriController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Libri = $this->Libri->newEmptyEntity();
    $this->Authorization->authorize($Libri);
  
     $query = $this->Libri 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $libri = $this->paginate($query);

    //    $this->set(compact('libri'));
        
          
        $lingue = $this->Libri->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Libri->Autori->find('list', ['limit' => 200]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('libri', 'lingue', 'autori', 'categorie'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
    $Libri = $this->Libri->newEmptyEntity();
    $this->Authorization->authorize($Libri);
     
  //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');

          $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
  
     $query = $this->Libri 
     ->find('search', ['search' => $filtroCookie]);
    
    $query=$query->contain(['Lingue', 'Autori']);
        $libri = $query->toArray();

                
        
        
    //    $this->set(compact('libri'));
        
          
        $lingue = $this->Libri->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Libri->Autori->find('list', ['limit' => 200]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('libri', 'lingue', 'autori', 'categorie'));   
          
        
    }
    
        
    




    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Libri = $this->Libri->newEmptyEntity();
    $this->Authorization->authorize($Libri);
  
     $this->viewBuilder()->setLayout('/pdf/default');
        $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Libri 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $libri = $this->paginate($query);

    //    $this->set(compact('libri'));
        
          
        $lingue = $this->Libri->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Libri->Autori->find('list', ['limit' => 200]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('libri', 'lingue', 'autori', 'categorie'));   
          
        
    }
    
        
    



    /**
     * Esportaxls method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportaxls()
    {
    $Libri = $this->Libri->newEmptyEntity();
    $this->Authorization->authorize($Libri);
  
     $this->viewBuilder()->setLayout('/pdf/default');
    
       $filtroCookie = json_decode($this->request->getCookie('filtroCookie'));
     $query = $this->Libri 
     ->find('search', ['search' => $filtroCookie]);
     
     //   $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
     //   $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $libri = $this->paginate($query);

    //    $this->set(compact('libri'));
        
          
        $lingue = $this->Libri->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Libri->Autori->find('list', ['limit' => 200]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('libri', 'lingue', 'autori', 'categorie'));   
     
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $libro = $this->Libri->newEmptyEntity();
        $this->Authorization->authorize($libro);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
         $lingue = $this->Libri->Lingue->find('list', ['limit' => 0]);
         $autori = $this->Libri->Autori->find('list', ['limit' => 0]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
        $this->set(compact('libro', 'lingue', 'autori', 'categorie'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $libro = $this->Libri->patchEntity($libro, $this->request->getData());
            if ($this->Libri->save($libro)) {

  
                $this->Flash->success(__('The libro stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$libro'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $libro->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('libro non puo\' essere salvato, riprova'));
      
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
    
        $Libri = $this->Libri->newEmptyEntity();
        $this->Authorization->authorize($Libri);
        
         $Libri = $this->Libri->patchEntity($Libri, $this->request->getData());
         
         
         if (!($Libri->getErrors())) { 
        if ($this->Libri->save($Libri) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Libri->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
            flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Libri->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
            flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Libro id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $libro = $this->Libri->findById($id)->firstOrFail();
        $this->Authorization->authorize($libro);   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $libro = $this->Libri->get($id, [
            'contain' => ['Categorie'],
        ]);
                  if ($libro->lingua_id)  $lingue = $this->Libri->Lingue->find('list',['conditions' => ['id' => $libro->lingua_id]]);
                 else $lingue = $this->Libri->Lingue->find('list',['limit' => 0]);
          if ($libro->autore_id)  $autori = $this->Libri->Autori->find('list',['conditions' => ['id' => $libro->autore_id]]);
                 else $autori = $this->Libri->Autori->find('list',['limit' => 0]);
            
      $categorie = $this->Libri->Categorie->find('list')->innerJoinWith('Libri', function (\Cake\ORM\Query $query) use ($id) {
    return $query->where([
        'Libri.id' => $id,
    ]);
});
    
        $this->set(compact('libro', 'lingue', 'autori','categorie'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $libro = $this->Libri->patchEntity($libro, $this->request->getData());
            if ($this->Libri->save($libro)) {
                $this->Flash->success(__('The libro has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The libro could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Libro id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Libri = $this->Libri->newEmptyEntity();
     $this->Authorization->authorize($Libri);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $libro = $this->Libri->get($id, [
            'contain' => ['Lingue', 'Autori', 'Categorie'],
        ]);

        $this->set(compact('libro'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Libro id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $libro = $this->Libri->get($id);
        $response = $this->getResponse();
        if ($this->Libri->delete($libro)) {
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
    $Libri = $this->Libri->newEmptyEntity();
    $this->Authorization->authorize($Libri);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Libri 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $this->paginate = [
            'contain' => ['Lingue', 'Autori'],
        ];
        $libri = $this->paginate($query);

    //    $this->set(compact('libri'));
        
          
        $lingue = $this->Libri->Lingue->find('list', ['limit' => 200]);
        $autori = $this->Libri->Autori->find('list', ['limit' => 200]);
        $categorie = $this->Libri->Categorie->find('list', ['limit' => 200]);
       $this->set(compact('libri', 'lingue', 'autori', 'categorie'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $libro = $this->Libri->newEmptyEntity();
        $this->Authorization->authorize($libro);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $libro = $this->Libri->findById($return['returnid'])->firstOrFail();
        $nameTable->Libri->link($related,[$libro]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Libro id.
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
$libro=$this->Libri->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Libri
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Libri->$modelsource->unlink($libro, $q)) {
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
     * @param string|null $id Libro id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $libro = $this->Libri->get($id);
         $this->Authorization->authorize($libro);   
        if ($this->Libri->delete($libro)) {
            $this->Flash->success(__('The libro has been deleted.'));
        } else {
            $this->Flash->error(__('The libro could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
