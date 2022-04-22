<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Newborn $newborn
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $newborn->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $newborn->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Newborns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="newborns form content">
            <?= $this->Form->create($newborn) ?>
            <fieldset>
                <legend><?= __('Edit Newborn') ?></legend>
                <?php
                    echo $this->Form->control('policy_id', ['options' => $policies]);
                    echo $this->Form->control('due_date');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
