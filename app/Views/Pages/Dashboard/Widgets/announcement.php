<div>
    <span class="h1"><?= $data[0]['title'] ?></span><br>
    <span><?= $data[0]['author'] ?? 'Admin' ?></span><br>
    <strong class="text-secondary"><?= $data[0]['created_at'] ?></strong>

    <div class="markdown mt-4 p-3 bg-gray-500" style="max-height: 181px;overflow-y: auto;">
        <?= html_entity_decode($data[0]['content']) ?>
    </div>
</div>


<?php if ($pager): ?>
    <ul class="pagination m-0 ms-auto text-end">
        <li class="page-item <?= !$pager->getPreviousPageURI() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getPreviousPageURI() ?>" tabindex="-1" aria-disabled="true">
                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 6l-6 6l6 6"></path>
                </svg>
                Prev
            </a>
        </li>

        <li class="page-item <?= !$pager->getNextPageURI() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getNextPageURI() ?>">
                Next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 6l6 6l-6 6"></path>
                </svg>
            </a>
        </li>
    </ul>
<?php endif ?>