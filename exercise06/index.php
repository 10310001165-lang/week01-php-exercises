<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 6: Profile Validation Engine</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 6: Profile Validation Engine</h1>
<?php
// Decision: collect every error instead of stopping at the first, so the user can fix all problems at once.
function validateProfile(array $p): array
{
    $errors = [];
    $name = trim((string) ($p['name'] ?? ''));
    if ($name === '') {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must contain at least three characters.";
    }
    $age = $p['age'] ?? null;
    if (!is_int($age) || $age < 0 || $age > 120) {
        $errors[] = "Age must be between 0 and 120.";
    }
    if (trim((string) ($p['dzongkhag'] ?? '')) === '') {
        $errors[] = "Dzongkhag is required.";
    }
    if (strlen((string) ($p['cid'] ?? '')) !== 11) {
        $errors[] = "CID must contain exactly 11 characters.";
    }
    if (!in_array($p['status'] ?? null, ["Active", "Inactive"], true)) {
        $errors[] = "Status must be Active or Inactive.";
    }
    return ["isValid" => count($errors) === 0, "errors" => $errors];
}

$tests = [
    "Valid profile"      => ["name" => "Pema Dorji", "age" => 24, "dzongkhag" => "Thimphu", "cid" => "10901000123", "status" => "Active"],
    "Invalid profile A"  => ["name" => "Al", "age" => 130, "dzongkhag" => "", "cid" => "123", "status" => "Pending"],
    "Invalid profile B"  => ["name" => "", "age" => "twenty", "dzongkhag" => "Paro", "cid" => "10901000456", "status" => "active"],
];

foreach ($tests as $label => $profile) {
    $r = validateProfile($profile);
    echo '<h2>' . htmlspecialchars($label) . '</h2>';
    if ($r['isValid']) {
        echo '<p class="ok">Profile is valid</p>';
    } else {
        echo '<ul class="bad">';
        foreach ($r['errors'] as $e) { echo '<li>' . htmlspecialchars($e) . '</li>'; }
        echo '</ul>';
    }
}
?>
</body></html>
