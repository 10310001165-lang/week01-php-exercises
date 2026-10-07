# Week 01 PHP Exercises – Full Stack Web Development

Solutions to the ten Week 01 exercises. All data is fictional.

## Run
Copy this folder into the XAMPP document root (`htdocs`), start Apache, then open
`http://localhost/week01-php-exercises/exercise01/` … `exercise10/`.
Exercise 10 has a form: choose `dataset = flawed` to see validation warnings and quality scores.

## Suggested Git workflow (one commit per exercise)
```
git init
git add exercise01 && git commit -m "Add fictional profile display exercise"
git add exercise02 && git commit -m "Implement age classification function"
git add exercise03 && git commit -m "Add household member summary"
git add exercise04 && git commit -m "Add dzongkhag service counter"
git add exercise05 && git commit -m "Add case-insensitive profile search"
git add exercise06 && git commit -m "Add profile validation rules"
git add exercise07 && git commit -m "Add service fee calculator"
git add exercise08 && git commit -m "Complete role permission checker"
git add exercise09 && git commit -m "Add B-PIS records report"
git add exercise10 README.md && git commit -m "Finish B-PIS dashboard and data-quality report"
```

## Review questions
73. Associative arrays label every value (`$p['dzongkhag']`), so B-PIS records read like the real-world fields they describe and don't depend on position.
74. A loop is better when the same step repeats over many items or an unknown number of items; it removes duplication and scales with the data.
75. Functions give one tested place for each rule, so a change (e.g. the age limit) is made once and reused everywhere.
76. `===` compares type and value, so `"0"`, `0`, `false` and `""` are not confused; it avoids surprising loose-comparison bugs.
77. Validation stops missing, out-of-range or malformed data from entering the system, so reports and decisions built on it are reliable.
78. Output may contain user-supplied text; escaping it (`htmlspecialchars`) prevents broken layout and cross-site scripting.
79. Small, well-described commits form a timeline showing how the solution grew, make mistakes easy to locate and revert, and prove incremental work.
