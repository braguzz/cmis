<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Autore[]|\Cake\Collection\CollectionInterface $autori
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"nome"' .';';
    $output .= '"cognome"' .';';
    $output .= '"note"' .';';
    $output .= '"genere_id"' .';';
 $output.="\n";
 ?>
  <?php foreach ($autori as $autore) : ?>
             <?php $output.=$this->Number->format($autore->id).';';?>
            <?php $output.='"' . h($autore->nome).'";'; ?>
            <?php $output.='"' . h($autore->cognome).'";'; ?>
            <?php $output.='"' . h($autore->note).'";'; ?>
        <?php $autore->has('genere') ? $output.= '"' .$autore->genere->title .'";' : $output.=';' ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=autori.csv");
echo $output; 
exit;