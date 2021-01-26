# PayZen for OXID eShop CE

PayZen for OXID eShop CE is an open source plugin that links e-commerce websites based on OXID eShop CE to PayZen secure payment gateway developed by [Lyra Network](https://www.lyra.com/).

# Installation

- Unzip downloaded archive and copy the `copy_this` directory contents to your website root folder.
- Browse to `EXTENSIONS > Modules` in OXID eShop CE backend.
- From version 6.2 of OXID eShop CE, you have to run the following command to install module configuration:

```
vendor/bin/oe-console oe:module:install-configuration <module sourcecode path>
```
- Click on the `Activate` button.
- Clear `/source/tmp/` folder contents.

# Upgrade

- Browse to `EXTENSIONS > Modules` in OXID eShop CE backend.
- Search for the old version of the module, then click on the `Deactivate` button.
- Manually delete files `metadata.php` (folder `/source/modules/ly/payzen/`) via FTP.
- Please consult previous chapter `# Installation` to perform the module installation.

# Configuration

- Browse to `EXTENSIONS > Modules` in OXID eShop CE backend.
- Click on `Settings` tab next to the desired PayZen payment method.
- You can now enter your gateway credentials.
- Click on the `Save` button.

## License

Each PayZen for OXID eShop CE source file included in this distribution is licensed under the GNU GENERAL PUBLIC LICENSE (GPL 3.0 or later).

Please see LICENSE for the full text of the GPL 3.0 license. It is also available through the world-wide-web at this URL: http://www.gnu.org/licenses/gpl.html.