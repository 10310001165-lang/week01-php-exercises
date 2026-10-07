<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 7: Service Fee Calculator</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 7: Service Fee Calculator</h1>
<?php
// Decision: all money maths happens in one function and is formatted only when displayed.
$serviceFees = ["Certificate" => 100, "Verification" => 50, "Replacement" => 200, "Correction" => 75];
const PROCESSING_CHARGE = 20.0;

function calculateFee(array $fees, string $service, int $quantity): array
{
    if (!array_key_exists($service, $fees)) {
        return ["error" => "Unknown service: $service."];
    }
    if ($quantity < 1) {
        return ["error" => "Quantity must be at least 1."];
    }
    $unit = (float) $fees[$service];
    $cost = $unit * $quantity;
    $discount = $quantity >= 5 ? $cost * 0.10 : 0.0;
    $final = $cost - $discount + PROCESSING_CHARGE;
    return ["error" => null, "service" => $service, "unit" => $unit, "quantity" => $quantity,
            "cost" => $cost, "discount" => $discount, "processing" => PROCESSING_CHARGE, "final" => $final];
}

function nu(float $v): string { return 'Nu. ' . number_format($v, 2); }

$orders = [["Certificate", 2], ["Verification", 5], ["Replacement", 10], ["Passport", 1], ["Correction", 0]];
foreach ($orders as [$service, $qty]) {
    $r = calculateFee($serviceFees, $service, $qty);
    echo '<h2>' . htmlspecialchars($service) . " x $qty</h2>";
    if ($r['error'] !== null) {
        echo '<p class="bad">Error: ' . htmlspecialchars($r['error']) . '</p>';
        continue;
    }
    echo '<table>';
    echo '<tr><th>Service</th><td>' . htmlspecialchars($r['service']) . '</td></tr>';
    echo '<tr><th>Unit fee</th><td>' . nu($r['unit']) . '</td></tr>';
    echo "<tr><th>Quantity</th><td>{$r['quantity']}</td></tr>";
    echo '<tr><th>Cost before discount</th><td>' . nu($r['cost']) . '</td></tr>';
    echo '<tr><th>Discount</th><td>' . nu($r['discount']) . '</td></tr>';
    echo '<tr><th>Processing charge</th><td>' . nu($r['processing']) . '</td></tr>';
    echo '<tr><th>Final amount</th><td><strong>' . nu($r['final']) . '</strong></td></tr>';
    echo '</table>';
}
?>
</body></html>
