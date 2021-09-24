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
            $('#owner_id').append(newOption).trigger('change');               
            
                   $('#addowners')
                    .trigger("reset");
                    alert("Dato inserito");
                    
                   $('#modalOwners')
                     .modal('hide');
                    
                        }
                        else
                        {

                        $.each(error, function(key,val) {
                                  //  console.log(key+val);
                                  //  $( "input[name*='descrizione']" ).val( 'pippo' );
                                classe='owner'
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
<?php $this->layout = 'ajax'; ?>


<div class="modal-dialog" role="document" id="modalowners">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aggiungi Owner </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
<div class="card bg-light">
<div class="owners form content card-body">

     <?= $this->Form->create($owner,['id'=>'addowners','url' => false]);   
      $this->Form->setConfig('autoSetCustomValidity', false);
      ?>
    <fieldset>
        <?php
            echo $this->Form->control('cmu');
            echo $this->Form->control('name');
            echo $this->Form->control('title');
        ?>
    </fieldset>
 <?= $this->Form->submit('ok',array(
    'id'=>'ownersAddClick',
    'class' => 'btn btn-lg btn-success',
    'div' => false));
  
  $this->Form->end() ;?>
</div>
</div>
    
  <script>
$(document).ready(function () {
    
        $('#ownersAddClick').on('click', Add);
                });
</script>    
</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

