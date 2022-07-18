<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categories view content">
            <h3><?= h($category->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($category->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($category->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtitle') ?></th>
                    <td><?= h($category->subtitle) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= $this->Number->format($category->position) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Elements') ?></h4>
                <?php if (!empty($category->elements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Subtitle') ?></th>
                            <th><?= __('Video') ?></th>
                            <th><?= __('Photo') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($category->elements as $elements) : ?>
                        <tr>
                            <td><?= h($elements->id) ?></td>
                            <td><?= h($elements->name) ?></td>
                            <td><?= h($elements->title) ?></td>
                            <td><?= h($elements->subtitle) ?></td>
                            <td><?= h($elements->video) ?></td>
                            <td><?= h($elements->photo) ?></td>
                            <td><?= h($elements->text) ?></td>
                            <td><?= h($elements->position) ?></td>
                            <td><?= h($elements->category_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Elements', 'action' => 'view', $elements->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Elements', 'action' => 'edit', $elements->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Elements', 'action' => 'delete', $elements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $elements->id)]) ?>
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
