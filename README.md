# VendHound
Convention Dealer's Room tool to run juries.  Successor to the Dealer's Room THING

## Quick Start with Docker

To run VendHound using Docker:

1. Navigate to the `app/` directory
2. Create a `.env.local` file with your configuration (see `README.docker.md` for details)
3. Build and start the containers:
   ```bash
   cd app
   docker-compose up -d --build
   ```
4. Run database migrations:
   ```bash
   docker-compose exec app php bin/console doctrine:migrations:migrate
   ```
5. Access the application at http://localhost:8080

For detailed Docker setup instructions, see [app/README.docker.md](app/README.docker.md)