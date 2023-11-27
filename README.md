# Tranqsite-Simplified
A simplified version of Tranqsite (a simple yet vulnerable web application), created by [Chrisando Ryan](https://github.com/chrisandoryan) for his Secure Programming course.

## Podman/Docker Setup (XAMPP Alternative)
Since I'm running on Linux (and an immutable distro at that), I don't have the luxury of installing XAMPP on my PC. I therefore have to resort to Podman to setup the Apache + MySQL + PhpMyAdmin stack required to run this web application. The setup should be identical for Docker.

Make sure to edit your MySQL database's credentials in [`docker-compose.yml`](docker-compose.yml) first. Assuming you already have Podman (along with Podman-Compose) installed, simply run the following command within the project's folder to start the containers:
```
podman-compose up -d
```

To stop the containers, run the following:
```
podman-compose down
```

## Contributing

Pull requests are welcome; please open an issue first for discussion.
