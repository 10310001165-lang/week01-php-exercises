<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 9: B-PIS Records Report</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 9: B-PIS Records Report</h1>
<?php
// Decision: one generic tally() helper does the counting; the named functions wrap it for readability.
$records = [
    ["name" => "Pema Dorji",    "dzongkhag" => "Thimphu",  "age" => 24, "status" => "Active",   "type" => "Birth"],
    ["name" => "Sonam Wangmo",  "dzongkhag" => "Paro",     "age" => 41, "status" => "Active",   "type" => "Marriage"],
    ["name" => "Karma Choden",  "dzongkhag" => "Thimphu",  "age" => 67, "status" => "Inactive", "type" => "Census"],
    ["name" => "Tashi Dorji",   "dzongkhag" => "Thimphu",  "age" => 62, "status" => "Active",   "type" => "Census"],
    ["name" => "Dechen Lhamo",  "dzongkhag" => "Punakha",  "age" => 19, "status" => "Active",   "type" => "Birth"],
    ["name" => "Jigme Tenzin",  "dzongkhag" => "Bumthang", "age" => 55, "status" => "Inactive", "type" => "Census"],
    ["name" => "Choki Zangmo",  "dzongkhag" => "Paro",     "age" => 28, "status" => "Active",   "type" => "Census"],
    ["name" => "Ugyen Namgay",  "dzongkhag" => "Trongsa",  "age" => 47, "status" => "Active",   "type" => "Marriage"],
    ["name" => "Rinchen Pem",   "dzongkhag" => "Thimphu",  "age" => 12, "status" => "Active",   "type" => "Birth"],
    ["name" => "Nima Tshering", "dzongkhag" => "Haa",      "age" => 71, "status" => "Inactive", "type" => "Census"],
];

function tally(array $records, string $key): array
{
    $c = [];
    foreach ($records as $r) { $c[$r[$key]] = ($c[$r[$key]] ?? 0) + 1; }
    arsort($c);
    return $c;
}
function countByStatus(array $r): array     { return tally($r, 'status'); }
function countByDzongkhag(array $r): array  { return tally($r, 'dzongkhag'); }
function countByRecordType(array $r): array { return tally($r, 'type'); }
function percentage(int $part, int $total): float { return $total === 0 ? 0.0 : round($part / $total * 100, 1); }

function countTable(string $title, array $counts, int $total): void
{
    echo '<h2>' . htmlspecialchars($title) . '</h2><table><tr><th>Category</th><th>Count</th><th>Share</th></tr>';
    foreach ($counts as $k => $c) {
        echo '<tr><td>' . htmlspecialchars((string) $k) . "</td><td>$c</td><td>" . percentage($c, $total) . '%</td></tr>';
    }
    echo '</table>';
}

$total = count($records);
$status = countByStatus($records);
$active = $status['Active'] ?? 0;
$adults = $seniors = 0;
foreach ($records as $r) {
    if ($r['age'] >= 60) { $seniors++; } elseif ($r['age'] >= 18) { $adults++; }
}

echo '<h2>Summary</h2><table>';
echo "<tr><th>Total records</th><td>$total</td></tr>";
echo "<tr><th>Active</th><td>$active</td></tr>";
echo '<tr><th>Inactive</th><td>' . ($status['Inactive'] ?? 0) . '</td></tr>';
echo "<tr><th>Adults (18-59)</th><td>$adults</td></tr>";
echo "<tr><th>Senior citizens (60+)</th><td>$seniors</td></tr>";
echo '<tr><th>Active percentage</th><td>' . percentage($active, $total) . '%</td></tr></table>';

$byDz = countByDzongkhag($records);
$byType = countByRecordType($records);
countTable('Records by dzongkhag', $byDz, $total);
countTable('Records by record type', $byType, $total);

echo '<h2>Interpretation</h2><p>';
echo htmlspecialchars((string) array_key_first($byDz)) . ' has the most records (' . reset($byDz) . ' of ' . $total . '), and ';
echo htmlspecialchars((string) array_key_first($byType)) . ' is the most common record type (' . reset($byType) . ' records). ';
echo percentage($active, $total) . '% of records are active.</p>';
?>
</body></html>
