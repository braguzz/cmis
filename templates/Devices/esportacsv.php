<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device[]|\Cake\Collection\CollectionInterface $devices
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"utenza_imei"' .';';
    $output .= '"devmodel_id"' .';';
    $output .= '"data_carico"' .';';
    $output .= '"data_scarico"' .';';
    $output .= '"created"' .';';
    $output .= '"modified"' .';';
    $output .= '"mac"' .';';
 $output.="\n";
 ?>
  <?php foreach ($devices as $device) : ?>
             <?php $output.='"' . h($device->id).'";'; ?>
            <?php $output.='"' . h($device->utenza_imei).'";'; ?>
        <?php $device->has('devmodel') ? $output.= '"' .$device->devmodel->title .'";' : $output.=';' ?>
            <?php $output.='"' . h($device->data_carico).'";'; ?>
            <?php $output.='"' . h($device->data_scarico).'";'; ?>
            <?php $output.='"' . h($device->created).'";'; ?>
            <?php $output.='"' . h($device->modified).'";'; ?>
            <?php $output.='"' . h($device->mac).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=devices.csv");
echo $output; 
exit;