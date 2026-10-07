<?php declare(strict_types=1); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Exercise 8: Role Permission Checker</title><style>body{font-family:sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem}table{border-collapse:collapse;margin:.5rem 0}td,th{border:1px solid #999;padding:4px 10px;text-align:left}th{background:#eee}.warn,.bad{color:#b00}.ok{color:#080}</style></head><body><h1>Exercise 8: Role Permission Checker</h1>
<?php
// Decision: a permissions lookup table replaces a long if/elseif chain; adding a role is just adding data.
$permissions = [
    "administrator" => ["create", "read", "update", "delete", "export"],
    "data officer"  => ["create", "read", "update"],
    "viewer"        => ["read"],
];

function canPerformAction(array $permissions, string $role, string $action): bool
{
    $role = strtolower(trim($role));
    $action = strtolower(trim($action));
    return isset($permissions[$role]) && in_array($action, $permissions[$role], true);
}

$tests = [
    ["Administrator", "delete"], ["ADMINISTRATOR", "Export"], ["Data Officer", "update"],
    ["Data Officer", "delete"], ["Viewer", "read"], ["viewer", "create"],
    ["Guest", "read"], ["Administrator", "approve"], ["  data officer ", "READ"],
];

echo '<table><tr><th>Role</th><th>Action</th><th>Result</th><th>Message</th></tr>';
foreach ($tests as [$role, $action]) {
    $ok = canPerformAction($permissions, $role, $action);
    $r = htmlspecialchars(trim($role));
    $a = htmlspecialchars(trim($action));
    $known = isset($permissions[strtolower(trim($role))]);
    if ($ok) {
        $msg = "The role \"$r\" is allowed to $a records.";
    } elseif (!$known) {
        $msg = "The role \"$r\" is unknown and has no permissions, so \"$a\" is denied.";
    } else {
        $msg = "The role \"$r\" is not allowed to $a records.";
    }
    echo "<tr><td>$r</td><td>$a</td><td class=\"" . ($ok ? 'ok' : 'bad') . '">' . ($ok ? 'true' : 'false') . "</td><td>$msg</td></tr>";
}
echo '</table>';
?>
</body></html>
