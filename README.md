# behat-clean-architecture-demo
A clean architecture demo developed using Behat - Build Driven Development

## Installation

1. Clone this repository into an empty folder and `cd` into the newly created project folder
2. Install Composer (if you don't already have it)
3. Run `composer install` in the project to install all dependencies

## Testing

Run `vendor/bin/behat` in the projects root directory to run the behat tests. The behat feature located at `features/purchaseorder.feature` and the tests that run against it are in `features/bootstrap/FeatureContext.php`