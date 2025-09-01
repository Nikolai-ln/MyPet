/* global Cypress, cy */

import Navbar from '../pageObjects/navbar';
import Random from '../externalFunctions/random';

const navbar = new Navbar();
const userData = require('../../fixtures/wrongUserDetails.json');

describe('Test 1 - Login tests', { defaultCommandTimeout: 5000 }, () => {
  beforeEach(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  afterEach(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  userData.forEach((user) => {
    it(user.testName, () => { // 'Try to sign in with wrong or missing credentials'
      cy.visit('/login');
      cy.SignIn(user.username, user.password);
      cy.contains(user.message).should('be.visible');
      if (user.secondMessage)
        cy.contains(user.secondMessage).should('be.visible');
    });
  });

  it('Sign in', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.visit('/login');

      cy.fixture('userDetails').then((user) => {
        cy.SignIn(user.username, user.password);
      });

      cy.url({ timeout: 10000 })
        .should('not.include', '/login');

      navbar.logout().should('be.visible');
    });
  
    it('Wait', () => {
      cy.wait(2600);
    });
  
    it('Logout', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.Logout();
    });
  });