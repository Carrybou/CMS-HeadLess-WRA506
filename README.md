# CMS HEADLESS WRA506 THOMAS GUIBERT

This project is an API for a headless CMS developed at the IUT of Troyes for the WRA506 course. The API is built using API Platform and Symfony.

## Project Overview

The CMS Headless WRA506 project provides a robust and flexible API for managing content. It allows users to create, read, update, and delete content, as well as manage tags and images associated with the content.

## API Documentation

The API documentation is available at the following link:

[API Documentation](http://localhost/api/docs)

**api/docs**

This documentation provides detailed information about the available endpoints, request and response formats, and example requests.

## How It Works

### Key Components

- **API Platform**: A powerful framework for building APIs in PHP.
- **Symfony**: A PHP framework for web applications and a set of reusable PHP components.
- **Doctrine ORM**: An object-relational mapper (ORM) for PHP that provides transparent persistence for PHP objects.

### Features

- **Content Management**: Create, read, update, and delete content.
- **Tag Management**: Manage tags associated with content.
- **Image Upload**: Upload and associate images with content.
- **Slug Generation**: Automatically generate unique slugs for content based on the title.
- **Role Management**: Manage user roles to control access to different parts of the application.
- **CSV Import**: Import content from a CSV file.
### Installation

To install the project, follow these steps:

1. Clone the repository:
    ```sh
    git clone https://github.com/Carrybou/CMS-HeadLess-WRA506.git
    cd cms-headless-wra506
    ```

2. Install dependencies using Composer:
    ```sh
    composer install
    ```

3. Set up the database:
    ```sh
    php bin/console doctrine:database:create
    php bin/console doctrine:migration:diff
    php bin/console doctrine:migration:migrate
    ```

4. Start the Symfony server:
    ```sh
    symfony server:start
    ```
### Commands

The project includes two Symfony console commands for managing user roles:

- **Add or Remove Roles from a User**:
    ```sh
    php bin/console user:role user@example.com --add=ROLE_ADMIN --add=ROLE_MANAGER
    php bin/console user:role user@example.com --remove=ROLE_ADMIN
    ```

  This command allows you to add or remove roles from a user. The roles control access to different parts of the application.


### Usage

To use the API, you can send HTTP requests to the endpoints defined in the API documentation. Here are some examples:

- **Create Content**:
    ```sh
    POST /api/contents
    {
      "title": "string",
      "img": "string",
      "meta_title": "string",
      "meta_description": "string",
      "content": "string",
      "slug": "string",
      "tags": [
        {
          "name": "string",
          "color": "string",
          "uuid": "3fa85f64-5717-4562-b3fc-2c963f66afa6"
        }
      ],
      "author": "https://example.com/",
      "uuid": "3fa85f64-5717-4562-b3fc-2c963f66afa6"
    }
    ```

- **Get Content**:
    ```sh
    GET /api/contents/{uuid}
    ```

- **Update Content**:
    ```sh
    PUT /api/contents/{uuid}
    {
        "title": "Updated Title",
        "content": "Updated content"
    }
    ```

- **Delete Content**:
    ```sh
    DELETE /api/contents/{uuid}
    ```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.
