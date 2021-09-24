<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Allocation $allocation
 */
?>


<!-- Fa vedere tramite TAB le righe delle tabelle collegate -->
<!-- Se la relazione e' 1:n e' possibile inserire un nuova riga -->
<!-- per l'inserimento si lancia semplicemente il controller add della tabella correlata -->
<!-- con i parametri di ritorno -->
<!-- Se la relazione e' n:m oltre ad inserire e' possibile scegliere fra righe gia presenti -->
<!-- per questa ricerca si chiama il controller indexexternal con i parametri di ritorno -->
<!--  -->
<!-- Per 1:n in ogni riga e' presente il bottone rimuovi che lancia il JS Remove-->
<!-- che, tramite chiamata Ajax al controller removeAjaxBelong cancella la riga dal DB e al ritorno -->
<!-- si preoccupa di togliere la riga dalla table html -->
<!-- nelle righe con n:m e' anche presente il bottone removehabtm che tramite il JS RemoveHABTM -->
<!-- fa la stessa cosa ma rimuove il collegamento fra le due tabelle -->
<!--  -->
<!--  -->
<script>
function Remove(data) {
        if (confirm("Sei sicuro di Cancellare?")) {   
            var nomes = data.from;
            var targeturl = MYAPP + '/' + nomes + '/removeajaxbelong/' + data.fromid;
            jQuery.ajax({
                type: 'post',
                async: true,
                cache: false,
                url: targeturl,
                success: function (response) {
                if (response.error === '0') {
                    $('.' + nomes + '_id_' + data.fromid).remove();
                     }
                } 
            });
            return false;
        }
        return false;
    };
    
 function RemoveHABTM(data) {
     console.log(data)
        if (confirm("Sei sicuro di rimuovere il collegamento?")) {
            var nomes = data.from;
            var targeturl = MYAPP + '/' + nomes + '/removehabtmajaxbelong/' + data.fromid;
            jQuery.ajax({
                type: 'post',
                async: true,
                cache: false,
                url: targeturl,
                success: function (response) {
                      $('.' + nomes + '_id_' + data.fromid).remove();
                },
                data: {data}
            });
            return false;
        }
        return false;

    };  


</script>


<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>


<div class="allocations view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Allocation: <?= h($allocation->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $allocation->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $allocation->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $allocation->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $allocation->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Device') ?></th>
                <td><?= $allocation->has('device') ? $this->Html->link($allocation->device->id, ['controller' => 'Devices', 'action' => 'view', $allocation->device->id]) : '' ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Owner') ?></th>
                <td><?= $allocation->has('owner') ? $this->Html->link($allocation->owner->name, ['controller' => 'Owners', 'action' => 'view', $allocation->owner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Referente') ?></th>
                <td><?= h($allocation->referente) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mail Referente') ?></th>
                <td><?= h($allocation->mail_referente) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($allocation->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('InizioUso') ?></th>
                <td><?= h($allocation->InizioUso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($allocation->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($allocation->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Note') ?></h4>
        <?= $this->Text->autoParagraph(h($allocation->note)); ?>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='querynomail' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Querynomail" aria-controls=" $Querynomail" role="tab" data-toggle="tab">Querynomail</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='rifproceduras' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Rifproceduras" aria-controls=" $Rifproceduras" role="tab" data-toggle="tab">Rifproceduras</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='querynomail' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Querynomail' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Querynomail', 'action' => 'add'],['data'=>['returncontroller'=>'allocations','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$allocation->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($allocation->querynomail)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="QuerynomailTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Allocation Id') ?></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                    <th scope="col"><?= __('Tipo') ?></th>
                    <th scope="col"><?= __('Cmu') ?></th>
                    <th scope="col"><?= __('Referente') ?></th>
                    <th scope="col"><?= __('Mail Referente') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                   
                </tr>
                <?php foreach ($allocation->querynomail as $querynomail): ?>
                <tr class="Querynomail_id_<?= $querynomail-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Querynomail', 'action' => 'view', $querynomail->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Querynomail', 'action' => 'edit', $querynomail->],['data'=>['returncontroller'=>'allocations','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$allocation->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Querynomail", fromid : "<?= $querynomail-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($querynomail->allocation_id) ?></td>
                    <td><?= h($querynomail->owner_id) ?></td>
                    <td><?= h($querynomail->name) ?></td>
                    <td><?= h($querynomail->model) ?></td>
                    <td><?= h($querynomail->tipo) ?></td>
                    <td><?= h($querynomail->cmu) ?></td>
                    <td><?= h($querynomail->referente) ?></td>
                    <td><?= h($querynomail->mail_referente) ?></td>
                    <td><?= h($querynomail->note) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='rifproceduras' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Rifproceduras' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Rifproceduras', 'action' => 'add'],['data'=>['returncontroller'=>'allocations','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$allocation->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($allocation->rifproceduras)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="RifprocedurasTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Procedura Id') ?></th>
                    <th scope="col"><?= __('Allocation Id') ?></th>
                    <th scope="col"><?= __('Exallocation Id') ?></th>
                    <th scope="col"><?= __('Tipoconsegna Id') ?></th>
                    <th scope="col"><?= __('Verbale Consegna') ?></th>
                    <th scope="col"><?= __('Verbale Riconsegna') ?></th>
                    <th scope="col"><?= __('In Lavorazione') ?></th>
                    <th scope="col"><?= __('Pronto') ?></th>
                    <th scope="col"><?= __('Data Chiusura') ?></th>
                   
                </tr>
                <?php foreach ($allocation->rifproceduras as $rifproceduras): ?>
                <tr class="Rifproceduras_id_<?= $rifproceduras-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Rifproceduras', 'action' => 'view', $rifproceduras->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Rifproceduras', 'action' => 'edit', $rifproceduras->],['data'=>['returncontroller'=>'allocations','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$allocation->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Rifproceduras", fromid : "<?= $rifproceduras-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($rifproceduras->id) ?></td>
                    <td><?= h($rifproceduras->procedura_id) ?></td>
                    <td><?= h($rifproceduras->allocation_id) ?></td>
                    <td><?= h($rifproceduras->exallocation_id) ?></td>
                    <td><?= h($rifproceduras->tipoconsegna_id) ?></td>
                    <td><?= h($rifproceduras->verbale_consegna) ?></td>
                    <td><?= h($rifproceduras->verbale_riconsegna) ?></td>
                    <td><?= h($rifproceduras->in_lavorazione) ?></td>
                    <td><?= h($rifproceduras->pronto) ?></td>
                    <td><?= h($rifproceduras->data_chiusura) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        
   
        
   
</div>





</div>
