/*
  * doAc()  Aggiunge ad un campo del form la funzione "autocomplete" di JQuery
  * @param {text} id                    //l'identificativo (id HTML) del campo del form
  * @param {text} tab                   //il MODELLO (non la tabella) di loookup
  * @param {text} fld                   //il nome del campo di lookup
  * @param {num}  lunghezza_minima      //numero di caratteri minimi per far scattare la ricerca autocomplete (OPZIONALE. Default 3)
  * @param {bool} verifica_dati         //true = verifica il dato inserito (OPZIONALE. Default false)
  * @returns void
  * ricordarsi di definire MYAPP in file Elements/navbar.php come copia di variabile php
  */
function doAc(id, tab, fld, lunghezza_minima = 2, verifica_dati = false) 
{
  
    //Aggancia la funzione autocomplete al campo, usando l'id
    $('#'+id).autocomplete({
        source: MYAPP+"/autocomplete/fetch/"+tab+'/'+fld+'',
        minLength: lunghezza_minima,
        select: function(event, data)
        {
            console.log('#'+id+'');
         console.log(data.item.value);
          console.log(this);
            console.log(data.item.label);
            $('#'+id+'').val(data.item.value);
            $(this).val(data.item.label);                                
            return false;
        }   
    });
    
    //Quando il campo perde il focus, controlla se il valore inserito corrisponde ad un valore esistente nella tabella
    //Di fatto, impedisce di scrivere valori differenti da quelli esistenti
    $('#'+id).blur(function()
    {
       // console.log(MYAPP+'/autocomplete/check/'+tab+'/'+fld+'?term='+this.value);
        if (Boolean(verifica_dati) == true) 
        {  
            if( $(this).val() != ''  ) 
            {
                $.getJSON(MYAPP+'/autocomplete/check/'+tab+'/'+fld+'?term='+this.value,
                function(data) 
                {
                   
                    if( data.length === 0) 
                    {
                        alert('ERRORE: il valore inserito nel campo "' + fld + '" non esiste nella tabella "' + tab + '"');
                        $('#'+id+'').focus();
                        return false;
                    }
                    else 
                    {                                
                        $('#'+id).val(data[0].label);                   
                    }
                });
            }
        }
    });

}


//cerca il cognome del dipendente nell'anagrafica regionale, via REST
//PARAMETRI:
//      id                  //l'identificativo (id HTML) del campo del form
//      nome_funzione       //nome della funzione (metodo) all'interno di AutocompleteController
//      lunghezza_minima    //numero di caratteri minimi per far scattare la ricerca autocomplete (OPZIONALE. Default 3)
function doAcFunzione(id, nome_funzione, lunghezza_minima = 3) 
{console.log(MYAPP+"/autocomplete/" + nome_funzione);
    //Aggancia la funzione autocomplete al campo, usando l'id
    $('#'+id).autocomplete({
        source: MYAPP+"/autocomplete/" + nome_funzione,
        minLength: lunghezza_minima,
        select: function(event, data)
        {    
            $('#'+id+'').val(data.item.value);
            $(this).val(data.item.label);                                
            return false;
        }   
    });
}




/*
 *  Add datepicker to input field
 *   to be used only in ajax html view
 */
function doDp(id,fmt) {
       $('#'+id+'')
               .removeClass('hasDatepicker')
               .datepicker({
                        dateFormat: fmt,
                        changeMonth: true, 
                        changeYear: true, 
                        autoSize: true
        });
}


// SPINNER load
$(window).on('load', function() { $("#loading").hide(); });
$(window).on('unload', function() { $("#loading").show(); });


    
$(document).ready(function() {    
        // busy in menu action
        $('#cakephp-global navigation a').on('click', function (){$('#loading').show();});
// spinner  
        $.ajaxSetup({
            beforeSend:function(){
                // show gif here, eg:
                $("#loading").show();
            },
            complete:function(){
                // hide gif here, eg:
                $("#loading").hide();
            }
        });
       
       // mmenu lateral on-off
        $('nav#lft-menu').mmenu({
                classes: "mm-white"
        });
        // activate tabs in forms 
        //$( "#tabs" ).tabs();
        // SPINNER AJAX
        $("#loading")
            .ajaxStart(function(){
                $(this).show();
            })
            .ajaxStop(function(){
                $(this).hide();
        });
        
        // autocomplete and datepicker  samples 
        //echo $this->Form->input('executive_id',array('id'=>'acExec','type'=>'text','size'=>'30'));
        //echo $this->Form->input('InizioUso',array('class'=>'dp','type'=>'text'));     //
        $('.dp').datepicker({
                        dateFormat: 'dd/mm/yy',
                         changeMonth: true, 
                         changeYear: true, 
                         autoSize: true
        });
        $('.dpymd').datepicker({
                        dateFormat: 'yy-mm-dd',
                        autoSize: true
        });
});


function doAcSelect2(id, tab, fld, lunghezza_minima = 2,modal_add_ajax_belong="") 
{
   var s2parameters = {
            allowClear: true,
            placeholder: "Vuoto",
            dropdownAutoWidth : true,
            width: 'auto',
            theme: 'bootstrap4',
            minimumInputLength: lunghezza_minima,
            language: "it",      
       
            ajax: {
              url:  MYAPP+"/autocomplete/fetchselect2/"+tab+'/'+fld+'',
              dataType: 'json',
               data: function(params) {
             var query = {
                    search: params.term,
                    page: params.page || 1
                    }
                 // Query parameters will be ?search=[term]&page=[page]
                 return query;
                },
               success: function(response) {
                    // console.log(response);
                    // return response; // <- I tried that one as well
                    }
              // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                 }
            };
    //aggiungo il nome della finestra modal altrimenti non funziona con addajaxbelong      
    if(modal_add_ajax_belong !=="")
           s2parameters.dropdownParent = $('#' + modal_add_ajax_belong);      

    $('#'+id).select2(
            s2parameters 
        ); 


}

