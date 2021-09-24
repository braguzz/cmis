<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
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


<div class="devices view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Device: <?= h($device->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $device->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $device->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $device->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $device->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= h($device->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Utenza Imei') ?></th>
                <td><?= h($device->utenza_imei) ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Devmodel') ?></th>
                <td><?= $device->has('devmodel') ? $this->Html->link($device->devmodel->title, ['controller' => 'Devmodels', 'action' => 'view', $device->devmodel->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mac') ?></th>
                <td><?= h($device->mac) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data Carico') ?></th>
                <td><?= h($device->data_carico) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data Scarico') ?></th>
                <td><?= h($device->data_scarico) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($device->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($device->modified) ?></td>
            </tr>
        </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='alldevnonassegnatis' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Alldevnonassegnatis" aria-controls=" $Alldevnonassegnatis" role="tab" data-toggle="tab">Alldevnonassegnatis</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='allocations' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Allocations" aria-controls=" $Allocations" role="tab" data-toggle="tab">Allocations</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='devicesims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Devicesims" aria-controls=" $Devicesims" role="tab" data-toggle="tab">Devicesims</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='exallocations' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Exallocations" aria-controls=" $Exallocations" role="tab" data-toggle="tab">Exallocations</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='simnonassegnate' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Simnonassegnate" aria-controls=" $Simnonassegnate" role="tab" data-toggle="tab">Simnonassegnate</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='simphones' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Simphones" aria-controls=" $Simphones" role="tab" data-toggle="tab">Simphones</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='uploads' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Uploads" aria-controls=" $Uploads" role="tab" data-toggle="tab">Uploads</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='uploadsims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Uploadsims" aria-controls=" $Uploadsims" role="tab" data-toggle="tab">Uploadsims</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='alldevnonassegnatis' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Alldevnonassegnatis' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Alldevnonassegnatis', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->alldevnonassegnatis)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="AlldevnonassegnatisTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Referente') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('Tipo') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                   
                </tr>
                <?php foreach ($device->alldevnonassegnatis as $alldevnonassegnatis): ?>
                <tr class="Alldevnonassegnatis_id_<?= $alldevnonassegnatis-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Alldevnonassegnatis', 'action' => 'view', $alldevnonassegnatis->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Alldevnonassegnatis', 'action' => 'edit', $alldevnonassegnatis->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Alldevnonassegnatis", fromid : "<?= $alldevnonassegnatis-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($alldevnonassegnatis->device_id) ?></td>
                    <td><?= h($alldevnonassegnatis->owner_id) ?></td>
                    <td><?= h($alldevnonassegnatis->name) ?></td>
                    <td><?= h($alldevnonassegnatis->referente) ?></td>
                    <td><?= h($alldevnonassegnatis->note) ?></td>
                    <td><?= h($alldevnonassegnatis->tipo) ?></td>
                    <td><?= h($alldevnonassegnatis->brand) ?></td>
                    <td><?= h($alldevnonassegnatis->model) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='allocations' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Allocations' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Allocations', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->allocations)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="AllocationsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('InizioUso') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Referente') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('Mail Referente') ?></th>
                   
                </tr>
                <?php foreach ($device->allocations as $allocations): ?>
                <tr class="Allocations_id_<?= $allocations->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Allocations', 'action' => 'view', $allocations->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Allocations', 'action' => 'edit', $allocations->id],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Allocations", fromid : "<?= $allocations->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($allocations->id) ?></td>
                    <td><?= h($allocations->device_id) ?></td>
                    <td><?= h($allocations->owner_id) ?></td>
                    <td><?= h($allocations->InizioUso) ?></td>
                    <td><?= h($allocations->created) ?></td>
                    <td><?= h($allocations->modified) ?></td>
                    <td><?= h($allocations->referente) ?></td>
                    <td><?= h($allocations->note) ?></td>
                    <td><?= h($allocations->mail_referente) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='devicesims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Devicesims' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Devicesims', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->devicesims)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="DevicesimsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Sim Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                   
                </tr>
                <?php foreach ($device->devicesims as $devicesims): ?>
                <tr class="Devicesims_id_<?= $devicesims->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Devicesims', 'action' => 'view', $devicesims->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Devicesims', 'action' => 'edit', $devicesims->id],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Devicesims", fromid : "<?= $devicesims->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($devicesims->id) ?></td>
                    <td><?= h($devicesims->sim_id) ?></td>
                    <td><?= h($devicesims->device_id) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='exallocations' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Exallocations' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Exallocations', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->exallocations)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="ExallocationsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('InizioUso') ?></th>
                    <th scope="col"><?= __('Referente') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('FineUso') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                   
                </tr>
                <?php foreach ($device->exallocations as $exallocations): ?>
                <tr class="Exallocations_id_<?= $exallocations-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Exallocations', 'action' => 'view', $exallocations->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Exallocations', 'action' => 'edit', $exallocations->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Exallocations", fromid : "<?= $exallocations-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($exallocations->id) ?></td>
                    <td><?= h($exallocations->device_id) ?></td>
                    <td><?= h($exallocations->owner_id) ?></td>
                    <td><?= h($exallocations->InizioUso) ?></td>
                    <td><?= h($exallocations->referente) ?></td>
                    <td><?= h($exallocations->note) ?></td>
                    <td><?= h($exallocations->FineUso) ?></td>
                    <td><?= h($exallocations->created) ?></td>
                    <td><?= h($exallocations->modified) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='simnonassegnate' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Simnonassegnate' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Simnonassegnate', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->simnonassegnate)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="SimnonassegnateTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Data Inizio') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('Referente') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                    <th scope="col"><?= __('Tipo') ?></th>
                   
                </tr>
                <?php foreach ($device->simnonassegnate as $simnonassegnate): ?>
                <tr class="Simnonassegnate_id_<?= $simnonassegnate-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Simnonassegnate', 'action' => 'view', $simnonassegnate->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Simnonassegnate', 'action' => 'edit', $simnonassegnate->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Simnonassegnate", fromid : "<?= $simnonassegnate-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($simnonassegnate->device_id) ?></td>
                    <td><?= h($simnonassegnate->owner_id) ?></td>
                    <td><?= h($simnonassegnate->name) ?></td>
                    <td><?= h($simnonassegnate->data_inizio) ?></td>
                    <td><?= h($simnonassegnate->note) ?></td>
                    <td><?= h($simnonassegnate->referente) ?></td>
                    <td><?= h($simnonassegnate->brand) ?></td>
                    <td><?= h($simnonassegnate->model) ?></td>
                    <td><?= h($simnonassegnate->tipo) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='simphones' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Simphones' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Simphones', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->simphones)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="SimphonesTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Owner Id') ?></th>
                    <th scope="col"><?= __('Sim Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Tiposim') ?></th>
                    <th scope="col"><?= __('Brand') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                   
                </tr>
                <?php foreach ($device->simphones as $simphones): ?>
                <tr class="Simphones_id_<?= $simphones-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Simphones', 'action' => 'view', $simphones->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Simphones', 'action' => 'edit', $simphones->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Simphones", fromid : "<?= $simphones-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($simphones->owner_id) ?></td>
                    <td><?= h($simphones->sim_id) ?></td>
                    <td><?= h($simphones->device_id) ?></td>
                    <td><?= h($simphones->tiposim) ?></td>
                    <td><?= h($simphones->brand) ?></td>
                    <td><?= h($simphones->model) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='uploads' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Uploads' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Uploads', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->uploads)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="UploadsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Descrizione') ?></th>
                    <th scope="col"><?= __('Dir') ?></th>
                    <th scope="col"><?= __('Size') ?></th>
                    <th scope="col"><?= __('Type') ?></th>
                   
                </tr>
                <?php foreach ($device->uploads as $uploads): ?>
                <tr class="Uploads_id_<?= $uploads-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Uploads', 'action' => 'view', $uploads->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Uploads', 'action' => 'edit', $uploads->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Uploads", fromid : "<?= $uploads-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($uploads->id) ?></td>
                    <td><?= h($uploads->device_id) ?></td>
                    <td><?= h($uploads->name) ?></td>
                    <td><?= h($uploads->descrizione) ?></td>
                    <td><?= h($uploads->dir) ?></td>
                    <td><?= h($uploads->size) ?></td>
                    <td><?= h($uploads->type) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='uploadsims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Uploadsims' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Uploadsims', 'action' => 'add'],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($device->uploadsims)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="UploadsimsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Device Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Descrizione') ?></th>
                    <th scope="col"><?= __('Dir') ?></th>
                    <th scope="col"><?= __('Size') ?></th>
                    <th scope="col"><?= __('Type') ?></th>
                    <th scope="col"><?= __('Iccd') ?></th>
                   
                </tr>
                <?php foreach ($device->uploadsims as $uploadsims): ?>
                <tr class="Uploadsims_id_<?= $uploadsims-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Uploadsims', 'action' => 'view', $uploadsims->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Uploadsims', 'action' => 'edit', $uploadsims->],['data'=>['returncontroller'=>'devices','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$device->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Uploadsims", fromid : "<?= $uploadsims-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($uploadsims->id) ?></td>
                    <td><?= h($uploadsims->device_id) ?></td>
                    <td><?= h($uploadsims->name) ?></td>
                    <td><?= h($uploadsims->descrizione) ?></td>
                    <td><?= h($uploadsims->dir) ?></td>
                    <td><?= h($uploadsims->size) ?></td>
                    <td><?= h($uploadsims->type) ?></td>
                    <td><?= h($uploadsims->iccd) ?></td>


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
