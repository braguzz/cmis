<?php
declare(strict_types=1);

namespace ReportSql\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
/**
 * Reports Model
 *
 * @method \ReportSql\Model\Entity\Report newEmptyEntity()
 * @method \ReportSql\Model\Entity\Report newEntity(array $data, array $options = [])
 * @method \ReportSql\Model\Entity\Report[] newEntities(array $data, array $options = [])
 * @method \ReportSql\Model\Entity\Report get($primaryKey, $options = [])
 * @method \ReportSql\Model\Entity\Report findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ReportSql\Model\Entity\Report patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ReportSql\Model\Entity\Report[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ReportSql\Model\Entity\Report|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ReportSql\Model\Entity\Report saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ReportSql\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ReportSql\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ReportSql\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ReportSql\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ReportsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    
    public $parametripaginazione;
    
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
          // Add the behavior to your table
 
       
    //PB per search
    $this->addBehavior('Search.Search');
    $this->searchManager()        ->add('name', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['name'],
            ])        ->add('strsql', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['strsql'],
            ])        ->add('db', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'fields' => ['db'],
            ])         ->add('menu', 'Search.Boolean', [
            'mode' => 'or',
            'fields' => ['menu'],
            ])
    ;
    //End PB          
        

        $dbPrefix=Configure::read('regtoscConf.dbPrefix');
        $tableName=$dbPrefix . 'reports';
        $this->setTable($tableName);
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
               ->notEmptyString('name', 'Inserimento necessario')   
               ->notBlank('name');    
         
             $validator    
               ->notEmptyString('strsql', 'Inserimento necessario')   
               ->notBlank('strsql');    
         
             $validator               ->notEmptyString('db', 'Inserimento necessario')   
               ->notBlank('db');    
         
             $validator    
               ->notEmpty('menu')   
               ->numeric('menu')
               ->range('menu',[-1,1000000], 'Inserimento consentito fra 0 e 999999');    
            
    return $validator;
 }
 

}
