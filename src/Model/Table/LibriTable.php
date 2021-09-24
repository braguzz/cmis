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
 * Libri Model
 *
 * @property \App\Model\Table\LingueTable&\Cake\ORM\Association\BelongsTo $Lingue
 * @property \App\Model\Table\AutoriTable&\Cake\ORM\Association\BelongsTo $Autori
 * @property \App\Model\Table\CategorieTable&\Cake\ORM\Association\BelongsToMany $Categorie
 *
 * @method \App\Model\Entity\Libro newEmptyEntity()
 * @method \App\Model\Entity\Libro newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Libro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Libro get($primaryKey, $options = [])
 * @method \App\Model\Entity\Libro findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Libro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Libro[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Libro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Libro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Libro[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Libro[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Libro[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Libro[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LibriTable extends Table
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
    $this->searchManager()        ->add('titolo', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['titolo'],
            ])        ->add('numero_scaffale', 'Search.Value', [
            'fields' => ['numero_scaffale'],
            ])        ->add('lingua_id', 'Search.Value', [
            'fields' => ['lingua_id'],
            ])        ->add('autore_id', 'Search.Value', [
            'fields' => ['autore_id'],
            ])        ->add('disponibile', 'Search.Boolean', [
            'mode' => 'or',
            'fields' => ['disponibile'],
            ])        ->add('data_acquisto', 'Search.Callback', 
            [
            'callback' => function($query, $args, $manager) {
              $dd= \DateDataPerRicerca($query,$args,'Libri','data_acquisto');    //funzione in config/common.php
              $query= $dd['query'];
              return $dd['return'];
            }
        ])   
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'libri';
        $this->setTable($tableName);
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Lingue', [
            'foreignKey' => 'lingua_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Autori', [
            'foreignKey' => 'autore_id',
        ]);
        $this->belongsToMany('Categorie', [
            'foreignKey' => 'libro_id',
            'targetForeignKey' => 'categoria_id',
            'joinTable' => 'categorie_libri',
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
             $validator               ->notEmptyString('titolo', 'Inserimento necessario')   
               ->notBlank('titolo');    
         
             $validator    
               ->allowEmpty('numero_scaffale')   
               ->decimal('numero_scaffale')
               ->range('numero_scaffale',[-1000000,1000000], 'Inserimento consentito fra -999999 e 999999');    
         
             $validator               ->notEmpty('lingua_id', 'Inserimento necessario')   
               ->numeric('lingua_id')
               ->range('lingua_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
         
             $validator    
               ->allowEmpty('autore_id')   
               ->numeric('autore_id')
               ->range('autore_id',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
           
                   $validator               ->notEmpty('disponibile', 'Inserimento necessario');    
         
        $validator    
    ->allowEmptyDate('data_acquisto')   
            ->date('data_acquisto')  ;
             $validator->add('data_acquisto', 'custom', [
             'rule' => ['verificaData','date'],
             'provider'=>'custom',
             'message'=>'Data errata (esempio 31/12/2016)'
            ]);    
            
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
