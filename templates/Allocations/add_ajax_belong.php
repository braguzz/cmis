<!--  add_ajax_belong -->
 <!--   -->
 <!--  Non ha Controller Associati -->
 <!--  Viene utilizzato dal Controller add per generare una risposta ajax -->
 <!--  che inserisce questa vista all'interno della finestra modale -->
 <!--  In pratica quando si proviene da un add che ha un campo 1:n e si vuole aggiungere un record associato -->
 <!--  quello che succede al click del '+' e' che viene chiamato un ajax che chiama la add del controller della tabella associata -->
 <!--  La add capisce che e' una chiamata ajax e restituisce questa vista ( a un certo punto ci sono i tag per la finestra modale) -->
 <!--  Al ritorno dell'ajax la add chiamante apre il modal con questo contenuto. -->
 <!--  Dentro questa vista c'e' la funzione JS Add che chiama il controller addffromadd per inserire tramite ajax senza fare il refresh -->
 <!--  La funzione ritorna l'id del campo inserito che serve per selezionare la riga giusta nel combo di provenienza --> <script>   
  function Add() {
       <!--  La funzione chiamata al click del pulsante ok -->
       <!--  effettua una chiamata ajax per aggiungere il dato -->
       <!--  e inserisce il dato di ritorno nel  -->
        var nomes = $(this).attr('id').replace("AddClick", "");
        var targeturl = MYAPP + '/' + nomes + '/addfromadd';
        console.log(targeturl);
        jQuery.ajax({
            type: 'post',
            async: true,
            cache: false,
            url: targeturl,
            success: function (response) {
              //  console.log(response)
                $(".error-message").remove();
                $( "div" ).removeClass( "error" );
                $( "div" ).removeClass( "form-group" );
                          var obj = response;
                        error=obj["ko"];
                        if (jQuery.isEmptyObject(error)) 
                        {
                          //  alert("Dato inserito");
                          //mette id se non trova name o title - se c'e' un campo diverso inserirlo qui
                            dato=obj["id"];
                            if ("name" in obj) {dato=obj["name"]}
                            if ("title" in obj) {dato=obj["title"]}
                           
           
                            var id1 = obj["id"];
            var newOption = new Option(dato, obj["id"], true, true);
            // Append it to the select
            $('#allocation_id').append(newOption).trigger('change');               
            
                   $('#addallocations')
                    .trigger("reset");
                    alert("Dato inserito");
                    
                   $('#modalAllocations')
                     .modal('hide');
                    
                        }
                        else
                        {

                        $.each(error, function(key,val) {
                                  //  console.log(key+val);
                                  //  $( "input[name*='descrizione']" ).val( 'pippo' );
                                classe='allocation'
                                    var element = $("#" + camelize(classe + '_' + key));
                                    element.parent('div').addClass('error');
                                    element.parent('div').addClass('form-group');
                                    var _insert = $(document.createElement('div')).insertAfter(element);
                                    _insert.addClass('error-message').text(val)

                                });

                 //         alert("Problemi nel salvataggio. Parametri corretti?");

                        }    
                
            },
            
            data: $("#add" + nomes).serialize()
            
        });
        return false;

 function camelize(string) {
        var a = string.split('_'), i;
        s = [];
        for (i=0; i<a.length; i++){
            s.push(a[i].charAt(0).toUpperCase() + a[i].substring(1));
        }
        s = s.join('');
        return s;
    }


    }
    ;

</script>
 
 

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Allocation $allocation
 * @var \App\Model\Entity\Device[]|\Cake\Collection\CollectionInterface $devices
 * @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $owners
 * @var \App\Model\Entity\Querynomail[]|\Cake\Collection\CollectionInterface $querynomail
 * @var \App\Model\Entity\Rifprocedura[]|\Cake\Collection\CollectionInterface $rifproceduras
 */
?>
<?php $this->layout = 'ajax'; ?>


<div class="modal-dialog" role="document" id="modalallocations">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aggiungi Allocation </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
<div class="card bg-light">
<div class="allocations form content card-body">

     <?= $this->Form->create($allocation,['id'=>'addallocations','url' => false]);   
      $this->Form->setConfig('autoSetCustomValidity', false);
      ?>
    <fieldset>
        <?php
    
                                               
           if (($return['returncontroller'])=='devices')
           {
             $f_id=$return['id'];
             echo $this->Form->hidden('device_id', array('hiddenField' => true, 'value'=> $f_id));
           }
           else
           {

                                  $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                </div>'];
                echo $this->Form->control('device_id', ['templates' => $myTemplates, 'options' => $devices, 'id'=> 'device_id','empty' => true]);              
       
           
           }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->

<script>
     $(document).ready(function () {    doAcSelect2('device_id', 'Devices' , 'id', 3, 'modalAllocations');  
    });
</script>

        
           
 <?php

                 //  echo $this->Form->control('device_id', ['options' => $devices]);

            
                                               
           if (($return['returncontroller'])=='owners')
           {
             $f_id=$return['id'];
             echo $this->Form->hidden('owner_id', array('hiddenField' => true, 'value'=> $f_id));
           }
           else
           {

                                  $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                </div>'];
                echo $this->Form->control('owner_id', ['templates' => $myTemplates, 'options' => $owners, 'id'=> 'owner_id','empty' => true]);              
       
           
           }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->

<script>
     $(document).ready(function () {    doAcSelect2('owner_id', 'Owners' , 'name', 3, 'modalAllocations');  
    });
</script>

        
           
 <?php

                 //  echo $this->Form->control('owner_id', ['options' => $owners]);

                    echo $this->Form->control('InizioUso');
            echo $this->Form->control('referente');
            echo $this->Form->control('note');
            echo $this->Form->control('mail_referente');
        ?>
    </fieldset>
 <?= $this->Form->submit('ok',array(
    'id'=>'allocationsAddClick',
    'class' => 'btn btn-lg btn-success',
    'div' => false));
  
  $this->Form->end() ;?>
</div>
</div>
    
  <script>
$(document).ready(function () {
    
        $('#allocationsAddClick').on('click', Add);
                });
</script>    
</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

