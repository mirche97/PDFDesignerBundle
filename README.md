PDFDesignerBundle
====================

PDF Designer Bundle for creating PDF templates for [Oro Platform](https://github.com/orocrm/platform) using [wkhtmltopdf](http://wkhtmltopdf.org/).

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/23664eed-3391-4310-85d8-c3c4c6199ba5/mini.png)](https://insight.sensiolabs.com/projects/23664eed-3391-4310-85d8-c3c4c6199ba5)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/shopline/PDFDesignerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/shopline/PDFDesignerBundle/?branch=master)

[![Build Status](https://scrutinizer-ci.com/g/shopline/PDFDesignerBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/shopline/PDFDesignerBundle/build-status/master)

## Installation

First make sure wkhtmltopdf is installed properly. Recommended way on Ubuntu is to install it with xvfb using a wrapper script to avoid needing X server to run.

Example:
```
apt-get install wkhtmltopdf
apt-get install xvfb
echo 'xvfb-run --server-args="-screen 0, 1024x768x24" /usr/bin/wkhtmltopdf $*' > ./wkhtmltopdf.sh
chmod a+x wkhtmltopdf.sh
sudo mv wkhtmltopdf.sh /usr/bin/wkhtmltopdf.sh
sudo ln -s /usr/bin/wkhtmltopdf.sh /usr/local/bin/wkhtmltopdf
wkhtmltopdf http://www.google.com output.pdf
```

Then add to composer.json:

```
"require": {
  "shopline/oro-pdfdesigner": "dev-master"
}
```

or run:

```
composer require shopline/oro-pdfdesigner

```
And add the following line in the composer.json 

Run pdf designer as composer post-install/update scripts

To run pdf designer as a composer post-install or post-update script, simply add the "Shopline\\Bundle\\PDFDesignerBundle\\Composer\\DesignerHandler::InstallDesigner" ScriptHandler to the post-install-cmd / post-update-cmd command sections of your composer.json:

"scripts": {
    "post-install-cmd": [
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
        "Shopline\\Bundle\\PDFDesignerBundle\\Composer\\DesignerHandler::InstallDesigner"
    ],
    "post-update-cmd": [
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
        "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
        "Shopline\\Bundle\\PDFDesignerBundle\\Composer\\DesignerHandler::InstallDesigner"
    ]
},



