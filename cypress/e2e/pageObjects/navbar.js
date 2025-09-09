/* global Cypress, cy */

class navbar {
  login() {
    return cy.get('[data-cy=navbar-login-btn]').should('be.visible');
  }

  users() {
    return cy.get('[data-cy=navbar-users-btn]').should('be.visible');
  }

  pets() {
    return cy.get('[data-cy=navbar-pets-btn]').should('be.visible');
  }

  vaccines() {
    return cy.get('[data-cy=navbar-vaccines-btn]').should('be.visible');
  }

  logout() {
    return cy.get('[data-cy=navbar-logout-btn]').should('be.visible');
  }
}
export default navbar;
