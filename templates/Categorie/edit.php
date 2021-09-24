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
 * @var \App\Model\Entity\Categoria $categoria
 * @var \App\Model\Entity\Libro[]|\Cake\Collection\CollectionInterface $libri
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2 border-bottom">  
<div class="col col-sm-auto">
<h1 class="page-header">Edit Categoria</h1>
 </div>  
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->

<div class="card bg-light">
<div class="categorie form content card-body">
    <?= $this->Form->create($categoria) ?>
    
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
            echo $this->Form->control('title');
            if (($return['returncontroller'])=='libri') echo $this->Form->control('libri.0.id', ['value' => $return['returncontrollerid']]);
            else echo $this->Form->control('libri._ids', ['options' => $libri]);
                ?>

</fieldset>
    <?= $this->Form->button('Salva', [
         'class' => 'btn btn-outline-info  mr-1',
         'div' => false]); ?>
    <?= $this->Form->end() ?>
</div>
</div>