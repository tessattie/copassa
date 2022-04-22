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
            <?= $this->Html->link(__('Edit Folder'), ['action' => 'edit', $folder->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Folder'), ['action' => 'delete', $folder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folder->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Folders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Folder'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folders view content">
            <h3><?= h($folder->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($folder->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Parent Folder') ?></th>
                    <td><?= $folder->has('parent_folder') ? $this->Html->link($folder->parent_folder->name, ['controller' => 'Folders', 'action' => 'view', $folder->parent_folder->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $folder->has('user') ? $this->Html->link($folder->user->name, ['controller' => 'Users', 'action' => 'view', $folder->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($folder->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lft') ?></th>
                    <td><?= $this->Number->format($folder->lft) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rght') ?></th>
                    <td><?= $this->Number->format($folder->rght) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($folder->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($folder->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Files') ?></h4>
                <?php if (!empty($folder->files)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Location') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Extension') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($folder->files as $files) : ?>
                        <tr>
                            <td><?= h($files->id) ?></td>
                            <td><?= h($files->name) ?></td>
                            <td><?= h($files->location) ?></td>
                            <td><?= h($files->created) ?></td>
                            <td><?= h($files->modified) ?></td>
                            <td><?= h($files->extension) ?></td>
                            <td><?= h($files->user_id) ?></td>
                            <td><?= h($files->description) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Files', 'action' => 'view', $files->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Files', 'action' => 'edit', $files->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Files', 'action' => 'delete', $files->id], ['confirm' => __('Are you sure you want to delete # {0}?', $files->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Folders') ?></h4>
                <?php if (!empty($folder->child_folders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($folder->child_folders as $childFolders) : ?>
                        <tr>
                            <td><?= h($childFolders->id) ?></td>
                            <td><?= h($childFolders->name) ?></td>
                            <td><?= h($childFolders->parent_id) ?></td>
                            <td><?= h($childFolders->lft) ?></td>
                            <td><?= h($childFolders->rght) ?></td>
                            <td><?= h($childFolders->created) ?></td>
                            <td><?= h($childFolders->modified) ?></td>
                            <td><?= h($childFolders->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Folders', 'action' => 'view', $childFolders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Folders', 'action' => 'edit', $childFolders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Folders', 'action' => 'delete', $childFolders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childFolders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
