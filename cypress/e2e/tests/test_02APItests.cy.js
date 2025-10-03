/* global Cypress, cy */

import Random from '../externalFunctions/random';
import userDetails from '../../fixtures/userDetails';

const petName = `Johni+${Random.text(5)}`;
let petId = null;
const userData = require('../../fixtures/wrongUserDetails.json');
let startTime;

describe('Test 2 - API tests', { defaultCommandTimeout: 5000 }, () => {
  before(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
    startTime = Date.now();
  });

  beforeEach(() => {
    const elapsedTime = (Date.now() - startTime) / 1000 / 60;

    if (elapsedTime > 5) {
      throw new Error("Timeout reached, stopping tests in this describe block.");
    }

    cy.restoreLocalStorage();
  });

  afterEach(() => {
    cy.saveLocalStorage();
  });

  it('Sign in', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.visit('/site/login');
    cy.get('input[name="_csrf"]').invoke('val').then((csrfToken) => {
      cy.request({
        method: 'POST',
        url: '/site/login',
        form: true,
        body: {
          _csrf: csrfToken,
          'LoginForm[username]': userDetails.username,
          'LoginForm[password]': userDetails.password,
          'LoginForm[rememberMe]': 0,
          'login-button': ''
        },
        failOnStatusCode: false
      }).then((response) => {

        expect(response.status).to.eq(200);
        expect(response.body).to.not.include('LoginForm[username]'); 
      });
    });
  });

  it('Login UI check', function () {
    cy.visit('/site/login');

    cy.url({ timeout: 5000 })
      .should('not.include', '/site/login');

    cy.get('input[name="LoginForm[username]"]').should('not.exist');
  });

  it('Get My Pets', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.request({
      method: 'GET',
      url: '/pet/index',
      form: true,
      body: {
      },
      failOnStatusCode: false
    }).then((response) => {

      expect(response.status).to.eq(200);
      expect(response.body).to.include('<div class="pet-index" data-cy="petIndex-div">'); 
    });
  });

  it('Logout', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.visit('/site/login');
    cy.get('input[name="_csrf"]').invoke('val').then((csrfToken) => {
      cy.request({
        method: 'POST',
        url: '/site/logout',
        form: true,
        body: {
          _csrf: csrfToken,
        },
        failOnStatusCode: false
      }).then((response) => {

        expect(response.status).to.eq(200);
        // expect(response.body).to.include('LoginForm[username]');
      });
    });
  });

  it('Logout UI check', function () {
    cy.visit('/site/logout', { method: 'POST' });
    cy.url().should('include', '/site/login');
    cy.get('input[name="LoginForm[username]"]').should('be.visible');
  });
});