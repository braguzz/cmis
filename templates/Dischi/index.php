<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Disco[]|\Cake\Collection\CollectionInterface $dischi
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
<h1 class="page-header"><?= 'Dischi' ?></h1>
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
       <?= $this->Form->control('title') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('descrizione') ?>    
   </td>   
    
  
   <td>  
        <?= $this->Form->control('lingua_id', ['empty' => 'scegli']) ?>    
   </td>   
    
  
   <td>  
        <?= $this->Form->control('autore_id', ['empty' => 'scegli']) ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('data') ?>    
   </td>   
    
 
       <tr>  
   <td>  
       <?= $this->Form->control('datetime') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('created') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('modified') ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('intero') ?>    
   </td>   
    
  
   <td>            <?= $this->Form->control('booleano',[ 'options' => [
                                                '' => 'scegli',
                                                '1' => 'Si',
                                                '0' => 'No'
                                            ]])  ?>    
   </td>   
    
  
   <td>  
       <?= $this->Form->control('decimale') ?>    
   </td>   
    
  </tbody>
</table>
<?= $this->Form->end() ?>
  </div>  
</div>








<?php $this->start('rt_actions'); ?>
<li><?= $this->Html->link(__('New Disco'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Lingue'), ['controller' => 'Lingue', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Lingua'), ['controller' => 'Lingue', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Autori'), ['controller' => 'Autori', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Autore'), ['controller' => 'Autori', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('rt_sidebar', '<ul class="nav flex-column">' . $this->fetch('rt_actions') . '</ul>'); ?>

<table class="table table-striped table-sm">
    <thead>
    <tr>
         <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('lingua_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('autore_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('data') ?></th>
        <th scope="col"><?= $this->Paginator->sort('datetime') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('intero') ?></th>
        <th scope="col"><?= $this->Paginator->sort('booleano') ?></th>
        <th scope="col"><?= $this->Paginator->sort('decimale') ?></th>
       
    </tr>
    </thead>
    <tbody>
        <?php foreach ($dischi as $disco) : ?>
        <tr>
                        <td class="actions" style="width:1%">
           <div class="btn-group" role="group" >

                <?= $this->Html->link('', ['action' => 'view', $disco->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>

                <?= $this->Html->link('', ['action' => 'edit', $disco->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1']) ?>

                <?= $this->Form->postLink('', ['action' => 'delete', $disco->id], ['confirm' => __('Are you sure you want to delete # {0}?', $disco->id), 'title' => __('Delete'), 'class' => 'btn btn-sm btn-danger bi-trash mr-1']) ?>

              </div>
                </td>
            <td><?= $this->Number->format($disco->id) ?></td>
            <td><?= $disco->has('lingua') ? $this->Html->link($disco->lingua->title, ['controller' => 'Lingue', 'action' => 'view', $disco->lingua->id]) : '' ?></td>
            <td><?= $disco->has('autore') ? $this->Html->link($disco->autore->id, ['controller' => 'Autori', 'action' => 'view', $disco->autore->id]) : '' ?></td>
            <td><?= h($disco->data) ?></td>
            <td><?= h($disco->datetime) ?></td>
            <td><?= h($disco->created) ?></td>
            <td><?= h($disco->modified) ?></td>
            <td><?= $this->Number->format($disco->intero) ?></td>
            <td><?= h($disco->booleano) ?></td>
            <td><?= $this->Number->format($disco->decimale) ?></td>

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
