# BileMo
## P7_03032023

A project Openclassroom, BtoB API to enable business who owes phone to rent them to other buisinesses.

A project using Symfony


## Installation

1. You'll need to install the maker-bundle (enabling to create controllers and entities)

```bash
composer require symfony/maker-bundle --dev
```

2. Install Doctrine : a PHP library to work with databases (MySQL, PostgreSQL or NoSQL databases like MongoDB)

```bash
composer require orm
```

3. Finally, you can find a AppFixtures.php file (path: src\DataFixtures\AppFixtures.php).
Run this command to create automatically what you need to first begin with the API :
```bash
php bin/console doctrine:fixtures:load
```

## Run Locally

Clone the project

```bash
  git clone https://github.com/Juchri/P7_03032023.git
```

Go to the project directory

```bash
  cd P7_03032023
```

After Installing the project, start the server

```bash
  symfony server:start
```


## Documentation

[Documentation locally accesible](http://127.0.0.1:8000/api/doc)


## API Reference

### Mobiles

#### Get all phones

```http
  GET /api/mobiles
```

#### Create a new phone

```http
POST /api/mobiles
```

#### Get a phone with its {id}

```http
GET /api/mobiles/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of mobile to fetch |

#### Edit a phone with its {id}

```http
PUT /api/mobiles/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of mobile to fetch |


#### Delete a phone with its {id}

```http
DELETE /api/mobiles/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of mobile to fetch |

### Brands

#### Get all brands

```http
GET /api/brands
```

#### Create a new brand

```http
POST /api/brands
```

#### Get a brand with its {id}

```http
GET /api/brands/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of brand to fetch |

#### Edit a brand with its {id}

```http
PUT /api/brands/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of brand to fetch |


#### Delete a brand with its {id}

```http
DELETE /api/brands/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of brand to fetch |

### Users

#### Get all users

```http
GET /api/users
```

#### Create a new user

```http
POST /api/users
```

#### Get a user with its {id}

```http
GET /api/users/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |

#### Edit a user with its {id}

```http
PUT /api/users/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |


#### Delete a user with its {id}

```http
DELETE /api/users/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |

#### Add a client to a user with its {id}

```http
POST /api/users/add-client/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |

#### Add a phone to a user with its {id}

```http
POST /api/users/add-phone/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |


### Clients

#### Get all clients

```http
GET /api/clients
```

#### Delete a client with its {id}

```http
DELETE /api/clients/{id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of user to fetch |

#### Add a client to a user with its {id}

## Badges

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/1af6f40003d74069b94903c0e9aca3e0)](https://app.codacy.com/gh/Juchri/P7_03032023/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)