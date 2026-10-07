<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 1: Fictional Citizen Profile</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 1: Fictional Citizen Profile</h1>
<?php
// Decision: status is stored as a real Boolean and converted to words only when displayed.
function displayProfileField(string $label, string $value): string
{
    return '<p><strong>' . htmlspecialchars($label) . ':</strong> ' . htmlspecialchars($value) . '</p>';
}

$profiles = [
    ["fullName" => "Pema Dorji", "cid" => "10901000123", "dob" => "1999-04-12", "dzongkhag" => "Thimphu",
     "gewog" => "Chang", "occupation" => "Teacher", "active" => true],
    // Unusual case: CID has only 10 characters and the profile is inactive.
    ["fullName" => "Sonam Wangmo", "cid" => "1090100045", "dob" => "1985-11-30", "dzongkhag" => "Paro",
     "gewog" => "Doga", "occupation" => "Farmer", "active" => false],
];

foreach ($profiles as $i => $p) {
    echo '<h2>Profile ' . ($i + 1) . '</h2>';
    echo displayProfileField('Full name', $p['fullName']);
    echo displayProfileField('Name (uppercase)', strtoupper($p['fullName']));
    echo displayProfileField('CID', $p['cid']);
    echo displayProfileField('Date of birth', $p['dob']);
    echo displayProfileField('Dzongkhag', $p['dzongkhag']);
    echo displayProfileField('Gewog', $p['gewog']);
    echo displayProfileField('Occupation', $p['occupation']);
    echo displayProfileField('Status', $p['active'] ? 'Active' : 'Inactive');
    $len = strlen($p['cid']);
    echo displayProfileField('CID length', (string) $len . ' characters');
    if ($len !== 11) {
        echo '<p class="warn">Warning: a CID must contain exactly 11 characters.</p>';
    }
}
?>
</body></html>


