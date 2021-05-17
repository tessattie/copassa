<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="companies view content">
            <h3><?= h($company->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($company->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $company->has('user') ? $this->Html->link($company->user->name, ['controller' => 'Users', 'action' => 'view', $company->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($company->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $this->Number->format($company->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($company->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($company->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Options') ?></h4>
                <?php if (!empty($company->options)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->options as $options) : ?>
                        <tr>
                            <td><?= h($options->id) ?></td>
                            <td><?= h($options->name) ?></td>
                            <td><?= h($options->company_id) ?></td>
                            <td><?= h($options->user_id) ?></td>
                            <td><?= h($options->created) ?></td>
                            <td><?= h($options->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Options', 'action' => 'view', $options->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Options', 'action' => 'edit', $options->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Options', 'action' => 'delete', $options->id], ['confirm' => __('Are you sure you want to delete # {0}?', $options->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Policies') ?></h4>
                <?php if (!empty($company->policies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Option Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Policy Number') ?></th>
                            <th><?= __('Mode') ?></th>
                            <th><?= __('Effective Date') ?></th>
                            <th><?= __('Paid Until') ?></th>
                            <th><?= __('Premium') ?></th>
                            <th><?= __('Fee') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Lapse') ?></th>
                            <th><?= __('Pending') ?></th>
                            <th><?= __('Grace Period') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->policies as $policies) : ?>
                        <tr>
                            <td><?= h($policies->id) ?></td>
                            <td><?= h($policies->company_id) ?></td>
                            <td><?= h($policies->option_id) ?></td>
                            <td><?= h($policies->customer_id) ?></td>
                            <td><?= h($policies->policy_number) ?></td>
                            <td><?= h($policies->mode) ?></td>
                            <td><?= h($policies->effective_date) ?></td>
                            <td><?= h($policies->paid_until) ?></td>
                            <td><?= h($policies->premium) ?></td>
                            <td><?= h($policies->fee) ?></td>
                            <td><?= h($policies->user_id) ?></td>
                            <td><?= h($policies->active) ?></td>
                            <td><?= h($policies->lapse) ?></td>
                            <td><?= h($policies->pending) ?></td>
                            <td><?= h($policies->grace_period) ?></td>
                            <td><?= h($policies->canceled) ?></td>
                            <td><?= h($policies->created) ?></td>
                            <td><?= h($policies->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Policies', 'action' => 'view', $policies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Policies', 'action' => 'edit', $policies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Policies', 'action' => 'delete', $policies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policies->id)]) ?>
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
