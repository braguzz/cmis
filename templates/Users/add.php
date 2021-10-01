<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php $this->loadHelper('Captcha.Captcha'); ?>

<?php $this->start('tb_actions'); ?>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="users form content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
           echo $this->Captcha->passive();
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('codice_fiscale');
            echo $this->Form->control('email');
            echo $this->Form->control('role_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
