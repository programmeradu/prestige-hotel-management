---
description: How to clear cache after making CSS/TPL changes
---
# Clear Cache Workflow

## After Making Style Changes

When you modify CSS or template (TPL) files, clear the cache using one of these methods:

### Option 1: Via QloApps Admin Panel (Recommended)
1. Log into your QloApps Back Office
2. Go to **Advanced Parameters** > **Performance**
3. Click **Clear cache** button

### Option 2: Delete Cache Files Manually
If you have server access, delete contents of these directories (keep the `index.php` files):
- `cache/smarty/compile/*`
- `cache/smarty/cache/*`
- `cache/cachefs/*`

### Option 3: Disable Cache for Development
In the Back Office:
1. Go to **Advanced Parameters** > **Performance**
2. Set **Template compilation** to "Force compilation"
3. Set **Cache** to "No"

> [!WARNING]  
> Re-enable caching before going to production!

## Files That Require Cache Clear
- `themes/hotel-reservation-theme/css/*.css`
- `themes/hotel-reservation-theme/*.tpl`
- `modules/*/views/css/*.css`
- `modules/*/views/templates/**/*.tpl`
