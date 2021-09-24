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
 * @var \App\Model\Entity\CategorieLibro $categorieLibro
 * @var \App\Model\Entity\Libro[]|\Cake\Collection\CollectionInterface $libri
 * @var \App\Model\Entity\Categoria[]|\Cake\Collection\CollectionInterface $categorie
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2 border-bottom">  
<div class="col col-sm-auto">
<h1 class="page-header">Aggiungi Categorie Libro</h1>
 </div>  
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->

<div class="card bg-light">
<div class="categorieLibri form content card-body">
    <?= $this->Form->create($categorieLibro) ?>
    
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
          //  echo $this->Form->control('libro_id', ['options' => $libri, 'empty' => true]);
                                               if (($return['returncontroller'])=='libri')  echo $this->Form->hidden('libro_id', array('hiddenField' => true, 'value'=> $return['returncontrollerid']));
                    else {
                                               
                       $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                <div class="input-group-append">
                                                <button id="libroButtonAdd" class="btn btn-outline-secondary bi-plus-lg" type="button"></button>
                                                </div></div>'];
                echo $this->Form->control('libro_id', ['templates' => $myTemplates, 'options' => $libri, 'id'=> 'libro_id','empty' => true]);              
       
                        }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {
        $('#libroButtonAdd').click({nome: 'Libri', returncontroller: 'categorieLibri'}, Aggiungi);            doAcSelect2('libro_id', 'Libri' , 'id', 3);  
        });
</script>
           
<!-- Bottoni per apertura delle finestre modali     -->  
<button id='buttonmodalLibri' type='button' class='d-none btn btn-primary btn-lg' data-toggle='modal' data-target='#modalLibri'>
</button>
<!-- Contenuto delle finestre modali (viene riempito via JS)-->
<div class='content modal fade' id='modalLibri' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
</div>
          
 <?php

                  //  echo $this->Form->control('libro_id', ['options' => $libri]);

                  //  echo $this->Form->control('categoria_id', ['options' => $categorie, 'empty' => true]);
                                               if (($return['returncontroller'])=='categorie')  echo $this->Form->hidden('categoria_id', array('hiddenField' => true, 'value'=> $return['returncontrollerid']));
                    else {
                                               
                       $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                <div class="input-group-append">
                                                <button id="categoriaButtonAdd" class="btn btn-outline-secondary bi-plus-lg" type="button"></button>
                                                </div></div>'];
                echo $this->Form->control('categoria_id', ['templates' => $myTemplates, 'options' => $categorie, 'id'=> 'categoria_id','empty' => true]);              
       
                        }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->
<script>
     $(document).ready(function () {
        $('#categoriaButtonAdd').click({nome: 'Categorie', returncontroller: 'categorieLibri'}, Aggiungi);            doAcSelect2('categoria_id', 'Categorie' , 'title', 3);  
        });
</script>
           
<!-- Bottoni per apertura delle finestre modali     -->  
<button id='buttonmodalCategorie' type='button' class='d-none btn btn-primary btn-lg' data-toggle='modal' data-target='#modalCategorie'>
</button>
<!-- Contenuto delle finestre modali (viene riempito via JS)-->
<div class='content modal fade' id='modalCategorie' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
</div>
          
 <?php

                  //  echo $this->Form->control('categoria_id', ['options' => $categorie]);

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
