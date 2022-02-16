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
                    <th><?= __('Extension') ?></th>
                    <td><?= h($file->extension) ?></td>
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
            <div class="related">
                <h4><?= __('Related Folders') ?></h4>
                <?php if (!empty($file->folders)) : ?>
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
                        <?php foreach ($file->folders as $folders) : ?>
                        <tr>
                            <td><?= h($folders->id) ?></td>
                            <td><?= h($folders->name) ?></td>
                            <td><?= h($folders->parent_id) ?></td>
                            <td><?= h($folders->lft) ?></td>
                            <td><?= h($folders->rght) ?></td>
                            <td><?= h($folders->created) ?></td>
                            <td><?= h($folders->modified) ?></td>
                            <td><?= h($folders->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Folders', 'action' => 'view', $folders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Folders', 'action' => 'edit', $folders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Folders', 'action' => 'delete', $folders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folders->id)]) ?>
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
