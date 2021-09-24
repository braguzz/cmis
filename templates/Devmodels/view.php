<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Devmodel $devmodel
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


<div class="devmodels view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Devmodel: <?= h($devmodel->title) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $devmodel->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $devmodel->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $devmodel->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $devmodel->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('Title') ?></th>
                <td><?= h($devmodel->title) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Brand') ?></th>
                <td><?= h($devmodel->brand) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Tipo') ?></th>
                <td><?= h($devmodel->tipo) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($devmodel->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Costo') ?></th>
                <td><?= $this->Number->format($devmodel->costo) ?></td>
            </tr>
        </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='devices' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Devices" aria-controls=" $Devices" role="tab" data-toggle="tab">Devices</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='devsims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Devsims" aria-controls=" $Devsims" role="tab" data-toggle="tab">Devsims</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='freedevs' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Freedevs" aria-controls=" $Freedevs" role="tab" data-toggle="tab">Freedevs</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='devices' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Devices' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Devices', 'action' => 'add'],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($devmodel->devices)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="DevicesTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Utenza Imei') ?></th>
                    <th scope="col"><?= __('Devmodel Id') ?></th>
                    <th scope="col"><?= __('Data Carico') ?></th>
                    <th scope="col"><?= __('Data Scarico') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Mac') ?></th>
                   
                </tr>
                <?php foreach ($devmodel->devices as $devices): ?>
                <tr class="Devices_id_<?= $devices->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Devices', 'action' => 'view', $devices->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Devices', 'action' => 'edit', $devices->id],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Devices", fromid : "<?= $devices->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($devices->id) ?></td>
                    <td><?= h($devices->utenza_imei) ?></td>
                    <td><?= h($devices->devmodel_id) ?></td>
                    <td><?= h($devices->data_carico) ?></td>
                    <td><?= h($devices->data_scarico) ?></td>
                    <td><?= h($devices->created) ?></td>
                    <td><?= h($devices->modified) ?></td>
                    <td><?= h($devices->mac) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='devsims' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Devsims' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Devsims', 'action' => 'add'],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($devmodel->devsims)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="DevsimsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Devmodel Id') ?></th>
                    <th scope="col"><?= __('Data Carico') ?></th>
                    <th scope="col"><?= __('Data Scarico') ?></th>
                   
                </tr>
                <?php foreach ($devmodel->devsims as $devsims): ?>
                <tr class="Devsims_id_<?= $devsims-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Devsims', 'action' => 'view', $devsims->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Devsims', 'action' => 'edit', $devsims->],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Devsims", fromid : "<?= $devsims-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($devsims->id) ?></td>
                    <td><?= h($devsims->devmodel_id) ?></td>
                    <td><?= h($devsims->data_carico) ?></td>
                    <td><?= h($devsims->data_scarico) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='freedevs' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Freedevs' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Freedevs', 'action' => 'add'],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($devmodel->freedevs)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="FreedevsTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Devmodel Id') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                    <th scope="col"><?= __('Free') ?></th>
                   
                </tr>
                <?php foreach ($devmodel->freedevs as $freedevs): ?>
                <tr class="Freedevs_id_<?= $freedevs-> ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Freedevs', 'action' => 'view', $freedevs->], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Freedevs', 'action' => 'edit', $freedevs->],['data'=>['returncontroller'=>'devmodels','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$devmodel->], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Freedevs", fromid : "<?= $freedevs-> ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($freedevs->id) ?></td>
                    <td><?= h($freedevs->devmodel_id) ?></td>
                    <td><?= h($freedevs->model) ?></td>
                    <td><?= h($freedevs->free) ?></td>


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
