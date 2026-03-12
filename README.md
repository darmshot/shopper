# Shopper

MVC open-source e-commerce platform built with Laravel.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

*   [Docker](https://docs.docker.com/get-docker/)
*   [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1.  Clone the repository:

    ```sh
    git clone https://github.com/darmshot/shopper.git
    ```

2.  Navigate to the project directory:

    ```sh
    cd shopper
    ```

3.  Run the setup script:
    This will build the Docker containers, install the Composer, and run the database migrations.

    ```sh
    ./app.sh setup
    ```


## Usage

After the setup is complete, you can start the application using Laravel Sail:

```sh
./vendor/bin/sail up
```

The application will be available at [http://localhost:8000](http://localhost:8000).

To stop the application, run:

```sh
./vendor/bin/sail down
```

## Running Tests

To run the test suite, you can use the following command:

```sh
./vendor/bin/sail artisan test
```

## Built With

*   [Laravel](https://laravel.com/) - The web framework used
*   [Docker](https://www.docker.com/) - Containerization platform


