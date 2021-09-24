<?php
declare(strict_types=1);

namespace App\Policy;


use App\Model\Entity\Lingua;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Core\Configure;

/**
 * Lingua policy
 */
 class LinguaPolicy implements BeforePolicyInterface
 {

 //PB Mappa il Json inserito all'interno dei ruoli per dare le autorizzazioni necessarie
 public function before($user, $resource, $action)
 {    
    if (is_string($user->role->data_config) && is_array(json_decode($user->role->data_config,true)))
           {
           $user->role->data_config =json_decode($user->role->data_config);
           }    

    //admin can do ALL PB  
    if (isset($user->role->data_config->all->canDoAll))
    {
           if ($user->role->data_config->all->canDoAll === 'true')
           {        
           return true;
           } 
    }

        //cerca di vedere se ci sono autorizzazioni globali definite in regtoscconf- DA TESTARE 
       $autorizzazioniMap = Configure::read('regtoscConf.autorizzazioniMap');
       if (isset($user->role->data_config->all->canReadAll) && $user->role->data_config->all->canReadAll)
            {        
               if (in_array ( $action, $autorizzazioniMap['Read'] )) return true;
            } 
       if (isset($user->role->data_config->all->canUpdateAll) && $user->role->data_config->all->canUpdateAll)
            {        
               if (in_array ( $action, $autorizzazioniMap['Update'] )) return true;
            } 
        if (isset($user->role->data_config->all->canCreateAll) && $user->role->data_config->all->canCreateAll)
            {        
               if (in_array ( $action, $autorizzazioniMap['Create'] )) return true;
            }     
        if (isset($user->role->data_config->all->canDeleteAll) && $user->role->data_config->all->canDeleteAll)
            {        
               if (in_array ( $action, $autorizzazioniMap['Delete'] )) return true;
            }   
     
       //cerca di vedere se ci sono autorizzazioni globali relative a questa tabella definite in regtoscconf- DA TESTARE       
             if (isset($user->role->data_config->Lingua->canRead) && $user->role->data_config->Lingua->canRead)
            {        
               if (in_array ( $action, $autorizzazioniMap['Read'] )) return true;
            } 
       if (isset($user->role->data_config->Lingua->canUpdate) && $user->role->data_config->Lingua->canUpdate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Update'] )) return true;
            } 
        if (isset($user->role->data_config->Lingua->canCreate) && $user->role->data_config->Lingua->canCreate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Create'] )) return true;
            }     
        if (isset($user->role->data_config->Lingua->canDelete) && $user->role->data_config->Lingua->canDelete)
            {        
               if (in_array ( $action, $autorizzazioniMap['Delete'] )) return true;
            }   
            
     
    // cerca di vedere se ci sono autorizzazioni specifiche definite nel json relative al ruolo - DA TESTARE
    $canatc= 'can' . ucfirst($action);
    if (isset( $user->role->data_config->article->$canatc ))
    {     
    return  filter_var($user->role->data_config->article->$canatc, FILTER_VALIDATE_BOOLEAN);
    }      
    
    // altrimenti NON si permette
    // se vogliemo continuare coi classici canAction togliere il return false e gestirlo 
    // all'interno dei vari canAction
    return false;  
    
 }   
 //END PB  





    /**
     * Check if $user can add Lingua
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Lingua $lingua
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Lingua $lingua)
    {
    }

    /**
     * Check if $user can edit Lingua
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Lingua $lingua
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Lingua $lingua)
    {
    }

    /**
     * Check if $user can delete Lingua
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Lingua $lingua
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Lingua $lingua)
    {
    }

    /**
     * Check if $user can view Lingua
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Lingua $lingua
     * @return bool
     */
    public function canView(IdentityInterface $user, Lingua $lingua)
    {
    }
}
