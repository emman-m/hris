<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Print' ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        h1, p {
            text-align: center;
        }
        footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1><?= $title ?? 'Print List' ?></h1>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <?php foreach ($headers as $header): ?>
                    <th><?= $header ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td> <!-- Numbering -->
                        <?php foreach ($row as $cell): ?>
                            <td><?= $cell ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= count($headers) + 1 ?>" style="text-align:center">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <footer>
        Downloaded by: <?= $downloadedBy ?? 'Unknown User' ?>
    </footer>
</body>
</html>
