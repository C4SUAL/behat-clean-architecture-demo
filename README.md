# Behat Clean Architecture Demo
A [clean architecture](https://8thlight.com/blog/uncle-bob/2012/08/13/the-clean-architecture.html) demo developed using [Behat](http://behat.org) - Build Driven Development

## Installation

1. Clone this repository into an empty folder and `cd` into the newly created project folder
2. [Install Composer](https://getcomposer.org) (if you don't already have it)
3. Run `composer install` in the project to install all dependencies

## Testing

Run `vendor/bin/behat` from the project's root directory to run the behat tests. 

The feature is defined using a human readable syntax called [Gherkin](https://github.com/cucumber/cucumber/wiki/Gherkin) located in `features/purchaseorder.feature` and the step definitions, written in PHP, can be found in `features/bootstrap/FeatureContext.php`
