<!-- app/Views/pagination/custom_pagination.php -->

<?php if ($pager): ?>
    <?php
    $currentPage = $pager->getCurrentPageNumber();
    $totalPages = $pager->getPageCount();
    $maxVisiblePages = 5;

    // Set the number of links to display on either side of the current page
    $pager->setSurroundCount(floor($maxVisiblePages / 2));
    ?>

    <ul class="pagination m-0 ms-auto">
        <!-- First Page Link -->
        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getFirst() ?>" tabindex="-1" aria-disabled="true">
                First
            </a>
        </li>

        <!-- Previous Page Link -->
        <li class="page-item <?= !$pager->hasPreviousPage() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getPreviousPage() ?>" tabindex="-1" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 6l-6 6l6 6"></path>
                </svg>
                Prev
            </a>
        </li>

        <!-- Page Number Links -->
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <!-- Next Page Link -->
        <li class="page-item <?= !$pager->hasNextPage() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getNextPage() ?>">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 6l6 6l-6 6"></path>
                </svg>
            </a>
        </li>

        <!-- Last Page Link -->
        <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getLast() ?>">
                Last
            </a>
        </li>
    </ul>
<?php endif ?>