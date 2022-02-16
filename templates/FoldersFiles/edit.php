<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoldersFile $foldersFile
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $foldersFile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $foldersFile->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Folders Files'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="foldersFiles form content">
            <?= $this->Form->create($foldersFile) ?>
            <fieldset>
                <legend><?= __('Edit Folders File') ?></legend>
                <?php
                    echo $this->Form->control('folder_id', ['options' => $folders]);
                    echo $this->Form->control('file_id', ['options' => $files]);
                    echo $this->Form->control('position');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
