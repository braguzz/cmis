<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cronoprogramma[]|\Cake\Collection\CollectionInterface $cronoprog
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
<h1 class="page-header"><?= 'Cronoprog' ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group">
 <?= $this->Html->link('', ['action' => 'add', ], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Esporta
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
         <?= $this->Html->link('Esporta in xls', ['action' => 'esportaxls', ], ['title' => __('Esporta in xls'), 'class' => 'dropdown-item']) ?>
         <?= $this->Html->link('Esporta in csv', ['action' => 'esportacsv', ], ['title' => __('Esporta in csv'), 'class' => 'dropdown-item']) ?>
         <?= $this->Html->link('Esporta in pdf', ['action' => 'esportapdf', ], ['title' => __('Esporta in pdf'), 'class' => 'dropdown-item']) ?>
    </div>
  </div>
 </div>
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
        <?=  $this->Html->link('Pulisci', ['action' => 'index'], ['class'=>'btn btn-outline-dark ']) ?>
        </div>
        </div>
        </tr> 
       <tr>  
   <td>  
       <?= $this->Form->control('VERSIONE') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('IDINT') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('CODATTIV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DESATTIV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('PESOATTIV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('FSP') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('FSI') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('FSL') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('RESTATTIV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DATAINIPREV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DATAFINEPREV') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('DATAINIEFF') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('DATAFINEFF') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('STATOATTUAZ') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('PERCATTUAZ') ?>    
   </td>   
    
  </tbody>
</table>
<?= $this->Form->end() ?>
  </div>  
</div>








<?php $this->start('rt_actions'); ?>
<li><?= $this->Html->link(__('New Cronoprogramma'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Interventi'), ['controller' => 'Interventi', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Intervento'), ['controller' => 'Interventi', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('rt_sidebar', '<ul class="nav flex-column">' . $this->fetch('rt_actions') . '</ul>'); ?>

<table class="table table-striped table-sm">
    <thead>
    <tr>
         <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('VERSIONE') ?></th>
        <th scope="col"><?= $this->Paginator->sort('IDINT') ?></th>
        <th scope="col"><?= $this->Paginator->sort('CODATTIV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DESATTIV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('PESOATTIV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('FSP') ?></th>
        <th scope="col"><?= $this->Paginator->sort('FSI') ?></th>
        <th scope="col"><?= $this->Paginator->sort('FSL') ?></th>
        <th scope="col"><?= $this->Paginator->sort('RESTATTIV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DATAINIPREV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DATAFINEPREV') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DATAINIEFF') ?></th>
        <th scope="col"><?= $this->Paginator->sort('DATAFINEFF') ?></th>
        <th scope="col"><?= $this->Paginator->sort('PERCATTUAZ') ?></th>
       
    </tr>
    </thead>
    <tbody>
        <?php foreach ($cronoprog as $cronoprogramma) : ?>
        <tr>
                        <td class="actions" style="width:1%">
           <div class="btn-group" role="group" >

                <?= $this->Html->link('', ['action' => 'view', $cronoprogramma->VERSIONE], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>

                <?= $this->Html->link('', ['action' => 'edit', $cronoprogramma->VERSIONE], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1']) ?>

                <?= $this->Form->postLink('', ['action' => 'delete', $cronoprogramma->VERSIONE], ['confirm' => __('Are you sure you want to delete # {0}?', $cronoprogramma->VERSIONE), 'title' => __('Delete'), 'class' => 'btn btn-sm btn-danger bi-trash mr-1']) ?>

              </div>
                </td>
            <td><?= h($cronoprogramma->VERSIONE) ?></td>
            <td><?= $this->Number->format($cronoprogramma->IDINT) ?></td>
            <td><?= h($cronoprogramma->CODATTIV) ?></td>
            <td><?= h($cronoprogramma->DESATTIV) ?></td>
            <td><?= $this->Number->format($cronoprogramma->PESOATTIV) ?></td>
            <td><?= $this->Number->format($cronoprogramma->FSP) ?></td>
            <td><?= $this->Number->format($cronoprogramma->FSI) ?></td>
            <td><?= $this->Number->format($cronoprogramma->FSL) ?></td>
            <td><?= h($cronoprogramma->RESTATTIV) ?></td>
            <td><?= h($cronoprogramma->DATAINIPREV) ?></td>
            <td><?= h($cronoprogramma->DATAFINEPREV) ?></td>
            <td><?= h($cronoprogramma->DATAINIEFF) ?></td>
            <td><?= h($cronoprogramma->DATAFINEFF) ?></td>
            <td><?= $this->Number->format($cronoprogramma->PERCATTUAZ) ?></td>

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
