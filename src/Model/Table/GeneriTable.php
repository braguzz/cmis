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
 * Generi Model
 *
 * @property \App\Model\Table\AutoriTable&\Cake\ORM\Association\HasMany $Autori
 *
 * @method \App\Model\Entity\Genere newEmptyEntity()
 * @method \App\Model\Entity\Genere newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Genere[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Genere get($primaryKey, $options = [])
 * @method \App\Model\Entity\Genere findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Genere patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Genere[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Genere|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genere saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genere[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genere[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genere[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genere[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GeneriTable extends Table
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
        $tableName=$dbPrefix . 'generi';
        $this->setTable($tableName);
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Autori', [
            'foreignKey' => 'genere_id',
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
            
    return $validator;
 }
/*End PB*/
}
