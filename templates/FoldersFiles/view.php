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
            <?= $this->Html->link(__('Edit Folders File'), ['action' => 'edit', $foldersFile->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Folders File'), ['action' => 'delete', $foldersFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foldersFile->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Folders Files'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Folders File'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="foldersFiles view content">
            <h3><?= h($foldersFile->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Folder') ?></th>
                    <td><?= $foldersFile->has('folder') ? $this->Html->link($foldersFile->folder->name, ['controller' => 'Folders', 'action' => 'view', $foldersFile->folder->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('File') ?></th>
                    <td><?= $foldersFile->has('file') ? $this->Html->link($foldersFile->file->name, ['controller' => 'Files', 'action' => 'view', $foldersFile->file->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($foldersFile->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= $this->Number->format($foldersFile->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($foldersFile->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($foldersFile->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
