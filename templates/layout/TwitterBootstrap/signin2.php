<?php
/**
 * @var \Cake\View\View $this
 */
$this->Html->css('BootstrapUI.signin', ['block' => true]);
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->getParam('controller'), $this->request->getParam('action')]) . '" ');
$this->start('tb_body_start');
/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash))
        echo '<div class="row">';
        echo $this->Flash->render();
         echo '</div>';
    $this->end();
}
?>
<body <?= $this->fetch('tb_body_attrs') ?>>
    <div class="grid">
<?php
$this->end();

$this->start('tb_body_end');
echo '</div></body>';
$this->end();

$this->start('tb_footer');
echo ' ';
$this->end();

echo $this->fetch('content');
