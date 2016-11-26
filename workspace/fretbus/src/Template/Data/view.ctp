<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Data'), ['action' => 'edit', $data->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Data'), ['action' => 'delete', $data->id], ['confirm' => __('Are you sure you want to delete # {0}?', $data->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Data'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Data'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Buses'), ['controller' => 'Buses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bus'), ['controller' => 'Buses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="data view large-9 medium-8 columns content">
    <h3><?= h($data->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Bus') ?></th>
            <td><?= $data->has('bus') ? $this->Html->link($data->bus->id, ['controller' => 'Buses', 'action' => 'view', $data->bus->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= h($data->lat) ?></td>
        </tr>
        <tr>
            <th><?= __('Lon') ?></th>
            <td><?= h($data->lon) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($data->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($data->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($data->modified) ?></td>
        </tr>
    </table>
</div>
