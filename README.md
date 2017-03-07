# Introduction:
This is test task. Project uses [matvieiev/login-bundle](https://github.com/sauron07/fbi_auth_test) to log into the system.

# Installation:
Project have automatic setup shell. It runs PHP's built-in web server for web application and oAuth server.

To install it locally just execute _start_project.sh_ shell:
```
sh start_project.sh {oAuth_server_address} {server_address}
```
_{oAuth_server_address}_ and _{server_address}_ parameters are optional. By default they will be 127.0.0.1:8001 and 127.0.0.1:8000 respectively.

After installation was done it is possible to login with next credentials:

|username|password|role        |
|--------|--------|------------|
|worker  |worker  | ROLE_WORKER|
|manager | manager|ROLE_MANAGER|
|admin   |admin   |ROLE_ADMIN  |

Each user already have credentials to access oauth server and get token.

# Website behavior:
1. Any user needs to be logged in to view / edit the employee list.
2. User with role "Worker" can view the list.
3. User with role "Manager" can add more employees to the list (but not edit) + whatever "Worker" can do.
4. User with role "Admin" can also edit employee and mark employee as deleted + whatever "Manager" can do.
User marked as deleted should remain in database but not be displayed in the employee list.
5. On arriving the website the first page is login.
6. The website must have a "logout" link that logs the system user out.
7. The employee list (table) and the employee "Add  / Edit" forms must be on two separate pages. (not popups)

# Directives for the code and architecture & structure:
1. Platform must be symphony (2 or 3).
2. Use doctrine 2+ for communication with the database.
3. Login should be done using oAuth server (setup any oAuth server) and retrieving a token (use any configuration you like).
4. In your architecture use standard symphony dependency injection (for example for the database connection)
5. Do not access database from a controller. all communications with the database should be performed by a service (the controller should ask the service for information - you can use standard symphony service)
6. The part of the code that logs the user in must be a separate composer package and installed via composer (setup a repository on GitHub - its free and deploy the package there.. Then add it to your project using composer in composer.json)
7. Write at least one unit test (choose any of your functions)
8. No need to spend too much time on UI. you can use any free grid or write your own but it does not matter - the purpose of the task is not to check UI skills.
9. Deploy your full solution to a git repository (so we can get the code from there and run it)