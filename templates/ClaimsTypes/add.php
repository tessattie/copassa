<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaimsType $claimsType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Claims Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="claimsTypes form content">
            <?= $this->Form->create($claimsType) ?>
            <fieldset>
                <legend><?= __('Add Claims Type') ?></legend>
                <?php
                    echo $this->Form->control('claim_id', ['options' => $claims]);
                    echo $this->Form->control('type_id', ['options' => $types]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('attachment');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('tenant_id', ['options' => $tenants]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
