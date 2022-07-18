<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Element[]|\Cake\Collection\CollectionInterface $elements
 */
?>
<div class="elements index content">
    <?= $this->Html->link(__('New Element'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Elements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('subtitle') ?></th>
                    <th><?= $this->Paginator->sort('video') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <th><?= $this->Paginator->sort('text') ?></th>
                    <th><?= $this->Paginator->sort('position') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($elements as $element): ?>
                <tr>
                    <td><?= $this->Number->format($element->id) ?></td>
                    <td><?= h($element->name) ?></td>
                    <td><?= h($element->title) ?></td>
                    <td><?= h($element->subtitle) ?></td>
                    <td><?= h($element->video) ?></td>
                    <td><?= h($element->photo) ?></td>
                    <td><?= h($element->text) ?></td>
                    <td><?= $this->Number->format($element->position) ?></td>
                    <td><?= $element->has('category') ? $this->Html->link($element->category->name, ['controller' => 'Categories', 'action' => 'view', $element->category->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $element->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $element->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $element->id], ['confirm' => __('Are you sure you want to delete # {0}?', $element->id)]) ?>
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
