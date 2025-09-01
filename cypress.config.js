const { defineConfig } = require("cypress");

module.exports = defineConfig({
  viewportWidth: 1350,
  viewportHeight: 850,
  numTestsKeptInMemory: 10,
  defaultCommandTimeout: 5000,
  video: false,
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
    baseUrl: 'http://localhost/MyPet/web/site/',
    specPattern: 'cypress/e2e/**/*.{js,mjs,jsx,ts,tsx}',
    supportFile: 'cypress/support/e2e.js',
    testIsolation: false,
    env: {
      apiBaseUrl: '',
    }
  },
});
