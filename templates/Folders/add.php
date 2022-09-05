<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folder $folder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Folders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folders form content">
            <?= $this->Form->create($folder) ?>
            <fieldset>
                <legend><?= __('Add Folder') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('tenant_id', ['options' => $tenants]);
                    echo $this->Form->control('files._ids', ['options' => $files]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
