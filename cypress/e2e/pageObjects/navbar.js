/* global Cypress, cy */

class navbar {
  login() {
    return cy.get('[data-cy=navbar-login-btn]');
  }

  users() {
    return cy.get('[data-cy=navbar-users-btn]');
  }

  pets() {
    return cy.get('[data-cy=navbar-pets-btn]');
  }

  vaccines() {
    return cy.get('[data-cy=navbar-vaccines-btn]');
  }

  logout() {
    return cy.get('[data-cy=navbar-logout-btn]');
  }
}
export default navbar;
