# A Lightweight PHP Framework

This is a lightweight PHP framework crafted for developers seeking a straightforward and efficient tool for building web applications. Focused on simplicity and performance, it provides all the essential features without unnecessary complexity.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
  - [Cloning the Repository](#cloning-the-repository)
  - [Using Composer](#using-composer)
- [Configuration and Setup](#configuration-and-setup)
- [Defining Routes](#defining-routes)
- [Contributing](#contributing)
- [License](#license)

## Features

This framework offers a rich set of features to help you build robust, scalable web applications:

- **MVC Architecture**: Organize your application using the Model-View-Controller (MVC) pattern, keeping business logic, user interface, and data models separated.
- **Query Builder / ORM**: Interact with your database effortlessly with an intuitive query builder or object-relational mapping (ORM).
- **Routing**: Define clean and readable URL routes with a powerful routing system.
- **Cookie Management**: Simplify cookie handling with an easy-to-use API for setting and retrieving cookies.
- **Crypto**: Enhance data security with built-in encryption and decryption methods.
- **Mailer**: Send emails easily using the built-in mailer component.
- **Session Management**: Handle user sessions securely and efficiently.
- **Form Validation**: Validate user input with a flexible and extendable form validation system.
- **HTTP Request and Response**: Manage HTTP requests and responses with a simple, consistent API.

## Installation

Install the framework by cloning the repository or using Composer.

### Cloning the Repository

To get started, clone the repository with:

```bash
git clone https://github.com/refkinscallv/framework.git
```

### Using Composer

Alternatively, install via Composer:

```bash
composer create-project refkinscallv/framework
```

## Configuration and Setup

After installing the framework, follow these steps to configure and set up your environment:

1. **Build the Project**

   Compile and prepare your project by running:

   ```bash
   php fw build
   ```

2. **Update the Project (Optional)**

   To update your project, run:

   ```bash
   php fw update
   ```

3. **Start the Built-In PHP Server**

   Run your application using PHP’s built-in server with:

   ```bash
   php fw serve
   ```

   This will start the server, allowing you to view your application in a web browser.

## Defining Routes

This framework uses a straightforward routing system. Routes are defined in `app/Routes/Route.php`. Here’s an example:

```php
<?php

use FW\Router\Route;

Route::register([
    __DIR__ ."/module/api"
]);

Route::set404(function() {
    echo "Custom Not Found Page";
});

Route::get("/", function() {
    echo "Hello World";
});

// Add more routes here
```

- **Module Registration**: Register modules with `Route::register()`.
- **Custom 404 Handling**: Set custom handlers for 404 errors using `Route::set404()`.
- **Defining GET Routes**: Use `Route::get()` to define GET routes.

## Contributing

Contributions are welcome! To contribute:

1. **Fork the Repository**: Create a personal fork on GitHub.
2. **Clone Your Fork**: Clone your forked repository to your machine.
3. **Create a Feature Branch**: Start a new branch for your feature or bug fix.
4. **Make Changes**: Implement changes in your feature branch.
5. **Submit a Pull Request**: Push changes to your forked repository and submit a pull request to the main repository.

For more detailed contribution guidelines, refer to the [CONTRIBUTING.md](CONTRIBUTING.md) file.

## License

This framework is open-source and licensed under the [MIT License](LICENSE). You’re free to use, modify, and distribute it in your projects.

---

Thank you for choosing this framework! We hope it helps you build projects quickly and efficiently. If you encounter issues or have suggestions, feel free to open an issue or contribute to the project.