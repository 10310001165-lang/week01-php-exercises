<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 5: B-PIS Record Search</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 5: B-PIS Record Search</h1>
<?php
// Decision: stripos() gives a case-insensitive substring match without altering the stored data.
$profiles = [
    ["name" => "Pema Dorji",      "dzongkhag" => "Thimphu",  "age" => 24, "status" => "Active"],
    ["name" => "Sonam Dorji",     "dzongkhag" => "Paro",     "age" => 41, "status" => "Active"],
    ["name" => "Karma Wangmo",    "dzongkhag" => "Punakha",  "age" => 33, "status" => "Inactive"],
    ["name" => "Tashi Dorji",     "dzongkhag" => "Thimphu",  "age" => 62, "status" => "Active"],
    ["name" => "Dechen Lhamo",    "dzongkhag" => "Wangdue",  "age" => 19, "status" => "Active"],
    ["name" => "Jigme Tenzin",    "dzongkhag" => "Bumthang", "age" => 55, "status" => "Inactive"],
    ["name" => "Choki Zangmo",    "dzongkhag" => "Haa",      "age" => 28, "status" => "Active"],
    ["name" => "Ugyen Namgay",    "dzongkhag" => "Trongsa",  "age" => 47, "status" => "Active"],
];

function searchProfiles(array $profiles, string $term): array
{
    $matches = [];
    foreach ($profiles as $p) {
        if (stripos($p['name'], $term) !== false) {
            $matches[] = $p;
        }
    }
    return $matches;
}

function renderProfiles(array $list): void
{
    echo '<table><tr><th>Name</th><th>Dzongkhag</th><th>Age</th><th>Status</th></tr>';
    foreach ($list as $p) {
        echo '<tr><td>' . htmlspecialchars($p['name']) . '</td><td>' . htmlspecialchars($p['dzongkhag'])
            . "</td><td>{$p['age']}</td><td>{$p['status']}</td></tr>";
    }
    echo '</table>';
}

echo '<h2>All profiles</h2>';
renderProfiles($profiles);

foreach (["DORJI", "tenzin", "xyz"] as $searchTerm) {   // several / one / none
    $found = searchProfiles($profiles, $searchTerm);
    echo '<h2>Search: "' . htmlspecialchars($searchTerm) . '"</h2>';
    echo '<p>Matches: ' . count($found) . '</p>';
    if (count($found) === 0) {
        echo '<p class="warn">No matching records found</p>';
    } else {
        renderProfiles($found);
    }
}
?>
</body></html>
