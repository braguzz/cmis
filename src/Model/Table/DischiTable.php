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
 * Dischi Model
 *
 * @property \App\Model\Table\LingueTable&\Cake\ORM\Association\BelongsTo $Lingue
 * @property \App\Model\Table\AutoriTable&\Cake\ORM\Association\BelongsTo $Autori
 *
 * @method \App\Model\Entity\Disco newEmptyEntity()
 * @method \App\Model\Entity\Disco newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Disco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Disco get($primaryKey, $options = [])
 * @method \App\Model\Entity\Disco findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Disco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Disco[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Disco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Disco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Disco[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Disco[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Disco[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Disco[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DischiTable extends Table
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
    $this->searchManager()        ->add('title', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['title'],
            ])        ->add('descrizione', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['descrizione'],
            ])        ->add('lingua_id', 'Search.Value', [
            'fields' => ['lingua_id'],
            ])        ->add('autore_id', 'Search.Value', [
            'fields' => ['autore_id'],
            ])        ->add('data', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Dischi','data');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('datetime', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Dischi','datetime');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('created', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Dischi','created');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('modified', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Dischi','modified');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('intero', 'Search.Value', [
            'fields' => ['intero'],
            ])        ->add('booleano', 'Search.Boolean', [
            'mode' => 'or',
            'fields' => ['booleano'],
            ])        ->add('decimale', 'Search.Value', [
            'fields' => ['decimale'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'dischi';
        $this->setTable($tableName);
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lingue', [
            'foreignKey' => 'lingua_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Autori', [
            'foreignKey' => 'autore_id',
        ]);
    }




//PB Validation Rules
 public function validationDefault(Validator $validator): Validator
    {
        // Validation Provider custom in src\Model\RegtoscProvider.php
        $validator->setProvider('custom',  new \App\Model\RegtoscProvider());
 
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
         $validator->add('id', 'custom', [
             'rule' => ['impedisceduplicati','id',$this],
             'provider'=>'custom',
             'message'=>'Record Duplicato'
            ]); 
             $validator               ->notEmptyString('title', 'Inserimento necessario')   
               ->notBlank('title');    
         
             $validator    
               ->allowEmptyString('descrizione')   
               ->notBlank('descrizione');    
         
             $validator               ->notEmpty('lingua_id', 'Inserimento necessario')   
               ->numeric('lingua_id')
               ->range('lingua_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmpty('autore_id')   
               ->numeric('autore_id')
               ->range('autore_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
        $validator    ->notEmptyDate('data', 'Inserimento necessario')   
            ->date('data')  ;
             $validator->add('data', 'custom', [
             'rule' => ['verificaData','date'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016)'
            ]);    
         
             $validator               ->notEmptyDateTime('datetime', 'Inserimento necessario')   
               ->datetime('datetime')  ;
             $validator->add('datetime', 'custom', [
             'rule' => ['verificaData','datetime'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016 23:59)'
            ]);    
         
             $validator               ->notEmpty('intero', 'Inserimento necessario')   
               ->numeric('intero')
               ->range('intero',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
           
                   $validator               ->notEmpty('booleano', 'Inserimento necessario');    
         
             $validator    
               ->allowEmpty('decimale')   
               ->decimal('decimale')
               ->range('decimale',[-1000000,1000000], 'Inserimento consentito fra -999999 e 999999');    
            
    return $validator;
 }
/*End PB*/
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['lingua_id'], 'Lingue'), ['errorField' => 'lingua_id']);
        $rules->add($rules->existsIn(['autore_id'], 'Autori'), ['errorField' => 'autore_id']);

        return $rules;
    }

}
