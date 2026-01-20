## QA Automation Project – My Pet Application

### Overview
Automated e2e testing of a Yii2-based web application using Cypress.
The project is designed to work as a pet passport manager, allowing the creation of galleries for them. There are two types of users - an admin who has access to all animals on the platform, can create and edit other users, can add and edit vaccines, and a regular user who can register, to enter data and upload photos for their own pets.

### Test Coverage
- Login & authentication
- Pet management (CRUD)
- Form validations
- Error handling
- Role access
- Demonstration of API testing approach

### Tech Stack
- Cypress
- JavaScript
- Yii2
- Git

### How to Run Tests
```
1. npm install
2. npx cypress open
   or
   npx cypress run
```

## Cypress Tests Structure
```
cypress/
├─ e2e/
│ └─ externalFunctions/ (random.js)
│ └─ pageObjects/ (access of elements)
│ └─ tests/ (the actual test files)
├─ fixtures/
│ └─ (images and json files)
├─ support/
│ ├─ commands.js
│ └─ e2e.js
├─ plugins/ (index.mjs)
```

---

## Original Yii2 Template Information

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
</p>

This application is based on the **Yii2 Basic Project Template**.
It provides a skeleton Yii2 app for rapid prototyping.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

DIRECTORY(basic folders) STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      models/             contains model classes
      runtime/            contains files generated during runtime
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION AND CONFIGURATION
------------

For full backend setup, follow Yii2 Basic Template instructions [here](https://www.yiiframework.com/doc/guide/2.0/en/start-installation).


**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.