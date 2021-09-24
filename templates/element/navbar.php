<script type="text/javascript">
    var MYAPP = '<?php echo MYAPP; ?>' ;
</script>  
<?php

use Cake\Core\Configure;



$MenuLeft=$regtoscConf['menuLeft'];



//MENU ReportSql
if (!empty($rep) or !empty($cha)) {
//debug($cha);
$MenuLeft['Report']= array('action' =>  '#',
                            'title'    => 'notitle',
                            'icon' => 'bi-stack',
                                        );
        }

if (!empty($rep)) {
 foreach ($rep as $key => $value):

            $r[$value]=array(
                    'action'=>'/report-sql/reports/admin-run/' . $key,
                    'title'=>$value,
            'icon' => 'bi-check',
                    );
endforeach;
$MenuLeft['Report']['children']['Report']['action']='#';
$MenuLeft['Report']['children']['Report']['icon']='bi-printer';
$MenuLeft['Report']['children']['Report']['children']=$r;
}

/*if (!empty($cha)) {
 foreach ($cha as $ch):
//debug($ch);
            $rc[$ch['Chart']['name']]=array(
                    'action'=>'/reports/charts/chart/' . $ch['Chart']['id'],
                    'title'=>$ch['Chart']['name'],
            'icon' => 'fa-check',
                    );
endforeach;
$MenuLeft['Report']['children']['Chart']['action']='#';
$MenuLeft['Report']['children']['Chart']['icon']='fa-area-chart';
$MenuLeft['Report']['children']['Chart']['children']=$rc;
}*/


 // modifica dinamica dei menu in funzione del profilo
    // NB: necessario template bundle Users/Group ACL 
  //  $nGroup = $this->Session->read('Auth.group_id') ;
    if(isset($role_id)) 
    {
        // L'UTENTE E' LOGON 
        switch($role_id) 
        {
            case 1:         //GRUPPO1: administrators
                //aggiunge il menu ADMIN + sottomenu
                $MenuRight['Admin'] = array (
                'title'    => 'notitle',
                'icon'      => 'bi-gear-fill',
                'action'   =>  '',
                'children' =>
                    array (
                'Elenco Utenti' =>
                        array (
                        'action'   =>  '/users/',
                        ),
                'Nuovo Utente' =>['action'   =>  '/users/add',],
                'ReportSQL' =>
                        [
                            'icon'      => 'fa-file-text',
                            'action'   =>  '#',
                             'children' =>
                                        array (
                                        'Lista Report' =>
                                            array (
                                            'title'    => 'Lista Report',
                                            'action'   =>  '/report-sql/reports',
                                            ),
                                        'Nuovo Report' =>
                                            array (
                                            'title'    => 'Nuovo Report',
                                            'action'   =>  '/report-sql/reports',
                                            ),

                                         ),
                        ],
                            'Charts' =>
                        array (
                            'icon'      => 'fa-area-chart',
                            'action'   =>  '#',
                             'children' =>
                                        array (
                                        'Lista Charts' =>
                                            array (
                                            'action'   =>  '/reports/charts',
                                            ),
                                        'Nuovo Chart' =>
                                            array (
                                            'action'   =>  '/reports/Charts/add',
                                            ),
                                        ),
                        )
                    ),
                );
           //     unset($MenuRight['User']['children']['Registra Utente']) ;
                break;
            case 2:         //GRUPPO2
                //toglie il menu REGISTRA UTENTE
             //   unset($MenuRight['User']['children']['Registra Utente']) ;
                break;
            case 3:         //GRUPPO3
                //toglie il menu REGISTRA UTENTE
             //   unset($MenuRight['User']['children']['Registra Utente']) ;
                break;
            case 4:         //GRUPPO4
                //toglie il menu REGISTRA UTENTE
              //  unset($MenuRight['User']['children']['Registra Utente']) ;
                //toglie alcuni menu (quelli definiti in RegTosc.ctp)
              //  unset($MenuLeft['Nuova']);
              //  unset($MenuLeft['Chiamate']) ;
              //  unset($MenuLeft['Contatti']);
                break;
            case 6:         //GRUPPO6: inactive
            default:        
                //toglie il menu REGISTRA UTENTE
             //   unset($MenuRight['User']['children']['Registra Utente']) ;
                //toglie tutti i menu di sinistra (quelli definiti in RegTosc.ctp)
                foreach ($MenuLeft as $key => $value) 
                {
                    unset($MenuLeft[$key]);
                }
                break;
        }
    }
    else
    {
        //L'UTENTE E' LOGOFF 
        //toglie tutti i menu di sinistra (quelli definiti in RegTosc.ctp)
        foreach ($MenuLeft as $key => $value) 
        {
            unset($MenuLeft[$key]);
        }
    }


?>

<nav class="navbar navbar-expand-lg navbar-custom  sticky-top">
   <?=  $this->Html->image('/img/logo_regione_toscana.jpg', [
    "alt" => "Home",
    'height' => '50',
    'url' => '/'
]);?>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse  navbar-collapse" id="navbarNavDropdown"> 
    

<?=  $this->CssMenu->menu($MenuLeft,'navbar-left'); ?>
<?php  if ($role_id=="1")
           echo $this->CssMenu->menu($MenuRight,'navbar-right'); 
  if(isset($cf)) 
      {  //  $MenuLogout=$regtoscConf['menuLogout'];
         //   $MenuLogout['User']['children'][''] = [$cf => ['action' => '']];
             $MenuLogout = [

                                '' => [ 'action' =>  '',
                                        'icon' => 'bi-person-circle',
                                         'children' => [
                                                        $cf .' Logout' => ['action' => '/Users/logout', 'icon'=>'bi-forward'],
                                                        ]
                                                                     ],
                              ];
            
            
            
           echo  $this->CssMenu->menu($MenuLogout,'navbar-right'); 
        }

  ?>
  
    </div>
    </nav>


