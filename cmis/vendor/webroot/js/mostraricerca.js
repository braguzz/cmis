function mostraRicerca() 
{
var pathname = window.location.pathname;
$('#ricercano').hide();
$('#ricerc').hide();
$('#ricercasi').click(function(){
    $('#ricercasi').hide();
    $('#ricercano').show();
	$('#ricerc').show();
    // $.cookie('ricerca', true, '/');
    $.cookie('ricerca', true, { path: pathname });
});

$('#ricercano').click(function(){
   
    $('#ricercasi').show();
    $('#ricercano').hide();
	$('#ricerc').hide();
    
    // $.cookie('ricerca', false, '/');
    $.cookie('ricerca', false, { path: pathname });
});

if($.cookie('ricerca') == 'true'){
    $('#ricercasi').click();
} else {
    $('#ricercano').click();
}
}

