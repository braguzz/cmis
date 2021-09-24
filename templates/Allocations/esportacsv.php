<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Allocation[]|\Cake\Collection\CollectionInterface $allocations
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"device_id"' .';';
    $output .= '"owner_id"' .';';
    $output .= '"InizioUso"' .';';
    $output .= '"created"' .';';
    $output .= '"modified"' .';';
    $output .= '"referente"' .';';
    $output .= '"note"' .';';
    $output .= '"mail_referente"' .';';
 $output.="\n";
 ?>
  <?php foreach ($allocations as $allocation) : ?>
             <?php $output.=$this->Number->format($allocation->id).';';?>
        <?php $allocation->has('device') ? $output.= '"' .$allocation->device->id .'";' : $output.=';' ?>
        <?php $allocation->has('owner') ? $output.= '"' .$allocation->owner->name .'";' : $output.=';' ?>
            <?php $output.='"' . h($allocation->InizioUso).'";'; ?>
            <?php $output.='"' . h($allocation->created).'";'; ?>
            <?php $output.='"' . h($allocation->modified).'";'; ?>
            <?php $output.='"' . h($allocation->referente).'";'; ?>
            <?php $output.='"' . h($allocation->note).'";'; ?>
            <?php $output.='"' . h($allocation->mail_referente).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=allocations.csv");
echo $output; 
exit;