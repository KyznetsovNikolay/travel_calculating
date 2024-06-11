Endpoint:

~~~
http://localhost:8073/travel/calculate
~~~

Form-data(example):
   ```
   birthdayDate:  01-01-2000
   basePrice: 10000
   travelPaymentDate: 29-11-2024
   travelStartDate: 01-05-2024
   ```

### Запуск приложения

Комманды приложение:

1. Запуск: docker compose up -d

2. Старт тестов:

    ```
    docker compose exec -it app bash
    bin/phpunit
    ```