<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaimsType[]|\Cake\Collection\CollectionInterface $claimsTypes
 */
?>
<div class="claimsTypes index content">
    <?= $this->Html->link(__('New Claims Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Claims Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('claim_id') ?></th>
                    <th><?= $this->Paginator->sort('type_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('attachment') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($claimsTypes as $claimsType): ?>
                <tr>
                    <td><?= $this->Number->format($claimsType->id) ?></td>
                    <td><?= $claimsType->has('claim') ? $this->Html->link($claimsType->claim->title, ['controller' => 'Claims', 'action' => 'view', $claimsType->claim->id]) : '' ?></td>
                    <td><?= $claimsType->has('type') ? $this->Html->link($claimsType->type->name, ['controller' => 'Types', 'action' => 'view', $claimsType->type->id]) : '' ?></td>
                    <td><?= h($claimsType->title) ?></td>
                    <td><?= h($claimsType->attachment) ?></td>
                    <td><?= $this->Number->format($claimsType->amount) ?></td>
                    <td><?= h($claimsType->created) ?></td>
                    <td><?= h($claimsType->modified) ?></td>
                    <td><?= $claimsType->has('user') ? $this->Html->link($claimsType->user->name, ['controller' => 'Users', 'action' => 'view', $claimsType->user->id]) : '' ?></td>
                    <td><?= $claimsType->has('tenant') ? $this->Html->link($claimsType->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $claimsType->tenant->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $claimsType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $claimsType->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $claimsType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $claimsType->id)]) ?>
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
