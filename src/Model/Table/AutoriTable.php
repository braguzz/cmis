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
 * Autori Model
 *
 * @property \App\Model\Table\GeneriTable&\Cake\ORM\Association\BelongsTo $Generi
 * @property \App\Model\Table\DischiTable&\Cake\ORM\Association\HasMany $Dischi
 * @property \App\Model\Table\LibriTable&\Cake\ORM\Association\HasMany $Libri
 *
 * @method \App\Model\Entity\Autore newEmptyEntity()
 * @method \App\Model\Entity\Autore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Autore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Autore get($primaryKey, $options = [])
 * @method \App\Model\Entity\Autore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Autore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Autore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Autore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Autore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Autore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Autore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Autore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Autore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AutoriTable extends Table
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
    $this->searchManager()        ->add('nome', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['nome'],
            ])        ->add('cognome', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['cognome'],
            ])        ->add('note', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['note'],
            ])        ->add('genere_id', 'Search.Value', [
            'fields' => ['genere_id'],
            ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'autori';
        $this->setTable($tableName);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Generi', [
            'foreignKey' => 'genere_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Dischi', [
            'foreignKey' => 'autore_id',
        ]);
        $this->hasMany('Libri', [
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
     /*    $validator->add('id', 'custom', [
             'rule' => ['impedisceduplicati','id',$this],
             'provider'=>'custom',
             'message'=>'Record Duplicato'
            ]);  */ 
             $validator    
               ->allowEmptyString('nome')   
               ->notBlank('nome');    
         
             $validator    
               ->allowEmptyString('cognome')   
               ->notBlank('cognome');    
         
             $validator    
               ->allowEmptyString('note')   
               ->notBlank('note');    
         
             $validator               ->notEmpty('genere_id', 'Inserimento necessario')   
               ->numeric('genere_id')
               ->range('genere_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
            
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
        $rules->add($rules->existsIn(['genere_id'], 'Generi'), ['errorField' => 'genere_id']);

        return $rules;
    }

}
