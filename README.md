# exam-app

Steps to install the application
1. Make sure you have docker installed on your local machine to run and access the sail. Follow this step https://laravel.com/docs/10.x/sail#installing-sail-into-existing-applications
2. The .env for this app will be provided by the recruiter.
3. Once docker and .env are set up. Pull the branch master.
4. go to your terminal locate the file for the pulled repository and run ./vendor/bin/sail (much better if you add an alias for this bash). 
5. Once the sail is up, we can now migrate the databases by the command sail php artisan migrate
6. Once the tables are migrated, we can now run our seeds by the command sail php artisan db:seed
7. Once the seed is done, We can now access the backend. By default the username and password are in below
   Username : stewie@mail.com
   Password : familyguy

   
