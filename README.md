## Repository for SAE 5.01
4 protected branches:
- main (no push no merge)
- mobile (no push)
- dev
- stable (here, no push)

# Laravel skeleton 

This repository has four protected branches.
- main is the initial state of the project. You cannot push to it or delete it.
- dev is the staging branch. Please merge your work here to ensure the web server is never updated with wrong code. You cannot delete it.
- stable is the default branch and the release branch. Each update here is automatically forwarded to the web server.
 - composer install is run if composer.json is updated
 - npm install is run if package.json is updated
 - .env.prod is converted to .env, an application key is generated
 - npm run build is called to produce public assets (css++)
 - database is migrated
 - /!\ You can add new steps to .gitlab-ci.yml if necessary
- mobile is the stable branch for mobile development
- initially, the three branches are synchronized. (same content)

Skeleton deploys three routes:
- / : welcome, the standard Laravel welcome screen
- /logs/<file> : a page to view access.log, error.log and laravel.log (the last one can be deleted for better reliability)
 -> /logs/access /log/error /log/laravel

To begin:
- clone the repository
 - run composer setup (will do composer install, npm install, generate .env and app key, and run migrations for you...)
 - tweak your local .env at will
 - setup your database
  - default is sqlite
  - you can switch to mysql is prefered
  - run the migrations (=> php artisan migrate)
 - never, ever, commit .env to the repository. It contains personal/machine specific informations.

To start working:
- checkout dev branch
- create your work branch
 - create or modify files
 - commit files (repeat as long as needed)
 - push
- merge with dev when the feature is ok (tested)
 - checkout dev
 - pull the latest version
 - merge you branch into dev
 - test & fix if necessary
 - push back to dev
- merge with stable when integration tests are ok
 - push is forbidden on "stable" and "mobile" branches.
 - when work is ready to integrate, emit a merge-request that will be reviewed by your team-mates and eventually validated.
 - That's all, when the request is validated, the server is updated automatically.
- test the web application
- start again with a new feature (clone is not necessary, of course!)


## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.
- composer install (will do composer install, npm install, generate .env and app key, and run migrations for you...)
- composer dev (will run npm run dev for the front-end and php artisan serve for the back-end...)

