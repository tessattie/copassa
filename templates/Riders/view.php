<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rider $rider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Rider'), ['action' => 'edit', $rider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Rider'), ['action' => 'delete', $rider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Riders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Rider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="riders view content">
            <h3><?= h($rider->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($rider->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $rider->has('user') ? $this->Html->link($rider->user->name, ['controller' => 'Users', 'action' => 'view', $rider->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($rider->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($rider->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($rider->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
