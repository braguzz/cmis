<?php
declare(strict_types=1);

namespace App\Policy;


use App\Model\Entity\Role;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Role policy
 */
 class RolePolicy implements BeforePolicyInterface
 {
 

     

 //PB Mappa il Json inserito all'interno dei ruoli per dare le autorizzazioni necessarie
 public function before($user, $resource, $action)
 {    
    //se e' admin puo vedere e agire sugli utenti altrimenti no
    return $user->role->id == 1 ?  true :  false;
     
     
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
     * Check if $user can add Role
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Role $role
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Role $role)
    {
    }

    /**
     * Check if $user can edit Role
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Role $role
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Role $role)
    {
    }

    /**
     * Check if $user can delete Role
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Role $role
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Role $role)
    {
    }

    /**
     * Check if $user can view Role
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Role $role
     * @return bool
     */
    public function canView(IdentityInterface $user, Role $role)
    {
    }
}
