<?php if (!empty($data)): ?>
    <?php foreach ($data as $item): ?>
        <a href="<?= route_to('notification-show', $item['id']) ?>" class="no-decoration">
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Icon badge -->
                        <?php if (!$item['is_read']): ?>
                            <span class="status-dot status-dot-animated bg-green d-block"></span>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <!-- <a href="#" class="text-body d-block">Example 1</a> -->

                        <div class="d-block text-body mt-n1">
                            <?= $item['context'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col-auto">
            </div>
            <div class="col">
                <div class="d-block text-body mt-n1">
                    No Updates
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>