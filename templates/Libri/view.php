<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Libro $libro
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


<div class="libri view large-9 medium-8 columns content">
    
 <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
    <h1 class="page-header">Libro: <?= h($libro->id) ?></h1>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group" role="group">
<?= $this->Html->link('', ['action' => 'edit', $libro->id], ['title' => __('Edit'), 'class' => 'btn btn-outline-dark bi-pencil mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'add', $libro->id], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $libro->id], ['confirm' => __('Sei sicuro di rimuovere # {0}?', $libro->id), 'title' => __('Delete'), 'class' => 'btn btn-danger bi-trash mr-1']) ?>

 </div>
 </div>

 </div>
</div>
<!-- PB: Fine titolo con bottoni -->


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th scope="row"><?= __('Titolo') ?></th>
                <td><?= h($libro->titolo) ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Lingua') ?></th>
                <td><?= $libro->has('lingua') ? $this->Html->link($libro->lingua->title, ['controller' => 'Lingue', 'action' => 'view', $libro->lingua->id]) : '' ?></td>
            </tr>
            <tr class="col-2">
                <th scope="row" class="col-2"><?= __('Autore') ?></th>
                <td><?= $libro->has('autore') ? $this->Html->link($libro->autore->id, ['controller' => 'Autori', 'action' => 'view', $libro->autore->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($libro->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Numero Scaffale') ?></th>
                <td><?= $this->Number->format($libro->numero_scaffale) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data Acquisto') ?></th>
                <td><?= h($libro->data_acquisto) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Disponibile') ?></th>
                <td><?= $libro->disponibile ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>




 <ul class="nav nav-tabs" role="tablist">
 <?php $tabact=1; ?>    

   
   
    
   
    

<?php $activetab=''; ?>
<?php if (($return['tab']=='categorie' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}; ?>
       
<li class='nav-item'>
    <a class ="nav-link <?= $activetab ?>" href="#Categorie" aria-controls=" $Categorie" role="tab" data-toggle="tab">Categorie</a>

</li>

   
 </ul>
<?php $tabact=1; ?>
<div class="tab-content">
   
   
        
   
        

<?php $activetab=''; ?>
<?php if (($return['tab']=='categorie' or $return['tab']=='') and ($tabact==1)) {$activetab='active'; $tabact=0;}?>
<div role='tabpanel' class="tab-pane <?= $activetab ?>" id='Categorie' >
   <div class="related">
 <div class="col btn-group" role="group"> 
    <?= $this->Form->postButton('', ['controller' => 'Categorie', 'action' => 'add'],['data'=>['returncontroller'=>'libri','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$libro->id], 'class' => 'btn btn-sm btn-info bi-plus m-1']) ?>
 
     <?= $this->Form->postButton('', ['controller' => 'Categorie', 'action' => 'indexexternal'],['data'=>['returncontroller'=>'libri', 'returnmodel'=>'Libri','returnsaveme' => '0','returncontrollerid'=>$libro->id], 'class' => 'btn btn-sm btn-info bi-search m-1']) ?>
      
       </div>
      <div class="col">
        <?php if (!empty($libro->categorie)): ?>

    
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="CategorieTable">
                <tr>
                    <th scope="col" class="actions"></th>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Title') ?></th>
                   
                </tr>
                <?php foreach ($libro->categorie as $categorie): ?>
                <tr class="Categorie_id_<?= $categorie->id ?>">
                                        <td class="actions" style="width:1%">
                           <div class="btn-group" role="group" >

                <?= $this->Html->link('',  ['controller' => 'Categorie', 'action' => 'view', $categorie->id], ['title' => __('View'), 'class' => 'btn btn-outline-dark btn-sm bi-info-lg mr-1']) ?>
                <?= $this->Form->postButton('', ['controller' => 'Categorie', 'action' => 'edit', $categorie->id],['data'=>['returncontroller'=>'libri','returnsaveme' => '0','returnaction'=>'view','returncontrollerid'=>$libro->id], 'class' => 'btn btn-outline-dark btn-sm bi-pencil mr-1 rounded-0']) ?>
                <button class="btn btn-sm btn-danger bi-trash mr-1" title="Elimina" onclick='Remove({from: "Categorie", fromid : "<?= $categorie->id ?>"})'></button>
                 
                <button class="btn btn-sm btn-danger bi-eraser mr-1" title="Rimuovi Collegamento" onclick='RemoveHABTM({from: "Categorie", sourceid : "<?= $libro->id ?>", modelsource: "Libri", fromid : "<?= $categorie->id ?>"})'></button>
                  
              </div>
                                        
                                        
                                        
                                        </td>
                    <td><?= h($categorie->id) ?></td>
                    <td><?= h($categorie->title) ?></td>


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
