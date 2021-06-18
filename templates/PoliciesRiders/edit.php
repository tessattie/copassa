<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoliciesRider $policiesRider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $policiesRider->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $policiesRider->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Policies Riders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="policiesRiders form content">
            <?= $this->Form->create($policiesRider) ?>
            <fieldset>
                <legend><?= __('Edit Policies Rider') ?></legend>
                <?php
                    echo $this->Form->control('policy_id', ['options' => $policies]);
                    echo $this->Form->control('rider_id', ['options' => $riders]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
