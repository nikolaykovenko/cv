Yii 2 Basic CMS Application
================================

Small project, based on Yii2 framework: CMS for managing of Curriculum Vitae content.

Main feature is auto generating content edit forms based just on models. It allows to develop simple projects very fast.

There are CI and deploy systems used for the project, config files are /phpci.yml and /deploy.ini.


DIRECTORY STRUCTURE
-------------------

      ncmscore/           the main part of project. It contains core CMS code (controllers, models, views and widgets)
      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains integration, functional and unit tests for the code core and CV application. 
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.
