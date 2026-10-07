<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 4: Dzongkhag Service Counter</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 4: Dzongkhag Service Counter</h1>
<?php
// Decision: counters live in one associative array, so a new dzongkhag needs no new variable.
$requests = ["Thimphu", "Paro", "Thimphu", "Punakha", "Paro", "Thimphu"];

echo '<h2>Requests</h2><ol>';
foreach ($requests as $n => $d) {
    echo '<li>Request #' . ($n + 1) . ': ' . htmlspecialchars($d) . '</li>';
}
echo '</ol>';

$counts = [];
foreach ($requests as $d) {
    $counts[$d] = ($counts[$d] ?? 0) + 1;
}

echo '<h2>Requests per dzongkhag</h2><ul>';
$topName = null;
$topCount = 0;
foreach ($counts as $d => $c) {
    echo '<li>' . htmlspecialchars($d) . ": $c</li>";
    if ($c > $topCount) { $topCount = $c; $topName = $d; }
}
echo '</ul>';

$total = count($requests);
echo "<p>Total requests: $total</p>";
echo '<p>Highest: ' . htmlspecialchars((string) $topName) . " with $topCount request(s)</p>";
$thimphuPct = $total > 0 ? (($counts['Thimphu'] ?? 0) / $total) * 100 : 0;
echo '<p>Thimphu share: ' . number_format($thimphuPct, 1) . '%</p>';
?>
</body></html>
