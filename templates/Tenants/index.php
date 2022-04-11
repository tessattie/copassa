<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant[]|\Cake\Collection\CollectionInterface $tenants
 */
?>
<div class="tenants index content">
    <?= $this->Html->link(__('New Tenant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tenants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('full_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('identification') ?></th>
                    <th><?= $this->Paginator->sort('company') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenants as $tenant): ?>
                <tr>
                    <td><?= $this->Number->format($tenant->id) ?></td>
                    <td><?= h($tenant->full_name) ?></td>
                    <td><?= h($tenant->email) ?></td>
                    <td><?= h($tenant->phone) ?></td>
                    <td><?= h($tenant->identification) ?></td>
                    <td><?= h($tenant->company) ?></td>
                    <td><?= h($tenant->created) ?></td>
                    <td><?= h($tenant->modified) ?></td>
                    <td><?= $tenant->has('user') ? $this->Html->link($tenant->user->name, ['controller' => 'Users', 'action' => 'view', $tenant->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($tenant->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tenant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tenant->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id)]) ?>
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
