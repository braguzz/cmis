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
 * Allocations Model
 *
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\BelongsTo $Devices
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 * @property \App\Model\Table\QuerynomailTable&\Cake\ORM\Association\HasMany $Querynomail
 * @property \App\Model\Table\RifprocedurasTable&\Cake\ORM\Association\HasMany $Rifproceduras
 *
 * @method \App\Model\Entity\Allocation newEmptyEntity()
 * @method \App\Model\Entity\Allocation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Allocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Allocation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Allocation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Allocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Allocation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Allocation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Allocation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Allocation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Allocation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Allocation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Allocation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AllocationsTable extends Table
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
    $this->searchManager()        ->add('device_id', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['device_id'],
            ])   
        ->add('owner_id', 'Search.Value', [
            'fields' => ['owner_id'],
            ])        ->add('InizioUso', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Allocations','InizioUso');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('created', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Allocations','created');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('modified', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Allocations','modified');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('referente', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['referente'],
            ])        ->add('note', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['note'],
            ])        ->add('mail_referente', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['mail_referente'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'allocations';
        $this->setTable($tableName);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Owners', [
            'foreignKey' => 'owner_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Querynomail', [
            'foreignKey' => 'allocation_id',
        ]);
        $this->hasMany('Rifproceduras', [
            'foreignKey' => 'allocation_id',
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
     /*    $validator->add('id', 'custom', [
             'rule' => ['impedisceduplicati','id',$this],
             'provider'=>'custom',
             'message'=>'Record Duplicato'
            ]);  */ 
             $validator               ->notEmptyString('device_id', 'Inserimento necessario')   
               ->notBlank('device_id');    
           
                   $validator               ->notEmpty('owner_id', 'Inserimento necessario');    
         
        $validator    ->notEmptyDate('InizioUso', 'Inserimento necessario')   
            ->date('InizioUso')  ;
             $validator->add('InizioUso', 'custom', [
             'rule' => ['verificaData','date'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016)'
            ]);    
         
             $validator    
               ->allowEmptyString('referente')   
               ->notBlank('referente');    
         
             $validator    
               ->allowEmptyString('note')   
               ->notBlank('note');    
         
             $validator    
               ->allowEmptyString('mail_referente')   
               ->notBlank('mail_referente');    
            
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
        $rules->add($rules->existsIn(['device_id'], 'Devices'), ['errorField' => 'device_id']);
        $rules->add($rules->existsIn(['owner_id'], 'Owners'), ['errorField' => 'owner_id']);

        return $rules;
    }

}
