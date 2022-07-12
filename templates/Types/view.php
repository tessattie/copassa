<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Type $type
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Type'), ['action' => 'edit', $type->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Type'), ['action' => 'delete', $type->id], ['confirm' => __('Are you sure you want to delete # {0}?', $type->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="types view content">
            <h3><?= h($type->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($type->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($type->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $type->has('tenant') ? $this->Html->link($type->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $type->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($type->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Claims') ?></h4>
                <?php if (!empty($type->claims)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Policy Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($type->claims as $claims) : ?>
                        <tr>
                            <td><?= h($claims->id) ?></td>
                            <td><?= h($claims->policy_id) ?></td>
                            <td><?= h($claims->title) ?></td>
                            <td><?= h($claims->description) ?></td>
                            <td><?= h($claims->user_id) ?></td>
                            <td><?= h($claims->created) ?></td>
                            <td><?= h($claims->modified) ?></td>
                            <td><?= h($claims->status) ?></td>
                            <td><?= h($claims->tenant_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Claims', 'action' => 'view', $claims->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Claims', 'action' => 'edit', $claims->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Claims', 'action' => 'delete', $claims->id], ['confirm' => __('Are you sure you want to delete # {0}?', $claims->id)]) ?>
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
