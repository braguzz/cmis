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
 * Lingue Model
 *
 * @property \App\Model\Table\DischiTable&\Cake\ORM\Association\HasMany $Dischi
 * @property \App\Model\Table\LibriTable&\Cake\ORM\Association\HasMany $Libri
 *
 * @method \App\Model\Entity\Lingua newEmptyEntity()
 * @method \App\Model\Entity\Lingua newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Lingua[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lingua get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lingua findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Lingua patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lingua[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lingua|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lingua saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lingua[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lingua[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lingua[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lingua[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LingueTable extends Table
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
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'lingue';
        $this->setTable($tableName);
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Dischi', [
            'foreignKey' => 'lingua_id',
        ]);
        $this->hasMany('Libri', [
            'foreignKey' => 'lingua_id',
        ]);
    }




//PB Validation Rules
 public function validationDefault(Validator $validator): Validator
    {
        // Validation Provider custom in src\Model\RegtoscProvider.php
        $validator->setProvider('custom',  new \App\Model\RegtoscProvider());
 
  /*      $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
         $validator->add('id', 'custom', [
             'rule' => ['impedisceduplicati','id',$this],
             'provider'=>'custom',
             'message'=>'Record Duplicato'
            ]); */
             $validator    
               ->allowEmptyString('title')   
               ->notBlank('title');    
            
    return $validator;
 }
/*End PB*/
}
