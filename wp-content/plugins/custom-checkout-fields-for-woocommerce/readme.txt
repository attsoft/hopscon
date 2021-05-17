=== Custom Checkout Fields for WooCommerce ===
Contributors: algoritmika, anbinder
Tags: woocommerce, checkout, woo commerce
Requires at least: 4.4
Tested up to: 5.6
Stable tag: 1.5.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add custom fields to WooCommerce checkout page.

== Description ==

**Custom Checkout Fields for WooCommerce** plugin lets you add custom fields to WooCommerce checkout.

= Field Types =

* Text
* Textarea
* Number
* Checkbox
* Color
* Datepicker
* Weekpicker
* Timepicker
* Select (including Select2)
* Radio
* Password
* Country
* State
* Email
* Phone
* Search
* URL
* Range

= General Options =

* Label
* Placeholder
* Default value
* Description
* Required
* Customer meta fields

= Position Options =

* Section (billing/shipping/account/order)
* Priority (i.e. order)

= Input Options =

* Max length
* Min value
* Max value
* Step
* Autofocus
* Autocomplete

= Style Options =

* Class
* Label class
* Input class

= Visibility Options =

* Product categories
* Product tags
* Products
* User roles
* Min cart amount
* Max cart amount
* Product shipping classes
* Virtual products
* Downloadable products
* Countries

= Fee Options =

* Fee value
* Fee type (fixed; percent)
* Fee title
* Is fee taxable

= Feedback =

* We are open to your suggestions and feedback. Thank you for using or trying out one of our plugins!
* [Visit plugin site](https://wpfactory.com/item/custom-checkout-fields-for-woocommerce/).

== Installation ==

1. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Start by visiting plugin settings at "WooCommerce > Settings > Custom Checkout Fields".

== Screenshots ==

1. Field options.

== Changelog ==

= 1.5.0 - 06/01/2020 =
* Dev - Datepicker/Weekpicker Type Options - Datepicker: Timepicker addon - "Custom text" options added.
* Developers - `alg_wc_ccf_get_field_option` filter added.
* Dev - Localization - `load_plugin_textdomain` moved to the to `init` action.

= 1.4.9 - 16/12/2020 =
* Dev - Frontend - Order meta - Checking if field `is_visible()` before adding it to order meta. This solves the issue with hidden (e.g. via "Visibility Options > Products") "checkbox" type fields.
* Tested up to: 5.6.
* WC tested up to: 4.8.

= 1.4.8 - 05/11/2020 =
* Dev - `[alg_wc_ccf_translate]` shortcode added (for WPML / Polylang).
* Dev - Shortcodes are now processed in these options: Label, Placeholder, Default value, Description, Fee title, Value for ON, Value for OFF.

= 1.4.7 - 28/10/2020 =
* Dev - Select/Radio Type Options - Select2 - "Text input by user" option added.
* WC tested up to: 4.6.

= 1.4.6 - 07/10/2020 =
* Dev - Using another algorithm for JS minification now.
* WC tested up to: 4.5.

= 1.4.5 - 19/08/2020 =
* Dev - Datepicker/Weekpicker Type Options - Datepicker: Timepicker addon - "Time format" option added.
* Dev - JS files minified.
* WC tested up to: 4.4.

= 1.4.4 - 17/08/2020 =
* Fix - Datepicker/Weekpicker Type Options - Datepicker: Exclude months - Fixed for 2-digit months.
* Dev - Datepicker/Weekpicker Type Options - "Datepicker: Exclude dates" option added.
* Dev - Datepicker/Weekpicker Type Options - Datepicker: Timepicker addon - "Min time" and "Max time" options added.
* Dev - Timepicker Type Options - "Min time" and "Max time" options added.

= 1.4.3 - 14/08/2020 =
* Fix - Weekpicker - JS errors fixed.
* Dev - Datepicker/Weekpicker Type Options - "Datepicker: Timepicker addon" option added.
* Dev - Datepicker/Weekpicker Type Options - Settings titles updated for "Exclude days" and "Exclude months" options (titles start with "Datepicker: ..." now).

= 1.4.2 - 13/08/2020 =
* Dev - Datepicker/Weekpicker Type Options - "Exclude days" option added.
* Dev - Datepicker/Weekpicker Type Options - "Exclude months" option added.
* Tested up to: 5.5.

= 1.4.1 - 07/08/2020 =
* Fix - Advanced - Force fields sort by priority - Option fixed.
* Dev - Select/Radio Type Options - Select2 - "Custom text" options added.
* WC tested up to: 4.3.
* Tested up to: 5.4.

= 1.4.0 - 02/03/2020 =
* Dev - Visibility Options - "Countries" ("Hide" or "Show") options added.
* Dev - Admin settings descriptions updated.
* Dev - Code refactoring.
* WC tested up to: 3.9.

= 1.3.0 - 13/11/2019 =
* Dev - Admin settings restyled.
* Dev - Code refactoring.
* Langs - `es_ES` translation added.
* Tested up to: 5.3.
* WC tested up to: 3.8.

= 1.2.1 - 22/05/2019 =
* Dev - Visibility Options - "Virtual products" option added.
* Dev - Visibility Options - "Downloadable products" option added.
* Dev - Fee Options - "Percent fee: Cart total" option added.
* Dev - Fee Options - "Percent fee: Add shipping" option added.

= 1.2.0 - 20/05/2019 =
* Dev - "Fee Options" added.

= 1.1.0 - 09/05/2019 =
* Fix - Plugin URI fixed.
* Dev - Visibility Options - "Product shipping classes" option added.
* Dev - Code refactoring.
* Tested up to: 5.2.
* WC tested up to: 3.6.

= 1.0.0 - 04/05/2018 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
This is the first release of the plugin.
