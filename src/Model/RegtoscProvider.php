<?php
namespace App\Model;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenTime;

class RegtoscProvider 
{
  //sono le regole aggiunte a quelle di default che possiamo applicare a tutti i modelli  

    
      public function regola1($check): bool
    {
   
            return false;
       
    }
    
 public function impedisceDuplicati($check,$field,$model) : bool
	{  
     $total = $model->find()->where([$field => $check])->count();
		if($total > 0)
		{
			return false;
		}
		return true;
	}
    
  //DG: validazione della data
 public function verificaData($check, $tipo) : bool
    {
        //anno minimo e massimo consentito (modificabile)
        $anno_min = 1850;
        $anno_max = 2099;

        $miadata = $check;
        switch ($tipo) 
        {
            case 'date':
                $formato = 'd/m/Y';
                break;
            case 'datetime':
                $formato = 'd/m/Y H:i';
                break;
            default:
                $formato = '';
                break;
        }

        //TO DO
        //DATA VALIDA
        return true;
    }
   
    
}
    