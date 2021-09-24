<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Disco $disco
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



<div class="dischi view large-9 medium-8 columns content">
    <h3><?= h($disco->title) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Lingua') ?></th>
                <td><?= $disco->has('lingua') ? $this->Html->link($disco->lingua->title, ['controller' => 'Lingue', 'action' => 'view', $disco->lingua->id]) : '' ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Autore') ?></th>
                <td><?= $disco->has('autore') ? $this->Html->link($disco->autore->id, ['controller' => 'Autori', 'action' => 'view', $disco->autore->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($disco->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Intero') ?></th>
                <td><?= $this->Number->format($disco->intero) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Decimale') ?></th>
                <td><?= $this->Number->format($disco->decimale) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data') ?></th>
                <td><?= h($disco->data) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Datetime') ?></th>
                <td><?= h($disco->datetime) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($disco->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($disco->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Booleano') ?></th>
                <td><?= $disco->booleano ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Title') ?></h4>
        <?= $this->Text->autoParagraph(h($disco->title)); ?>
    </div>
    <div class="row">
        <h4><?= __('Descrizione') ?></h4>
        <?= $this->Text->autoParagraph(h($disco->descrizione)); ?>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    
   
    
   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        
   
        
   
</div>





</div>
