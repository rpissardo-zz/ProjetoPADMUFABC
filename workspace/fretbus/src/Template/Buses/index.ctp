<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bus'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="buses index large-9 medium-8 columns content">
    <h3><?= __('Buses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('code') ?></th>
                <th><?= $this->Paginator->sort('company') ?></th>
                <th><?= $this->Paginator->sort('photo') ?></th>
                <th><?= $this->Paginator->sort('dir') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buses as $bus): ?>
            <tr>
                <td><?= $this->Number->format($bus->id) ?></td>
                <td><?= h($bus->code) ?></td>
                <td><?= h($bus->company) ?></td>
                <td><?= h($bus->photo) ?></td>
                <td><?= h($bus->dir) ?></td>
                <td><?= h($bus->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bus->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
