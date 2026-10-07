<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 2: Age and Service Eligibility</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 2: Age and Service Eligibility</h1>
<?php
// Decision: the function returns a structured array so display code never re-derives the rules.
function classifyCitizen(int $age): array
{
    if ($age < 0 || $age > 120) {
        return ["group" => "Invalid", "eligible" => false,
                "explanation" => "Age $age is outside the valid range of 0 to 120, so it was rejected."];
    }
    if ($age < 13) {
        $group = "Child";
    } elseif ($age < 18) {
        $group = "Teenager";
    } elseif ($age < 60) {
        $group = "Adult";
    } else {
        $group = "Senior Citizen";
    }
    $eligible = $age >= 18;
    $explanation = $eligible
        ? "Aged $age ($group): meets the minimum age of 18, so the adult-only service is available."
        : "Aged $age ($group): below the minimum age of 18, so the adult-only service is not available.";
    return ["group" => $group, "eligible" => $eligible, "explanation" => $explanation];
}

$name = "Karma Choden";
$testAges = [8, 15, 18, 59, 60, 130, -3];
echo '<p>Citizen: <strong>' . htmlspecialchars($name) . '</strong></p>';
echo '<table><tr><th>Age</th><th>Age group</th><th>Eligible</th><th>Explanation</th></tr>';
foreach ($testAges as $age) {
    $r = classifyCitizen($age);
    $cls = $r['eligible'] ? 'ok' : 'bad';
    echo "<tr><td>$age</td><td>{$r['group']}</td><td class=\"$cls\">" . ($r['eligible'] ? 'Yes' : 'No')
        . "</td><td>{$r['explanation']}</td></tr>";
}
echo '</table>';
?>
</body></html>
