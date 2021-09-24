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
 * Prove Model
 *
 * @method \App\Model\Entity\Prova newEmptyEntity()
 * @method \App\Model\Entity\Prova newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Prova[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Prova get($primaryKey, $options = [])
 * @method \App\Model\Entity\Prova findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Prova patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Prova[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Prova|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Prova saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Prova[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prova[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prova[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Prova[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProveTable extends Table
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
    $this->searchManager()        ->add('DATANUCLEO', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATANUCLEO'],
            ])        ->add('FLAGB', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['FLAGB'],
            ])        ->add('COD_TIPOCRITICITA_NV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['COD_TIPOCRITICITA_NV'],
            ])        ->add('COD_TIPOSOLUZIONE_NV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['COD_TIPOSOLUZIONE_NV'],
            ])        ->add('DATACOMASS', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATACOMASS'],
            ])        ->add('SOL_GR_A', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['SOL_GR_A'],
            ])        ->add('DATA_SOL_GR', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATA_SOL_GR'],
            ])        ->add('CRITICITA_NDV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['CRITICITA_NDV'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'prove';
        $this->setTable($tableName);
$this->setDisplayField('CODPROG');
    $this->setPrimaryKey(['CODPROG', 'VERSIONE']);
//berna
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
             $validator               ->notEmptyString('DATANUCLEO', 'Inserimento necessario')   
               ->notBlank('DATANUCLEO');    
         
             $validator    
               ->allowEmptyString('FLAGB')   
               ->notBlank('FLAGB');    
         
             $validator    
               ->allowEmptyString('COD_TIPOCRITICITA_NV')   
               ->notBlank('COD_TIPOCRITICITA_NV');    
         
             $validator    
               ->allowEmptyString('COD_TIPOSOLUZIONE_NV')   
               ->notBlank('COD_TIPOSOLUZIONE_NV');    
         
             $validator    
               ->allowEmptyString('DATACOMASS')   
               ->notBlank('DATACOMASS');    
         
             $validator    
               ->allowEmptyString('SOL_GR_A')   
               ->notBlank('SOL_GR_A');    
         
             $validator    
               ->allowEmptyString('DATA_SOL_GR')   
               ->notBlank('DATA_SOL_GR');    
         
             $validator    
               ->allowEmptyString('CRITICITA_NDV')   
               ->notBlank('CRITICITA_NDV');    
            
    return $validator;
 }
/*End PB*/
}
