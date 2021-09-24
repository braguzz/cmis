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
            $('#device_id').append(newOption).trigger('change');               
            
                   $('#adddevices')
                    .trigger("reset");
                    alert("Dato inserito");
                    
                   $('#modalDevices')
                     .modal('hide');
                    
                        }
                        else
                        {

                        $.each(error, function(key,val) {
                                  //  console.log(key+val);
                                  //  $( "input[name*='descrizione']" ).val( 'pippo' );
                                classe='device'
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
 * @var \App\Model\Entity\Device $device
 * @var \App\Model\Entity\Devmodel[]|\Cake\Collection\CollectionInterface $devmodels
 * @var \App\Model\Entity\Alldevnonassegnati[]|\Cake\Collection\CollectionInterface $alldevnonassegnatis
 * @var \App\Model\Entity\Allocation[]|\Cake\Collection\CollectionInterface $allocations
 * @var \App\Model\Entity\Devicesim[]|\Cake\Collection\CollectionInterface $devicesims
 * @var \App\Model\Entity\Exallocation[]|\Cake\Collection\CollectionInterface $exallocations
 * @var \App\Model\Entity\Simnonassegnate[]|\Cake\Collection\CollectionInterface $simnonassegnate
 * @var \App\Model\Entity\Simphone[]|\Cake\Collection\CollectionInterface $simphones
 * @var \App\Model\Entity\Upload[]|\Cake\Collection\CollectionInterface $uploads
 * @var \App\Model\Entity\Uploadsim[]|\Cake\Collection\CollectionInterface $uploadsims
 */
?>
<?php $this->layout = 'ajax'; ?>


<div class="modal-dialog" role="document" id="modaldevices">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aggiungi Device </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
<div class="card bg-light">
<div class="devices form content card-body">

     <?= $this->Form->create($device,['id'=>'adddevices','url' => false]);   
      $this->Form->setConfig('autoSetCustomValidity', false);
      ?>
    <fieldset>
        <?php
            echo $this->Form->control('utenza_imei');
    
                                               
           if (($return['returncontroller'])=='devmodels')
           {
             $f_id=$return['id'];
             echo $this->Form->hidden('devmodel_id', array('hiddenField' => true, 'value'=> $f_id));
           }
           else
           {

                                  $myTemplates = ['select' => '   <div class="input-group"><select name="{{name}}"{{attrs}}>{{content}}</select>
                                                </div>'];
                echo $this->Form->control('devmodel_id', ['templates' => $myTemplates, 'options' => $devmodels, 'id'=> 'devmodel_id','empty' => true]);              
       
           
           }
?>
<!-- chiamo gli script per aggiungere e selezionare -->
<!-- lo script Seleziona'nometabella' serve per selezionare quello giusto al click di 'seleziona' nella finestra modale di ricerca' -->

<script>
     $(document).ready(function () {    doAcSelect2('devmodel_id', 'Devmodels' , 'title', 3, 'modalDevices');  
    });
</script>

        
           
 <?php

                 //  echo $this->Form->control('devmodel_id', ['options' => $devmodels]);

                    echo $this->Form->control('data_carico');
            echo $this->Form->control('data_scarico', ['empty' => true]);
            echo $this->Form->control('mac');
        ?>
    </fieldset>
 <?= $this->Form->submit('ok',array(
    'id'=>'devicesAddClick',
    'class' => 'btn btn-lg btn-success',
    'div' => false));
  
  $this->Form->end() ;?>
</div>
</div>
    
  <script>
$(document).ready(function () {
    
        $('#devicesAddClick').on('click', Add);
                });
</script>    
</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

