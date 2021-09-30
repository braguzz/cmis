<?php

return [ 'regtoscConf'=> [
    
            'pagetitle' => 'Progetto di Prova C4',  //Titolo del progetto

            'landingPage' => ['controller' =>'Users','action' => 'landing'],  //Pagina di avvio dopo il login

             'dbPrefix' => '',  //prefix per il DB default - se non c'e' prefisso inserire stringa vuota ''

            'logAccess' => FALSE,  //per loggare in http://www321.regione.toscana.it/logrest/Logs
    
            'authenticUserPassoword' => TRUE,  //TODO - se messo a FALSE si elimina la possibilita di autenticarsi tramite User e Password

            /* =============== MENU PRINCIPALE =========================*/
            /* icone in https://icons.getbootstrap.com/                 */    
            'menuLeft' => ['Menu1' => ['action' => '/Menu1',],
                           'Menu2' => ['icon' => 'bi-justify',
                                       'children' => [
                                            'Sottomenu4' => ['action'=> '/Sottomenu4'],
                                            'Sottomenu5' => ['action' => '/Sottomenu5'],
                                            ]
                                        ],

                           'Chiamate' => [  'action' => '/Calls/add',
                                            'icon' => 'bi-telephone',
                                            'children' => [
                                                'Lista' => [   'action' => '/Calls',
                                                    '           icon' => 'bi-justify',
                                                                'children' => [
                                                                    'Elenco generale' => [
                                                                            'action' => '/reports/ReportSqls/',
                                                                            'icon' => 'bi-file-earmark-bar-graph'],
                                                                    'Elenco mensile' => [
                                                                            'action' =>   '/reports/ReportSqls/add',
                                                                            'icon' => 'bi-file-earmark-bar-graph',
                                                                            ],
                                                                    ],
                                                            ],
                                                'Aggiungi chiamata' => [    'action' => '/Calls/add',
                                                                            'icon' => 'bi-plus-square',
                                                                        ],
                                            ],
                                        ],

                            ] ,
              //              'menuRight' => [] , Definito in element/navbar.php

              //              'menuLogout' => [ ], Definito in element/navbar.php

              //fine menu

            'arpaAuthenticator' => [
                    'myClientID' => 'rt-ac20-c1',
                    'myClientSecret' => 'ba58e127-52f7-420a-9e37-61e62611a7bd',
                    'arpa' => "https://accessosicuro-trial.rete.toscana.it/auth/realms/arpa/protocol/openid-connect",  //Stage
               //     'arpa' => "https://accessosicuro.rete.toscana.it/auth/realms/arpa/protocol/openid-connect", //Production
                     ],

            // AutorizzazioniMap serve per mappare certe azioni alle autorizzazioni
            // se un ruolo ha nella configurazione json del db ad esempio CanReadAll => true, allora potra accedere a
            // tutte le azioni definite in Read.
            // Quindi se creiamo una nuova azione basta inserirla qui
                'autorizzazioniMap' => [
                    'Create' => ['add', 'addmodal', 'tabadd', 'madd','addHABTM','addfromadd', 'importaxml', 'importaexcel', 'importafileexcel', 'importafilexml','addAjaxBelong','addAjax'],
                    'Read'   => ['index', 'indexTab','indexfromaddresults', 'indexfromadd', 'indexdt','display', 'view', 'fetch', 'check', 'get', 'search', 'find', 'logout', 'pdf', 'tosql', 
                                 'cerca',  'AzzeraFiltro', 'esportaxls', 'view_pdf','esportapdf', 'esportacsv', 'chart', 'admin_run','ReportSqls', 'criptapsw'],
                    'Update' => ['edit', 'tabedit', 'medit','ajax','searchAjax','addAjax','removehabtmAjaxBelong','addAjaxBelong','selezioneAjax','removeselection','indexexternal'],
                    'Delete' => ['delete','deleteselection','removeAjaxBelong','removehabtmAjaxBelong']
                 ],

            /* tema colore: light, blue, red, green, deepblue, gray, black, orange, brown, teal */
            'ColourTheme' => 'light'

    ]
    ];