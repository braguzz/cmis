<?php
/*
** Custom functions and global to be used in the whole app
** import this file in boostrap.php  with 
** 
require_once(dirname(__FILE__).'/common.php');
*/
/*
 *  selezione colonne da array associativo 
 */

use Cake\I18n\FrozenTime;
use Cake\ORM\Query;


function getColumnArray( $data = array(), $fields = array(), $head = '') {
        $res = array();
        if(!empty($fields)) {
            foreach( $data as $k => $v ) {                    
                    foreach($fields as $field ) {
                        if(!empty($head)) {
                             $res[$k][$head][$field] =$v[$head][$field]; // only selected columns 
                        } else {
                            $res[$k][$field] =$v[$field]; // only selected columns                           
                        }
                    }
            }
        }
        return $res;
}
/*
 *  prepara Array dati di ritorno da Find per array Javascript 
 */
function flatArray($modelName = '', $data = array()) {
        $res = array();
        if(!empty($modelName)) {
            for($i = 0; $i < count($data) ; $i++ ) {
                        //$res[$i] =$data[$i][$modelName]; // remove model array from array                                  
                        $res[] = array_values($data[$i][$modelName]); // remove model array from array                                  

            }
        }
        return $res;
}

function isActive($profilo) {
    return ($profilo !== 'inactive');
}
/*
 *  * @return string  url
 */
function currentUrl() {
  return (!env('HTTPS') ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
} 

// ultimi caratteri di una stringa
function right($string,$chars)
{
    return substr($string, strlen($string)-$chars,$chars);   
} 
// by AMT to remove '[ ]' in stringa
function unsquare($text,$replace=''){

	return preg_replace('/\[\-*\w+\\-*]$/i', $replace, $text);
}
/**
* Determines if the browser provided a valid SSL client certificate
*
* @return string  CF 
*/
 function getSSLUser()  {
        return (env('HTTPS')) ? substr(env('SSL_CLIENT_S_DN_CN'),0,16):null; 
 
}

// presenta campi DECIMAL in formato ITA su tutti i Model 
function nf($decvar) {
       return number_format($decvar,2,',','.');     
}


//DG: imposta le date in formato italiano 
function data_italiano($data, $tipo='data') 
{
    $formato = '';
    switch($tipo)
    {
        case 'data':
            $formato = '%d/%m/%Y';
            break;
        case 'dataora':
            $formato = '%d/%m/%Y %H:%M';
            break;
        case 'ora':
            $formato = '%H:%M';
            break;
        case 'iso':
            $formato = '%Y-%m-%d %H:%M:%S';
            break;
        default:
            //usa il formato passato con TIPO 
            $formato = $tipo;
            break;
    }
    return CakeTime::format($data, $formato);      
}




/*
** Use the LOCALE/LC_TIME to set locale format
*/
function getLocales($lang) {
// Loading the L10n object
App::uses('L10n','I18n');

$l10n = new L10n();

// Iso2 lang code
$iso2 = $l10n->map($lang);
$catalog = $l10n->catalog($lang);

$locales = array(
  $iso2.'_'.strtoupper($iso2).'.'.strtoupper(str_replace('-', '', $catalog['charset'])),    // fr_FR.UTF8
  $iso2.'_'.strtoupper($iso2),    // fr_FR
  $catalog['locale'],             // fre
  $catalog['localeFallback'],     // fre
  $iso2                           // fr
  );
return $locales;
}



//DG: converte un array risultato della query (gerarchico) 
//    in uno piatto usabile con la libreria grafica C3
//    formato_out:      array, json
//    $tipo_grafico:    torta, barre, titolo 
function arrayToFlat($array_gerarchico, $formato_out = "array", $tipo_grafico = "barre")
{
    //produre un array piatto (ma non direttamente usabile)
    //formato --> '0#0#numero_progetti' => '562'
    $righe_piatte = Hash::flatten($array_gerarchico, "#");

    //produce un array nel formato classico
    $array_piatto = array();
    foreach ($righe_piatte as $key => $value) 
    {
        //cerca il primo #, che identifica la fine dell'indice numerico
        $pos1 = strpos($key, "#");
        $indice_array = substr($key, 0, $pos1) + 0;

        //cerca l'ultimo # che identifica l'inizio del nome del campo
        $pos2 = strrpos($key, "#");
        $nome_campo = substr($key, $pos2 + 1);
        
        //popola l'array
        $array_piatto[$indice_array][$nome_campo] = $value;
    }
    

    //prepara l'array per i grafici di tipo torta, donut
    if($tipo_grafico == "torta")
    {
        //ricava il nome di campi
        $nomeCampi = array();
        if( count($array_piatto) > 0)
        {
            foreach ($array_piatto[0] as $key => $value)
            {
                $nomeCampi[] = $key;
            }
        }

        //prepara l'array 
        $array_temp = array();
        foreach ($array_piatto as $chiave => $valore) 
        {
            $array_temp[$valore[$nomeCampi[0]]] = $valore[$nomeCampi[1]];
        }
        $array_piatto = $array_temp;
    }

    //prepara l'array per i titoli
    if($tipo_grafico == "titolo")
    {
        //ricava il nome di campi
        $nomeCampi = array();
        if( count($array_piatto) > 0)
        {
            foreach ($array_piatto[0] as $key => $value)
            {
                $nomeCampi[] = $key;
            }
        }

        //prepara l'array 
        $array_temp = array();
        foreach ($array_piatto as $chiave => $valore) 
        {
            // debug( $valore[$nomeCampi[0]] );
            $array_temp[] = $valore[$nomeCampi[0]];
        }
        $array_piatto = $array_temp;
    }

    //prepara l'output nel formato richiesto
    switch ($formato_out) 
    {
        case 'json':
            $risposta = json_encode($array_piatto);
            break;
        case 'array':
        default:
            $risposta = $array_piatto;
            break;
    }  
    return($risposta);
}



//Funzione per tracciare il flusso nel file di LOG
//USO: scrivi_nel_log("Sei allo step1"); 
//PER GUARDARE IL LOG: tail -f /tmp/cakephp.log
function scrivi_nel_log($messaggio) 
{
    $file_di_log = "/tmp/cakephp.log";
    $oggi = date("d/m/Y H:i:s ");
    if(is_array($messaggio) || is_object($messaggio))
    {
        $info = serialize($messaggio);
    } 
    else 
    {
        $info = $messaggio;
    }
    error_log($oggi . $info . "\n", 3, $file_di_log);
}


//DG: converte la data-stringa da un formato ad un altro formato (ritorna FALSE se e' errata)
function convertiData($datastringa, $formatoIn, $formatoOut) 
{
    //se la data e' NULL o vuota, la ritorna uguale
    if($datastringa === NULL || $datastringa === '')
    {
        return $datastringa;       
    }
    //verifica se la data rispetta il formato richiesto
    if(DateTime::createFromFormat($formatoIn, $datastringa) == false)
    {
        return false;      //il formato della data e' diverso dal formato richiesto 
    }

    //converte la data in un array
    $dataarray = date_parse_from_format($formatoIn, $datastringa);
    $giorno  = $dataarray['day'];
    $mese    = $dataarray['month'];
    $anno    = $dataarray['year'];
    $ore     = $dataarray['hour']; 
    $minuti  = $dataarray['minute'];
    $secondi = $dataarray['second'];
    
    //controlla se la data e' valida
    if(!checkdate($mese, $giorno, $anno))
    {
        return false;       //data invalida
    }
    if($ore > 23 || $minuti > 59 || $secondi > 59)
    {
        return false;      //ora invalida
    }
    
    //formatta la data nel nuovo formato
    $datatemp = date_create_from_format($formatoIn, $datastringa);
    $dataout = date_format($datatemp, $formatoOut);     
    return $dataout; 
}


//DG: converte la data dal formato "%31/12/2015 18:30%" al formato "%2015-12-31 18:30%" 
//    accetta anche: "%31/12/2015%", "%12/2015%", "%31/12%", "%2015%", ecc 
//    output: "%2015-12-31 18:30%" 
function convertiData2iso($datastringa) 
{
    //se la data e' NULL o vuota, la ritorna uguale
    if($datastringa === NULL || $datastringa === '')
        return $datastringa;       
    //se la data contiene '-', dovrebbe essere gia' in formato ISO e la ritorna uguale
    if(strpos($datastringa, '-') !== false)
        return $datastringa;       
    //se la data NON contiene '/', la ritorna uguale
    // if( strpos($datastringa, '/') === false )
    //     return $datastringa;
    
    //----------------------------------------------------------------------
    //trasforma la data dal formato formato ITA al formato ISO
    //----------------------------------------------------------------------
    //separa la data dall'eventuale ora
    $dataoraarray = explode(' ', $datastringa);

    //separa i caratteri '%' e converte la data in un array
    $dataarraylike = explode('%', $dataoraarray[0]);
    for($i = count($dataarraylike) - 1; $i >= 0; $i--)
    {
        if($dataarraylike[$i] == '')
            $dataarraylike[$i] = '%';
        else
        {
            $dataarray = explode('/', $dataarraylike[$i]);
            $posizioneData = $i;
        }
    }
    //rigira la data nel formato ISO
    $dataoutarray = array();
    for($i = count($dataarray) - 1; $i >= 0; $i--)
    {
        $dataoutarray[] = $dataarray[$i];
    }
    
    //rimette i caratteri '%' al loro posto
    $dataarraylike[$posizioneData] = implode('-', $dataoutarray);

    //prepara la stringa di output
    $dataoraarray[0] = implode('', $dataarraylike);
    $dataout = implode(' ', $dataoraarray);                 
    return $dataout; 
}


//DG: mette in chiaro i campi booleani
function Bool2Testo($valore) 
{
    if($valore)
    {
        $testo = 'Si';
    }
    else
    {
        $testo = 'No';
    }
    return $testo;      
}



//FUNZIONE RICORSIVA
//Cerca una chiave (per nome) e imposta il nuovo valore 
//PARAMETRI:
//      $Array          array da elaborare
//      $Find           chiave da cercare
//      $Replace        nuovo valore da impostare
//https://www.w3schools.in/php-script/recursive-array-replace-by-Key-or-Value/
function ArrayReplace($Array, $Find, $Replace)
{
    if(is_array($Array))
    {
        foreach($Array as $Key=>$Val) 
        {
            if(is_array($Array[$Key]))
            {
                //richiama se stessa
                $Array[$Key] = ArrayReplace($Array[$Key], $Find, $Replace);
            }
            else
            {
                if($Key == $Find) 
                {
                    //sostituisce il valore della chiave
                    $Array[$Key] = $Replace;
                }
            }
        }
    }
    return $Array;
}




//FUNZIONE RICORSIVA
//sfoglia l'array e lo modifica per poter eseguire le ricerche in italiano
//PARAMETRI:
//      $filtri             array dei filtri di ricerca
//      $skema              array con le info sui campi del db
function ConvertiCampiRicercaInItaliano($filtri, $skema) 
{
    if(is_array($filtri))
    {
        foreach($filtri as $key => $termine_cercato) 
        {
            if(is_array($filtri[$key]))
            {
                //richiama se stessa
                $filtri[$key] = ConvertiCampiRicercaInItaliano($filtri[$key], $skema);
            }
            else
            {
                //---------------------------------------------------------------
                //esegue il lavoro sporco
                //---------------------------------------------------------------
                //  $key                // 'Libro.titolo LIKE'
                //  $termine_cercato    // '%termine%'

                foreach($skema as $xNomeCampo => $xtipo)
                {
                    // $xNomeCampo --> "Libro.data_acquisto"
                    if(strpos($key, $xNomeCampo) === 0)
                    {
                        switch ($xtipo) 
                        {
                            case 'decimal':
                                //campo di tipo DECIMAL: sostituisce VIRGOLA con PUNTO
                                $filtri[$key] = str_replace(",",  ".",  $termine_cercato);
                                break;
                            case 'date':
                            case 'datetime':
                                //campo di tipo DATE/DATETIME: esegue la query sulla data MySQL in italiano usando DATE_FORMAT()
                                $formato_data_italiano = ($xtipo == 'datetime') ? '%d/%m/%Y %H:%i' : '%d/%m/%Y';
                                if(strpos($key, ' LIKE') !== false)
                                {
                                    $xtemp = "LIKE";    //ricerca con LIKE
                                }
                                else
                                {
                                    $xtemp = "";        //ricerca con VALUE
                                }

                                //elimina la vecchia entrata
                                unset($filtri[$key]);

                                //inserisce la nuova entrata
                                $nuovo_key = "DATE_FORMAT(" . $xNomeCampo . ", '" . $formato_data_italiano . "') " . $xtemp;
                                $filtri[$nuovo_key] = $termine_cercato;
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }
    }
    return($filtri);
}



//verifica se il codice fiscale e' valido 
//copiato da http://www.manuelmarangoni.it/sir-bit/705/php-controllare-le-variabili-nei-form-codice-fiscale-partita-iva-email-e-prezzo/
function verificaCodiceFiscale($check)
{
    $value = array_values($check);
    $cf = $value[0];
    
    if(strlen($cf)!= 16)
        return false;
    $cf=strtoupper($cf);
    if(!preg_match("/[A-Z0-9]+$/", $cf))
        return false;
    
    $s = 0;
    for($i=1; $i<=13; $i+=2)
    {
        $c=$cf[$i];
        if('0'<=$c and $c<='9')
            $s+=ord($c)-ord('0');
        else
            $s+=ord($c)-ord('A');
    }
    for($i=0; $i<=14; $i+=2)
    {
        $c=$cf[$i];
        switch($c)
        {
            case '0':  $s += 1;  break;
            case '1':  $s += 0;  break;
            case '2':  $s += 5;  break;
            case '3':  $s += 7;  break;
            case '4':  $s += 9;  break;
            case '5':  $s += 13;  break;
            case '6':  $s += 15;  break;
            case '7':  $s += 17;  break;
            case '8':  $s += 19;  break;
            case '9':  $s += 21;  break;
            case 'A':  $s += 1;  break;
            case 'B':  $s += 0;  break;
            case 'C':  $s += 5;  break;
            case 'D':  $s += 7;  break;
            case 'E':  $s += 9;  break;
            case 'F':  $s += 13;  break;
            case 'G':  $s += 15;  break;
            case 'H':  $s += 17;  break;
            case 'I':  $s += 19;  break;
            case 'J':  $s += 21;  break;
            case 'K':  $s += 2;  break;
            case 'L':  $s += 4;  break;
            case 'M':  $s += 18;  break;
            case 'N':  $s += 20;  break;
            case 'O':  $s += 11;  break;
            case 'P':  $s += 3;  break;
            case 'Q':  $s += 6;  break;
            case 'R':  $s += 8;  break;
            case 'S':  $s += 12;  break;
            case 'T':  $s += 14;  break;
            case 'U':  $s += 16;  break;
            case 'V':  $s += 10;  break;
            case 'W':  $s += 22;  break;
            case 'X':  $s += 25;  break;
            case 'Y':  $s += 24;  break;
            case 'Z':  $s += 23;  break;
        }
    }
    //controllo con l'ultimo carattere
    if( chr($s%26+ord('A'))!=$cf[15] )
        return false;
    //CF e' OK
    return true;
}


//PB: se nel campo di ricerca c'e' una sola data (in formato dd/mm/YYYY) fa la ricerca solo per quella data
//    se in vece inseriamo due date fa la ricerca per periodo
function DateDataPerRicerca($query,$args,$model,$field) 
{
    $data1=substr($args[$field],0,10);
    $data2=substr($args[$field],11,10);
    
    $vd1=validateDate($data1);
    $vd2=validateDate($data2);    
   
    if (!($vd1)) //prima data errata
        {
        $return['query']=$query;
        $return['return']=FALSE;
        return $return;
    }
    if (!($vd2)) //seconda tata errata o non c'e'
        {
         $return['query']=$query->andWhere([$model . "." . $field  => new FrozenTime(convertiData2iso($data1))]);
         $return['return']=TRUE;
          return $return;
    }
    else
      {
         $return['query']=$query->andWhere([$model . "." . $field . " >= " => new FrozenTime( convertiData2iso($data1))]);
         $return['query']=$query->andWhere([$model . "." . $field . " <= " => new FrozenTime( convertiData2iso($data2))]);
         $return['return']=TRUE;
         return $return;
    }  
    
}

function validateDate($date, $format = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

?>