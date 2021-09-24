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
 * Devmodels Model
 *
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\HasMany $Devices
 * @property \App\Model\Table\DevsimsTable&\Cake\ORM\Association\HasMany $Devsims
 * @property \App\Model\Table\FreedevsTable&\Cake\ORM\Association\HasMany $Freedevs
 *
 * @method \App\Model\Entity\Devmodel newEmptyEntity()
 * @method \App\Model\Entity\Devmodel newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Devmodel[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Devmodel get($primaryKey, $options = [])
 * @method \App\Model\Entity\Devmodel findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Devmodel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Devmodel[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Devmodel|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devmodel saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devmodel[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Devmodel[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Devmodel[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Devmodel[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DevmodelsTable extends Table
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
            ])        ->add('brand', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['brand'],
            ])        ->add('tipo', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['tipo'],
            ])        ->add('costo', 'Search.Value', [
            'fields' => ['costo'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'devmodels';
        $this->setTable($tableName);
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Devices', [
            'foreignKey' => 'devmodel_id',
        ]);
        $this->hasMany('Devsims', [
            'foreignKey' => 'devmodel_id',
        ]);
        $this->hasMany('Freedevs', [
            'foreignKey' => 'devmodel_id',
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
             $validator               ->notEmptyString('title', 'Inserimento necessario')   
               ->notBlank('title');    
         
             $validator    
               ->allowEmptyString('brand')   
               ->notBlank('brand');    
         
             $validator               ->notEmptyString('tipo', 'Inserimento necessario')   
               ->notBlank('tipo');    
         
             $validator    
               ->allowEmpty('costo')   
               ->decimal('costo')
               ->range('costo',[-1000000,1000000], 'Inserimento consentito fra -999999 e 999999');    
            
    return $validator;
 }
/*End PB*/
}
