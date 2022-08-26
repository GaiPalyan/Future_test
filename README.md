[![Laravel](https://github.com/GaiPalyan/Future_test/actions/workflows/laravel.yml/badge.svg)](https://github.com/GaiPalyan/Future_test/actions/workflows/laravel.yml)

### Тестовое задание в компанию Future на позицию PHP-developer.

#### Описание
API для записной книжки, с возможностью добавления, обновления, чтение и удаления (CRUD).

#### Установка

~~~
$ make setup
$ make migrate
$ make start
~~~

#### Наполнение базы
~~~
$ make seed
~~~

#### Тесты
~~~
$ make test
~~~

#### Линтер
~~~
$ make list
$ make lint-fix
~~~

##### Маршруты

| entity  | route                      | method |
|---------|----------------------------|--------|
| user    | api/v1/register            | POST   |
| user    | api/v1/login               | POST   |
| user    | api/v1/logout              | POST   |   
| persons | api/v1/notebook/           | GET    |   
| person  | api/v1/notebook/{id}       | GET    |   
| person  | api/v1/notebook/           | POST   |   
| person  | api/v1/notebook/update{id} | POST   |   
| person  | api/v1/notebook/delete{id} | DELETE |


#### Регистрация

- name
- email
- password
- password_confirmation

Пример ответа
~~~

{
    "name": "admin",
    "email": "test@test",
    "updated_at": "2022-08-20T03:00:58.000000Z",
    "created_at": "2022-08-20T03:00:58.000000Z",
    "id": 1
}
~~~
#### Аутентификация
Пример ответа
~~~
{
    "token": "1|07rZjpHuG299cc2H16S0glJYa36V4X5bQMet4tv9",
    "expires_at": null
}
~~~
В целях простоты у токена нет срока жизни, при повторной аутентификации токен будет уничтожен и выдан новый.

#### Добавление записи

- full_name (обязательное)
- company_name
- phone_number (обязательное)
- email (обязательное)
- birthday
- photo (.png .jpg)

Пример ответа
~~~
{
    "id": 23,
    "full_name": "Gai P",
    "photo": "person_photos/6308736de4a6e.jpg",
    "birthday": "02.07.1988",
    "company": [
        {
            "id": 21,
            "company_name": "apple"
        }
    ],
    "contacts": [
        {
            "id": 23,
            "phone_number": "89253172211",
            "email": "mail@test"
        }
    ],
    "created_by": [
        {
            "id": 1
        }
    ]
}
~~~

#### Удаление и изменение

Запрашивать, удалять и изменять сущности можно только созданные самим пользователем.

Пример успеха

~~~
{
    "id": 23,
    "full_name": "Gai Palyan",
    "photo": "person_photos/6308736de4a6e.jpg",
    "birthday": "1988-07-02",
    "company": [
        {
            "id": 23,
            "company_name": "Future"
        }
    ],
    "contacts": [
        {
            "id": 23,
            "phone_number": "89253172211",
            "email": "mail@test"
        }
    ],
    "created_by": [
        {
            "id": 1
        }
    ]
}
~~~
Пример ошибки
~~~
{
    "error": "Permission denied"
}
~~~


Пример пагинации

api/v1/notebook/?page=1&perPage=3

~~~
{
    "collection": [
        {
            "id": 5,
            "full_name": "Hassan Mertz",
            "photo": "/tmp/fakerOsShFJ",
            "birthday": "1984-03-30",
            "company": [
                {
                    "id": 5,
                    "company_name": "BEtdG"
                }
            ],
            "contacts": [
                {
                    "id": 5,
                    "phone_number": "(318) 730-3556",
                    "email": "nader.liana@kshlerin.com"
                }
            ],
            "created_by": [
                {
                    "id": 6
                }
            ]
        },
        {
            "id": 6,
            "full_name": "Prof. Christophe Welch PhD",
            "photo": "/tmp/faker0NlbbO",
            "birthday": "2010-07-24",
            "company": [
                {
                    "id": 6,
                    "company_name": "E2u9B"
                }
            ],
            "contacts": [
                {
                    "id": 6,
                    "phone_number": "1-442-513-0767",
                    "email": "reilly.houston@feil.com"
                }
            ],
            "created_by": [
                {
                    "id": 7
                }
            ]
        },
        {
            "id": 7,
            "full_name": "Shawn Hauck",
            "photo": "/tmp/fakereyaVaM",
            "birthday": "1972-02-23",
            "company": [
                {
                    "id": 7,
                    "company_name": "ARmUO"
                }
            ],
            "contacts": [
                {
                    "id": 7,
                    "phone_number": "+14793068729",
                    "email": "meta66@hotmail.com"
                }
            ],
            "created_by": [
                {
                    "id": 8
                }
            ]
        }
    ],
    "meta": {
        "page": 1,
        "count": 3,
        "overall": 17
    }
}
~~~
