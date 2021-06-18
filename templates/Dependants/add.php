<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dependant $dependant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Dependants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="dependants form content">
            <?= $this->Form->create($dependant) ?>
            <fieldset>
                <legend><?= __('Add Dependant') ?></legend>
                <?php
                    echo $this->Form->control('relation');
                    echo $this->Form->control('dob', ['empty' => true]);
                    echo $this->Form->control('sexe');
                    echo $this->Form->control('limitations');
                    echo $this->Form->control('policy_id', ['options' => $policies]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
