<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoldersFile[]|\Cake\Collection\CollectionInterface $foldersFiles
 */
?>
<div class="foldersFiles index content">
    <?= $this->Html->link(__('New Folders File'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Folders Files') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('folder_id') ?></th>
                    <th><?= $this->Paginator->sort('file_id') ?></th>
                    <th><?= $this->Paginator->sort('position') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foldersFiles as $foldersFile): ?>
                <tr>
                    <td><?= $this->Number->format($foldersFile->id) ?></td>
                    <td><?= $foldersFile->has('folder') ? $this->Html->link($foldersFile->folder->name, ['controller' => 'Folders', 'action' => 'view', $foldersFile->folder->id]) : '' ?></td>
                    <td><?= $foldersFile->has('file') ? $this->Html->link($foldersFile->file->name, ['controller' => 'Files', 'action' => 'view', $foldersFile->file->id]) : '' ?></td>
                    <td><?= $this->Number->format($foldersFile->position) ?></td>
                    <td><?= h($foldersFile->created) ?></td>
                    <td><?= h($foldersFile->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $foldersFile->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $foldersFile->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $foldersFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foldersFile->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
