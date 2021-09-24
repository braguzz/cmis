<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Disco[]|\Cake\Collection\CollectionInterface $dischi
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"title"' .';';
    $output .= '"descrizione"' .';';
    $output .= '"lingua_id"' .';';
    $output .= '"autore_id"' .';';
    $output .= '"data"' .';';
    $output .= '"datetime"' .';';
    $output .= '"created"' .';';
    $output .= '"modified"' .';';
    $output .= '"intero"' .';';
    $output .= '"booleano"' .';';
    $output .= '"decimale"' .';';
 $output.="\n";
 ?>
  <?php foreach ($dischi as $disco) : ?>
             <?php $output.=$this->Number->format($disco->id).';';?>
            <?php $output.='"' . h($disco->title).'";'; ?>
            <?php $output.='"' . h($disco->descrizione).'";'; ?>
        <?php $disco->has('lingua') ? $output.= '"' .$disco->lingua->title .'";' : $output.=';' ?>
        <?php $disco->has('autore') ? $output.= '"' .$disco->autore->id .'";' : $output.=';' ?>
            <?php $output.='"' . h($disco->data).'";'; ?>
            <?php $output.='"' . h($disco->datetime).'";'; ?>
            <?php $output.='"' . h($disco->created).'";'; ?>
            <?php $output.='"' . h($disco->modified).'";'; ?>
            <?php $output.=$this->Number->format($disco->intero).';';?>
            <?php $output.='"' . h($disco->booleano).'";'; ?>
            <?php $output.=$this->Number->format($disco->decimale).';';?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=dischi.csv");
echo $output; 
exit;