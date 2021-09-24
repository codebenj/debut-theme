# Git Workflow

## 1. Create branch

- Create work branch from master for each [Web/app](https://trello.com/b/BNUIDpI2/web-app) cards you work on.
- Keep in mind to add [Web/app](https://trello.com/b/BNUIDpI2/web-app) card ID and ticket title to your branch name instead of using `dev-onur`, `simon` or etc.

``` 
e.g.
- If adding new features on card "Integrations View", the branch name should be “feature/151-integrations-view”
- If fixing bugs on card, the branch name should be “hotfix/151-integrations-view”
``` 

## 2. Commit

- Add the only files you've worked on.
- Add comment what you worked on commit.
```
e.g.
git add app/Http/Controllers/HomeController.php
git commit -m "Add Integrations View"
```
## 3. Create PR(Pull Request)

- Once you've completed the work and want to deploy on [staging](https://dev.debutify.com/admin), create PR to merge `development` branch.
- When you create PR to `development` branch, please keep in mind to provide detailed description - what you've done and where can see the result.
- Once PR is created, add `M Talal` or `Onur Dogan` as reviewer or ping him directly.

```
e.g.
Add Integrations View in App Dashboard > Integrations
Please follow the below details to see the result:
Admin > Integrations. You can see new page.
```

## 4. NOTE
- Do not commit any file that doesn't related with your work. Only commit the files that you've created or modified for the task.
- Automation script for database update. 
-- When you need database table updates, please make sure that database updates should be done by only automation script. 
	Manual update doesn't allowed. (e.g. )


# Setting up Local environment

## 1. Clone git repo
Git clone this [repo](https://github.com/rifleby/debutify.git) on your local.

## 2. Setup vendor
Run below command on your above repo root directory.
```
composer install
```
## 3. Import database
Get latest db dump file from live store. Ask username and password to Raphael. (Needs update on migration and we can use migration later)

*** Future ***
Run below command on your above repo root directory.
```
php artisan migrate
php artisan migrate:refresh –seed or php artisan db:seed
```
## 4. Configure vhost
Configure vhost based  on your OS

## 5. Configure `.env`
- Configure `.env` with your local db_name / db_username / db_password

## 6. Let's Go!

# Deploy process on Production

- Connect in SSH & MySQL to production.
- Make sure all changes are in develop, merge to master branch, and tag commit with an annoted version `git commit -a v2.5`.
- Check for new configs (.env, wordpress blog site too) and prepare update
- Check for new SQL changes (tables, fields, alters, new entries)
- Check for changes in Stripe plans and update Stripe prod data and database entries accordingly (copy paste plans in stripe and prepare insert statements for the db to replace previous entries)
- Once everything is ready to be released and tested (SQL changes, Configs chages, Code pushed, Stripe rdy, no bugs in staging)
- Go to prod server, `git fetch && git checkout -f origin/master` 
- Exec SQL changes, update new configs (.env, wordpress)
- Run simultaneously `npm run prod` and `composer install`
- Test the hell out of it, check storage/logs for details on errors
