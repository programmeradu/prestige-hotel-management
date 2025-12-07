# Prestige Hotel Booking Flow Documentation

## Overview
This document describes the complete booking flow from room selection to order confirmation in the PrestaShop/QloApps hotel management system.

## 1. Room Selection (Homepage)

### Module: `wkhotelroom`
- **File**: `modules/wkhotelroom/wkhotelroom.php`
- **Hook**: `displayHome`
- **Template**: `modules/wkhotelroom/views/templates/hook/hotelRoomDisplayBlock.tpl`

**Process**:
1. Module fetches room display data via `WkHotelRoomDisplay::getHotelRoomDisplayData()`
2. For each room, it:
   - Loads product information
   - Gets product images
   - Calculates pricing (with/without feature pricing)
   - Generates product links using `$this->context->link->getProductLink($idProduct)`
   - Assigns data to Smarty template

**Key Fix Applied**:
- Added `product_link` to each room data array as a fallback
- Explicitly assigned `$this->context->link` to Smarty as `'link'`
- Template uses fallback: `{$roomDisplay.product_link}` → `{$link->getProductLink()}` → `#`

## 2. Product Page (Room Details)

### Controller: `ProductController`
- **File**: `controllers/front/ProductController.php`

**Process**:
1. Validates product ID and loads product
2. Checks if product is a booking product (`$product->booking_product`)
3. Validates date range for hotel bookings
4. Displays room details, availability calendar, pricing
5. User can select dates, occupancy, and add to cart

**Key Features**:
- Date validation via `HotelHelper::validateDateRangeForHotel()`
- Room availability checking
- Feature pricing display
- Service products (additional services) selection

## 3. Adding to Cart

### Controller: `CartController`
- **File**: `controllers/front/CartController.php`
- **Method**: `processChangeProductInCart()` (lines 510-562)

**Process for Hotel Rooms**:
1. Checks if product is a booking product (`$product->booking_product`)
2. If yes, uses `HotelCartBookingData::updateCartBooking()` instead of standard cart update
3. Parameters passed:
   - `id_product`: Product ID
   - `occupancy`: Guest occupancy details (adults, children, child ages)
   - `operator`: 'up' (add) or 'down' (remove)
   - `id_hotel`: Hotel ID
   - `date_from`: Check-in date
   - `date_to`: Check-out date
   - `roomDemands`: JSON-encoded extra demands (facilities, services)
   - `serviceProducts`: Additional service products
   - `id_cart`: Cart ID
   - `id_guest`: Guest ID

**HotelCartBookingData Class**:
- **File**: `modules/hotelreservationsystem/classes/HotelCartBookingData.php`
- **Method**: `updateCartBooking()`
- Creates/updates `HotelCartBookingData` records in database
- Each record represents a room booking in the cart with:
  - Room assignment
  - Date range
  - Occupancy details
  - Extra demands
  - Service products

**Cart Structure**:
- Standard PrestaShop cart items (via `Cart::updateQty()`)
- Hotel-specific booking data (via `HotelCartBookingData` table)
- Service products linked to room bookings (via `RoomTypeServiceProductCartDetail`)

## 4. Cart Review

### Controller: `CartController` or `OrderController`
- **File**: `controllers/front/CartController.php` or `controllers/front/OrderController.php`

**Process**:
1. Displays cart contents
2. Shows hotel bookings with:
   - Room details
   - Date ranges
   - Occupancy
   - Pricing breakdown
   - Service products
3. User can modify quantities, dates, or remove items
4. Proceeds to checkout

## 5. Checkout Process

### Controller: `OrderController`
- **File**: `controllers/front/OrderController.php`

**Steps**:
1. **STEP_ADDRESSES (Step 1)**: Select/enter delivery address
2. **STEP_DELIVERY (Step 2)**: Select shipping method (if applicable)
3. **STEP_PAYMENT (Step 3)**: Select payment method

**Validation**:
- Checks cart quantities
- Validates product availability
- Checks minimum purchase amounts
- Validates customer authentication (if required)

## 6. Order Creation (Payment Processing)

### Class: `PaymentModule`
- **File**: `classes/PaymentModule.php`
- **Method**: `validateOrder()` (lines 164-1005)

**Process**:
1. **Order Creation** (lines 200-400):
   - Creates `Order` object
   - Sets order status
   - Sets `with_occupancy` flag based on configuration
   - Sets advance payment information

2. **Order Details Creation** (lines 400-600):
   - Creates `OrderDetail` for each product in cart
   - Standard PrestaShop order detail records

3. **Hotel Booking Conversion** (lines 700-980):
   - **Key Method**: `HotelCartBookingData::addRoomDataToOrder()`
   - Converts cart bookings to order bookings:
     - Reads `HotelCartBookingData` records for the cart
     - Creates `HotelBookingDetail` records for the order
     - Each booking detail includes:
       - Room assignment (`id_room`)
       - Hotel (`id_hotel`)
       - Date range (`date_from`, `date_to`)
       - Occupancy (`adults`, `children`, `child_ages`)
       - Pricing information
       - Booking type (auto/manual allotment)
   
   - **Extra Demands Processing**:
     - Creates `HotelBookingDemand` records for each extra demand
     - Links to `HotelRoomTypeGlobalDemand`
     - Calculates pricing based on price calculation method
     - Applies taxes
   
   - **Service Products Processing**:
     - Creates `RoomTypeServiceProductOrderDetail` records
     - Links service products to room bookings
     - Handles auto-added services

4. **Cleanup** (line 980):
   - Deletes cart feature prices: `HotelRoomTypeFeaturePricing::deleteByIdCart()`

5. **Hooks** (lines 987-993):
   - Executes `actionValidateOrder` hook
   - Updates product sales statistics

6. **Order Status** (line 1005+):
   - Sets final order status
   - Sends confirmation emails

## 7. Order Confirmation

### Controller: `OrderConfirmationController`
- **File**: `controllers/front/OrderConfirmationController.php` (if exists)

**Process**:
1. Displays order confirmation page
2. Shows order reference
3. Displays booking details
4. Provides order tracking information

## Database Tables Involved

### Cart Phase:
- `ps_cart`: Standard PrestaShop cart
- `ps_cart_product`: Cart products
- `ps_hotel_cart_booking_data`: Hotel room bookings in cart
- `ps_room_type_service_product_cart_detail`: Service products in cart

### Order Phase:
- `ps_orders`: Standard PrestaShop orders
- `ps_order_detail`: Order line items
- `ps_hotel_booking_detail`: Hotel room bookings in orders
- `ps_hotel_booking_demand`: Extra demands for bookings
- `ps_room_type_service_product_order_detail`: Service products in orders

## Key Classes

1. **WkHotelRoom**: Module for displaying rooms on homepage
2. **ProductController**: Handles product/room detail pages
3. **CartController**: Handles cart operations
4. **OrderController**: Handles checkout process
5. **PaymentModule**: Base class for payment processing and order creation
6. **HotelCartBookingData**: Manages cart bookings
7. **HotelBookingDetail**: Manages order bookings
8. **HotelRoomTypeFeaturePricing**: Handles dynamic pricing
9. **RoomTypeServiceProductCartDetail/OrderDetail**: Manages service products

## Common Issues and Fixes

### Issue 1: Broken Product Links
**Symptom**: "Book Now" buttons open broken URLs with PHP notices
**Root Cause**: `$link` object not available in Smarty context
**Fix Applied**:
- Added `product_link` to room data array in `wkhotelroom.php`
- Explicitly assigned `$this->context->link` to Smarty
- Added template fallbacks for link generation

### Issue 2: Cart Booking Data Not Converting
**Symptom**: Orders created but no hotel bookings
**Potential Causes**:
- `HotelCartBookingData::addRoomDataToOrder()` not called
- Cart booking data missing or invalid
- Date validation failures
**Debug Steps**:
- Check `ps_hotel_cart_booking_data` table for cart ID
- Verify `HotelCartBookingData::addRoomDataToOrder()` is called in `PaymentModule::validateOrder()`
- Check for errors in PrestaShop logs

### Issue 3: Occupancy Data Missing
**Symptom**: Bookings created without occupancy information
**Root Cause**: `with_occupancy` flag not set correctly or occupancy data not passed
**Fix**: Ensure `$order->with_occupancy` is set in `PaymentModule::validateOrder()` based on configuration

## Testing Checklist

- [ ] Room links work from homepage
- [ ] Product page loads correctly
- [ ] Adding room to cart works
- [ ] Cart displays booking information correctly
- [ ] Checkout process completes
- [ ] Order is created with hotel bookings
- [ ] Booking details are correct in order
- [ ] Service products are linked correctly
- [ ] Extra demands are saved correctly
- [ ] Confirmation emails are sent

## Notes

- Hotel bookings require both standard cart items AND `HotelCartBookingData` records
- Service products can be auto-added or manually selected
- Feature pricing is temporary and deleted after order creation
- Occupancy-based booking requires `with_occupancy = 1` on order
- All hotel-specific data is stored in custom tables, not standard PrestaShop tables


