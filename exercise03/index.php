<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 3: Household Member Summary</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 3: Household Member Summary</h1>
<?php
// Decision: the loops track the best candidate so far instead of sorting, so original order is kept.
$members = ["Tshering", "Dorji", "Pema Lhamo", "Ugyen", "Karma", "Choki Wangmo", "Jigme"];

function householdSummary(array $names): array
{
    if (count($names) === 0) {
        return ["count" => 0, "shortest" => null, "longest" => null, "average" => 0.0];
    }
    $shortest = $longest = $names[0];
    $total = 0;
    foreach ($names as $n) {
        $len = strlen($n);
        $total += $len;
        if ($len < strlen($shortest)) { $shortest = $n; }
        if ($len > strlen($longest)) { $longest = $n; }
    }
    return ["count" => count($names), "shortest" => $shortest, "longest" => $longest,
            "average" => round($total / count($names), 2)];
}

echo '<h2>Members</h2><ol>';
foreach ($members as $m) {
    echo '<li>' . htmlspecialchars($m) . ' (' . strlen($m) . ' characters)</li>';
}
echo '</ol>';
echo '<p>Total members: ' . count($members) . '</p>';
echo '<p>First: ' . htmlspecialchars($members[0]) . ' | Last: ' . htmlspecialchars($members[count($members) - 1]) . '</p>';

$s = householdSummary($members);
echo '<h2>Summary function result</h2><ul>';
echo "<li>Member count: {$s['count']}</li>";
echo '<li>Shortest name: ' . htmlspecialchars($s['shortest']) . '</li>';
echo '<li>Longest name: ' . htmlspecialchars($s['longest']) . '</li>';
echo "<li>Average name length: {$s['average']}</li></ul>";
?>
</body></html>
