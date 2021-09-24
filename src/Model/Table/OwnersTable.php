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
 * Owners Model
 *
 * @property \App\Model\Table\AccountmailsTable&\Cake\ORM\Association\HasMany $Accountmails
 * @property \App\Model\Table\AlldevnonassegnatisTable&\Cake\ORM\Association\HasMany $Alldevnonassegnatis
 * @property \App\Model\Table\AllocationsTable&\Cake\ORM\Association\HasMany $Allocations
 * @property \App\Model\Table\ExallocationsTable&\Cake\ORM\Association\HasMany $Exallocations
 * @property \App\Model\Table\QuerynomailTable&\Cake\ORM\Association\HasMany $Querynomail
 * @property \App\Model\Table\SelectsimabbinatesTable&\Cake\ORM\Association\HasMany $Selectsimabbinates
 * @property \App\Model\Table\SimnonassegnateTable&\Cake\ORM\Association\HasMany $Simnonassegnate
 * @property \App\Model\Table\SimphonesTable&\Cake\ORM\Association\HasMany $Simphones
 *
 * @method \App\Model\Entity\Owner newEmptyEntity()
 * @method \App\Model\Entity\Owner newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Owner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Owner get($primaryKey, $options = [])
 * @method \App\Model\Entity\Owner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Owner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Owner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Owner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Owner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class OwnersTable extends Table
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
    $this->searchManager()        ->add('id', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['id'],
            ])        ->add('cmu', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['cmu'],
            ])        ->add('name', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['name'],
            ])        ->add('title', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['title'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'owners';
        $this->setTable($tableName);
        $this->setDisplayField('name');
                $this->setPrimaryKey('id');

        $this->hasMany('Accountmails', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Alldevnonassegnatis', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Allocations', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Exallocations', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Querynomail', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Selectsimabbinates', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Simnonassegnate', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('Simphones', [
            'foreignKey' => 'owner_id',
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
             $validator    
               ->allowEmptyString('id')   
               ->notBlank('id');    
         
             $validator    
               ->allowEmptyString('cmu')   
               ->notBlank('cmu');    
         
             $validator    
               ->allowEmptyString('name')   
               ->notBlank('name');    
         
             $validator    
               ->allowEmptyString('title')   
               ->notBlank('title');    
            
    return $validator;
 }
/*End PB*/
}
