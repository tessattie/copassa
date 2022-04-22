<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Authorization $authorization
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $authorization->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $authorization->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Authorizations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="authorizations form content">
            <?= $this->Form->create($authorization) ?>
            <fieldset>
                <legend><?= __('Edit Authorization') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('type');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
