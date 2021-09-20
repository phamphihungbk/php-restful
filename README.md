## PHP RESTFUL

☘️ A REST API project was built by PHP, followed the SOLID principles and Clean
Architecture.

## Features

```txt
- Protect API with CORS
- Authorization with Laravel Passport
- Prevent registration with week password
- Tests
- Login
- Register
- Uuid
- Centralize log with Syslog-ng
- API Caching with Memcached
```

## Project Structure

```bash
├── config                      # contains all env file for different environments
├── environment                 # dockerfile
└── web                    	# main sourcecode
```

## Project setup:

Add domain to your host file ( MacOS )

```bash
make host
```

Build docker image

```bash
make build
```

Start docker container

```bash
make up
```

Create DB table in Mysql

```bash
make db-create
```

Run migration on DB

```bash
make db-migrate
```

Access api by putting below domain on Postman

```bash
tinnyapi.local
```
