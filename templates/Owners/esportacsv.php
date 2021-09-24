<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $owners
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"cmu"' .';';
    $output .= '"name"' .';';
    $output .= '"title"' .';';
 $output.="\n";
 ?>
  <?php foreach ($owners as $owner) : ?>
             <?php $output.='"' . h($owner->id).'";'; ?>
            <?php $output.='"' . h($owner->cmu).'";'; ?>
            <?php $output.='"' . h($owner->name).'";'; ?>
            <?php $output.='"' . h($owner->title).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=owners.csv");
echo $output; 
exit;