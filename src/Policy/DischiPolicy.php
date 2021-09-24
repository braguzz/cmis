<?php
declare(strict_types=1);

namespace App\Policy;


use App\Model\Entity\Dischi;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Core\Configure;

/**
 * Dischi policy
 */
 class DischiPolicy implements BeforePolicyInterface
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
             if (isset($user->role->data_config->Dischi->canRead) && $user->role->data_config->Dischi->canRead)
            {        
               if (in_array ( $action, $autorizzazioniMap['Read'] )) return true;
            } 
       if (isset($user->role->data_config->Dischi->canUpdate) && $user->role->data_config->Dischi->canUpdate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Update'] )) return true;
            } 
        if (isset($user->role->data_config->Dischi->canCreate) && $user->role->data_config->Dischi->canCreate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Create'] )) return true;
            }     
        if (isset($user->role->data_config->Dischi->canDelete) && $user->role->data_config->Dischi->canDelete)
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
     * Check if $user can add Dischi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Dischi $dischi
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Dischi $dischi)
    {
    }

    /**
     * Check if $user can edit Dischi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Dischi $dischi
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Dischi $dischi)
    {
    }

    /**
     * Check if $user can delete Dischi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Dischi $dischi
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Dischi $dischi)
    {
    }

    /**
     * Check if $user can view Dischi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Dischi $dischi
     * @return bool
     */
    public function canView(IdentityInterface $user, Dischi $dischi)
    {
    }
}
