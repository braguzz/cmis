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
 * @var \App\Model\Entity\Libro $libro
 * @var \App\Model\Entity\Lingua[]|\Cake\Collection\CollectionInterface $lingue
 * @var \App\Model\Entity\Autore[]|\Cake\Collection\CollectionInterface $autori
 * @var \App\Model\Entity\Categoria[]|\Cake\Collection\CollectionInterface $categorie
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2 border-bottom">  
<div class="col col-sm-auto">
<h1 class="page-header">Edit Libro</h1>
 </div>  
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->

<div class="card bg-light">
<div class="libri form content card-body">
    <?= $this->Form->create($libro) ?>
    
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
            echo $this->Form->control('titolo');
            echo $this->Form->control('numero_scaffale');
          //  echo $this->Form->control('lingua_id', ['options' => $lingue, 'empty' => true]);
                                               if (($return['returncontroller'])=='lingue')  echo $this->Form->hidden('lingua_id', array('hiddenField' => true, 'value'=> $return['returncontrollerid']));
                    else {
                                               
                       $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                <div class="input-group-append">
                                                <button id="linguaButtonAdd" class="btn btn-outline-secondary bi-plus-lg" type="button"></button>
                                                </div></div>'];
                echo $this->Form->control('lingua_id', ['templates' => $myTemplates, 'options' => $lingue, 'id'=> 'lingua_id','empty' => true]);              
       
                        }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {
        $('#linguaButtonAdd').click({nome: 'Lingue', returncontroller: 'libri'}, Aggiungi);            doAcSelect2('lingua_id', 'Lingue' , 'title', 3);  
        });
</script>
           
<!-- Bottoni per apertura delle finestre modali     -->  
<button id='buttonmodalLingue' type='button' class='d-none btn btn-primary btn-lg' data-toggle='modal' data-target='#modalLingue'>
</button>
<!-- Contenuto delle finestre modali (viene riempito via JS)-->
<div class='content modal fade' id='modalLingue' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
</div>
          
 <?php

                  //  echo $this->Form->control('lingua_id', ['options' => $lingue]);

                  //  echo $this->Form->control('autore_id', ['options' => $autori, 'empty' => true]);
                                               if (($return['returncontroller'])=='autori')  echo $this->Form->hidden('autore_id', array('hiddenField' => true, 'value'=> $return['returncontrollerid']));
                    else {
                                               
                       $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                <div class="input-group-append">
                                                <button id="autoreButtonAdd" class="btn btn-outline-secondary bi-plus-lg" type="button"></button>
                                                </div></div>'];
                echo $this->Form->control('autore_id', ['templates' => $myTemplates, 'options' => $autori, 'id'=> 'autore_id','empty' => true]);              
       
                        }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {
        $('#autoreButtonAdd').click({nome: 'Autori', returncontroller: 'libri'}, Aggiungi);            doAcSelect2('autore_id', 'Autori' , 'id', 3);  
        });
</script>
           
<!-- Bottoni per apertura delle finestre modali     -->  
<button id='buttonmodalAutori' type='button' class='d-none btn btn-primary btn-lg' data-toggle='modal' data-target='#modalAutori'>
</button>
<!-- Contenuto delle finestre modali (viene riempito via JS)-->
<div class='content modal fade' id='modalAutori' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
</div>
          
 <?php

                  //  echo $this->Form->control('autore_id', ['options' => $autori]);

                    echo $this->Form->control('disponibile');
            echo $this->Form->control('data_acquisto', ['empty' => true]);
            if (($return['returncontroller'])=='categorie') echo $this->Form->hidden('categorie.0.id', ['value' => $return['returncontrollerid']]);
            else echo $this->Form->control('categorie._ids', ['options' => $categorie]);
                ?>
<!-- chiamo gli script per aggiungere e selezionare nei belongsToMany-->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {            doAcSelect2('categorie-ids', 'Categorie' , 'title', 3);                 
         
        });
</script>
</fieldset>
    <?= $this->Form->button('Salva', [
         'class' => 'btn btn-outline-info  mr-1',
         'div' => false]); ?>
    <?= $this->Form->end() ?>
</div>
</div>