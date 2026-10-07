<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 10: B-PIS Command Dashboard</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 10: B-PIS Command Dashboard</h1>
<?php
// Decision: invalid ages are excluded from statistics (but still flagged), so bad data cannot skew the averages.
$valid = [
    ["name" => "Pema Dorji",   "age" => 24, "status" => "Active",   "location" => ["dzongkhag" => "Thimphu",  "gewog" => "Chang"]],
    ["name" => "Sonam Wangmo", "age" => 41, "status" => "Active",   "location" => ["dzongkhag" => "Paro",     "gewog" => "Doga"]],
    ["name" => "Karma Choden", "age" => 67, "status" => "Inactive", "location" => ["dzongkhag" => "Thimphu",  "gewog" => "Kawang"]],
    ["name" => "Tashi Dorji",  "age" => 62, "status" => "Active",   "location" => ["dzongkhag" => "Thimphu",  "gewog" => "Mewang"]],
    ["name" => "Dechen Lhamo", "age" => 19, "status" => "Active",   "location" => ["dzongkhag" => "Punakha",  "gewog" => "Guma"]],
    ["name" => "Jigme Tenzin", "age" => 55, "status" => "Inactive", "location" => ["dzongkhag" => "Bumthang", "gewog" => "Chhoekhor"]],
    ["name" => "Choki Zangmo", "age" => 28, "status" => "Active",   "location" => ["dzongkhag" => "Paro",     "gewog" => "Lungnyi"]],
    ["name" => "Ugyen Namgay", "age" => 47, "status" => "Active",   "location" => ["dzongkhag" => "Trongsa",  "gewog" => "Nubi"]],
];
$flawed = $valid;
$flawed[1]['name'] = '';                                  // missing name
$flawed[3]['age'] = 150;                                  // invalid age
$flawed[4]['location']['dzongkhag'] = '';                 // missing dzongkhag
$flawed[4]['status'] = 'Pending';                         // invalid status (profile has 2 problems)
$flawed[6]['age'] = -5;                                   // invalid age

$permissions = [
    "administrator" => ["create", "read", "update", "delete", "export"],
    "data officer"  => ["create", "read", "update"],
    "viewer"        => ["read"],
];

function findProblems(array $p): array
{
    $problems = [];
    if (trim($p['name']) === '') { $problems[] = 'Missing name'; }
    if (!is_int($p['age']) || $p['age'] < 0 || $p['age'] > 120) { $problems[] = 'Invalid age'; }
    if (trim($p['location']['dzongkhag']) === '') { $problems[] = 'Missing dzongkhag'; }
    if (!in_array($p['status'], ['Active', 'Inactive'], true)) { $problems[] = 'Invalid status'; }
    return $problems;
}
function qualityScore(array $p): int { return max(0, 100 - 25 * count(findProblems($p))); }
function filterProfiles(array $profiles, string $dz, string $status): array
{
    return array_filter($profiles, fn($p) => ($dz === '' || $p['location']['dzongkhag'] === $dz)
                                          && ($status === '' || $p['status'] === $status));
}
function canPerformAction(array $perms, string $role, string $action): bool
{
    $role = strtolower(trim($role));
    return isset($perms[$role]) && in_array(strtolower(trim($action)), $perms[$role], true);
}
function options(array $values, string $selected, string $blank = ''): string
{
    $html = $blank !== '' ? '<option value="">' . $blank . '</option>' : '';
    foreach ($values as $v) {
        $s = ($v === $selected) ? ' selected' : '';
        $html .= '<option' . $s . '>' . htmlspecialchars($v) . '</option>';
    }
    return $html;
}

// --- Read the selections (GET), falling back to safe defaults ---
$dataset = (($_GET['dataset'] ?? 'valid') === 'flawed') ? 'flawed' : 'valid';
$profiles = $dataset === 'flawed' ? $flawed : $valid;
$selDz = (string) ($_GET['dzongkhag'] ?? '');
$selStatus = (string) ($_GET['status'] ?? '');
$selRole = (string) ($_GET['role'] ?? 'Viewer');
$selAction = (string) ($_GET['action'] ?? 'read');

// --- Statistics ---
$total = count($profiles);
$active = $inactive = 0;
$ages = [];
$youngest = $oldest = null;
foreach ($profiles as $p) {
    if ($p['status'] === 'Active') { $active++; } elseif ($p['status'] === 'Inactive') { $inactive++; }
    if (is_int($p['age']) && $p['age'] >= 0 && $p['age'] <= 120) {
        $ages[] = $p['age'];
        if ($youngest === null || $p['age'] < $youngest['age']) { $youngest = $p; }
        if ($oldest === null || $p['age'] > $oldest['age']) { $oldest = $p; }
    }
}
$dzList = array_values(array_unique(array_filter(array_map(fn($p) => $p['location']['dzongkhag'], $profiles))));
sort($dzList);
?>
<form method="get">
  Dataset: <select name="dataset"><?= options(['valid', 'flawed'], $dataset) ?></select>
  Dzongkhag: <select name="dzongkhag"><?= options($dzList, $selDz, 'All') ?></select>
  Status: <select name="status"><?= options(['Active', 'Inactive'], $selStatus, 'All') ?></select><br><br>
  Role: <select name="role"><?= options(['Administrator', 'Data Officer', 'Viewer', 'Guest'], $selRole) ?></select>
  Action: <select name="action"><?= options(['create', 'read', 'update', 'delete', 'export'], $selAction) ?></select>
  <button type="submit">Apply</button>
</form>
<?php
echo '<h2>Overview</h2><ul>';
echo "<li>Total profiles: $total</li><li>Active: $active | Inactive: $inactive</li>";
if ($youngest !== null) {
    echo '<li>Youngest: ' . htmlspecialchars($youngest['name'] ?: '(no name)') . " ({$youngest['age']})</li>";
    echo '<li>Oldest: ' . htmlspecialchars($oldest['name'] ?: '(no name)') . " ({$oldest['age']})</li>";
    echo '<li>Average age (valid ages only): ' . number_format(array_sum($ages) / count($ages), 1) . '</li>';
}
echo '</ul>';

$allowed = canPerformAction($permissions, $selRole, $selAction);
echo '<h2>Permission check</h2><p class="' . ($allowed ? 'ok' : 'bad') . '">'
    . htmlspecialchars($selRole) . ' ' . ($allowed ? 'may' : 'may not') . ' ' . htmlspecialchars($selAction) . ' records.</p>';

$filtered = filterProfiles($profiles, $selDz, $selStatus);
echo '<h2>Profiles (' . count($filtered) . ' shown)</h2>';
if (count($filtered) === 0) {
    echo '<p>No matching records found.</p>';
} else {
    echo '<table><tr><th>#</th><th>Name</th><th>Age</th><th>Dzongkhag / Gewog</th><th>Status</th><th>Score</th><th>Warnings</th></tr>';
    foreach ($filtered as $i => $p) {
        $problems = findProblems($p);
        echo '<tr><td>' . ($i + 1) . '</td><td>' . htmlspecialchars($p['name']) . "</td><td>{$p['age']}</td><td>"
            . htmlspecialchars($p['location']['dzongkhag'] . ' / ' . $p['location']['gewog']) . '</td><td>'
            . htmlspecialchars($p['status']) . '</td><td>' . qualityScore($p) . '</td><td class="warn">'
            . htmlspecialchars(implode('; ', $problems)) . '</td></tr>';
    }
    echo '</table>';
}

// --- Data-quality summary (whole dataset, not just the filtered rows) ---
$scoreSum = 0; $imperfect = 0; $worst = null; $worstScore = 101;
foreach ($profiles as $i => $p) {
    $s = qualityScore($p);
    $scoreSum += $s;
    if ($s < 100) { $imperfect++; }
    if ($s < $worstScore) { $worstScore = $s; $worst = $i; }
}
echo '<h2>Data-quality summary</h2><ul>';
echo '<li>Average score: ' . number_format($scoreSum / $total, 1) . '</li>';
echo "<li>Imperfect profiles: $imperfect of $total</li>";
if ($imperfect > 0) {
    echo '<li>Most correction needed: record #' . ($worst + 1) . ' (' . htmlspecialchars($profiles[$worst]['name'] ?: 'no name')
        . "), score $worstScore - " . htmlspecialchars(implode(', ', findProblems($profiles[$worst]))) . '</li>';
} else {
    echo '<li class="ok">All profiles are perfect.</li>';
}
echo '</ul>';
?>
</body></html>
