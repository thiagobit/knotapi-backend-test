# KnotAPI Backend Advanced Test

A REST API created using Laravel 10 for KnotAPI backend developer position test.

## Notes:
- The endpoints require a _Bearer Token_ which can be obtained from the _login_ endpoint after a user registration.
- The Merchant _index_ endpoint has pagination implemented for the efficient retrieval and presentation of large sets of data. It has the objective of reducing the response size, network traffic and processing time.
- The _Finished Tasks_ endpoint has a cache layer implemented with _Redis_ for performance improvement.

## Configuration:
1. Since it's using [Laravel Sail](https://laravel.com/docs/10.x/sail), you need to execute the following command to first install the dependencies and be able to run Sail commands:
    ```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

2. Create Docker containers:
    ```shell
    ./vendor/bin/sail up -d
    ```

3. Run migrations:
    ```shell
    ./vendor/bin/sail artisan migrate
    ```

## Endpoints:

### POST api/v1/register
- Description: Register a user.
- Needs authentication: `false`
- Parameters:
    - `name`
        - Description: Name of the user.
        - Type: `string`
        - Required: `true`
    - `email`
        - Description: User email address.
        - Type: `string`
        - Required: `true`
    - `password`
        - Description: User password (at least 8 characters).
        - Type: `string`
        - Required: `true`
    - `password_confirmation`
        - Description: User password confirmation.
        - Type: `string`
        - Required: `true`
    - Example:
        - Input:
            ```json
            {
                "name": "Test",
                "email": "test@example.com",
                "password": "password",
                "password_confirmation": "password"
            }
            ```
        - Output:
            - Status: `201`
            - Response:
            ```json
            {
                "user": {
                    "name": "Test",
                    "email": "test@example.com",
                    "updated_at": "2023-09-20T20:10:27.000000Z",
                    "created_at": "2023-09-20T20:10:27.000000Z",
                    "id": 40
                }
            }
            ```

### POST api/v1/login
- Description: Generate the access token.
- Needs authentication: `false`
- Parameters:
    - `email`
        - Description: User email address.
        - Type: `string`
        - Required: `true`
    - `password`
        - Description: User password.
        - Type: `string`
        - Required: `true`
- Example:
    - Input:
        ```json
        {
            "email": "test@example.com",
            "password": "password"
        }
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "token": "1|uYpWFhhdkYdmcbTX4GeAy8SPW4kNv1GeM6zJOxNT"
        }
        ```

### POST api/v1/logout
- Description: Revoke the access token.
- Needs authentication: `true`
- Parameters:
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "message": "Successfully logged out"
        }
        ```

### POST api/v1/cards
- Description: Store a credit card
- Needs authentication: `true`
- Parameters:
    - `number`
        - Description: Credit Card number.
        - Type: `integer`
        - Required: `true`
    - `expiry_date`
        - Description: Credit Card expiry date.
        - Type: `integer`
        - Required: `true`
    - `cvv`
        - Description: Credit Card CVV.
        - Type: `integer`
        - Required: `true`
- Example:
    - Input:
        ```json
        {
            "number": "123456789123456",
            "expiry_date": "10/24",
            "cvv": "1234"
        }
        ```
    - Output:
        - Status: `201`
        - Response:
        ```json
        {
            "number": "123456789123456",
            "expiry_date": "10/24",
            "cvv": "1234",
            "updated_at": "2023-09-20T21:06:22.000000Z",
            "created_at": "2023-09-20T21:06:22.000000Z",
            "id": 16
        }
        ```

### POST api/v1/merchants
- Description: Store a merchant
- Needs authentication: `true`
- Parameters:
    - `name`
        - Description: Merchant name.
        - Type: `string`
        - Required: `true`
    - `website`
        - Description: Merchant website.
        - Type: `string`
        - Required: `true`
- Example:
    - Input:
        ```json
        {
            "name": "Example",
            "website": "http://www.example.com"
        }
        ```
    - Output:
        - Status: `201`
        - Response:
        ```
        ```

### GET api/v1/merchants
- Description: Get merchant list.
- Needs authentication: `true`
- Parameters:
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `200`
        - Response:
        ```json
        {
            "data": [
                {
                    "id": 19,
                    "name": "Aufderhar-Jenkins",
                    "website": "http://okeefe.com/blanditiis-rem-sequi-dolor-consectetur-repellat-perferendis-similique",
                    "created_at": "2023-09-20T20:23:54.000000Z",
                    "updated_at": "2023-09-20T20:23:54.000000Z"
                },
                {
                    "id": 20,
                    "name": "Goldner PLC",
                    "website": "http://shields.org/",
                    "created_at": "2023-09-20T20:23:54.000000Z",
                    "updated_at": "2023-09-20T20:23:54.000000Z"
                }
            ]
        }
        ```

### POST api/v1/tasks
- Description: Store a new task.
- Needs authentication: `true`
- Parameters:
    - `card_id`
        - Description: Credit Card ID.
        - Type: `integer`
        - Required: `true`
    - `merchant_id`
        - Description: Merchant ID.
        - Type: `integer`
        - Required: `false`
- Example:
    - Input:
        ```json
        {
            "card_id": "17",
            "merchant_id": "22"
        }
        ```
    - Output:
        - Status: `201`
        - Response:
        ```json
        {
            "task": {
                "user_id": 41,
                "card_id": "17",
                "merchant_id": "22",
                "updated_at": "2023-09-20T20:28:54.000000Z",
                "created_at": "2023-09-20T20:28:54.000000Z",
                "id": 14
            }
        }
        ```

### PATCH api/v1/tasks/{id}/finish
- Description: Mark a task as finished.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Task ID.
        - Type: `integer`
        - Required: `true`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `204`
        - Response:
        ```
        ```

### PATCH api/v1/tasks/{id}/fail
- Description: Mark a task as failed.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Task ID.
        - Type: `integer`
        - Required: `true`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `204`
        - Response:
        ```
        ```

### GET api/v1/users/{user}/tasks/finished
- Description: Return all finished tasks for each merchant from a specific user.
- Needs authentication: `true`
- Parameters:
    - `{id}`
        - Description: Book ID.
        - Type: `integer`
- Example:
    - Input:
        ```
        ```
    - Output:
        - Status: `204`
        - Response:
        ```
        {
            "Ruecker-Lowe": [
                {
                    "id": 15,
                    "card": "4556185881376551",
                    "created_at": "2023-09-20 20:39:24"
                }
            ],
            "Greenholt-Morissette": [
                {
                    "id": 16,
                    "card": "5155733354890657",
                    "created_at": "2023-09-20 20:39:24"
                }
            ]
        }
        ```
