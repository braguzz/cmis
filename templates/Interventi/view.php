<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Intervento $intervento
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


<div class="interventi view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Intervento: <?= h($intervento->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $intervento->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $intervento->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $intervento->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $intervento->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('VERSIONE') ?></th>
                <td><?= h($intervento->VERSIONE) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DESLDITEMP') ?></th>
                <td><?= h($intervento->DESLDITEMP) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('TITOLOINT') ?></th>
                <td><?= h($intervento->TITOLOINT) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('ANNODEFR') ?></th>
                <td><?= h($intervento->ANNODEFR) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('CODCMU') ?></th>
                <td><?= h($intervento->CODCMU) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('MATRESPOP') ?></th>
                <td><?= h($intervento->MATRESPOP) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('MONITSTATO') ?></th>
                <td><?= h($intervento->MONITSTATO) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('ANNOINIZIOINT') ?></th>
                <td><?= h($intervento->ANNOINIZIOINT) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('STATOINT') ?></th>
                <td><?= h($intervento->STATOINT) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('MATRCSG') ?></th>
                <td><?= h($intervento->MATRCSG) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('CODLOCPROG') ?></th>
                <td><?= h($intervento->CODLOCPROG) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('INSVERS') ?></th>
                <td><?= h($intervento->INSVERS) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($intervento->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('IDINT') ?></th>
                <td><?= $this->Number->format($intervento->IDINT) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('FLAGPQPO') ?></th>
                <td><?= $this->Number->format($intervento->FLAGPQPO) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('INTMONITORATO') ?></th>
                <td><?= $this->Number->format($intervento->INTMONITORATO) ?></td>
            </tr>
     
    <tr>
        <th scope="row"><?= __('DESCRINT') ?></th>
       <td> <?= $this->Text->autoParagraph(h($intervento->DESCRINT)); ?></td>
     </tr>
    <tr>
        <th scope="row"><?= __('NOTEANAG') ?></th>
       <td> <?= $this->Text->autoParagraph(h($intervento->NOTEANAG)); ?></td>
     </tr>
    <tr>
        <th scope="row"><?= __('NOTECRONOPROG') ?></th>
       <td> <?= $this->Text->autoParagraph(h($intervento->NOTECRONOPROG)); ?></td>
     </tr>
  </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    
   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        
   
        
   
</div>





</div>
