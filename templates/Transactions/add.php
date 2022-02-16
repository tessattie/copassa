<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactions form content">
            <?= $this->Form->create($transaction) ?>
            <fieldset>
                <legend><?= __('Add Transaction') ?></legend>
                <?php
                    echo $this->Form->control('type');
                    echo $this->Form->control('credit');
                    echo $this->Form->control('debit');
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('business_id', ['options' => $businesses]);
                    echo $this->Form->control('group_id');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('renewal_id', ['options' => $renewals]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
