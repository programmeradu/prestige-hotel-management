<?php
/**
 * 2023-2025 StaNetwork
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @author    StaNetwork <contact@stanetwork.com>
 * @copyright 2023-2025 StaNetwork
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

// Use this script to generate PNG files from the base64 data

// Cash icon
$cash_base64 = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAA7AAAAOwBeShxvQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAMtSURBVFiF7ZZPiE1RGMaf985983Le2MiQmpF/2SjNSrKzsGBjYaFmYWGhZmOlrNQslJJSs7CwGgulbGysZKFsxEwTzeS9O++9O+/PnWM1RZNz74xmYWE+dTbn3vN9v9/9zjn3O5Ri6f+PrHZja2yMAQ49a4HdzTeQxJnYKGPC7ZmcZaqmiaxYm3vpatiDDFP+OJEUcUz32iWxeCRdDjBTtgfdzRGHpNO5XBZ3v7xB//gw8iaDnCngZ6axPCKSkcZG+A2Hs+/R2bgVV/LPMczTqGBJGUoCShKjzBI3Tx2XHwZG8OL2Q+xejBGWPfIRGQM+py4EgBbnssiqYpQ6enK6MNWPmc8fYM0YpAggChPktO8ub96ync5cuZYP7j5jIUJIhNiJkOjQvuYJrwAqkzA1wT58YeD9a+TzORhj6gJkYpO3RXm5ZeNGnj46zfliESPFFJyhKrRzzGQsiqkgpEaAgIlEfJRDHirY09qG00cGOWctKGVI8w/gX1WlxADIFIgDCOd0PDSeTXvacOpyjsuFDGMxYFQdAAARICKo1kXFQSYEHx0q4N6ll9TVvYc6t53H8pP9MN6CRCw8CAzIynkSBYSH1UDeZXH22hBvaGnhzs2b6Nixg3snJvCsWMKUgA4FkErO30Z4gAVBzBiMTGRw//EEH+rd473d3Tddtru7UChkf3y3Pur9NCZBQAcCOSZ/Ki6IPCAPDxDKFsGI1YqoJUHbvBkD1xPX1b2nFIWDK+vGiJ1wCICVgiohEwNrogAoKXxMlbC7axt6D/ZyMTtrowhbE8CgAiCPCmAFXHHfSSiwBniipoS+Bz8Aaw3lS6UdveqhZU72DVQAKAMWL3NkXkDke1xMZ3ijoxkvX71B5Gc4gWDRJe8wyyI5AURLo8OlBxwgARUUsGfXTh4au8+lbIZZKZJ5WRH5InltgOXRp9UDjlAFsCiHE/eO0tj4JCeLWc6UZNV7acVFAoVvPqr2hAEk9gkTtQLoaG3lllXNnLFwMvmO7z8xkfz/WO3cFbPmJKQKFaVoV0MjF/IZDu3/p2Pj6N5/AdDxldva2jg1NcVm1eEt5b/MbwMXbllmX267AAAAAElFTkSuQmCC';

// Mobile Money icon
$momo_base64 = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAA7AAAAOwBeShxvQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAOZSURBVFiFzZddiJVVFIafvfb+zp7jnJnxZ8SasQZmQGyEoUYlL6QMQoIKKi+KLooMuugiKOgHKi+KKCgvCqEgqosIMSSRIBKjSM2yxBR/8mfGGc/MOeec7+z97V3MOGbN8cw4As/dfvtb73r3u9fae21HVTlKOTUwj0DEA8pABaiIaP/o9/8Q0YCIelQbIjoE6KDAB8ADuuV7ib1ydXUl0nqNSGUS2KNA+6nSoCoHVLVTRT8+dPjQq7v37v0NaBQgAkJgzNwd44v5aXcuWfLYvFlzHi7P8M9t3lP/6MgP3ZsHe3mtvb29df68+Yubm5o6pk6dumbp0qX3V6qVFLDiM0gROwWIw1DXtC1esGJZ27OTJ6Eif1lVIaocOARP37/mkdUd7R+uf2b9Q0PDQ52tra1XtbS0LEpTDyAYLUDOcRqXLbpj3e0LQzyx4C/rpxHgwLeHGRkp09FxR3tbW9uGDRte7evr6547d+4rwAKgWATAzSm5gXUtiwPHceIiF0QEVaWrq4ve3l6ampqGFy9evGn//v0bN27c+GJvb+8g4AFJEYBc+MIUEKJCXp3jgAj4vk9nZyc9PT0MDQ1pEAQD27dvP9DZ2fnl7t27VwITxiSkCEA+H14BEddxJhQgAr7vs3fvXjo7O+nu7mZkZISWlhZmz57NihUr6O7ufmLbtm1rgMeByrkC5DkFSMAhDiPcIARg586d9Pf3s23bNnbs2MHBgwcZHh7GdV0mTZoEwOrVq5kzZ84a4LLzTUGcj+Li40bk+75u2bKF9evXs2nTJnbt2kV/fz9hODrLnudhWRaO42BZFp7nYZomtm0zYcKE1vMFiHMAxNRbzcZx4vl+L9AHjDq/nZ2ddHV1sXXrVrZv386hQ4colUqUSiVs28Z1XUqlEkEQEIYhpmliWRbGmMkXkgIjQlS9iRfrp1TQY+e2bWPbNrVajXK5jOd5RFFEHMeICJZl4TgOxhjCMMQYQxiGkxljskIA4gJVEKmfCCqAqqKqeJ436ghVxfM8VJUoikiSBGMMQRCQJAmqSrVaBeOvohBAXB8PB1UAOa6qxhhUlSAIiKKIJEnQY+GlUgnXdVFVarUalmURBAHGGFpaWooB1AM0KACgqhgRVJUoiojjmDiOSZKEKIpOAKgqSZKQpimu6xIEAcYYCoVIUFCKAFRVBUmS0Th5wUSEJElO7EySBBE5EWmSJNRqNZIkoeFJvBCAUlXV5y++uDxYrX2z8tpr7hThopJfnkf27WPpiy+9U7337leBaLzPfw9c93UB+V2rNQAAAABJRU5ErkJggg==';

// Paystack icon
$paystack_base64 = 'iVBORw0KGgoAAAANSUhEUgAAAJYAAAAyCAYAAAC+jCIaAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAB9BJREFUeJztnHtwVNUdxz/n7ibZJIQkJEAgQBKSQAghEAiPKKCoKFoQxRHUjrXWx9hqR+1M7Ywz2hnt1Gk7U6cPW1+tjrXWB1IfHQUriIgKCCKvEALkCeS9STabzWbv6R93N5vNPrKbDdmQ/X5mdnLvOb977u/c3z33d347J0opDCClTASmAlOAM6. . .';

// Visa icon
$visa_base64 = 'iVBORw0KGgoAAAANSUhEUgAAAFYAAAAyCAYAAADYM8BmAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAABtJJREFUeJztm39sU1UUx7/nvvZtXbuurRt0wMbGBhs/BgMGZvgDUBASIxgJIQQTY4JGYoLRSPxBCP5AMBojJCYSjEQJiUZDjAYxKkLQgHMbwjbcGDAcbMAYrGPdWruu7Xv3+KdbWdutfW3fKwPyfSX9cc+5t/fc7z333HPvLVBSUoKNGzdi7dq1UFUVLS0tOHToEJqamqDrOmKxGGKxGDRNQzweRyKRQDKZRCqVQjqdRiaTgWEYME0TjDEQEYgIRMScc. . .';

// Mastercard icon
$mastercard_base64 = 'iVBORw0KGgoAAAANSUhEUgAAAFYAAAAyCAYAAADYM8BmAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAABrFJREFUeJztnH9MVWUYx7/nXi5cQQzxR4gmKP4CUxTDrWXOznLLzF+V5cw/amprrrV+bK61aqtZW7TNtdpoNctqzZnlLCzNFJUfFmXOFBWwIC. . .';

// Create directories if they don't exist
$img_dir = dirname(__FILE__) . '/views/img';
if (!is_dir($img_dir)) {
    mkdir($img_dir, 0755, true);
}

// Save the PNG files
file_put_contents($img_dir . '/cash.png', base64_decode($cash_base64));
file_put_contents($img_dir . '/momo.png', base64_decode($momo_base64));

// Create a simple paystack.png
$image = imagecreatetruecolor(100, 30);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 139); // Dark blue
imagefill($image, 0, 0, $bg_color);
imagestring($image, 5, 10, 8, "PAYSTACK", $text_color);
ob_start();
imagepng($image);
$image_data = ob_get_clean();
file_put_contents($img_dir . '/paystack.png', $image_data);

// Create simple visa.png
$image = imagecreatetruecolor(100, 30);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 139); // Dark blue
imagefill($image, 0, 0, $bg_color);
imagestring($image, 5, 10, 8, "VISA", $text_color);
ob_start();
imagepng($image);
$image_data = ob_get_clean();
file_put_contents($img_dir . '/visa.png', $image_data);

// Create simple mastercard.png
$image = imagecreatetruecolor(100, 30);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 255, 0, 0); // Red
imagefill($image, 0, 0, $bg_color);
imagestring($image, 5, 10, 8, "MASTERCARD", $text_color);
ob_start();
imagepng($image);
$image_data = ob_get_clean();
file_put_contents($img_dir . '/mastercard.png', $image_data);

echo "PNG files created successfully in {$img_dir}/";