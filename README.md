# simpleWebapp project 

* Adopt from webapp repo
* Dockerize project
    - Command to compose the project: docker compose up
    NOTE: Please wait 3 minutes
    - Command to stop the project: docker compose down or Ctrl + C
    - Access the project at: 
        + for phpmyadmin: http://localhost:5000
            - root-username: root
            - root-password: secret
            - user-username: user
            - user-password: user
        + for admin panel: http://localhost:9090
            - username: admin
            - password: admin
            - NOTE: run this command before access admin panel ( still improving ): docker exec -it apidev-web-server-1 bash /root/config.sh
        + for api development: http://localhost:9090/api/*
            - Use Postman to control and perform api testing
* Funtions 
    - CRUD API
    - JWT
    - Document
