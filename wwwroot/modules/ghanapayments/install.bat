@echo off
title GhanaPayments Module Installation Helper

echo GhanaPayments Module Installation Helper
echo ======================================
echo.

set /p PS_PATH=Enter the full path to your PrestaShop installation (e.g. C:\xampp\htdocs\prestashop): 

if not exist "%PS_PATH%" (
    echo Error: The specified path does not exist.
    goto end
)

if not exist "%PS_PATH%\config\config.inc.php" (
    echo Warning: This may not be a valid PrestaShop installation.
    echo Do you want to continue anyway? (Y/N)
    set /p CONFIRM=
    if /i "%CONFIRM%" neq "Y" goto end
)

echo.
echo Setting up the module...
echo.

if not exist "%PS_PATH%\modules\ghanapayments" (
    mkdir "%PS_PATH%\modules\ghanapayments"
)

echo Copying files...
xcopy "%~dp0*.*" "%PS_PATH%\modules\ghanapayments\" /Y
xcopy "%~dp0controllers" "%PS_PATH%\modules\ghanapayments\controllers\" /E /I /Y
xcopy "%~dp0views" "%PS_PATH%\modules\ghanapayments\views\" /E /I /Y
xcopy "%~dp0sql" "%PS_PATH%\modules\ghanapayments\sql\" /E /I /Y
xcopy "%~dp0translations" "%PS_PATH%\modules\ghanapayments\translations\" /E /I /Y 2>nul

echo.
echo Module files have been copied to: %PS_PATH%\modules\ghanapayments
echo.
echo Next steps:
echo 1. Log into your PrestaShop admin panel
echo 2. Navigate to Modules ^> Module Manager
echo 3. Find 'Ghana Payments' and click Install
echo 4. Configure the module settings as needed
echo.

:end
echo Press any key to exit...
pause > nul
