<?php
declare(strict_types=1);

namespace App\Controller;
/*
 * Autocomplete Controller
 *
 */
class AutocompleteController extends AppController {


 
   /* Cerca il termine nella tabella
    * @param $model
    * @param $field
    * @return void
    */ 
    public function fetch($model, $field) 
    {     
        
        if ($this->request->is('ajax')) 
        { 
            // avoid fetch.ctp  view file 
            //Configure::write('debug', 0);
          
            $results = array();           //output data init

            //legge il termine di ricerca dal FORM
            $termine = trim($_GET['term']); 

            //prepara il termine di ricerca per la LIKE di MySQL
            if(strpos($termine, "*") !== false)
            {
                //se la stringa di ricerca contiene ASTERISCHI, li sostituisce con "%"
                $termine_ricerca_sql = str_replace("*", "%", $termine);
            }
            else
            {
                //alrimenti mette % all'inizio e alla fine
                $termine_ricerca_sql = '%' . $termine . '%';
            }

            //prepara la scringa per la ricerca su MySQL
           $this->loadModel($model);
            $tipo_colonna = $this->$model->getSchema()->getColumnType($field);
            switch($tipo_colonna) 
            {
                case 'date':
                    $stringa_ricerca_sql = "DATE_FORMAT(" . $model . "." . $field . ", '%d/%m/%Y')  LIKE '" . $termine_ricerca_sql . "'";
                    break;
                case 'datetime':
                    $stringa_ricerca_sql = "DATE_FORMAT(" . $model . "." . $field . ", '%d/%m/%Y %H:%i')  LIKE '" . $termine_ricerca_sql . "'";
                    break;
                default:
                    $stringa_ricerca_sql = $model . "." . $field . " LIKE '" . $termine_ricerca_sql . "'";
                    break;
            }

            //esegue la query SQL
            $rows = $this->$model->find('all', array(
                'conditions'=>array(
                    // $model . "." . $field . " LIKE '%" . $termine . "%'"
                    $stringa_ricerca_sql
                ),
                'limit'     => '100',
                'recursive' => '-1',
                'fields'    => array('id', $field),
                'group'     => array($field),               //GROUP BY (per eliminare i duplicati)
                'order'     => array($model.".".$field)
            ));
            
            if(!empty($rows)) 
            {
                $i=0;
                foreach($rows as $row) 
                {
                    $testo = $row->$field;
                    if (is_numeric($testo)) {
                            $testo= strval($testo);
                    }
                    if(strlen($testo) > 0)
                    {
                        $results[$i]['value'] = $row->id;
                        $results[$i]['label'] = $testo;
                        $i++;
                    }
                }
            }

            // scrivi_nel_log( json_encode($results) ); 
$response = $this->getResponse();      
$this->autoRender = false;
return $response->withType( 'application/json' )
    ->withStringBody( json_encode( $results ) );
         //   flush();
        }
    }

 public function fetchselect2($model, $field) 
    {     
        
        if ($this->request->is('ajax') || TRUE) 
        { 
            // avoid fetch.ctp  view file 
            //Configure::write('debug', 0);
          
            $results = array();           //output data init
            $numperpage=20;
           //   $page = $_GET['page'];
           empty($_GET['page']) ? $page=1 : $page=intval($_GET['page']);
            
            //legge il termine di ricerca dal FORM
             empty($_GET['search']) ? $termine="" : $termine=trim($_GET['search']);


            //prepara il termine di ricerca per la LIKE di MySQL
            if(strpos($termine, "*") !== false)
            {
                //se la stringa di ricerca contiene ASTERISCHI, li sostituisce con "%"
                $termine_ricerca_sql = str_replace("*", "%", $termine);
            } 
            else
            {
                //alrimenti mette % all'inizio e alla fine
                $termine_ricerca_sql = '%' . $termine . '%';
            }
          

            //prepara la scringa per la ricerca su MySQL
           $this->loadModel($model);
           $tipo_colonna = $this->$model->getSchema()->getColumnType($field);
          
            switch($tipo_colonna) 
            {
                case 'date':
                    $stringa_ricerca_sql = "DATE_FORMAT(" . $model . "." . $field . ", '%d/%m/%Y')  LIKE '" . $termine_ricerca_sql . "'";
                    break;
                case 'datetime':
                    $stringa_ricerca_sql = "DATE_FORMAT(" . $model . "." . $field . ", '%d/%m/%Y %H:%i')  LIKE '" . $termine_ricerca_sql . "'";
                    break;
                default:
                    $stringa_ricerca_sql = $model . "." . $field . " LIKE '" . $termine_ricerca_sql . "'";
                    break;
            }
  
            if ($termine=="")
            {           
                 $rows = $this->$model->find('all', array(
                'limit'     => $numperpage,
                 'page'  => $page,
                'recursive' => '-1',
                'fields'    => array('id', $field),
                'group'     => array($field),               //GROUP BY (per eliminare i duplicati)
                'order'     => array($model.".".$field)
            ));
                $totalrows=$this->$model->find()->count(); 
            }  
            else
             {   
           
            //esegue la query SQL
            $rows = $this->$model->find('all', array(
                'conditions'=>array(
                    // $model . "." . $field . " LIKE '%" . $termine . "%'"
                    $stringa_ricerca_sql
                ),
                'limit'     => $numperpage,
                 'page'  => $page,
                'recursive' => '-1',
                'fields'    => array('id', $field),
                'group'     => array($field),               //GROUP BY (per eliminare i duplicati)
                'order'     => array($model.".".$field)
            ));
            $totalrows=$this->$model->find('all', array(
                'conditions'=>array(
                    $stringa_ricerca_sql
                ),'group'     => array($field), ))->count();
            }
 
            $offset = ($page - 1) * $numperpage;
            $endCount = $offset + $numperpage;
            $morePages = $endCount < $totalrows;
            
            if(!empty($rows)) 
            {
                $i=0;
                foreach($rows as $row) 
                {
                    $testo = $row->$field;
                    if (is_numeric($testo)) {
                            $testo= strval($testo);
                    }
                    if(strlen($testo) > 0)
                    {
                        $results['results'][$i]['id'] = $row->id;
                        $results['results'][$i]['text'] = $testo;
                        $i++;
                    }
                }  
                $results['pagination']["more"]=$morePages;
            }

            // scrivi_nel_log( json_encode($results) ); 
$response = $this->getResponse();      
$this->autoRender = false;
return $response->withType( 'application/json' )
    ->withStringBody( json_encode( $results ) );
           // flush();
        }
    }


    /**
    * Controlla che il termine cercato sia presente nella tabella
    * @param $model
    * @param $field
    * @return void
    */ 
    public function check($model, $field) 
    {
        if ($this->request->is('ajax') || TRUE) 
        {
                    
            //Configure::write('debug', 0);
            //$this->layout = false;
         //   $this->autoRender = false;
            $results=array();       //output data init

            $this->loadModel($model);
            $query = $this->$model->find('all', array(
                'conditions'=>array(
                    $model . "." . $field . " LIKE '%" . $_GET['term'] . "%'"
                ),
                 'limit'     => '1',
                'recursive' => '-1',
                'fields' => array('id', $field),
                'order' => array($model.".".$field)
            ));
            $rows = $query;
             if(!empty($rows)) 
            {
                $i=0;
                foreach($rows as $row) 
                {
                    $testo = $row->$field;
                    if(strlen($testo) > 0)
                    {
                        $results[$i]['value'] = $row->id;
                        $results[$i]['label'] = $testo;
                        $i++;
                    }
                }
            }
          $response = $this->getResponse();      
$this->autoRender = false;
return $response->withType( 'application/json' )
    ->withStringBody( json_encode( $results ) );
          //  flush();
        
        }
    }


    //-------------------------------------------------------------------------------
    //QUESTO E' UN ESEMPIO PER CAPIRE COME USARE doAcFunzione()
    //-------------------------------------------------------------------------------
    //Cercare un nome nell'array $database_dei_dati e restituisce i dati a Autocomplete
    //nella EDIT bisogna mettere la funzione javascript: 
    //      doAcFunzione('AutoreNome', 'CercaNome', 1);
    public function CercaNome() 
    {
        if ($this->RequestHandler->isAjax()) 
        {
            $this->autoRender = false;
            $results = array();       

            //legge il termine di ricerca dal FORM
            $termine = strtoupper(trim($_GET['term'])); 
            $termine = str_replace("*", "", $termine);      //toglie eventuali asterischi
            if( strlen($termine) == 0 )
            {
                //se la stringa e' vuota, non cerca niente
                $termine = "(nessun termine di ricerca)";
            }
            
            //array con i dati in cui cercare il termine di ricerca. Simula un database
            $database_dei_dati = array(
                "Lino",
                "Pino",
                "Gino",
                "Luigi",
                "Danilo",
                "Daniele",
                "Ginevra",
                "Beatrice",
                "Luisella",
                "Donatella",
            );

            //Filtra i dati di $database_dei_dati, in base al termine di ricerca, e crea l'array $elenco_dati_trovati
            //Puo' essere sostituito da una query SQL o da una chiamata REST
            $elenco_dati_trovati = array();
            foreach ($database_dei_dati as $key => $value) 
            {
                if(strpos(  strtoupper($value), $termine) !== false)
                {
                    $elenco_dati_trovati[] = $value;
                }
            }

            //prepara l'array di risposta
            $risposta = array();
            foreach ($elenco_dati_trovati as $key => $value) 
            {
                $riga = array();
                $riga["label"] = $value;                //testo che si vede nell'autocomplete
                array_push($risposta, $riga);
            }

            //trasforma la risposta in formato JSON, per Autocomplete 
            $risposta_json = json_encode($risposta);
            echo $risposta_json;
            flush();
        }
    }



    // to be used in Ajax
    public function beforeFilter(\Cake\Event\EventInterface $event) 
    {
         parent::beforeFilter($event);
          $this->loadComponent('RequestHandler');
        if ($this->request->is('ajax')) 
        {
        	//$this->Auth->allow(array('fetch', 'check', 'CercaCognome'));
        }                
    }




} //FINE DI TUTTO
