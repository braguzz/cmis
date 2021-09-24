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
 * CategorieLibri Model
 *
 * @property \App\Model\Table\LibriTable&\Cake\ORM\Association\BelongsTo $Libri
 * @property \App\Model\Table\CategorieTable&\Cake\ORM\Association\BelongsTo $Categorie
 *
 * @method \App\Model\Entity\CategorieLibro newEmptyEntity()
 * @method \App\Model\Entity\CategorieLibro newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CategorieLibro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategorieLibro get($primaryKey, $options = [])
 * @method \App\Model\Entity\CategorieLibro findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CategorieLibro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CategorieLibro[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategorieLibro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategorieLibro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategorieLibro[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategorieLibro[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategorieLibro[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategorieLibro[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CategorieLibriTable extends Table
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
    $this->searchManager()        ->add('libro_id', 'Search.Value', [
            'fields' => ['libro_id'],
            ])        ->add('categoria_id', 'Search.Value', [
            'fields' => ['categoria_id'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'categorie_libri';
        $this->setTable($tableName);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Libri', [
            'foreignKey' => 'libro_id',
        ]);
        $this->belongsTo('Categorie', [
            'foreignKey' => 'categoria_id',
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
               ->allowEmpty('libro_id')   
               ->numeric('libro_id')
               ->range('libro_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmpty('categoria_id')   
               ->numeric('categoria_id')
               ->range('categoria_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
            
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
        $rules->add($rules->existsIn(['libro_id'], 'Libri'), ['errorField' => 'libro_id']);
        $rules->add($rules->existsIn(['categoria_id'], 'Categorie'), ['errorField' => 'categoria_id']);

        return $rules;
    }

}
