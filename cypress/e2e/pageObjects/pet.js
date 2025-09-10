/* global Cypress, cy */

class pet {
  createPetButton() {
    return cy.get('[data-cy=petIndex-createPet-button');
  }

  petCreateDiv() {
    return cy.get('[data-cy=petCreate-div');
  }

  petIndexDiv() {
    return cy.get('[data-cy=petIndex-div');
  }

  petViewDiv() {
    return cy.get('[data-cy=petView-div');
  }

  petUpdateDiv() {
    return cy.get('[data-cy=petUpdate-div');
  }

  petCreateTitle() {
    return cy.get('[data-cy=petCreate-title');
  }

  petIndexTitle() {
    return cy.get('[data-cy=petIndex-title');
  }

  petViewTitle() {
    return cy.get('[data-cy=petView-title]');
  }

  petUpdateTitle() {
    return cy.get('[data-cy=petUpdate-title');
  }

  petForm() {
    return cy.get('[data-cy=petForm-form');
  }

  petNameInput() {
    return cy.get('[data-cy=petForm-inputPet-name]');
  }

  petTypeInput() {
    return cy.get('[data-cy=petForm-inputPet-type]');
  }

  petBreedInput() {
    return cy.get('[data-cy=petForm-inputPet-breed]');
  }

  petDateOfBirthInput() {
    return cy.get('[data-cy=petForm-inputPet-dateOfBirth]');
  }

  petInformationInput() {
    return cy.get('[data-cy=petForm-inputPet-information]');
  }

  petOwnerInput() {
    return cy.get('[data-cy=petForm-inputPet-owner]');
  }

  petAddressInput() {
    return cy.get('[data-cy=petForm-inputPet-address]');
  }

  petEmailInput() {
    return cy.get('[data-cy=petForm-inputPet-email]');
  }

  petPhoneNumberInput() {
    return cy.get('[data-cy=petForm-inputPet-phoneNumber]');
  }

  petOwnerLabelInput() {
    return cy.get('[data-cy=petForm-inputPet-ownerLabel]');
  }

  petSelectUserInput() {
    return cy.get('[data-cy=petForm-inputPet-selectUser]');
  }

  petSaveButton() {
    return cy.get('[data-cy=petForm-inputPet-save-btn]').contains('Save').should('be.visible');
  }

  updatePetButton() {
    return cy.get('[data-cy=petView-update-btn]').contains('Update').should('be.visible');
  }

  deletePetButton() {
    return cy.get('[data-cy=petView-delete-btn]').contains('Delete').should('be.visible');
  }

  petViewTable() {
    return cy.get('[data-cy=petView-detailView-table]');
  }

  petViewName() {
    return cy.get('[data-cy=petView-detailView-name]');
  }

  petViewType() {
    return cy.get('[data-cy=petView-detailView-type]');
  }

  petViewBreed() {
    return cy.get('[data-cy=petView-detailView-breed]');
  }

  petViewDateOfBirth() {
    return cy.get('[data-cy=petView-detailView-dateOfBirth]');
  }

  petViewInformation() {
    return cy.get('[data-cy=petView-detailView-information]');
  }

  petViewOwner() {
    return cy.get('[data-cy=petView-detailView-owner]');
  }

  petViewAddress() {
    return cy.get('[data-cy=petView-detailView-address]');
  }

  petViewEmail() {
    return cy.get('[data-cy=petView-detailView-email]');
  }

  petViewPhoneNumber() {
    return cy.get('[data-cy=petView-detailView-phoneNumber]');
  }
}
export default pet;
