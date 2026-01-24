<?php $pager->setSurroundCount(2); ?>
<?php $group = $pagerGroup ?? 'default'; ?>

<nav class="navPaginacao" aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($pager->hasPrevious($group)) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst($group) ?>" aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true"><i class="las la-angle-double-left"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious($group) ?>" aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true"><i class="icon ion-ios-arrow-back"></i></span>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links($group) as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext($group)) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext($group) ?>" aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true"><i class="icon ion-ios-arrow-forward"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast($group) ?>" aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true"><i class="las la-angle-double-right"></i></span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
