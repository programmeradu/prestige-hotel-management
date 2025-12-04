# Ghana Payments Module for PrestaShop

## Description
The Ghana Payments module allows PrestaShop merchants to accept payments through multiple Ghanaian payment methods:
- Mobile Money (MTN, Vodafone, AirtelTigo)
- Pay at Check-in (for hotel bookings and physical stores)
- Credit/Debit Cards via Paystack

## Installation
1. Download the module zip file
2. Go to your PrestaShop back office > Modules > Module Manager
3. Click on "Upload a module" and select the downloaded zip file
4. Once uploaded, click on "Configure" to set up the payment methods

## Configuration
After installation, you need to configure each payment method you want to offer:

### General Settings
- **Live Mode**: Enable when you're ready to accept real payments
- **Debug Mode**: Enable for development and testing to view detailed logs

### Mobile Money Settings
1. Enable Mobile Money payments in the settings
2. Enter your Mobile Money phone number where you want to receive payments
3. Customize the payment title and description shown to customers
4. Set payment instructions that will be shown on the payment page
5. Mobile Money orders will be placed in the "Awaiting Mobile Money Payment" order state

### Pay at Check-in Settings
1. Enable Pay at Check-in if you want to allow customers to pay when they arrive
2. Customize the title and description for this payment method
3. Pay at Check-in orders will be placed in the "Awaiting Check-in Payment" order state

### Paystack Settings
1. Create a Paystack account at [paystack.com](https://paystack.com) if you don't have one
2. Get your API keys from your Paystack dashboard:
   - Test Secret Key & Public Key for testing
   - Live Secret Key & Public Key for real payments
3. Enter these keys in the module settings
4. Enable Test Mode for testing (no real charges will be made)
5. When ready to accept real payments, disable Test Mode

## Payment Flow
### Mobile Money:
1. Customer selects Mobile Money payment option
2. Customer sees your Mobile Money number and payment instructions
3. Customer makes the payment from their mobile device
4. Customer enters the transaction ID, phone number, and network on your website
5. Order is created with "Awaiting Mobile Money Payment" status
6. Store owner verifies payment and processes the order

### Pay at Check-in:
1. Customer selects Pay at Check-in payment option
2. Order is created with "Awaiting Check-in Payment" status
3. Customer pays in person when they arrive at your location
4. Store owner updates the order status after receiving payment

### Paystack:
1. Customer selects Paystack payment option
2. Customer is redirected to the Paystack secure payment page
3. Customer enters their card details and completes payment
4. Customer is redirected back to your store
5. Order is created with "Payment Accepted" status if payment is successful

## Requirements
- PrestaShop 1.6 or later (tested up to 8.0)
- PHP 5.6 or later
- cURL extension enabled
- SSL Certificate recommended for secure payments

## Support
For support, please contact:
- Email: support@stanetwork.com
- Website: [www.stanetwork.com](https://www.stanetwork.com)

## Changelog
### 1.0.0 (Initial release)
- Mobile Money payment integration (MTN, Vodafone, AirtelTigo)
- Pay at Check-in payment option
- Paystack integration for card payments
- Custom order states for payment tracking
- Admin panel for transaction details