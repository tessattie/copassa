<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping $grouping
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $grouping->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $grouping->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Groupings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groupings form content">
            <?= $this->Form->create($grouping) ?>
            <fieldset>
                <legend><?= __('Edit Grouping') ?></legend>
                <?php
                    echo $this->Form->control('business_id', ['options' => $businesses]);
                    echo $this->Form->control('grouping_number');
                    echo $this->Form->control('company_id', ['options' => $companies]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
