<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersAuthorization $usersAuthorization
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Users Authorization'), ['action' => 'edit', $usersAuthorization->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Users Authorization'), ['action' => 'delete', $usersAuthorization->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersAuthorization->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users Authorizations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Users Authorization'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usersAuthorizations view content">
            <h3><?= h($usersAuthorization->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $usersAuthorization->has('user') ? $this->Html->link($usersAuthorization->user->name, ['controller' => 'Users', 'action' => 'view', $usersAuthorization->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Authorization') ?></th>
                    <td><?= $usersAuthorization->has('authorization') ? $this->Html->link($usersAuthorization->authorization->name, ['controller' => 'Authorizations', 'action' => 'view', $usersAuthorization->authorization->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usersAuthorization->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
