// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
import Login from '../e2e/pageObjects/login';
import Navbar from '../e2e/pageObjects/navbar';
import Random from '../e2e/externalFunctions/random';
import Pet from '../e2e/pageObjects/pet';

const login = new Login();
const navbar = new Navbar();
const pet = new Pet();

// store tokens
let LOCAL_STORAGE_MEMORY = {};

Cypress.Commands.add("saveLocalStorage", () => {
  LOCAL_STORAGE_MEMORY = {};

  Object.keys(localStorage).forEach(key => {
    LOCAL_STORAGE_MEMORY[key] = localStorage.getItem(key);
  });
});

Cypress.Commands.add("restoreLocalStorage", () => {
  Object.keys(LOCAL_STORAGE_MEMORY).forEach(key => {
    localStorage.setItem(key, LOCAL_STORAGE_MEMORY[key]);
  });
});

Cypress.Commands.add("getTokens", () => {
  let LOCAL_STORAGE_MEMORY = {};
  let accessToken = null;
  let idToken = null;

  LOCAL_STORAGE_MEMORY = {};

  Object.keys(localStorage).forEach(key => {
    LOCAL_STORAGE_MEMORY[key] = localStorage.getItem(key);
  });

  function getValueWithSuffix(prefix, suffix) {
    let values = null;

    if (typeof localStorage !== 'undefined') {
      const keyPrefix = prefix || '';
      const keySuffix = suffix || '';

      const keys = Object.keys(localStorage);
      const filteredKeys = keys.filter(key => key.startsWith(keyPrefix) && key.endsWith(keySuffix));

      values = filteredKeys.map(key => localStorage.getItem(key));

      if (filteredKeys.length === 0) {
        console.log(`Not found elements with prefix "${keyPrefix}" and "${keySuffix}" in localStorage.`);
        return null;
      }
    }

    return values;
  }

  // console.log(localStorage);
  accessToken = getValueWithSuffix('', 'accessToken');
  idToken = getValueWithSuffix('', 'idToken');
  return [accessToken, idToken];
});

Cypress.Commands.add("loginWithDelay", (uEmail, uPass) => {
  login.form().within(($form) => {
    // Split the input text into an array of characters
    if (uEmail)
    {
      const characters = uEmail.split('');

      // Iterate over each character and type with a custom delay
      characters.forEach((char, index) => {
        login.email().then(e => {
          cy.wrap(e).type(char)
          .wait(index === characters.length - 1 ? 0 : Random.numberBetweenTwoNumbers(100, 300));
        });
      });
    }
    if (uPass)
    {
      const characters = uPass.split('');

      characters.forEach((char, index) => {
        login.password().then(e => {
          cy.wrap(e).type(char)
          .wait(index === characters.length - 1 ? 0 : Random.numberBetweenTwoNumbers(100, 300));
        });
      });
    }

  login.signInButton().click();
  });
});

Cypress.Commands.add('SignInWithDelay', (uEmail, uPass) => {
  login.form().within(($form) => {
    login.email().then(e => {
      if (uEmail)
        cy.wrap(e).type(uEmail, { delay: Random.numberBetweenTwoNumbers(100, 300) });
    });
    login.password().then(p => {
      if (uPass)
        cy.wrap(p).type(uPass, { delay: Random.numberBetweenTwoNumbers(100, 300) });
    });

    login.signInButton().click();
  });
});

Cypress.Commands.add('SignIn', (uUsername, uPass) => {
  login.form().within(($form) => {
    login.username().then(e => {
      if (uUsername)
        cy.wrap(e).type(uUsername);
    });
    login.password().then(p => {
      if (uPass)
        cy.wrap(p).type(uPass);
    });

    login.signInButton().click();
  });
});

Cypress.Commands.add('UploadFile', (name, mType) => {
  // const fileName = name;

  cy.fixture(name, { encoding: null })
    .then((contents) => {
      pet.petFormPhoto().selectFile({
        contents,
        fileName: name,
        // mimeType: mType,
        encoding: 'utf-8',
      }, {force: true});
    });
});

Cypress.Commands.add('Logout', () => {
  navbar.logout().should('be.visible').click();

  cy.wait(2600);
  navbar.login().should('be.visible');
});

Cypress.Commands.add('StopRunnerOnFail', () => {
  Cypress.on('fail', (error) => {
    Cypress.runner.stop();
    throw error;
  });
});