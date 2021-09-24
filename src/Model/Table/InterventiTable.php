<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

/**
 * Interventi Model
 *
 * @method \App\Model\Entity\Intervento newEmptyEntity()
 * @method \App\Model\Entity\Intervento newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Intervento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Intervento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Intervento findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Intervento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Intervento[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Intervento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Intervento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Intervento[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Intervento[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Intervento[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Intervento[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InterventiTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
          // Add the behavior to your table
 
       
    //PB per search
    $this->addBehavior('Search.Search');
    $this->searchManager()        ->add('VERSIONE', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['VERSIONE'],
            ])        ->add('IDINT', 'Search.Value', [
            'fields' => ['IDINT'],
            ])        ->add('DESLDITEMP', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DESLDITEMP'],
            ])        ->add('TITOLOINT', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['TITOLOINT'],
            ])        ->add('DESCRINT', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DESCRINT'],
            ])        ->add('ANNODEFR', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['ANNODEFR'],
            ])        ->add('FLAGPQPO', 'Search.Value', [
            'fields' => ['FLAGPQPO'],
            ])        ->add('CODCMU', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['CODCMU'],
            ])        ->add('MATRESPOP', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['MATRESPOP'],
            ])        ->add('NOTEANAG', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['NOTEANAG'],
            ])        ->add('NOTECRONOPROG', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['NOTECRONOPROG'],
            ])        ->add('INTMONITORATO', 'Search.Value', [
            'fields' => ['INTMONITORATO'],
            ])        ->add('MONITSTATO', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['MONITSTATO'],
            ])        ->add('ANNOINIZIOINT', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['ANNOINIZIOINT'],
            ])        ->add('STATOINT', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['STATOINT'],
            ])        ->add('MATRCSG', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['MATRCSG'],
            ])        ->add('CODLOCPROG', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['CODLOCPROG'],
            ])        ->add('INSVERS', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['INSVERS'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'interventi';
        $this->setTable($tableName);
    $this->setDisplayField('id');
  $this->setPrimaryKey('id');
  


    }




//PB Validation Rules
 public function validationDefault(Validator $validator): Validator
    {
        // Validation Provider custom in src\Model\RegtoscProvider.php
        $validator->setProvider('custom',  new \App\Model\RegtoscProvider());
 
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
     /*    $validator->add('id', 'custom', [
             'rule' => ['impedisceduplicati','id',$this],
             'provider'=>'custom',
             'message'=>'Record Duplicato'
            ]);  */ 
             $validator               ->notEmptyString('VERSIONE', 'Inserimento necessario')   
               ->notBlank('VERSIONE');    
         
             $validator               ->notEmptyString('IDINT', 'Inserimento necessario')   
               ->numeric('IDINT')
               ->range('IDINT',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('DESLDITEMP')   
               ->notBlank('DESLDITEMP');    
         
             $validator    
               ->allowEmptyString('TITOLOINT')   
               ->notBlank('TITOLOINT');    
         
             $validator    
               ->allowEmptyString('DESCRINT')   
               ->notBlank('DESCRINT');    
         
             $validator    
               ->allowEmptyString('ANNODEFR')   
               ->notBlank('ANNODEFR');    
         
             $validator    
               ->allowEmptyString('FLAGPQPO')   
               ->numeric('FLAGPQPO')
               ->range('FLAGPQPO',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('CODCMU')   
               ->notBlank('CODCMU');    
         
             $validator    
               ->allowEmptyString('MATRESPOP')   
               ->notBlank('MATRESPOP');    
         
             $validator    
               ->allowEmptyString('NOTEANAG')   
               ->notBlank('NOTEANAG');    
         
             $validator    
               ->allowEmptyString('NOTECRONOPROG')   
               ->notBlank('NOTECRONOPROG');    
         
             $validator    
               ->allowEmptyString('INTMONITORATO')   
               ->numeric('INTMONITORATO')
               ->range('INTMONITORATO',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('MONITSTATO')   
               ->notBlank('MONITSTATO');    
         
             $validator    
               ->allowEmptyString('ANNOINIZIOINT')   
               ->notBlank('ANNOINIZIOINT');    
         
             $validator    
               ->allowEmptyString('STATOINT')   
               ->notBlank('STATOINT');    
         
             $validator    
               ->allowEmptyString('MATRCSG')   
               ->notBlank('MATRCSG');    
         
             $validator    
               ->allowEmptyString('CODLOCPROG')   
               ->notBlank('CODLOCPROG');    
         
             $validator    
               ->allowEmptyString('INSVERS')   
               ->notBlank('INSVERS');    
            
    return $validator;
 }
/*End PB*/
}
