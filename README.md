Chicho challenge
================

#### Use
1. Fork this repository
1. Run `composer install`
1. Run `php ./vendor/phpunit/phpunit/phpunit` (requires php >= 7.3 if you use other version please update composer.json file first)

#### Tasks

- Fix any errors and add the necessary to make the test work and commit it
- Add a test for the method makeCallByName passing a valid contact, mock up any hard dependency and add the right assertions
- Add the necessary code in the production code to check when the contact is not found and add another test to test that case
- Add your own logic to send a SMS given a number and the body, the method should validate the number using the validateNumber method from ContactService and using the provider property’s methods
- When writing the tests you should mock every method from ContactService

#### Bonus
- Can you add support for two mobile carriers? How would you accomplish that?
- Create a new integration with an external service like Twilio to send and track an SMS.
- Create Unit Tests for this integration using a mock web server or similar.

#### NOTAS

- Las pruebas pasan sin problemas cuando son ejecutadas individualmente, tuve unos problemas para ejecutar la suit de pruebas ya que habian algunos conflictos en los mocks, creo que eso se puede manejar. 

aqui dejo de igual manera el comando para cada test

php ./vendor/phpunit/phpunit/phpunit tests/MobileTest.php --filter it_returns_null_when_name_empty
php ./vendor/phpunit/phpunit/phpunit tests/MobileTest.php --filter it_returns_a_contact_valid_when_name_is_not_empty
php ./vendor/phpunit/phpunit/phpunit tests/MobileTest.php --filter it_returns_null_when_contact_not_found
php ./vendor/phpunit/phpunit/phpunit tests/MobileTest.php --filter it_returns_ok_when_send_sms
php ./vendor/phpunit/phpunit/phpunit tests/MobileTest.php --filter it_returns_error_when_send_sms
