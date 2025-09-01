/* global Cypress, cy */

class login {
  form() {
    return cy.get('[data-cy=login-form]');
  }

  username() {
    return cy.get('[data-cy=login-username]');
  }

  password() {
    return cy.get('[data-cy=login-password]');
  }

  signInButton() {
    return cy.get('[data-cy=login-submit-btn]').contains('Login').should('be.visible');
  }
}
export default login;
