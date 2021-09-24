<!--  add -->
<!--  Vista per add  della tabella -->
<!--  Se chiamata da dal pulsante + di una add di un altra view (nel caso di collegamenti) -->
<!--  viene chiamata con i parametri $return['returncontroller'] e $return['id'] settati -->
<!--  una volta cliccato su ok si ritona quindi al controller e id giusto. -->
<!--  Altrimenti vengono visualizzati i pulsanti 'ok', 'ok++' e 'ok e mod' -->
<!--  Se un campo e' collegato con un altra tabella vengono visualizzati i bottoni '+' e 'lente' -->
<!--  Per campo 'collegato' vengono inseriti dei js che chiamano lo script Aggiungi(event)  -->
<!--  dove in event troviamo il nome (nome della tabella relazionata) e il returncontroller (cioe' il nome di questa tabella) -->
<!--  si va quindi ad aggiungere il form 'add_ajax_belong' della tabella relazionata ad una finestra modale -->
<!--   -->
<!--  Se si clicca su cerca viene lanciato Cerca(event) che lancia il controller indexfromadd della -->
<!--  tabella relazionata che viene inserito nella finestra modale -->
<!--  indexfromadd fa piu o meno quello che fa index MA -->
<!--  se la finestra e' stata appena aperta renderizza indexFromAdd.ctp-->
<!--  altrimenti e' il risultato di una ricerca e allora renderizza indexFromAddResults.ctp -->
<!--  in indexFromAdd.ctp c'e' un js scatenato dal bottone cerca che richiama la indexfromadd con parametro search:1 -->
<!--  che inserisce nel form il risultato della ricerca -->
<!--  mettendo in cima ad ogni riga un link con l'id giusto e classe 'seleziona' -->
<!--  lo script Seleziona'nometabella'() serve ad aggiungere alla lista e selezionare l'elemento, quando si clicca sull'elemento da selezionare -->
<!--   -->
<script>
    <!--  lanciato dal bottone + di eventuali campi collegati  -->
    function Aggiungi(event) {
        var nome = event.data.nome;
        var returncontroller = event.data.returncontroller;
        var nomeMa = nome.charAt(0).toUpperCase() + nome.slice(1);
        var targeturl = MYAPP + '/' + nomeMa + "/add/returncontroller:" + returncontroller;
        // console.log(targeturl)
        var $t = $(this);

        jQuery.ajax({
            type: "post",
            async: true,
            cache: false,
            url: targeturl,
            success: function (response) {
                //    console.log(response)
                $("#modal" + nome).html("")
                $("#modal" + nome).html(response)
                $("#buttonmodal" + nome).click()
            },
            data: $("#add" + nome).serialize()
        });
        return false;
    }
    ;
   
</script>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Owner $owner
 * @var \App\Model\Entity\Accountmail[]|\Cake\Collection\CollectionInterface $accountmails
 * @var \App\Model\Entity\Alldevnonassegnati[]|\Cake\Collection\CollectionInterface $alldevnonassegnatis
 * @var \App\Model\Entity\Allocation[]|\Cake\Collection\CollectionInterface $allocations
 * @var \App\Model\Entity\Exallocation[]|\Cake\Collection\CollectionInterface $exallocations
 * @var \App\Model\Entity\Querynomail[]|\Cake\Collection\CollectionInterface $querynomail
 * @var \App\Model\Entity\Selectsimabbinate[]|\Cake\Collection\CollectionInterface $selectsimabbinates
 * @var \App\Model\Entity\Simnonassegnate[]|\Cake\Collection\CollectionInterface $simnonassegnate
 * @var \App\Model\Entity\Simphone[]|\Cake\Collection\CollectionInterface $simphones
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2 border-bottom">  
<div class="col col-sm-auto">
<h1 class="page-header">Aggiungi Owner</h1>
 </div>  
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->

<div class="card bg-light">
<div class="owners form content card-body">
    <?= $this->Form->create($owner) ?>
    
    <?php
    if (($return['returncontroller'])<>'')
     {    echo $this->Form->hidden('returncontroller', array('hiddenField' => true, 'value'=> $return['returncontroller']));
          echo $this->Form->hidden('returnsaveme', array('hiddenField' => true, 'value'=> 1));
          echo $this->Form->hidden('returnaction', array('hiddenField' => true, 'value'=> $return['returnaction']));
          echo $this->Form->hidden('returncontrollerid', array('hiddenField' => true, 'value'=> $return['returncontrollerid']));
           }
    ?>
    <fieldset>
        <?php
            echo $this->Form->control('cmu');
            echo $this->Form->control('name');
            echo $this->Form->control('title');
        ?>
<!-- chiamo gli script per aggiungere e selezionare nei belongsToMany-->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {  
        });
</script>
</fieldset>
<!-- Bottoni Ok, Ok + e Ok e mod (nel controller si discrimina il NAME e non il testo del bottone) -->
 <div class="btn-group" role="group" >
     <?=
     $this->Form->submit('Salva', [
         'name' => 'submit_ok',
         'id' => 'BottoneSubmitDiDefault',
         'class' => 'btn btn-outline-info  mr-1',
         'div' => false]);
     ?>
     <?php if ($return['returncontrollerid'] == '') { ?> 
         <?=
         $this->Form->submit('Salva e aggiungi un altro', ['name' => 'submit_ok_piu',
             'class' => 'btn btn-outline-info  mr-1',
             'div' => false]);
         ?>
         <?=
         $this->Form->submit('Salva e modifica', ['name' => 'submit_ok_mod',
             'class' => 'btn btn-outline-info ',
             'div' => false]);
         ?>
 <?php } ?>   
 </div>
 
    <?= $this->Form->end() ?>
</div>
</div>
