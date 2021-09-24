<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Intervento[]|\Cake\Collection\CollectionInterface $interventi
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard');
$this->Html->script('jquery.cookie', ['block' => true]);
$this->Html->script('mostraricerca', ['block' => true]);
 ?>
<!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
<h1 class="page-header"><?= 'Interventi' ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
    <?= $this->Form->postButton('', ['controller' => $return['returncontroller'],'action' => 'view',$return['returncontrollerid']],['class' => 'btn btn-sm btn-info bi-arrow-left m-1']) ?>

 </div>
<div class="col text-right">
   <button id="ricercasi" type="button" class="btn btn-outline-primary bi-search mr-1"> 
       </button>
   <button id="ricercano" type="button" class="btn btn-outline-primary bi-search mr-1 active">
       </button>    
</div>
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->

<!-- ================================= -->
<!-- FORM DI RICERCA su piu' RIGHE     -->
<!-- ================================= -->
<div id="ricerc" class="card">
    <div class="card-body">
    
<?= $this->Form->create(null, ['valueSources' => 'query']) ?>
<table class="table table-sm table-borderless">
    <tr>
        <div class="text-center">
        <div class="btn-group" role="group">
        <?= $this->Form->button('Cerca', ['type' => 'submit', 'class'=>'btn btn-outline-info  mr-1']) ?>
        <?= $this->Form->postButton('Pulisci', [ 'action' => 'indexexternal'],['data'=>['returncontroller'=>$return['returncontroller'],'returncontrollerid'=>$return['returncontrollerid'],'returnmodel'=>$return['returnmodel'],'returnsaveme'=>$return['returnsaveme']], 'class' => 'btn btn-outline-info rounded-right']) ?>

        <?=  $this->Form->Hidden('returncontroller', ['default' => $return['returncontroller']]) ?>
        <?=  $this->Form->Hidden('returncontrollerid', ['default' => $return['returncontrollerid']]) ?>
        <?=  $this->Form->Hidden('returnmodel', ['default' => $return['returnmodel']]) ?>
        <?=  $this->Form->Hidden('returnsaveme', ['default' => $return['returnsaveme']]) ?>
        </div>
        </div>
        </tr> 
       <tr>  
   <td>  
       <?= $this->Form->control('id') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('VERSIONE') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('IDINT') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DESLDITEMP') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('TITOLOINT') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DESCRINT') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('ANNODEFR') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('FLAGPQPO') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('CODCMU') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('MATRESPOP') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('NOTEANAG') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('NOTECRONOPROG') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('INTMONITORATO') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('MONITSTATO') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('ANNOINIZIOINT') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('STATOINT') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('MATRCSG') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('CODLOCPROG') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('INSVERS') ?>    
   </td>   
    
  </tbody>
</table>
<?= $this->Form->end() ?>
  </div>  
</div>








<?php $this->start('rt_actions'); ?>
<li><?= $this->Html->link(__('New Intervento'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('rt_sidebar', '<ul class="nav flex-column">' . $this->fetch('rt_actions') . '</ul>'); ?>

<table class="table table-striped table-sm">
    <thead>
    <tr>
         <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('VERSIONE') ?></th>
        <th scope="col"><?= $this->Paginator->sort('IDINT') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DESLDITEMP') ?></th>
        <th scope="col"><?= $this->Paginator->sort('TITOLOINT') ?></th>
        <th scope="col"><?= $this->Paginator->sort('ANNODEFR') ?></th>
        <th scope="col"><?= $this->Paginator->sort('FLAGPQPO') ?></th>
        <th scope="col"><?= $this->Paginator->sort('CODCMU') ?></th>
        <th scope="col"><?= $this->Paginator->sort('MATRESPOP') ?></th>
        <th scope="col"><?= $this->Paginator->sort('INTMONITORATO') ?></th>
        <th scope="col"><?= $this->Paginator->sort('MONITSTATO') ?></th>
        <th scope="col"><?= $this->Paginator->sort('ANNOINIZIOINT') ?></th>
        <th scope="col"><?= $this->Paginator->sort('STATOINT') ?></th>
        <th scope="col"><?= $this->Paginator->sort('MATRCSG') ?></th>
        <th scope="col"><?= $this->Paginator->sort('CODLOCPROG') ?></th>
        <th scope="col"><?= $this->Paginator->sort('INSVERS') ?></th>
       
    </tr>
    </thead>
    <tbody>
        <?php foreach ($interventi as $intervento) : ?>
        <tr>
                        <td class="actions" style="width:1%">
           <div class="btn-group" role="group" >

        
    <?= $this->Form->postButton('', ['controller' => $return['returncontroller'], 'action' => 'addhabtm', $return['returncontrollerid']],['data'=>['id'=>$intervento->id, 'returnid'=>$return['returncontrollerid'], 'return'=>'Interventi'], 'class' => 'btn btn-outline-dark btn-sm bi-check  mr-1','title'=>'Inserisci collegamento']) ?>

                
              </div>
                </td>
            <td><?= $this->Number->format($intervento->id) ?></td>
            <td><?= h($intervento->VERSIONE) ?></td>
            <td><?= $this->Number->format($intervento->IDINT) ?></td>
            <td><?= h($intervento->DESLDITEMP) ?></td>
            <td><?= h($intervento->TITOLOINT) ?></td>
            <td><?= h($intervento->ANNODEFR) ?></td>
            <td><?= $this->Number->format($intervento->FLAGPQPO) ?></td>
            <td><?= h($intervento->CODCMU) ?></td>
            <td><?= h($intervento->MATRESPOP) ?></td>
            <td><?= $this->Number->format($intervento->INTMONITORATO) ?></td>
            <td><?= h($intervento->MONITSTATO) ?></td>
            <td><?= h($intervento->ANNOINIZIOINT) ?></td>
            <td><?= h($intervento->STATOINT) ?></td>
            <td><?= h($intervento->MATRCSG) ?></td>
            <td><?= h($intervento->CODLOCPROG) ?></td>
            <td><?= h($intervento->INSVERS) ?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>


<script>
    
    $(document).ready(function()
    {
        // Attiva autocomplete sui campi di ricerca
        // PARAMETRI per doAc(): 
        //      l'identificativo (id HTML) del campo del form
        //      l'Entity (non la tabella) di loookup, in cui cercare i dati
        //      il nome del campo di lookup, in cui cercare i dati
        //      numero di caratteri minimi per far scattare la ricerca autocomplete (OPZIONALE. Default=3)
        //      true = verifica il dato inserito (OPZIONALE. Default=false)
        //
        // ES:
        //      doAc('titolo', 'Libri' , 'name');           
        //      doAc('autore-id', 'Autori' , 'cognome'); ( in questo caso nel form inserire     <?= $this->Form->control('autore_id',['type' => 'text']) ?>   )
                    
    });    
    
    // chiama la funzione mostraRicerca presente in js/mostraricerca.js per mostrare/nascondere il blocco ricerca
    mostraRicerca();


</script>
