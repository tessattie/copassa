<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File $file
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit File'), ['action' => 'edit', $file->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete File'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Files'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New File'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="files view content">
            <h3><?= h($file->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($file->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($file->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Folder') ?></th>
                    <td><?= $file->has('folder') ? $this->Html->link($file->folder->name, ['controller' => 'Folders', 'action' => 'view', $file->folder->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $file->has('user') ? $this->Html->link($file->user->name, ['controller' => 'Users', 'action' => 'view', $file->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($file->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $file->has('tenant') ? $this->Html->link($file->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $file->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($file->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($file->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($file->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
