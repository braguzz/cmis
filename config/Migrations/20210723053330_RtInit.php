<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Authentication\PasswordHasher\DefaultPasswordHasher; 
use Cake\Core\Configure;


class RtInit extends AbstractMigration
{
   
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {

    //Table ROLES    
        
        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $roles = $this->table( $dbPrefix . 'roles' );
        $roles->addColumn( 'name', 'string', [            
                                            'length' => 45,
                                            'null' => false,
                                        ]);
        $roles->addColumn( 'descrizione', 'string', [            
                                            'length' => 1024,
                                            'null' => true,
                                        ]);
        $roles->addColumn( 'data_config', 'text', [            
                                           
                                            'null' => true,
                                        ]);
        $roles->addColumn( 'created', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
        $roles->addColumn( 'modified', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
            $roles->create();
            $DC=json_encode(['all'=>['canDoAll'=>'true']]);
            $roles->insert( [ 'id' => 1,
           'name'=>'administrators',
           'descrizione'=>'Global Admin puo fare tutto',
           'data_config'=>$DC,
           ] );
            

           $DC=json_encode(['all'=>['canDoAll'=>'true']]);
            $roles->insert( [ 'id' => 2,
           'name'=>'managers',
           'descrizione'=>'Puo agire su tutte le tabelle ma non in users e roles (definito nelle politiche)',     
           'data_config'=>$DC,
           ] );
            
            $DC=json_encode([
                            'all'=>['canReadAll'=>'true','canCreateAll'=>'true','canDeleteAll'=>'true']
              ]);
          $roles->insert( [ 'id' => 3,
           'name'=>'executives',
          'descrizione'=>'Puo scrivere e cancellare ma non editare',
           'data_config'=>$DC,
           ] ); 
          
            $DC=json_encode([
                            'all'=>['canReadAll'=>'true','canEditAll'=>'true']
              ]);
           $roles->insert( [ 'id' => 4,
           'name'=>'accountants',
          'descrizione'=>'Possono editare ma non scrivere e cancellare',
           'data_config'=>$DC,
           ] ); 
           
          $DC=json_encode([
                            'all'=>['canReadAll'=>'true']
              ]);
           $roles->insert( [ 'id' => 5,
           'name'=>'guests',
          'descrizione'=>'Possono solo vedere',
           'data_config'=>$DC,
           ] ); 
           $roles->insert( [ 'id' => 6,
           'name'=>'inactive',
           ] );
           
           $DC=json_encode(['all'=>['canReadAll'=>'true'],
                            'Controller1'=>['canAction1C1'=>'true','canAction1C2'=>'true'],
                            'Controller2'=>['canAction1C2'=>'true','canAction2C2'=>'true','canAction2C3'=>'false']
              ]);
             $roles->insert( [ 'id' => 7,
           'name'=>'testrole',
           'descrizione'=>"Ruolo di test per capirne il funzionamento. In questo caso puo agire su tutti i controller definiti su regtosc.conf come 'Read' e puo utilizzare Action1C1 e Action2C1 sul Controller1 e Action1C2 e Action2C2 sul Controller2. Non puo aqgire su canAction2C3.",      
           'data_config'=>$DC,
           ] );
       $roles->saveData();
        
     
      //Table USERS         
       $users = $this->table( $dbPrefix . 'users' );
       $users->addColumn( 'username', 'string', [            
                                            'length' => 40,
                                            'null' => false,
                                        ]);
        $users->addColumn( 'password', 'string', [            
                                            'length' => 255,
                                            'null' => false,
                                        ]);
        $users->addColumn( 'codice_fiscale', 'string', [            
                                            'length' => 16,
                                            'null' => false,
                                        ]);
        $users->addColumn( 'email', 'string', [            
                                            'length' => 255,
                                            'null' => false,
                                        ]);
       $users->addColumn( 'role_id', 'integer', [            
                                            'length' => 3,
                                            'null' => false,
                                            'default' => 6
                                        ]);
        $users->addColumn( 'created', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
        $users->addColumn( 'modified', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
        $users->create();
        $adminpassword=(new DefaultPasswordHasher())->hash('adminadmin');
        $users->insert( [ 'id' => 1,
           'username'=>'admin',
           'password'=>$adminpassword,
           'codice_fiscale'=>'QWERTYASDFGHZXCV',
            'email'=>'removeme@regione.toscana.it',
            'role_id'=>1
           ] ); 
        $users->saveData();
        
 //reportSQL
        
       $reports = $this->table( $dbPrefix . 'reports' );
       $reports->addColumn( 'name', 'string', [            
                                            'length' => 255,
                                            'null' => false,
                                        ]);
        $reports->addColumn( 'strsql', 'text', [ 
                                            'null' => false,
                                        ]);
        $reports->addColumn( 'db', 'string', [            
                                            'length' => 256,
                                            'null' => false,
                                            'default' => 'default',
                                        ]);
        $reports->addColumn( 'menu', 'boolean', [
                                            'null' => false,
                                        ]);

        $reports->addColumn( 'created', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
        $reports->addColumn( 'modified', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'null' => false,
      ] );
        $reports->create(); 
        
        
        
       
        
    }
}