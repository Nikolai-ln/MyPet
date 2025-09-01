/* global Cypress, cy */

class navbar {
  login() {
    return cy.get('[data-cy=navbar-login-btn]').should('be.visible');
  }

  logout() {
    return cy.get('[data-cy=navbar-logout-btn]').should('be.visible');
  }
}
export default navbar;
