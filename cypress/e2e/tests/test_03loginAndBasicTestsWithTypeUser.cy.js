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
const files = ['Wolf.jfif', 'dog.jpeg'];
const filePath = 'cypress/fixtures/';
let startTime;

describe('Test 1 - Login and basic tests', { defaultCommandTimeout: 5000 }, () => {
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

    cy.fixture('userDetails').then((user) => {
      cy.SignIn(user.usernameUser, user.passwordUser);
    });

    cy.url({ timeout: 10000 })
      .should('not.include', '/site/login');

    navbar.logout().should('be.visible');
    navbar.users().should('not.exist');
    navbar.vaccines().should('not.exist');
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

  it('Try to add a new pet without all mandatory fields filled', () => {
    pet.petCreateDiv().should('be.visible').within(() => {
      pet.petCreateTitle().should('be.visible');
      pet.petNameInput().should('be.visible').type(petName);
      pet.petTypeInput().should('be.visible');

      pet.petSaveButton().should('be.visible').click();
    });
  });

  it('Check for shown help messages', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.contains('Type cannot be blank.').should('be.visible');

    cy.url({ timeout: 5000 })
      .should('not.include', 'pet/view?pet_id=')
      .should('include', '/pet/create');
  });

  it('Add data to a new pet', () => {
    pet.petCreateDiv().should('be.visible').within(() => {
      pet.petCreateTitle().should('be.visible');
      pet.petFormPhoto().should('be.visible');
      pet.petNameInput().should('be.visible').clear().type(petName);
      pet.petTypeInput().should('be.visible').type("dog");
      pet.petBreedInput().should('be.visible').type("pincher");
      pet.petDateOfBirthInput().should('be.visible').type("2021-05-05");
      pet.petInformationInput().should('be.visible').type(petInformation);
      pet.petOwnerInput().should('be.visible').type("Nikolai Nikolov");
      pet.petAddressInput().should('be.visible').type("Plovdiv");
      pet.petEmailInput().should('be.visible').type(petUserEmail);
      pet.petPhoneNumberInput().should('be.visible').type("0888123456");
      pet.petOwnerLabelInput().should('not.exist');
      pet.petSelectUserInput().should('not.exist');

      pet.petSaveButton().should('be.visible').click();
    });

    cy.url({ timeout: 10000 })
      .should('include', '/pet/view?pet_id=');
  });

  it('Check if the new pet is created and get the pet id', () => {
    cy.url()
      .should('include', '/pet/view?pet_id=');

    cy.url().then((url) => {
      const temp = url.split('pet_id=')[1] // take the ending part after that
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
      pet.petViewPhoto().should('not.exist');
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

  it('Open the pet update form', () => {
    pet.updatePetButton().should('be.visible').click();

    cy.url({ timeout: 6000 })
      .should('include', `/pet/update?pet_id=${petId}`);

    pet.petUpdateTitle().should('be.visible');
  });

  it('Update some of the pet data', () => {
    pet.petUpdateDiv().should('be.visible').within(() => {
      pet.petUpdateTitle().should('be.visible');
      pet.petNameInput().should('be.visible').should('have.value', petName)
          .clear().type(`${petName}+edited`);
      pet.petTypeInput().should('be.visible').should('have.value', "dog");
      pet.petBreedInput().should('be.visible').should('have.value', "pincher");
      pet.petDateOfBirthInput().should('be.visible').should('have.value', "2021-05-05");
      pet.petInformationInput().should('be.visible').should('have.value', petInformation)
          .clear().type(`Updated+${petInformation}`);
      pet.petOwnerInput().should('be.visible').should('have.value', "Nikolai Nikolov");
      pet.petAddressInput().should('be.visible').should('have.value', "Plovdiv");
      pet.petEmailInput().should('be.visible').should('have.value', petUserEmail);
      pet.petPhoneNumberInput().should('be.visible').should('have.value', "0888123456");
      pet.petSelectUserInput().should('not.exist');

      pet.petSaveButton().click();
    });

    cy.url({ timeout: 6000 })
      .should('include', `/pet/view?pet_id=${petId}`);

    pet.petViewTitle().should('be.visible');
  });

  it('Check the edited pet data', () => {
    pet.petViewTitle().should('be.visible');
    pet.updatePetButton().should('be.visible');
    pet.deletePetButton().should('be.visible');

    pet.petViewTable().should('be.visible').within(() => {
      pet.petViewName().should('be.visible').should('contain', `${petName}+edited`);
      pet.petViewType().should('be.visible').should('contain', "dog");
      pet.petViewBreed().should('be.visible').should('contain', "pincher");
      pet.petViewDateOfBirth().should('be.visible').should('contain', "2021-05-05");
      pet.petViewInformation().should('be.visible').should('contain', `Updated+${petInformation}`);
      pet.petViewOwner().should('be.visible').should('contain', "Nikolai Nikolov");
      pet.petViewAddress().should('be.visible').should('contain', "Plovdiv");
      pet.petViewEmail().should('be.visible').should('contain', petUserEmail);
      pet.petViewPhoneNumber().should('be.visible').should('contain', "0888123456");
    });
  });

  it('Open the pet update form', () => {
    pet.updatePetButton().should('be.visible').click();

    cy.url({ timeout: 6000 })
      .should('include', `/pet/update?pet_id=${petId}`);

    pet.petUpdateTitle().should('be.visible');
  });

  it('Try to upload an image of not supported format', () => {
    pet.petUpdateDiv().should('be.visible').within(() => {
      pet.petUpdateTitle().should('be.visible');
      pet.petFormPhoto().should('be.visible').selectFile(filePath+files[0]);
      pet.petNameInput().should('be.visible').should('have.value', `${petName}+edited`);

      pet.petSaveButton().should('be.visible').click();
    });
  });

  it('Check for shown help messages', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.contains('Only files with these extensions are allowed: png, jpg, jpeg.').should('be.visible');

    cy.url()
      .should('include', `/pet/update?pet_id=${petId}`);
  });

  it('Upload an image', () => {
    pet.petUpdateDiv().should('be.visible').within(() => {
      pet.petUpdateTitle().should('be.visible');
      pet.petFormPhoto().should('be.visible').selectFile(filePath+files[1]);
      pet.petNameInput().should('be.visible'); // .should('have.value', `${petName}+edited`);

      pet.petSaveButton().should('be.visible').click();
    });

    cy.url({ timeout: 6000 })
      .should('include', `/pet/view?pet_id=${petId}`);

    pet.petViewTitle().should('be.visible');
  });

  it('Check for the uploaded photo and the same entered data', () => {
    pet.petViewTitle().should('be.visible');
    pet.updatePetButton().should('be.visible');
    pet.deletePetButton().should('be.visible');

    pet.petViewPhoto().should('be.visible');
    pet.petViewTable().should('be.visible').within(() => {
      pet.petViewName().should('be.visible').should('contain', `${petName}+edited`);
      pet.petViewType().should('be.visible').should('contain', "dog");
      pet.petViewBreed().should('be.visible').should('contain', "pincher");
      pet.petViewDateOfBirth().should('be.visible').should('contain', "2021-05-05");
      pet.petViewInformation().should('be.visible').should('contain', `Updated+${petInformation}`);
      pet.petViewOwner().should('be.visible').should('contain', "Nikolai Nikolov");
      pet.petViewAddress().should('be.visible').should('contain', "Plovdiv");
      pet.petViewEmail().should('be.visible').should('contain', petUserEmail);
      pet.petViewPhoneNumber().should('be.visible').should('contain', "0888123456");
    });
  });

  it('Delete the new pet', () => {
    cy.url({ timeout: 10000 })
      .should('include', `/pet/view?pet_id=${petId}`);

    pet.petViewTitle().should('be.visible');
    pet.updatePetButton().should('be.visible');
    pet.deletePetButton().should('be.visible').click();
  });

  it('Check if the new pet record is deleted', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.visit(`/pet/view?pet_id=${petId}`, { failOnStatusCode: false });

    cy.get('h1').should('be.visible').should('contain', "Not Found (#404)");
  });

  it('Check if the user can access the users page', () => {
    cy.visit(`/user/index`, { failOnStatusCode: false });

    cy.get('h1').should('be.visible').should('contain', "Forbidden (#403)");
  });

  it('Check if the user can access the vaccines page', () => {
    cy.visit(`/vaccine/index`, { failOnStatusCode: false });

    cy.get('h1').should('be.visible').should('contain', "Forbidden (#403)");
  });

  it('Logout', { retries: { runMode: 1, openMode: 1 } }, () => {
    cy.Logout();
  });
});