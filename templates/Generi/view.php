<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Genere $genere
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


<div class="generi view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Genere: <?= h($genere->title) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $genere->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $genere->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $genere->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $genere->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($genere->id) ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Title') ?></h4>
        <?= $this->Text->autoParagraph(h($genere->title)); ?>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='autori' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Autori" aria-controls=" $Autori" role="tab" data-toggle="tab">Autori</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='autori' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class="tab-pane <?= $activetab ?>" id='Autori' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Autori', 'action' => 'add'],['data'=>['returncontroller'=>'generi','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$genere->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($genere->autori)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="AutoriTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Nome') ?></th>
                    <th scope="col"><?= __('Cognome') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('Genere Id') ?></th>
                   
                </tr>
                <?php foreach ($genere->autori as $autori): ?>
                <tr class="Autori_id_<?= $autori->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Autori', 'action' => 'view', $autori->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Autori', 'action' => 'edit', $autori->id],['data'=>['returncontroller'=>'generi','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$genere->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Autori", fromid : "<?= $autori->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($autori->id) ?></td>
                    <td><?= h($autori->nome) ?></td>
                    <td><?= h($autori->cognome) ?></td>
                    <td><?= h($autori->note) ?></td>
                    <td><?= h($autori->genere_id) ?></td>


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
