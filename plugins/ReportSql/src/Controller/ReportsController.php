<?php
declare(strict_types=1);

namespace ReportSql\Controller;

use ReportSql\Controller\AppController;

use Cake\Http\Cookie\Cookie;
use Cake\Datasource\ConnectionManager;

/**
 * Reports Controller
 *
 * @property \ReportSql\Model\Table\ReportsTable $Reports
 * @method \ReportSql\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

     public function adminRun_nopagination($id = null)
    {
        $report = $this->Reports->get($id); 
        $strsql=$report->get('strsql');
        $name=$report->get('name');
        $db=$report->get('db');
        $strdacamb=$strsql;
        preg_match_all("~<tag>(.*?)</tag>~", $strdacamb, $parametri);
        $parametri[0]=array_unique($parametri[0]);
        $parametri[1]=array_unique($parametri[1]);
        $cambia=$this->request->getData();
      
        if ((!empty($cambia)) &&  ($this->request->is(['patch', 'post', 'put']))) {
            foreach ($parametri[1] as $str) {
                $dacambiare = $cambia[$str];
                $stri = '<tag>' . $str . '</tag>';
                $out = str_replace($stri, $dacambiare, $strdacamb);
                $strdacamb = $out;
            }
        }
        $pagination = new \Zebra_Pagination();
        
        
        $strsql=str_replace(";","",$strdacamb);
        $this->Reports->parametripaginazione = new \stdClass();
        $this->Reports->parametripaginazione->strsql= $strsql;
        $this->Reports->parametripaginazione->name = $name;
        $this->Reports->parametripaginazione->limit = '20';  
        $this->Reports->parametripaginazione->db = $db;  
        $this->Reports->parametripaginazione->page = 1;

        $results= $this->Reports->run();
        $this->set(compact('results','report','parametri', 'strsql'));
      
     }
    
    
       public function adminRun($id = null)
    {
        $report = $this->Reports->get($id); 
        $strsql=$report->get('strsql');
        $name=$report->get('name');
        $db=$report->get('db');
        $strdacamb=$strsql;
        preg_match_all("~<tag>(.*?)</tag>~", $strdacamb, $parametri);
        $parametri[0]=array_unique($parametri[0]);
        $parametri[1]=array_unique($parametri[1]);
        $cambia=$this->request->getQuery();
      
        if ((!empty($cambia)) &&  ($this->request->is(['get']))) {
            foreach ($parametri[1] as $str) {
                $dacambiare = $cambia[$str];
                $stri = '<tag>' . $str . '</tag>';
                $out = str_replace($stri, $dacambiare, $strdacamb);
                $strdacamb = $out;

            }
        }
        $strsql=str_replace(";","",$strdacamb);
        $cookiestrsql=Cookie::create('strsqlCookie', $strsql);
        $cookiedb=Cookie::create('dbCookie', $db);
        $this->response = $this->response->withCookie($cookiestrsql);
        $this->response = $this->response->withCookie($cookiedb);
        $records_per_page = 10;
        $pagination = new \Zebra_Pagination();
        $sql = $strsql . '  LIMIT
        ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
        ';
         $sqlcount = $strsql;
        
        $conn = ConnectionManager::get($db);
	try {
            // execute dangerous sql
            $results = $conn->execute($sql)->fetchAll('assoc');
            $count = $conn->execute($sqlcount)->count();
        } catch (\PDOException $Exception) {
            // custom error handling here...
             $results= FALSE;
             $count=FALSE;
        }
        $pagination->records($count);
        $pagination->records_per_page($records_per_page);
        $this->set(compact('results','report','parametri', 'strsql','pagination'));
      
     }
  
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
    $Reports = $this->Reports->newEmptyEntity();
    $this->Authorization->authorize($Reports);
  
     $query = $this->Reports 
     ->find('search', ['search' => $this->request->getQueryParams()]);
     
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $reports = $this->paginate($query);

    //    $this->set(compact('reports'));
        
          
       $this->set(compact('reports'));   
          
        
    }
    
        
    

   /**
     * Esportacsv method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
     
   
    public function esportacsv()
    {
        
    $Reports = $this->Reports->newEmptyEntity();
    $this->Authorization->authorize($Reports); 
    //aumenta il tempo massimo consentito per l'esecuzione (default 120 secondi)
        ini_set('max_execution_time', '600');    //in secondi
        //aumenta la memoria
        ini_set('memory_limit', '512M');
        $cookies = $this->request->getCookieParams();
        $dbCookie = $cookies['dbCookie'];
      $strsqlCookie = $cookies['strsqlCookie'];
     $conn = ConnectionManager::get($dbCookie);
	try {
            // execute dangerous sql
            $results = $conn->execute($strsqlCookie)->fetchAll('assoc');
        } catch (\PDOException $Exception) {
            // custom error handling here...
             $results= FALSE;
            
        }
     
       $this->set(compact('results'));   
          
        
    }
    
    /**
     * Esportapdf method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function esportapdf()
    {
    $Reports = $this->Reports->newEmptyEntity();
    $this->Authorization->authorize($Reports);
  
     $this->viewBuilder()->setLayout('/pdf/default');
       $cookies = $this->request->getCookieParams();
        $dbCookie = $cookies['dbCookie'];
      $strsqlCookie = $cookies['strsqlCookie'];
     $conn = ConnectionManager::get($dbCookie);
	try {
            // execute dangerous sql
            $results = $conn->execute($strsqlCookie)->fetchAll('assoc');
        } catch (\PDOException $Exception) {
            // custom error handling here...
             $results= FALSE;
            
        }
       $this->set(compact('results'));        
        
    }
    
      

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $report = $this->Reports->newEmptyEntity();
        $this->Authorization->authorize($report);
        
        $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
    
        $this->set(compact('report'));

        // se e' ajax proviene da un add di un altra tabella
        if ($this->request->is('ajax')) {
                $return = $this->request->getParam('pass');
                $this->render('addAjaxBelong');
            } 
        else if ($this->request->is(array('post', 'put')) && in_array($return['returnsaveme'],["",1,"1"] )) 
         {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {

  
                $this->Flash->success(__('The report stato salvato.'));                              
                 if ($return['returncontrollerid']<>"")
                    {    
                    //se $return['returncontrollerid'] non e' vuoto significa che sono qui dalla view di un altra tabella
                    //prendo l'id e il controller che passo nel form e faccio un redirect su quell id, controller e tab di provenienza
                    $id=$return['returncontrollerid'];
                    $action=$return['returnaction'];
                    $controller=$return['returncontroller'];
                    return $this->redirect(array('action' =>$action,'controller'=>$controller, $id, 'tab' => '$report'));
                    }
                  else
                    {
                        //redirezione in base al bottone premuto -
                        if(isset($return['submit_ok'])) return $this->redirect(array('action' => 'index'));
                        if(isset($return['submit_ok_piu'])) return $this->redirect(array('action' => 'add'));
                        if(isset($return['submit_ok_mod'])) return $this->redirect(array('action' => 'view', $report->id));   
                   
                    } 

            } 
            else 
            {
                $this->Flash->error(__('report non puo\' essere salvato, riprova'));
      
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
    
        $Reports = $this->Reports->newEmptyEntity();
        $this->Authorization->authorize($Reports);
        
         $Reports = $this->Reports->patchEntity($Reports, $this->request->getData());
         
         
         if (!($Reports->getErrors())) { 
        if ($this->Reports->save($Reports) )
            {
            $this->Flash->success(__('salvato'));
            $st = $Reports->toArray();
            $response = $this->getResponse();      
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                ->withStringBody( json_encode( $st ) );
           // flush();
            } 
        
         } else {
        // didn't validate logic
            $errors["ko"] = $this->Reports->validationErrors;
            $this->autoRender = false;
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode( $errors ) );
           // flush();
        }

    }
        
        
        
        
        
        
      
    /**
     * Edit method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $report = $this->Reports
                                   ->findById($id)
                                   ->firstOrFail();
        $this->Authorization->authorize($report);   
   
      $return=$this->request->getData();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);      
        $report = $this->Reports->get($id, [
            'contain' => [],
        ]);
        
        $this->set(compact('report'));
      
        if ($this->request->is(['patch', 'post', 'put']) && in_array($return['returnsaveme'],["",1,"1"] ))  {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                $this->Flash->success(__('The report has been saved.'));
                $session = $this->request->getSession();
                $sendback = $session->read('referer');
                $session->delete('referer');
                return $this->redirect( $sendback );    
            }
            $this->Flash->error(__('The report could not be saved. Please, try again.'));
        }
          else  { $session = $this->request->getSession();
        $session->write('referer', $this->referer());   
 }
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     $Reports = $this->Reports->newEmptyEntity();
     $this->Authorization->authorize($Reports);
     $return = $this->request->getParam('pass');
        if (empty($return['tab'])) {
            $return['tab'] = "";
        }   
     $this->set('return',$return);  
        $report = $this->Reports->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('report'));
    }

    /**
     * removeajaxbelong method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function removeajaxbelong($id = null)
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        if ($this->request->is('ajax')) {  
        $report = $this->Reports->get($id);
        $response = $this->getResponse();
        if ($this->Reports->delete($report)) {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'0', 'id'=> $id]  ) );
           // flush();
            } else {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'1', 'id'=> $id]  ) );
           // flush();   
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
    $Reports = $this->Reports->newEmptyEntity();
    $this->Authorization->authorize($Reports);
    
      $return=$this->request->getQueryParams();
        if (empty($return['returncontroller']))
        {         $return['returncontrollerid']="";
                  $return['returnmodel']="";
                  $return['returnaction']="";
                  $return['returncontroller']="";
                  $return['returnsaveme']="";
        }
        $this->set('return',$return);     
  

          $query = $this->Reports 
                    ->find('search', ['search' => $this->request->getQueryParams()])
                    ->notMatching($return['returnmodel'], function ($q) use ($return) {
                    return $q->where([$return['returnmodel'] . '.id' => $return['returncontrollerid']]);
                    });
    
        $cookie = Cookie::create('filtroCookie', $this->request->getQueryParams());
        $this->response = $this->response->withCookie($cookie); 
        
        $reports = $this->paginate($query);

    //    $this->set(compact('reports'));
        
          
       $this->set(compact('reports'));   
          
        
    }
    
        
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addhabtm()
    {
        $report = $this->Reports->newEmptyEntity();
        $this->Authorization->authorize($report);
        $this->autoRender = false; 
        $return=$this->request->getData();
        if (empty($return['returnid']))
        {   $return['id'] = "";
            $return['returnid'] = "";
            $return['return'] = "";
        }
        $nameTable = $this->getTableLocator()->get($return['return']);
        $related=$nameTable->findById($return['id'])->firstOrFail();
        $report = $this->Reports->findById($return['returnid'])->firstOrFail();
        $nameTable->Reports->link($related,[$report]);
        return $this->redirect(array('action' => 'view', $return['returnid']));
      
    }


    /**
     * removehabtmajaxbelong method
     *
     * @param string|null $id Report id.
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
$report=$this->Reports->get($return['fromid']);   
$modelsource=strval($return['modelsource']); 
$sourceid=+$return['sourceid']; 
$q = $this->Reports
        ->$modelsource
        ->findById($sourceid)->toList();           
        if ($this->Reports->$modelsource->unlink($report, $q)) {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'0', 'id'=> $id]  ) );
          //  flush();
            } else {
            return $response->withType( 'application/json' )
                             ->withStringBody( json_encode(  ['error'=>'1', 'id'=> $id]  ) );
          //  flush();   
            }
        }
    }


    /**
     * Delete method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $report = $this->Reports->get($id);
         $this->Authorization->authorize($report);   
        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
