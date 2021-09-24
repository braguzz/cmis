<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Libro[]|\Cake\Collection\CollectionInterface $libri
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"titolo"' .';';
    $output .= '"numero_scaffale"' .';';
    $output .= '"lingua_id"' .';';
    $output .= '"autore_id"' .';';
    $output .= '"disponibile"' .';';
    $output .= '"data_acquisto"' .';';
 $output.="\n";
 ?>
  <?php foreach ($libri as $libro) : ?>
             <?php $output.=$this->Number->format($libro->id).';';?>
            <?php $output.='"' . h($libro->titolo).'";'; ?>
            <?php $output.=$this->Number->format($libro->numero_scaffale).';';?>
        <?php $libro->has('lingua') ? $output.= '"' .$libro->lingua->title .'";' : $output.=';' ?>
        <?php $libro->has('autore') ? $output.= '"' .$libro->autore->id .'";' : $output.=';' ?>
            <?php $output.='"' . h($libro->disponibile).'";'; ?>
            <?php $output.='"' . h($libro->data_acquisto).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=libri.csv");
echo $output; 
exit;