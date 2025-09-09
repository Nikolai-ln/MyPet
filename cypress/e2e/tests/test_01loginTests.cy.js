/* global Cypress, cy */

import Navbar from '../pageObjects/navbar';
import Pet from '../pageObjects/pet';
import Random from '../externalFunctions/random';

const navbar = new Navbar();
const pet = new Pet();
const petName = `Johni+${Random.text(5)}`;
const petInformation = `Information+${Random.text(5)}`;
const petUserEmail = `user+${Random.text(5)}@abv.bg`;
let petId = null;
const userData = require('../../fixtures/wrongUserDetails.json');

describe('Test 1 - Login tests', { defaultCommandTimeout: 5000 }, () => {
  before(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  beforeEach(() => {
    cy.restoreLocalStorage();
  });

  afterEach(() => {
    cy.saveLocalStorage();
  });

  userData.forEach((user) => {
    it(user.testName, () => { // 'Try to sign in with wrong or missing credentials'
      cy.visit('/site/login');
      cy.SignIn(user.username, user.password);
      cy.contains(user.message).should('be.visible');
      if (user.secondMessage)
        cy.contains(user.secondMessage).should('be.visible');
    });
  });

  it('Sign in', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.visit('/site/login');

      cy.fixture('userDetails').then((user) => {
        cy.SignIn(user.username, user.password);
      });

      cy.url({ timeout: 10000 })
        .should('not.include', '/site/login');

      navbar.logout().should('be.visible');
    });

    it('Open My Pets menu', () => {
      navbar.pets().should('be.visible').click();

      cy.url({ timeout: 10000 })
        .should('include', '/pet/index');

      pet.petIndexTitle().should('be.visible');
    });

    it('Open the pet creation form', () => {
      pet.createPetButton().should('be.visible').click();

      cy.url({ timeout: 10000 })
        .should('include', '/pet/create');

      pet.petCreateTitle().should('be.visible');
    });

    it('Add data to a new pet', () => {
      pet.petCreateDiv().should('be.visible').within(() => {
        pet.petCreateTitle().should('be.visible');
        pet.petNameInput().should('be.visible').type(petName);
        pet.petTypeInput().should('be.visible').type("dog");
        pet.petBreedInput().should('be.visible').type("pincher");
        pet.petDateOfBirthInput().should('be.visible').type("2021-05-05");
        pet.petInformationInput().should('be.visible').type(petInformation);
        pet.petOwnerInput().should('be.visible').type("Nikolai Nikolov");
        pet.petAddressInput().should('be.visible').type("Plovdiv");
        pet.petEmailInput().should('be.visible').type(petUserEmail);
        pet.petPhoneNumberInput().should('be.visible').type("0888123456");
        pet.petOwnerLabelInput().should('be.visible');
        pet.petSelectUserInput().should('be.visible').select('UserCypress');

        pet.petSaveButton().should('be.visible').click();

        cy.url({ timeout: 10000 })
        .should('include', '/pet/view?pet_id=');
      });
    });

    it('Check if the new pet is created and get the pet id', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.url({ timeout: 10000 })
        .should('include', '/pet/view?pet_id=');

      cy.url().then((url) => {
        const temp = url.split('pet_id=')[1]
        expect(temp).to.not.be.undefined;

        petId = temp;
        expect(petId).not.to.eq(null);
      });
    });

    it('Check the new pet data', () => {
      pet.petViewTitle().should('be.visible');
      pet.updatePetButton().should('be.visible');
      pet.deletePetButton().should('be.visible');

      pet.petViewTable().should('be.visible').within(() => {
        pet.petViewName().should('be.visible').should('contain', petName);
        pet.petViewType().should('be.visible').should('contain', "dog");
        pet.petViewBreed().should('be.visible').should('contain', "pincher");
        pet.petViewDateOfBirth().should('be.visible').should('contain', "2021-05-05");
        pet.petViewInformation().should('be.visible').should('contain', petInformation);
        pet.petViewOwner().should('be.visible').should('contain', "Nikolai Nikolov");
        pet.petViewAddress().should('be.visible').should('contain', "Plovdiv");
        pet.petViewEmail().should('be.visible').should('contain', petUserEmail);
        pet.petViewPhoneNumber().should('be.visible').should('contain', "0888123456");
      });
    });

    it('Delete the new pet', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.url({ timeout: 10000 })
        .should('include', '/pet/view?pet_id=');

      pet.petViewTitle().should('be.visible');
      pet.updatePetButton().should('be.visible');
      pet.deletePetButton().should('be.visible').click();
    });

    it('Check if the new pet record is deleted', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.visit(`/pet/view?pet_id=${petId}`, { failOnStatusCode: false });

      cy.get('h1').should('be.visible').should('contain', "Not Found (#404)");
    });
  
    it('Logout', { retries: { runMode: 1, openMode: 1 } }, () => {
      cy.Logout();
    });
  });