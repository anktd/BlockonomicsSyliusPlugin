## Progress so far

### Installation

```bash
composer install
cd tests/application
php bin/console sylius:install
yarn install
yarn build
symfony start
```

### Adding Blockonomics payment method
- Todo: translations

![image](https://github.com/user-attachments/assets/21df33b9-59d4-4a16-908b-20b9554e6097)


### Blockonomics gateway form
Todo: 
- Translations
- Update callback url to correct url
- Action to submit form

![image](https://github.com/user-attachments/assets/842f2766-a82d-4418-a107-5b067e40105f)

### Added Blockonomics payment gateway on Admin 

![image](https://github.com/user-attachments/assets/4284f00e-ab9a-43e9-81d0-c8d8abe07b41)

### Customer selects Blockonomics
Todo:
- Potentially add blockonomics icon in the bottom right corner?

![image](https://github.com/user-attachments/assets/98e3e247-bdb7-4f6b-a80d-4320bf703514)

### Payment screen
Already working:
- QR code generation
- BTC address fetch
- BTC price fetch
- BTC price refresh every 10 min or on button click
- Copy to clipboard for BTC address and amount

Todo: 
- Implement action on WS receiving unconfirmed payment
- Improve UI

![image](https://github.com/user-attachments/assets/b1a0a73b-c327-425b-884b-f668c45ec277)

### Post Payment screen

![image](https://github.com/user-attachments/assets/df4af2aa-ffe1-4d35-8b88-fb7ee774e5e9)

- Add routes that can accept the callback
- Test to make sure the order status is updated correctly
- Add information about order (e.g. txid) instead of warning

### Admin view of order
Todo:
- Add Bitcoin icon instead of card icon next to Blockonomics?
- Create callback that can mark payment as complete
![image](https://github.com/user-attachments/assets/1f6f32e2-aa52-40f3-b7c6-2faa1c6e1a7c)


## The below should to be updated when the Blockonomoics plugin works end to end


<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Plugin Skeleton</h1>

<p align="center">Skeleton for starting Sylius plugins.</p>

## Documentation

For a comprehensive guide on Sylius Plugins development please go to Sylius documentation,
there you will find the <a href="https://docs.sylius.com/en/latest/plugin-development-guide/index.html">Plugin Development Guide</a>, that is full of examples.

## Quickstart Installation

### Traditional

1. Run `composer create-project blocknomics/blockonomics-plugin ProjectName`.

2. From the plugin skeleton root directory, run the following commands:

    ```bash
    $ (cd tests/Application && yarn install)
    $ (cd tests/Application && yarn build)
    $ (cd tests/Application && APP_ENV=test bin/console assets:install public)
    
    $ (cd tests/Application && APP_ENV=test bin/console doctrine:database:create)
    $ (cd tests/Application && APP_ENV=test bin/console doctrine:schema:create)
    ```

To be able to set up a plugin's database, remember to configure you database credentials in `tests/Application/.env` and `tests/Application/.env.test`.

### Docker

1. Execute `docker compose up -d`

2. Initialize plugin `docker compose exec app make init`

3. See your browser `open localhost`

## Usage

### Running plugin tests

  - PHPUnit

    ```bash
    vendor/bin/phpunit
    ```

  - PHPSpec

    ```bash
    vendor/bin/phpspec run
    ```

  - Behat (non-JS scenarios)

    ```bash
    vendor/bin/behat --strict --tags="~@javascript"
    ```

  - Behat (JS scenarios)
 
    1. [Install Symfony CLI command](https://symfony.com/download).
 
    2. Start Headless Chrome:
    
      ```bash
      google-chrome-stable --enable-automation --disable-background-networking --no-default-browser-check --no-first-run --disable-popup-blocking --disable-default-apps --allow-insecure-localhost --disable-translate --disable-extensions --no-sandbox --enable-features=Metal --headless --remote-debugging-port=9222 --window-size=2880,1800 --proxy-server='direct://' --proxy-bypass-list='*' http://127.0.0.1
      ```
    
    3. Install SSL certificates (only once needed) and run test application's webserver on `127.0.0.1:8080`:
    
      ```bash
      symfony server:ca:install
      APP_ENV=test symfony server:start --port=8080 --dir=tests/Application/public --daemon
      ```
    
    4. Run Behat:
    
      ```bash
      vendor/bin/behat --strict --tags="@javascript"
      ```
    
  - Static Analysis
  
    - Psalm
    
      ```bash
      vendor/bin/psalm
      ```
      
    - PHPStan
    
      ```bash
      vendor/bin/phpstan analyse -c phpstan.neon -l max src/  
      ```

  - Coding Standard
  
    ```bash
    vendor/bin/ecs check
    ```

### Opening Sylius with your plugin

- Using `test` environment:

    ```bash
    (cd tests/Application && APP_ENV=test bin/console sylius:fixtures:load)
    (cd tests/Application && APP_ENV=test bin/console server:run -d public)
    ```
    
- Using `dev` environment:

    ```bash
    (cd tests/Application && APP_ENV=dev bin/console sylius:fixtures:load)
    (cd tests/Application && APP_ENV=dev bin/console server:run -d public)
    ```
