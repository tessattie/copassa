<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pending $pending
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Pendings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pendings form content">
            <?= $this->Form->create($pending) ?>
            <fieldset>
                <legend><?= __('Add Pending') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('option_id', ['options' => $options]);
                    echo $this->Form->control('dependants');
                    echo $this->Form->control('country_id', ['options' => $countries]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
