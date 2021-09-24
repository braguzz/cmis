<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Autore $autore
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


<div class="autori view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Autore: <?= h($autore->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $autore->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $autore->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $autore->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $autore->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('Nome') ?></th>
                <td><?= h($autore->nome) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Cognome') ?></th>
                <td><?= h($autore->cognome) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Note') ?></th>
                <td><?= h($autore->note) ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Genere') ?></th>
                <td><?= $autore->has('genere') ? $this->Html->link($autore->genere->title, ['controller' => 'Generi', 'action' => 'view', $autore->genere->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($autore->id) ?></td>
            </tr>
        </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='dischi' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Dischi" aria-controls=" $Dischi" role="tab" data-toggle="tab">Dischi</a>

</li>


<?php $activetab=''; ?>
<?php if (($return['tab']=='libri' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Libri" aria-controls=" $Libri" role="tab" data-toggle="tab">Libri</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='dischi' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class="tab-pane <?= $activetab ?>" id='Dischi' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Dischi', 'action' => 'add'],['data'=>['returncontroller'=>'autori','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$autore->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($autore->dischi)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="DischiTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Title') ?></th>
                    <th scope="col"><?= __('Descrizione') ?></th>
                    <th scope="col"><?= __('Lingua Id') ?></th>
                    <th scope="col"><?= __('Autore Id') ?></th>
                    <th scope="col"><?= __('Data') ?></th>
                    <th scope="col"><?= __('Datetime') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col"><?= __('Intero') ?></th>
                    <th scope="col"><?= __('Booleano') ?></th>
                    <th scope="col"><?= __('Decimale') ?></th>
                   
                </tr>
                <?php foreach ($autore->dischi as $dischi): ?>
                <tr class="Dischi_id_<?= $dischi->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Dischi', 'action' => 'view', $dischi->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Dischi', 'action' => 'edit', $dischi->id],['data'=>['returncontroller'=>'autori','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$autore->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Dischi", fromid : "<?= $dischi->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($dischi->id) ?></td>
                    <td><?= h($dischi->title) ?></td>
                    <td><?= h($dischi->descrizione) ?></td>
                    <td><?= h($dischi->lingua_id) ?></td>
                    <td><?= h($dischi->autore_id) ?></td>
                    <td><?= h($dischi->data) ?></td>
                    <td><?= h($dischi->datetime) ?></td>
                    <td><?= h($dischi->created) ?></td>
                    <td><?= h($dischi->modified) ?></td>
                    <td><?= h($dischi->intero) ?></td>
                    <td><?= h($dischi->booleano) ?></td>
                    <td><?= h($dischi->decimale) ?></td>


                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
        </div>
    </div>
 </div>                        

<?php $activetab=''; ?>
<?php if (($return['tab']=='libri' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class="tab-pane <?= $activetab ?>" id='Libri' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Libri', 'action' => 'add'],['data'=>['returncontroller'=>'autori','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$autore->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($autore->libri)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="LibriTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Titolo') ?></th>
                    <th scope="col"><?= __('Numero Scaffale') ?></th>
                    <th scope="col"><?= __('Lingua Id') ?></th>
                    <th scope="col"><?= __('Autore Id') ?></th>
                    <th scope="col"><?= __('Disponibile') ?></th>
                    <th scope="col"><?= __('Data Acquisto') ?></th>
                   
                </tr>
                <?php foreach ($autore->libri as $libri): ?>
                <tr class="Libri_id_<?= $libri->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Libri', 'action' => 'view', $libri->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Libri', 'action' => 'edit', $libri->id],['data'=>['returncontroller'=>'autori','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$autore->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Libri", fromid : "<?= $libri->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($libri->id) ?></td>
                    <td><?= h($libri->titolo) ?></td>
                    <td><?= h($libri->numero_scaffale) ?></td>
                    <td><?= h($libri->lingua_id) ?></td>
                    <td><?= h($libri->autore_id) ?></td>
                    <td><?= h($libri->disponibile) ?></td>
                    <td><?= h($libri->data_acquisto) ?></td>


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
