# Development Guide for rshp2 Project

This guide provides an overview of the `rshp2` project, its structure, and how to set up your development environment.

## Table of Contents
- [Project Overview](#project-overview)
- [Setup Instructions](#setup-instructions)
- [Project Structure](#project-structure)
- [Key Components](#key-components)
  - [Router](#router)
  - [Auth](#auth)
  - [Container](#container)
  - [Models](#models)
  - [Controllers](#controllers)
  - [Views](#views)
- [Contribution Guidelines](#contribution-guidelines)

## Project Overview
The `rshp2` project is a simple PHP application demonstrating basic routing, authentication, and dependency injection. It follows a Model-View-Controller (MVC) pattern to separate concerns, making the codebase organized and maintainable.


## Project Structure

The project follows a clear directory structure to organize its components:

-   [`index.php`](index.php): The entry point of the application, responsible for bootstrapping and dispatching requests.
-   [`controllers/`](controllers/): Contains the application's controllers, which handle incoming requests, interact with models, and load views.
    -   [`AuthController.php`](controllers/AuthController.php): Handles user authentication (login, logout).
    -   [`DashboardController.php`](controllers/DashboardController.php): Manages the dashboard view.
    -   [`HomeController.php`](controllers/HomeController.php): Manages the home page view.
-   [`core/`](core/): Houses the core framework logic and utilities.
    -   [`Auth.php`](core/Auth.php): Manages user authentication state and sessions.
    -   [`Container.php`](core/Container.php): Implements a simple dependency injection container.
    -   [`Router.php`](core/Router.php): Handles URL routing and dispatches requests to the appropriate controllers.
-   [`models/`](models/): Contains the application's models, which represent data structures and interact with the database (though this project uses a simple in-memory user store).
    -   [`User.php`](models/User.php): Represents the user model.
-   [`views/`](views/): Stores the application's view templates, responsible for rendering the user interface.
    -   [`dashboard.php`](views/dashboard.php): The dashboard view.
    -   [`home.php`](views/home.php): The home page view.
    -   [`login.php`](views/login.php): The login page view.
    Open your web browser and go to `http://localhost:8000`.

### Router

The [`core/Router.php`](core/Router.php) class is responsible for handling incoming HTTP requests and mapping them to the appropriate controller actions. It defines routes using `get()` and `post()` methods, which associate a URL path with a controller method.

### Auth

The [`core/Auth.php`](core/Auth.php) class manages user authentication. It provides methods for logging in, logging out, checking if a user is authenticated, and retrieving the currently logged-in user. It typically interacts with session variables to maintain the user's login state.

### Container

The [`core/Container.php`](core/Container.php) class implements a basic dependency injection container. It allows you to register and resolve dependencies (e.g., instances of classes) throughout your application. This promotes loose coupling and makes the application more testable and maintainable.

### Models

The `models/` directory contains classes that represent the application's data and business logic. For example, [`models/User.php`](models/User.php) represents a user in the system. In a more complex application, models would typically interact with a database to perform CRUD (Create, Read, Update, Delete) operations. In this project, the `User` model uses a simple in-memory array for demonstration purposes.

### Controllers

The `controllers/` directory holds the application's controllers. Controllers are responsible for processing user input, interacting with models, and selecting the appropriate view to render. Each controller typically corresponds to a specific part of the application's functionality (e.g., [`controllers/AuthController.php`](controllers/AuthController.php) for authentication, [`controllers/HomeController.php`](controllers/HomeController.php) for the home page).

### Views

The `views/` directory contains the application's view templates. Views are responsible for presenting data to the user. They are typically simple PHP files that include HTML and display data passed to them by controllers. Examples include [`views/home.php`](views/home.php), [`views/login.php`](views/login.php), and [`views/dashboard.php`](views/dashboard.php).

## Contribution Guidelines

We welcome contributions to the `rshp2` project! To contribute, please follow these guidelines:

1.  **Fork the repository:** Start by forking the project repository to your GitHub account.
2.  **Create a new branch:** Create a new branch for your feature or bug fix. Use a descriptive name (e.g., `feature/add-user-profile` or `bugfix/login-issue`).
3.  **Make your changes:** Implement your changes, adhering to the existing coding style and conventions.
4.  **Test your changes:** Ensure that your changes do not introduce new bugs and that all existing functionality remains intact.
5.  **Commit your changes:** Write clear and concise commit messages.
6.  **Push to your fork:** Push your new branch to your forked repository.
7.  **Create a Pull Request:** Open a pull request to the `main` branch of the original repository. Provide a detailed description of your changes and why they are necessary.

Thank you for contributing!
