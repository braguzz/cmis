<?php $this->extend('/layout/TwitterBootstrap/signin2'); ?>
<?php $this->loadHelper('Captcha.Captcha'); ?>
 
<div class="container">
     <div class="row">
        <div class="col text-center">  
            <?= $this->Flash->render() ?>
            <div class="mb-3">
                <?= $this->Html->image('logo_regione_toscana.jpg'); ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="users form">
            <?= $this->Form->create($user) ?>

            <fieldset>
                <h2 id="top"><?php echo __('Registrazione nuovo utente'); ?></h2>

                <?php
                echo $this->Captcha->passive();
                echo $this->Form->control('username', array('label' => 'Utente (es: dg11915)'));
                echo $this->Form->control('password', array('label' => 'Password (almeno 7 caratteri)'));
                echo $this->Form->control('email', array('label' => 'Email'));
                echo $this->Form->control('codice_fiscale', array('style' => 'text-transform: uppercase', 'default' => $cf));
                echo '<div style="display:none;">';
                echo $this->Form->input('role_id', array('type' => 'text'));
                echo '</div>';
                ?>

            </fieldset>
            <?php echo $this->Form->button('REGISTRA UTENTE', array('type' => 'submit', 'class' => 'bottone1')); ?>
            <?php echo $this->Form->end(); ?>
           
</div>
</div>
</div>