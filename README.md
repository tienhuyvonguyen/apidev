# simpleWebapp project 

* Visit website at https://huyvo.tech hosted on Google Cloud Platform & Cloudflare proxy, pending cloudflare WAF ( under maintenant )
* Synk, Solatint security for vuln and code quality check
* SSL cerrtificate for https connection provided by zeroSSL & report at: https://www.ssllabs.com/ssltest/analyze.html?d=huyvo.tech&s=35.240.219.228
* Config apache server with SSL certificate
* Config apache redirect http to https and www to non-www
* Dockerize project
    - Command to compose the project: docker compose up
    NOTE: Please wait 3 minutes
    - Command to stop the project: docker compose down or Ctrl + C
    - Access the project at: 
        + for user website: http://localhost:8080
            -test account: valen
            -test password: valen123
        + for phpmyadmin: http://localhost:5000
            - root-username: root
            - root-password: secret
            - user-username: user
            - user-password: user
        + for admin panel: http://localhost:9090
            - username: admin
            - password: admin
            - NOTE: run this command before access admin panel: docker exec -it webapp-web-server-1 bash /root/config.sh ( still improving )
* Funtions 
    - Login
    - Register
    - Top up balance
    - Place order
    - Upgrade account to VIP
    - Vip account can place order with discount
    - Online payment 
    - Update profile

* Under development
   - Using ORM instead of raw query
   - Admin Panel
   - Using validation framework: HTMLPurifier & PHP validator,...
   - Unit Test
   - Recontruct to MVC pattern
* Fixing
   ~~- Secret information exposed in code~~
