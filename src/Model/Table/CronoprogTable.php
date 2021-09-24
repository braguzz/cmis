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
 * Cronoprog Model
 *
 * @method \App\Model\Entity\Cronoprogramma newEmptyEntity()
 * @method \App\Model\Entity\Cronoprogramma newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Cronoprogramma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cronoprogramma get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cronoprogramma findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Cronoprogramma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cronoprogramma[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cronoprogramma|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cronoprogramma saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cronoprogramma[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cronoprogramma[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cronoprogramma[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cronoprogramma[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CronoprogTable extends Table
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
    $this->searchManager()        ->add('DESATTIV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DESATTIV'],
            ])        ->add('PESOATTIV', 'Search.Value', [
            'fields' => ['PESOATTIV'],
            ])        ->add('FSP', 'Search.Value', [
            'fields' => ['FSP'],
            ])        ->add('FSI', 'Search.Value', [
            'fields' => ['FSI'],
            ])        ->add('FSL', 'Search.Value', [
            'fields' => ['FSL'],
            ])        ->add('RESTATTIV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['RESTATTIV'],
            ])        ->add('DATAINIPREV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATAINIPREV'],
            ])        ->add('DATAFINEPREV', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATAFINEPREV'],
            ])        ->add('DATAINIEFF', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATAINIEFF'],
            ])        ->add('DATAFINEFF', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['DATAFINEFF'],
            ])        ->add('STATOATTUAZ', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['STATOATTUAZ'],
            ])        ->add('PERCATTUAZ', 'Search.Value', [
            'fields' => ['PERCATTUAZ'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'cronoprog';
        $this->setTable($tableName);
    $this->setDisplayField('VERSIONE');
    $this->setPrimaryKey(['VERSIONE', 'IDINT', 'CODATTIV']);
    
    $this->hasMany('Interventi')
    ->setForeignKey([
        'VERSIONE',
        'IDINT'
    ])
    ->setBindingKey([
        'VERSIONE',
        'IDINT'
    ]);
    
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
             $validator    
               ->allowEmptyString('DESATTIV')   
               ->notBlank('DESATTIV');    
         
             $validator    
               ->allowEmptyString('PESOATTIV')   
               ->decimal('PESOATTIV')
               ->range('PESOATTIV',[-1000000,1000000], 'Inserimento consentito fra -999999 e 999999');    
         
             $validator    
               ->allowEmptyString('FSP')   
               ->numeric('FSP')
               ->range('FSP',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('FSI')   
               ->numeric('FSI')
               ->range('FSI',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('FSL')   
               ->numeric('FSL')
               ->range('FSL',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmptyString('RESTATTIV')   
               ->notBlank('RESTATTIV');    
         
             $validator    
               ->allowEmptyString('DATAINIPREV')   
               ->notBlank('DATAINIPREV');    
         
             $validator    
               ->allowEmptyString('DATAFINEPREV')   
               ->notBlank('DATAFINEPREV');    
         
             $validator    
               ->allowEmptyString('DATAINIEFF')   
               ->notBlank('DATAINIEFF');    
         
             $validator    
               ->allowEmptyString('DATAFINEFF')   
               ->notBlank('DATAFINEFF');    
         
             $validator    
               ->allowEmptyString('STATOATTUAZ')   
               ->notBlank('STATOATTUAZ');    
         
             $validator    
               ->allowEmptyString('PERCATTUAZ')   
               ->decimal('PERCATTUAZ')
               ->range('PERCATTUAZ',[-1000000,1000000], 'Inserimento consentito fra -999999 e 999999');    
            
    return $validator;
 }
/*End PB*/
}
