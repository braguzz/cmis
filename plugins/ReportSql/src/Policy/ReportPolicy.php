<?php
declare(strict_types=1);

namespace ReportSql\Policy;


use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Cake\Core\Configure;
use ReportSql\Model\Entity\report;

/**
 * report policy
 */
 class reportPolicy implements BeforePolicyInterface
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
             if (isset($user->role->data_config->report->canRead) && $user->role->data_config->report->canRead)
            {        
               if (in_array ( $action, $autorizzazioniMap['Read'] )) return true;
            } 
       if (isset($user->role->data_config->report->canUpdate) && $user->role->data_config->report->canUpdate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Update'] )) return true;
            } 
        if (isset($user->role->data_config->report->canCreate) && $user->role->data_config->report->canCreate)
            {        
               if (in_array ( $action, $autorizzazioniMap['Create'] )) return true;
            }     
        if (isset($user->role->data_config->report->canDelete) && $user->role->data_config->report->canDelete)
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
     * Check if $user can add report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \ReportSql\Model\Entity\report $report
     * @return bool
     */
    public function canAdd(IdentityInterface $user, report $report)
    {
    }

    /**
     * Check if $user can edit report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \ReportSql\Model\Entity\report $report
     * @return bool
     */
    public function canEdit(IdentityInterface $user, report $report)
    {
    }

    /**
     * Check if $user can delete report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \ReportSql\Model\Entity\report $report
     * @return bool
     */
    public function canDelete(IdentityInterface $user, report $report)
    {
    }

    /**
     * Check if $user can view report
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \ReportSql\Model\Entity\report $report
     * @return bool
     */
    public function canView(IdentityInterface $user, report $report)
    {
    }
}
