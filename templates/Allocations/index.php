<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Allocation[]|\Cake\Collection\CollectionInterface $allocations
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
<h1 class="page-header"><?= 'Allocations' ?></h1>
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
       <?= $this->Form->control('id') ?>    
   </td>   
    
  
   <td>  
        <?= $this->Form->control('device_id', ['empty' => 'scegli']) ?>    
   </td>   
    
  
   <td>  
        <?= $this->Form->control('owner_id', ['empty' => 'scegli']) ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('InizioUso') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('created') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('modified') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('referente') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('note') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('mail_referente') ?>    
   </td>   
    
  </tbody>
</table>
<?= $this->Form->end() ?>
  </div>  
</div>








<?php $this->start('rt_actions'); ?>
<li><?= $this->Html->link(__('New Allocation'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Devices'), ['controller' => 'Devices', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Device'), ['controller' => 'Devices', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Owners'), ['controller' => 'Owners', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Owner'), ['controller' => 'Owners', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Querynomail'), ['controller' => 'Querynomail', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Querynomail'), ['controller' => 'Querynomail', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Rifproceduras'), ['controller' => 'Rifproceduras', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Rifprocedura'), ['controller' => 'Rifproceduras', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('rt_sidebar', '<ul class="nav flex-column">' . $this->fetch('rt_actions') . '</ul>'); ?>

<table class="table table-striped table-sm">
    <thead>
    <tr>
         <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('device_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('owner_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('InizioUso') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('referente') ?></th>
        <th scope="col"><?= $this->Paginator->sort('mail_referente') ?></th>
       
    </tr>
    </thead>
    <tbody>
        <?php foreach ($allocations as $allocation) : ?>
        <tr>
                        <td class="actions" style="width:1%">
           <div class="btn-group" role="group" >

                <?= $this->Html->link('', ['action' => 'view', $allocation->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>

                <?= $this->Html->link('', ['action' => 'edit', $allocation->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1']) ?>

                <?= $this->Form->postLink('', ['action' => 'delete', $allocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $allocation->id), 'title' => __('Delete'), 'class' => 'btn btn-sm btn-danger bi-trash mr-1']) ?>

              </div>
                </td>
            <td><?= $this->Number->format($allocation->id) ?></td>
            <td><?= $allocation->has('device') ? $this->Html->link($allocation->device->id, ['controller' => 'Devices', 'action' => 'view', $allocation->device->id]) : '' ?></td>
            <td><?= $allocation->has('owner') ? $this->Html->link($allocation->owner->name, ['controller' => 'Owners', 'action' => 'view', $allocation->owner->id]) : '' ?></td>
            <td><?= h($allocation->InizioUso) ?></td>
            <td><?= h($allocation->created) ?></td>
            <td><?= h($allocation->modified) ?></td>
            <td><?= h($allocation->referente) ?></td>
            <td><?= h($allocation->mail_referente) ?></td>

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
