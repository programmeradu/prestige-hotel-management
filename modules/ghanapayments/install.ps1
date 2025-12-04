# GhanaPayments Module Installation Helper
Write-Host "GhanaPayments Module Installation Helper" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Green
Write-Host ""

# Get PrestaShop path
$PS_PATH = Read-Host "Enter the full path to your PrestaShop installation (e.g. C:\xampp\htdocs\prestashop)"

# Check if the path exists
if (-not (Test-Path $PS_PATH)) {
    Write-Host "Error: The specified path does not exist." -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit
}

# Check if it's a valid PrestaShop installation
if (-not (Test-Path "$PS_PATH\config\config.inc.php")) {
    Write-Host "Warning: This may not be a valid PrestaShop installation." -ForegroundColor Yellow
    $confirm = Read-Host "Do you want to continue anyway? (Y/N)"
    if ($confirm -ne "Y" -and $confirm -ne "y") {
        exit
    }
}

Write-Host ""
Write-Host "Setting up the module..." -ForegroundColor Cyan
Write-Host ""

# Create the module directory if it doesn't exist
$moduleDir = "$PS_PATH\modules\ghanapayments"
if (-not (Test-Path $moduleDir)) {
    New-Item -ItemType Directory -Path $moduleDir -Force | Out-Null
}

# Copy module files
Write-Host "Copying files..." -ForegroundColor Cyan
$sourceDir = Split-Path -Parent $MyInvocation.MyCommand.Path
Copy-Item -Path "$sourceDir\*" -Destination $moduleDir -Recurse -Force

Write-Host ""
Write-Host "Module files have been copied to: $moduleDir" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:"
Write-Host "1. Log into your PrestaShop admin panel"
Write-Host "2. Navigate to Modules > Module Manager"
Write-Host "3. Find 'Ghana Payments' and click Install"
Write-Host "4. Configure the module settings as needed"
Write-Host ""

Read-Host "Press Enter to exit"
