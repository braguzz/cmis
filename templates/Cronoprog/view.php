<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cronoprogramma $cronoprogramma
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


<div class="cronoprog view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Cronoprogramma: <?= h($cronoprogramma->VERSIONE) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $cronoprogramma->VERSIONE], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $cronoprogramma->VERSIONE], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $cronoprogramma->VERSIONE], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $cronoprogramma->VERSIONE), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('VERSIONE') ?></th>
                <td><?= h($cronoprogramma->VERSIONE) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('CODATTIV') ?></th>
                <td><?= h($cronoprogramma->CODATTIV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DESATTIV') ?></th>
                <td><?= h($cronoprogramma->DESATTIV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('RESTATTIV') ?></th>
                <td><?= h($cronoprogramma->RESTATTIV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DATAINIPREV') ?></th>
                <td><?= h($cronoprogramma->DATAINIPREV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DATAFINEPREV') ?></th>
                <td><?= h($cronoprogramma->DATAFINEPREV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DATAINIEFF') ?></th>
                <td><?= h($cronoprogramma->DATAINIEFF) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('DATAFINEFF') ?></th>
                <td><?= h($cronoprogramma->DATAFINEFF) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('IDINT') ?></th>
                <td><?= $this->Number->format($cronoprogramma->IDINT) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('PESOATTIV') ?></th>
                <td><?= $this->Number->format($cronoprogramma->PESOATTIV) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('FSP') ?></th>
                <td><?= $this->Number->format($cronoprogramma->FSP) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('FSI') ?></th>
                <td><?= $this->Number->format($cronoprogramma->FSI) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('FSL') ?></th>
                <td><?= $this->Number->format($cronoprogramma->FSL) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('PERCATTUAZ') ?></th>
                <td><?= $this->Number->format($cronoprogramma->PERCATTUAZ) ?></td>
            </tr>
     
    <tr>
        <th scope="row"><?= __('STATOATTUAZ') ?></th>
       <td> <?= $this->Text->autoParagraph(h($cronoprogramma->STATOATTUAZ)); ?></td>
     </tr>
  </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='interventi' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Interventi" aria-controls=" $Interventi" role="tab" data-toggle="tab">Interventi</a>

</li>

   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='interventi' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class='tab-pane <?= $activetab ?>' id='Interventi' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Interventi', 'action' => 'add'],['data'=>['returncontroller'=>'cronoprog','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$cronoprogramma->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
     
       </div>
      <div class="col">
        <?php if (!empty($cronoprogramma->interventi)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="InterventiTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('VERSIONE') ?></th>
                    <th scope="col"><?= __('IDINT') ?></th>
                    <th scope="col"><?= __('DESLDITEMP') ?></th>
                    <th scope="col"><?= __('TITOLOINT') ?></th>
                    <th scope="col"><?= __('DESCRINT') ?></th>
                    <th scope="col"><?= __('ANNODEFR') ?></th>
                    <th scope="col"><?= __('FLAGPQPO') ?></th>
                    <th scope="col"><?= __('CODCMU') ?></th>
                    <th scope="col"><?= __('MATRESPOP') ?></th>
                    <th scope="col"><?= __('NOTEANAG') ?></th>
                    <th scope="col"><?= __('NOTECRONOPROG') ?></th>
                    <th scope="col"><?= __('INTMONITORATO') ?></th>
                    <th scope="col"><?= __('MONITSTATO') ?></th>
                    <th scope="col"><?= __('ANNOINIZIOINT') ?></th>
                    <th scope="col"><?= __('STATOINT') ?></th>
                    <th scope="col"><?= __('MATRCSG') ?></th>
                    <th scope="col"><?= __('CODLOCPROG') ?></th>
                    <th scope="col"><?= __('INSVERS') ?></th>
                   
                </tr>
                <?php foreach ($cronoprogramma->interventi as $interventi): ?>
                <tr class="Interventi_id_<?= $interventi->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Interventi', 'action' => 'view', $interventi->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Interventi', 'action' => 'edit', $interventi->id],['data'=>['returncontroller'=>'cronoprog','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$cronoprogramma->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Interventi", fromid : "<?= $interventi->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($interventi->id) ?></td>
                    <td><?= h($interventi->VERSIONE) ?></td>
                    <td><?= h($interventi->IDINT) ?></td>
                    <td><?= h($interventi->DESLDITEMP) ?></td>
                    <td><?= h($interventi->TITOLOINT) ?></td>
                    <td><?= h($interventi->DESCRINT) ?></td>
                    <td><?= h($interventi->ANNODEFR) ?></td>
                    <td><?= h($interventi->FLAGPQPO) ?></td>
                    <td><?= h($interventi->CODCMU) ?></td>
                    <td><?= h($interventi->MATRESPOP) ?></td>
                    <td><?= h($interventi->NOTEANAG) ?></td>
                    <td><?= h($interventi->NOTECRONOPROG) ?></td>
                    <td><?= h($interventi->INTMONITORATO) ?></td>
                    <td><?= h($interventi->MONITSTATO) ?></td>
                    <td><?= h($interventi->ANNOINIZIOINT) ?></td>
                    <td><?= h($interventi->STATOINT) ?></td>
                    <td><?= h($interventi->MATRCSG) ?></td>
                    <td><?= h($interventi->CODLOCPROG) ?></td>
                    <td><?= h($interventi->INSVERS) ?></td>


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
