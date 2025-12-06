$adminPath = "C:\Backend_Projects\Project1\resources\views\admin"

Get-ChildItem -Path $adminPath -Recurse -Filter *.blade.php | ForEach-Object {
    $content = Get-Content $_.FullName -Raw -Encoding UTF8

    # Replace common emojis
    $content = $content -replace '➕ ', ''
    $content = $content -replace '✏️', 'Bewerken'
    $content = $content -replace '👁️', 'Bekijken'
    $content = $content -replace '🗑️', 'Verwijderen'
    $content = $content -replace '✓ ', ''
    $content = $content -replace '✗ ', ''
    $content = $content -replace '📧ен', ''
    $content = $content -replace '📬', 'Ongelezen'
    $content = $content -replace '📭', 'Gelezen'
    $content = $content -replace '📂 ', ''
    $content = $content -replace '👥', 'Deelnemers'
    $content = $content -replace '⬆️', 'Promote'
    $content = $content -replace '⬇️', 'Demote'

    Set-Content $_.FullName -Value $content -Encoding UTF8 -NoNewline
    Write-Host "Updated: $($_.FullName)"
}

Write-Host "Done!"
