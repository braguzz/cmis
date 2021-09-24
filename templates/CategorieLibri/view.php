<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategorieLibro $categorieLibro
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


<div class="categorieLibri view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Categorie Libro: <?= h($categorieLibro->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $categorieLibro->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $categorieLibro->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $categorieLibro->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $categorieLibro->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Libro') ?></th>
                <td><?= $categorieLibro->has('libro') ? $this->Html->link($categorieLibro->libro->id, ['controller' => 'Libri', 'action' => 'view', $categorieLibro->libro->id]) : '' ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Categoria') ?></th>
                <td><?= $categorieLibro->has('categoria') ? $this->Html->link($categorieLibro->categoria->title, ['controller' => 'Categorie', 'action' => 'view', $categorieLibro->categoria->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($categorieLibro->id) ?></td>
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
