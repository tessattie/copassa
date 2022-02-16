<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Renewal $renewal
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $renewal->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $renewal->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Renewals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="renewals form content">
            <?= $this->Form->create($renewal) ?>
            <fieldset>
                <legend><?= __('Edit Renewal') ?></legend>
                <?php
                    echo $this->Form->control('business_id', ['options' => $businesses]);
                    echo $this->Form->control('group_id');
                    echo $this->Form->control('total');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
