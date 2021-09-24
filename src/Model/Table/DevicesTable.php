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
 * Devices Model
 *
 * @property \App\Model\Table\DevmodelsTable&\Cake\ORM\Association\BelongsTo $Devmodels
 * @property \App\Model\Table\AlldevnonassegnatisTable&\Cake\ORM\Association\HasMany $Alldevnonassegnatis
 * @property \App\Model\Table\AllocationsTable&\Cake\ORM\Association\HasMany $Allocations
 * @property \App\Model\Table\DevicesimsTable&\Cake\ORM\Association\HasMany $Devicesims
 * @property \App\Model\Table\ExallocationsTable&\Cake\ORM\Association\HasMany $Exallocations
 * @property \App\Model\Table\SimnonassegnateTable&\Cake\ORM\Association\HasMany $Simnonassegnate
 * @property \App\Model\Table\SimphonesTable&\Cake\ORM\Association\HasMany $Simphones
 * @property \App\Model\Table\UploadsTable&\Cake\ORM\Association\HasMany $Uploads
 * @property \App\Model\Table\UploadsimsTable&\Cake\ORM\Association\HasMany $Uploadsims
 *
 * @method \App\Model\Entity\Device newEmptyEntity()
 * @method \App\Model\Entity\Device newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Device[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Device get($primaryKey, $options = [])
 * @method \App\Model\Entity\Device findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Device patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Device[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Device|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevicesTable extends Table
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
    $this->searchManager()        ->add('utenza_imei', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['utenza_imei'],
            ])        ->add('devmodel_id', 'Search.Value', [
            'fields' => ['devmodel_id'],
            ])        ->add('data_carico', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Devices','data_carico');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('data_scarico', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Devices','data_scarico');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('created', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Devices','created');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])        ->add('modified', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Devices','modified');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])   
        ->add('mac', 'Search.Value', [
            'fields' => ['mac'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'devices';
        $this->setTable($tableName);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Devmodels', [
            'foreignKey' => 'devmodel_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Alldevnonassegnatis', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Allocations', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Devicesims', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Exallocations', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Simnonassegnate', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Simphones', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Uploads', [
            'foreignKey' => 'device_id',
        ]);
        $this->hasMany('Uploadsims', [
            'foreignKey' => 'device_id',
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
             $validator               ->notEmptyString('utenza_imei', 'Inserimento necessario')   
               ->notBlank('utenza_imei');    
         
             $validator               ->notEmpty('devmodel_id', 'Inserimento necessario')   
               ->numeric('devmodel_id')
               ->range('devmodel_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
        $validator    ->notEmptyDate('data_carico', 'Inserimento necessario')   
            ->date('data_carico')  ;
             $validator->add('data_carico', 'custom', [
             'rule' => ['verificaData','date'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016)'
            ]);    
         
        $validator    
    ->allowEmptyDate('data_scarico')   
            ->date('data_scarico')  ;
             $validator->add('data_scarico', 'custom', [
             'rule' => ['verificaData','date'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016)'
            ]);    
           
                   $validator    
               ->allowEmpty('mac');    
            
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
        $rules->add($rules->existsIn(['devmodel_id'], 'Devmodels'), ['errorField' => 'devmodel_id']);

        return $rules;
    }

}
