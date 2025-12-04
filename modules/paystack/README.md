# Paystack Payment Gateway for PrestaShop 1.7+ and QloApps

This module allows you to accept payments via Paystack in your PrestaShop 1.7+ and QloApps stores.

## Features

- Accept payments via multiple channels:
  - Credit/Debit Cards
  - Mobile Money (Momo)
  - Bank Transfers
  - USSD
- Real-time payment verification
- Automatic order status updates
- Seamless checkout experience
- PCI-DSS compliant
- Compatible with both PrestaShop 1.7+ and QloApps

## Supported Currencies

- NGN (Nigerian Naira)
- GHS (Ghanaian Cedi)
- ZAR (South African Rand)
- USD (US Dollar)
- XOF (West African CFA)
- KES (Kenyan Shilling)
- EGP (Egyptian Pound)
- UGX (Ugandan Shilling)
- TZS (Tanzanian Shilling)
- RWF (Rwandan Franc)
- EUR (Euro)
- GBP (British Pound)

## Installation

1. Download the module
2. Upload the `paystack` folder to your PrestaShop's `modules` directory
3. Install the module from the Modules page in your PrestaShop back office

## Configuration

1. Sign up for a Paystack account at [paystack.com](https://paystack.com)
2. Obtain your API keys from the Paystack Dashboard
3. Configure the module with your API keys
4. Set your preferred mode (Test or Live)

## Testing

1. Set the module to Test Mode
2. Use Paystack's test cards to simulate transactions:
   - Card Number: 4084 0840 8408 4081
   - Expiry Date: Any future date
   - CVV: Any 3 digits
   - PIN: Any 4 digits
   - OTP: 123456

## Support

For support, please contact:
- Paystack Support: [support@paystack.com](mailto:support@paystack.com)
- Visit [paystack.com/support](https://paystack.com/support)

## Version History

- 1.2.0: Updated for compatibility with latest PrestaShop and QloApps, improved UI, added support for more currencies
- 1.1.0: Initial release for PrestaShop 1.7

## License

This module is released under the [Academic Free License (AFL 3.0)](http://opensource.org/licenses/afl-3.0.php)